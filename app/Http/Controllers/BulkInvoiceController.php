<?php

namespace App\Http\Controllers;

use App\Models\BulkInvoice;
use App\Models\BulkInvoicePayment;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BulkInvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);
        $query = BulkInvoice::with(['company'])
            ->withSum('payments', 'amount')
            ->orderByDesc('issued_on')
            ->orderByDesc('id');

        if (! empty($filters['date_from'])) {
            $query->whereDate('issued_on', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->whereDate('issued_on', '<=', $filters['date_to']);
        }

        $invoices = $query->paginate(20)->withQueryString();

        return view('bulkInvoices.index', [
            'metaTitle' => 'فواتير الشركات',
            'invoices' => $invoices,
            'dateFrom' => $filters['date_from'] ?? '',
            'dateTo' => $filters['date_to'] ?? '',
        ]);
    }

    public function create(): View
    {
        return view('bulkInvoices.create', [
            'metaTitle' => 'إنشاء فاتورة شركة',
            'companies' => Company::orderBy('name')->get(),
            'items' => Item::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'issued_on' => ['required', 'date'],
            'due_on' => ['nullable', 'date', 'after_or_equal:issued_on'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'distinct', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
            'items.*.unit_price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0.01', 'max:9999999999.99'],
        ]);

        $invoice = DB::transaction(function () use ($validated) {
            $selectedItems = Item::query()
                ->whereIn('id', collect($validated['items'])->pluck('item_id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $totalCents = 0;
            $lines = [];

            foreach ($validated['items'] as $line) {
                $item = $selectedItems->get((int) $line['item_id']);
                if (! $item) {
                    throw ValidationException::withMessages([
                        'items' => 'أحد الأصناف المحددة لم يعد متاحاً.',
                    ]);
                }
                $unitPriceCents = (int) round((float) $line['unit_price'] * 100);
                $lineTotalCents = $unitPriceCents * (int) $line['quantity'];

                if ($lineTotalCents > 999999999999 - $totalCents) {
                    throw ValidationException::withMessages([
                        'items' => 'إجمالي الفاتورة يتجاوز الحد المسموح به.',
                    ]);
                }

                $totalCents += $lineTotalCents;

                $lines[] = [
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'quantity' => (int) $line['quantity'],
                    'unit_price' => number_format($unitPriceCents / 100, 2, '.', ''),
                    'line_total' => number_format($lineTotalCents / 100, 2, '.', ''),
                ];
            }

            $invoice = BulkInvoice::create([
                'company_id' => $validated['company_id'],
                'user_id' => Auth::id(),
                'invoice_number' => 'PENDING-'.Str::uuid(),
                'issued_on' => $validated['issued_on'],
                'due_on' => $validated['due_on'] ?? null,
                'total' => number_format($totalCents / 100, 2, '.', ''),
                'notes' => $validated['notes'] ?? null,
            ]);

            $invoice->update([
                'invoice_number' => 'BULK-'.str_pad((string) $invoice->id, 6, '0', STR_PAD_LEFT),
            ]);

            $invoice->items()->createMany($lines);

            return $invoice;
        });

        return redirect()->route('bulkInvoices.show', $invoice)
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function show(BulkInvoice $bulkInvoice): View
    {
        $bulkInvoice->load(['company', 'user', 'items', 'payments.user']);

        return view('bulkInvoices.show', [
            'metaTitle' => 'فاتورة '.$bulkInvoice->invoice_number,
            'invoice' => $bulkInvoice,
        ]);
    }

    public function storePayment(Request $request, BulkInvoice $bulkInvoice): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'gt:0', 'max:9999999999.99'],
            'paid_on' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($bulkInvoice, $validated) {
            $invoice = BulkInvoice::query()->lockForUpdate()->findOrFail($bulkInvoice->id);
            $paidCents = (int) round((float) $invoice->payments()->sum('amount') * 100);
            $balanceCents = (int) round((float) $invoice->total * 100) - $paidCents;
            $amountCents = (int) round((float) $validated['amount'] * 100);

            if ($amountCents > $balanceCents) {
                throw ValidationException::withMessages([
                    'amount' => 'لا يمكن أن تتجاوز الدفعة الرصيد المتبقي للفاتورة.',
                ]);
            }

            BulkInvoicePayment::create([
                'bulk_invoice_id' => $invoice->id,
                'user_id' => Auth::id(),
                'amount' => number_format($amountCents / 100, 2, '.', ''),
                'paid_on' => $validated['paid_on'],
                'payment_method' => $validated['payment_method'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('bulkInvoices.show', $bulkInvoice)
            ->with('success', 'تم تسجيل الدفعة بنجاح');
    }
}
