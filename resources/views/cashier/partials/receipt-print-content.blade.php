@php
    $usesDualReceipts = ($name ?? null)?->usesDualReceipts() ?? true;
    $receiptData = [
        'name' => $name,
        'order' => $order,
        'counter' => $counter,
        'orderDateFormatted' => $orderDateFormatted,
        'orderTimeFormatted' => $orderTimeFormatted,
        'paymentName' => $paymentName,
        'items' => $items,
        'singleItem' => $singleItem,
    ];

    if (isset($typeSubtotal)) {
        $receiptData['typeSubtotal'] = $typeSubtotal;
    }
@endphp

@if($usesDualReceipts)
    @include('cashier.partials.receipt-client', $receiptData)
    <div class="page-break"></div>
    @include('cashier.partials.receipt-kitchen', $receiptData)
@else
    @include('cashier.partials.receipt-general', $receiptData)
@endif
