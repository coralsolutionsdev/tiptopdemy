<?php

namespace App\Modules\Store;

use App\UniqueId;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Invoice extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'order_id',
        'invoice_number',
        'date',
        'date_paid',
        'customer_name',
        'customer_phone_number',
        'billing_company_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'description',
        'status',
        'type',
        'currency',
        'subtotal',
        'grand_total',
        'discount_type',
        'discount_amount',
        'taxes',
        'payment_method',
        'notes',
        'creator_id',
        'editor_id',
    ];

    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    const STATUS_ARRAY = [
        self::STATUS_UNPAID => 'Unpaid',
        self::STATUS_PAID => 'Paid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'status' => 'integer',
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'discount_amount' => 'decimal',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'date_paid',
    ];

    /**
     * @param Order $order
     * @return false
     * @throws \Exception
     */
    public static function generate(Order $order)
    {
        if (!getAuthUser() || empty($order)){
            return false;
        }
        $invoiceNumber = UniqueId::generate(['table' => 'invoices', 'length' => 10, 'prefix' =>'INV']);
        $dateNow = Carbon::now();

        $input = [
            'order_id' => $order->id,
            'invoice_number' => $invoiceNumber,
            'date' => $dateNow,
            'date_paid' => $dateNow, // change to paid date
            'customer_name' => $order->customer_name,
            'customer_phone_number'=> $order->customer_phone_number,
            'status' => self::STATUS_PAID,
            'currency' => '$',
            'subtotal' => $order->subtotal,
            'grand_total'=> $order->grand_total,
            'discount_amount' => 0,
            'payment_method' => $order->payment_method,
            'creator_id' => getAuthUser()->id,
        ];
        return self::create($input);
    }

    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
