<?php

namespace App\Modules\Store;

use App\Product;
use App\UniqueId;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'order_number',
        'description',
        'status',
        'type',
        'currency',
        'subtotal',
        'grand_total',
        'discount_type',
        'discount_amount',
        'taxes',
        'customer_name',
        'customer_phone_number',
        'billing_company_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'shipping_company_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
        'notes',
        'payment_method',
        'creator_id',
        'editor_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'discount_amount' => 'decimal',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
        'taxes' => 'array',
    ];
    const STATUS_PENDING = 0;
    const STATUS_PAYMENT_COMPLETE = 1;
    const STATUS_AWAITING_SHIPMENT = 2;
    const STATUS_PARTIALLY_SHIPPED = 3;
    const STATUS_SHIPPED = 4;
    const STATUS_PAYMENT_PARTIALLY_PAID = 5;
    const STATUS_COMPLETED = 10;
    const STATUS_ON_HOLD = 20;
    const STATUS_CANCELLED = 21;
    const STATUS_DISPUTED = 30;
    const STATUS_REFUNDED = 31;
    const STATUS_DECLINED = 32;
    const STATUS_FRAUD = 33;

    const STATUS_ARRAY = [
        self::STATUS_PENDING            => 'Pending Payment',
        self::STATUS_PAYMENT_COMPLETE   => 'Payment Completed',
        self::STATUS_AWAITING_SHIPMENT  => 'Awaiting Shipment',
        self::STATUS_PARTIALLY_SHIPPED  => 'Partially Shipped',
        self::STATUS_SHIPPED            => 'Shipped',
        self::STATUS_PAYMENT_PARTIALLY_PAID => 'Partially Paid',
        self::STATUS_COMPLETED          => 'Completed',
        self::STATUS_ON_HOLD            => 'On Hold',
        self::STATUS_CANCELLED          => 'Cancelled',
        self::STATUS_DISPUTED           => 'Disputed',
        self::STATUS_REFUNDED           => 'Refunded',
        self::STATUS_DECLINED           => 'Declined',
        self::STATUS_FRAUD              => 'Fraud',
    ];

    /**
     * create new order
     * @param $product_info
     * @param false $addToProductUser
     * @return mixed
     * @throws \Exception
     */
    public static function make($product_info, $addToProductUser = false)
    {
        $order_number = UniqueId::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'SP']);
        $user = getAuthUser();
        if (empty(getAuthUser())){
            abort(404);
        }
        $input = [
            'order_number' => $order_number,
            'status' => self::STATUS_PAYMENT_COMPLETE,
            'subtotal' => Cart::subtotal(),
            'grand_total' => Cart::priceTotal(),
            'discount_amount' => 0,
            'customer_name' => $user->name,
            'customer_phone_number' => $user->phone_number,
            'billing_country' => !empty($user->country)? $user->country->name : '',
            'payment_method' => $product_info['pay_by'],
            'creator_id' => $user->id,

        ];
        $order = self::create($input);
        // create order items
        foreach (Cart::content() as $rowID => $item){
            $product = Product::find($item->id);
            if (!empty($product)){
                $newOrderItemInput = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'title' => $product->name,
                    'description' => $product->description,
                    'quantity' => $item->qty,
                    'unit_price' => $product->price,
                    'total_price' => $item->price,
                    'status' => 1,
                    'seller_id' => $product->creator_id,
                    'creator_id' => $user->id,
                ];
                OrderItem::create($newOrderItemInput);
                // add product to user TODO: check if already have the product
                if ($addToProductUser == true){
                    $qty = $item->qty;
                    $ownedProduct = $user->products->where('id', $product->id)->first();
                    if (!empty($ownedProduct)){
                        $qty = $ownedProduct->pivot->quantity + $item->qty;
                    }
                    $user->products()->sync([
                        [
                            'user_id' => $user->id,
                            'product_id' => $product->id,
                            'quantity' => $qty ]
                    ], false);
                }

            }
            Cart::remove($rowID);
        }
        return $order;
    }

    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class);
    }
}
