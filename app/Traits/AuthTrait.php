<?php

namespace App\Traits;

use App\Mail\ParentAuthOtpMail;
use Image;
use Auth;
use Carbon\Carbon;
use cms\core\configurations\helpers\Configurations;
use cms\core\layout\helpers\CmsMail;
use cms\parent\Models\OtpVerificationModel;
use cms\parent\Models\ParentModel;
use Session;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Ramesh\Cms\Facades\Cms;

trait AuthTrait
{
    public function SendotpEmail($email_id = null)
    {
        try {
            $otp = $this->GenerateOtp();

            $time24HoursAgo = Carbon::now(
                Configurations::getTimeZone()
            )->subHours(24);

            $getLast_OTP = OtpVerificationModel::where("email", $email_id)
                ->whereNotNull("otpverify")
                ->where("send_time", ">=", $time24HoursAgo)
                ->first();

            if ($getLast_OTP) {
                $otp = $getLast_OTP->otpverify;
            } else {
                // before send next otp null previous otps
                OtpVerificationModel::where([
                    "email" => $email_id,
                ])->update(["otpverify" => null]);
            }

            $otpsend = $this->SendEmailOtp($otp, $email_id);

            if ($otpsend) {
                if (!$getLast_OTP) {
                    $exptime = Carbon::now(Configurations::getTimeZone())
                        ->addHours(24)
                        ->format("Y-m-d H:i:s");

                    $otp_info = new OtpVerificationModel();

                    $otp_info->email = $email_id;
                    $otp_info->exp_time = $exptime;
                    $otp_info->send_time = Carbon::now(
                        Configurations::getTimeZone()
                    );
                    $otp_info->otpverify = $otp;

                    $otp_info->save();
                }

                if (true) {
                    return [
                        "message" => "Successfully Otp Send " . $email_id,
                        "code" => 200,
                        "email" => $email_id,
                    ];
                }
            } else {
                throw new \Exception("Whoops Sowmething went wrong");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function GenerateOtp()
    {
        $otp = mt_rand(10000, 99999);

        return $otp;
    }

    public function SendOtp($otp, $phonenumber)
    {
        if (true) {
            $response = Http::get(
                "http://sms.dhinatechnologies.com/api/smsapi?key=65fa6aaf44580d5f04a01e69b43c1616&route=2&sender=POLPUL&number=" .
                    $phonenumber .
                    "&templateid=1407172189288825687&sms=Your OTP for login is : " .
                    $otp .
                    ". Valid for 10 minutes. Please do not share this OTP. Regards, Team PoliticoPulse"
            );

            return true;
        } else {
            return [
                "success" => true,
                "data" => "Otp Send Succesfully",
            ];
        }
    }

    public function SendEmailOtp($otp, $email_id)
    {
        try {
            $mail_data = [
                "otp" => $otp,
            ];

            if (env("ENABLE_SMTP") == 1) {
                CmsMail::setMailConfig();
                // send otp to parent email
                $emailSent = Mail::to($email_id)->send(
                    new ParentAuthOtpMail(
                        "emails.parent-auth-otp-mail",
                        "One Time Password",
                        $mail_data
                    )
                );
                return true;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function CheckuserExists($input)
    {
        try {
            $user = ParentModel::where(
                "parent_email",
                $input["email_id"]
            )->first();

            return $user;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
