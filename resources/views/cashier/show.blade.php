<style>
/* Receipt styling - screen & print */
.receipt-paper {
    max-width: 320px;
    width: 100%;
    margin: 0 auto;
    padding: 16px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    font-family: "Changa", sans-serif;
    direction: rtl;
    text-align: right;
}
.receipt-paper .receipt-header {
    text-align: center;
    border-bottom: 2px dashed #333;
    padding-bottom: 12px;
    margin-bottom: 12px;
}
.receipt-paper .receipt-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #000;
    margin: 0 0 8px 0;
}
.receipt-paper .receipt-meta {
    font-size: 0.75rem;
    color: #333;
    line-height: 1.6;
}
.receipt-paper .receipt-section-label {
    font-size: 0.7rem;
    font-weight: 700;
    color: #000;
    text-align: center;
    margin: 10px 0 6px 0;
}
.receipt-paper .receipt-table {
    width: 100%;
    font-size: 0.8rem;
    border-collapse: collapse;
    margin-bottom: 8px;
}
.receipt-paper .receipt-table th,
.receipt-paper .receipt-table td {
    padding: 4px 6px;
    border-bottom: 1px solid #ddd;
}
.receipt-paper .receipt-table th {
    font-weight: 700;
    border-bottom: 2px solid #333;
}
.receipt-paper .receipt-table .text-left { text-align: left; }
.receipt-paper .receipt-table .text-center { text-align: center; }
.receipt-paper .receipt-totals {
    border-top: 2px dashed #333;
    padding-top: 10px;
    margin-top: 8px;
    font-size: 0.85rem;
}
.receipt-paper .receipt-total-row {
    display: flex;
    justify-content: space-between;
    padding: 2px 0;
}
.receipt-paper .receipt-total-row.grand {
    font-weight: 700;
    font-size: 1rem;
    margin-top: 6px;
    padding-top: 6px;
    border-top: 1px solid #333;
}
.receipt-paper .receipt-footer {
    text-align: center;
    font-size: 0.8rem;
    color: #555;
    margin-top: 14px;
    padding-top: 10px;
    border-top: 2px dashed #333;
}
.receipt-paper .page-break {
    page-break-after: always;
    break-after: page;
}
@media print {
    .receipt-paper {
        box-shadow: none;
        border: none;
        max-width: 100%;
    }
    .no-print { display: none !important; }
    .page-break {
        page-break-after: always;
        break-after: page;
    }
}
</style>

<div class="d-flex gap-2 mb-3 no-print">
    <button class="btn btn-danger close">رجوع</button>
    <button type="button" class="print-all btn btn-success">طباعة الكل</button>
</div>

@php
    $orderDate = $order->created_at;
    $orderDateFormatted = $orderDate ? $orderDate->format('Y-m-d') : '';
    $orderTimeFormatted = $orderDate ? $orderDate->format('H:i') : '';
    $paymentName = $order->payment ? $order->payment->method : '-';
@endphp

<div class="cashier-card cashier-card--print cashier-card--flush">
    <div class="cashier-card-body p-2">
        <div id="printAll">
            @foreach($order->items as $item)
                @include('cashier.partials.receipt-print-content', [
                    'name' => $name,
                    'order' => $order,
                    'counter' => $counter,
                    'orderDateFormatted' => $orderDateFormatted,
                    'orderTimeFormatted' => $orderTimeFormatted,
                    'paymentName' => $paymentName,
                    'items' => [$item],
                    'singleItem' => true,
                ])
                <div class="page-break"></div>
            @endforeach
        </div>
    </div>
</div>
