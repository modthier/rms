<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Order model: sales order with items, payment, and return status.
 *
 * @property int $id
 * @property int|null $status
 * @property int|null $user_id
 * @property float|null $total_price
 * @property int|null $total_items
 * @property int|null $order_type_id
 * @property int|null $payment_id
 * @property int $returned
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Order extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'status',
        'user_id',
        'total_price',
        'total_items',
        'order_type_id',
        'payment_id',
        'returned',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Scope: orders created today.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay(),
        ]);
    }

    /**
     * Scope: orders this week (Saturday to Friday).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisWeek($query)
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    /**
     * Scope: orders this month.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ]);
    }

    /**
     * Scope: orders not returned (valid sales).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotReturned($query)
    {
        return $query->where('returned', 0);
    }

    /**
     * Scope: returned/canceled orders.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReturned($query)
    {
        return $query->where('returned', 1);
    }

    /**
     * Scope: pending orders.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Order line items (pivot: quantity, price).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_details')
                    ->withPivot('quantity')
                    ->withPivot('id')
                    ->withPivot('price')
            ->withTimestamps();
    }

    /**
     * User (cashier) who created the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payment method used for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    /**
     * Get order detail rows for a given item type (for receipt grouping).
     *
     * @param int $type Item type ID
     * @return \Illuminate\Support\Collection
     */
    public function getItemsByTypes($type)
    {
        $result = DB::table('order_details as os')
                ->select([
                    'os.id' , 'i.name' , 'os.price' , 'os.quantity' , 'os.created_at'
                ])
                ->leftJoin('items as i' ,'os.item_id','i.id')
                ->leftJoin('orders as s','os.order_id','s.id')
                ->where('os.order_id',$this->id)
                ->where('i.item_type_id',$type)
                ->get();
        return $result;
    }

    /**
     * Order type (e.g. dine-in, takeaway).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }
}
