<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use cms\core\configurations\helpers\Configurations;
use cms\order\Models\RazorpayOrderModel;
use cms\Paymentgateway\Models\PaymentgatewayModel;
use cms\school\Models\SchoolModel;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    use ApiResponse;

    private $api;
    public function __construct()
    {
        $api_key = config("payments.razorpay.key");
        $api_secret = config("payments.razorpay.secret");

        //$this->api = new Api($api_key, $api_secret);
    }

    public function createOrder(Request $request)
    {
        try {
            if (!$request->razorpay_mode) {
                return response()->json(
                    ["error" => "Please Give RazorpayMode Live/Sandbox"],
                    500
                );
            }
            if (!$request->api_key) {
                return response()->json(
                    ["error" => "Please Give Razorpay Api Key Live/Sandbox"],
                    500
                );
            }

            $this->setupApiCredentials($request);
            $amount = $request->total_amount;

            $order = $this->api->order->create([
                "receipt" => now(),
                "amount" => (int) ($amount * 100),
                "currency" => "INR",
            ]);

            $data["order_id"] = $order["id"];
            $data["amount"] = $order["amount"];
            $data["currency"] = "INR";
            $data["total_amount"] = $amount;

            // create new order for razorpay

            $razorpayOrder = new RazorpayOrderModel();
            $razorpayOrder->parent_id = $request->user()->id;

            $razorpayOrder->order_created_date = Carbon::now(
                Configurations::getTimeZone()
            );
            $razorpayOrder->pay_amount = $amount;
            $razorpayOrder->razorpay_order_id = $order["id"];
            $razorpayOrder->razorpay_mode =
                $request->razorpay_mode == "live" ? "Live" : "Sandbox";
            $razorpayOrder->payment_type = RazorpayOrderModel::PAYMENT_TYPE[1];

            $razorpayOrder->saveQuietly();

            return $this->success($data, __("messages.flash.order_created"));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    public function Verifypay(Request $request)
    {
        if (!$request->razorpay_mode) {
            return response()->json(
                ["error" => "Please Give RazorpayMode Live/Sandbox"],
                500
            );
        }

        $this->setupApiCredentials($request);

        $attributes = [
            "razorpay_order_id" => $request->orderCreationId,
            "razorpay_payment_id" => $request->razorpayPaymentId,
            "razorpay_signature" => $request->razorpaySignature,
        ];
        try {
            $this->api->utility->verifyPaymentSignature($attributes);

            session()->put("razerpay_history", $attributes);

            // if successfully verified

            $razorpayOrder = RazorpayOrderModel::where(
                "razorpay_order_id",
                $request->orderCreationId
            )->first();

            if ($razorpayOrder) {
                $razorpayOrder->updateQuietly([
                    "payment_status" => 2,
                    "razorpay_payment_id" => $request->razorpayPaymentId,
                ]);
            }

            return response()->json(
                [
                    "message" => "verify successfully",
                    "verify" => true,
                    "attributes" => $attributes,
                ],
                200
            );
        } catch (SignatureVerificationError $e) {
            session()->forget("razerpay_history");

            return response()->json(
                ["message" => "verify faild", "verify" => false],
                400
            );
        }
    }
    public function AccessKeys(Request $request, $school_id)
    {
        if (!$school_id) {
            return response()->json(
                [
                    "error" =>
                        "Please Give School id and get Razorpay Information",
                ],
                500
            );
        }
        if (!$request->razorpay_mode) {
            return response()->json(
                ["error" => "Please Give RazorpayMode Live/Sandbox"],
                500
            );
        }

        //find that school rzorpayinformation

        $gateway_information = SchoolModel::find($school_id)
            ->razorpayInformation()
            ->where("razorpay_mode", $request->razorpay_mode)
            ->first();

        if ($request->razorpay_mode == "live") {
            if ($gateway_information) {
                $api_key = $gateway_information->live_key_id;
                //$api_secret = config("payments.razorpay.secret");
            } else {
                $api_key = config("payments.razorpay.key");
                $api_secret = config("payments.razorpay.secret");
            }
        } else {
            if ($gateway_information) {
                $api_key = $gateway_information->test_key_id;
            } else {
                $api_key = config("payments.razorpayApi.key");
                $api_secret = config("payments.razorpayApi.secret");
            }
        }

        return response()->json(
            ["api_key" => $api_key, "razorpay_mode" => $request->razorpay_mode],
            200
        );
    }
    public function setupApiCredentials($request)
    {
        //find paymentgateway information

        if ($request->razorpay_mode == "sandbox") {
            $payment_gateway = PaymentgatewayModel::where(
                "razorpay_mode",
                $request->razorpay_mode
            )
                ->where("test_key_id", $request->api_key)
                ->first();

            if (!$payment_gateway) {
                throw new \Exception("Gateway Not Found");
            }

            $api_key = $payment_gateway->test_key_id;
            $api_secret = $payment_gateway->test_key_secret;
            $this->api = new Api($api_key, $api_secret);

            return true;
        } else {
            //live
            $payment_gateway = PaymentgatewayModel::where(
                "razorpay_mode",
                $request->razorpay_mode
            )
                ->where("live_key_id", $request->api_key)
                ->first();
            if (!$payment_gateway) {
                throw new \Exception("Gateway Not Found");
            }
            $api_key = $payment_gateway->live_key_id;
            $api_secret = $payment_gateway->live_key_secret;
            $this->api = new Api($api_key, $api_secret);
            return true;
        }
    }
}
