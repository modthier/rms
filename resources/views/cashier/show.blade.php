@include('cashier.partials.receipt-styles')

<div class="d-flex gap-2 mb-3 no-print">
    <button class="btn btn-danger close">رجوع</button>
    <button type="button" class="print-all btn btn-success">طباعة الكل</button>
</div>

@php
    $orderDate = $order->created_at;
    $orderDateFormatted = $orderDate ? $orderDate->format('Y-m-d') : '';
    $orderTimeFormatted = $orderDate ? $orderDate->format('H:i') : '';
@endphp

<div class="cashier-card cashier-card--print cashier-card--flush">
    <div class="cashier-card-body p-2">
        <div id="printAll"
             data-customer-printer="{{ $name->customer_printer ?? '' }}"
             data-kitchen-printer="{{ $name->kitchen_printer ?? '' }}"
             data-receipt-mode="{{ $name->receipt_mode ?? \App\Models\Setting::RECEIPT_MODE_DUAL }}">
            @foreach($order->items as $item)
                @include('cashier.partials.receipt-print-content', [
                    'name' => $name,
                    'order' => $order,
                    'counter' => $counter,
                    'orderDateFormatted' => $orderDateFormatted,
                    'orderTimeFormatted' => $orderTimeFormatted,
                    'items' => [$item],
                    'singleItem' => true,
                ])
                <div class="page-break"></div>
            @endforeach
        </div>
    </div>
</div>
