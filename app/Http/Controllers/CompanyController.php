<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::withCount('bulkInvoices')
            ->orderBy('name')
            ->paginate(20);

        return view('companies.index', [
            'metaTitle' => 'الشركات',
            'companies' => $companies,
        ]);
    }

    public function create(): View
    {
        return view('companies.create', ['metaTitle' => 'إضافة شركة']);
    }

    public function store(Request $request): RedirectResponse
    {
        Company::create($this->validatedData($request));

        return redirect()->route('companies.index')
            ->with('success', 'تمت إضافة الشركة بنجاح');
    }

    public function edit(Company $company): View
    {
        return view('companies.edit', [
            'metaTitle' => 'تعديل الشركة',
            'company' => $company,
        ]);
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $company->update($this->validatedData($request));

        return redirect()->route('companies.index')
            ->with('success', 'تم تحديث بيانات الشركة بنجاح');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'tax_number' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}
