<div class="receipt-paper">
    <div class="receipt-header">
        <h3 class="receipt-title">{{ ($name ?? null)?->name ?? config('app.name') }}</h3>
        <div class="receipt-meta">
            <div>رقم الفاتورة : {{ $counter }}</div>
            <div>نوع الطلب : {{ $order->orderType->name ?? '-' }}</div>
        </div>
    </div>
    <div class="receipt-section-label">نسخة المطبخ</div>
    <table class="receipt-table">
        <thead>
            <tr>
                <th class="text-right">اسم الصنف</th>
                <th class="text-center">الكمية</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @if($singleItem ?? false)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->pivot->quantity }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <div class="receipt-footer">
        {{ $order->created_at ? $order->created_at->format('H:i') : '' }}
    </div>
</div>
