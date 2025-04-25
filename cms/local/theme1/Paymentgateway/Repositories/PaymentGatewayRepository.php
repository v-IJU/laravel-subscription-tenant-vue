<?php

namespace cms\Paymentgateway\Repositories;

use cms\Paymentgateway\Models\PaymentgatewayModel;
use Illuminate\Support\Facades\Crypt;

use DB;

class PaymentGatewayRepository
{
    protected $paymentGatewayModel;

    public function __construct(PaymentgatewayModel $paymentGatewayModel)
    {
        $this->paymentGatewayModel = $paymentGatewayModel;
    }

    public function createPaymentGateway($request)
    {
        try {
            // start a db transaction
            DB::transaction(function () use ($request) {
                // store payment gateway record with encrypted secret key
                PaymentgatewayModel::create([
                    "gateway_name" => $request["gateway_name"],
                    "razorpay_mode" => $request["razorpay_mode"],
                    "live_key_id" => $request["live_key_id"],
                    "live_key_secret" => $request["live_key_secret"]
                        ? $request["live_key_secret"]
                        : null,
                    "test_key_id" => $request["test_key_id"],
                    "test_key_secret" => $request["test_key_secret"]
                        ? $request["test_key_secret"]
                        : null,
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception(
                "Failed to create Payment gateway. " . $e->getMessage()
            );
        }
    }

    public function updatePaymentGateway($request, $id)
    {
        try {
            // start a db transaction
            DB::beginTransaction();
            $paymentGateway = PaymentgatewayModel::find($id);

            // store payment gateway record with encrypted secret key
            $paymentGateway->update([
                "gateway_name" => $request["gateway_name"],
                "razorpay_mode" => $request["razorpay_mode"],
                "live_key_id" => $request["live_key_id"],
                "live_key_secret" => $request["live_key_secret"]
                    ? $request["live_key_secret"]
                    : null,
                "test_key_id" => $request["test_key_id"],
                "test_key_secret" => $request["test_key_secret"]
                    ? $request["test_key_secret"]
                    : null,
            ]);

            //dd($paymentGateway);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception(
                "Failed to update payment gateway. " . $e->getMessage()
            );
        }
    }

    public function findGateway($id)
    {
        try {
            $data = $this->paymentGatewayModel->find($id);

            return $data;
        } catch (\Exception $e) {
            throw new \Exception(
                "Failed to get payment gateway. " . $e->getMessage()
            );
        }
    }

    public function getAllGateways()
    {
        return $this->paymentGatewayModel
            ->where("status", "1")
            ->pluck("gateway_name", "id")
            ->toArray();
    }
}
