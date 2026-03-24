<div class="receipt-paper">
    <div class="receipt-header">
        <h3 class="receipt-title">{{ ($name ?? null)?->name ?? config('app.name') }}</h3>
        <div class="receipt-meta">
            <div>رقم الفاتورة : {{ $counter }}</div>
            <div>نوع الطلب : {{ $order->orderType->name ?? '-' }}</div>
            <div>طريقة الدفع : {{ $paymentName }}</div>
            <div>التاريخ : {{ $orderDateFormatted }} &nbsp; الوقت : {{ $orderTimeFormatted }}</div>
        </div>
    </div>
    <div class="receipt-section-label">نسخة العميل</div>
    <table class="receipt-table">
        <thead>
            <tr>
                <th class="text-right">اسم الصنف</th>
                <th class="text-center">الكمية</th>
                <th class="text-left">السعر</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @if($singleItem ?? false)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->pivot->quantity }}</td>
                        <td class="text-left">{{ number_format($item->pivot->price, 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-left">{{ number_format($item->price, 2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="receipt-totals">
        @if(isset($typeSubtotal))
            <div class="receipt-total-row">مجموع القسم : {{ number_format($typeSubtotal, 2) }}</div>
        @endif
        <div class="receipt-total-row grand">اجمالي الفاتورة : {{ number_format($order->total_price, 2) }}</div>
    </div>
    <div class="receipt-footer">
        @if($order->total_items)
            عدد الأصناف : {{ $order->total_items }}
            <br>
        @endif
        شكراً لزيارتكم
    </div>
</div>
