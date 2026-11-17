@php
    $usesDualReceipts = ($name ?? null)?->usesDualReceipts() ?? true;
    $receiptFontSize = ($name ?? null)?->receipt_font_size ?? \App\Models\Setting::DEFAULT_RECEIPT_FONT_SIZE;
    $receiptData = [
        'name' => $name,
        'receiptFontSize' => $receiptFontSize,
        'order' => $order,
        'counter' => $counter,
        'orderDateFormatted' => $orderDateFormatted,
        'orderTimeFormatted' => $orderTimeFormatted,
        'items' => $items,
        'singleItem' => $singleItem,
    ];

    if (isset($typeSubtotal)) {
        $receiptData['typeSubtotal'] = $typeSubtotal;
    }
@endphp

@if($usesDualReceipts)
    <div class="qz-receipt-client">
        @include('cashier.partials.receipt-client', $receiptData)
    </div>
    <div class="page-break"></div>
    <div class="qz-receipt-kitchen">
        @include('cashier.partials.receipt-kitchen', $receiptData)
    </div>
@else
    <div class="qz-receipt-general">
        @include('cashier.partials.receipt-general', $receiptData)
    </div>
@endif
