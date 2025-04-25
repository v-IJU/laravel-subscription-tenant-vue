<?php

namespace cms\Paymentgateway\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentgatewayModel extends Model
{
    protected $table = "payment_gateway";
    protected $fillable = [
        "gateway_name",
        "razorpay_mode",
        "live_key_id",
        "live_key_secret",
        "test_key_id",
        "test_key_secret",
        "status",
    ];

    protected $casts = [
        "live_key_secret" => "encrypted",
        "test_key_secret" => "encrypted",
    ];
}
