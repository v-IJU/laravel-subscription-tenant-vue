<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\SendNotification;
use App\Events\SocketEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegistrationRequest;
use App\Notifications\RealTimeNotification;
use App\Traits\ApiResponse;
use App\Traits\AuthTrait;

use cms\core\configurations\helpers\Configurations;
use Google\Api\CustomHttpPattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use cms\core\configurations\Traits\FileUploadTrait;
use cms\core\user\Models\AddressModel;
use cms\core\user\Models\UserModel;
use cms\customer\Models\CustomerModel;
use cms\parent\Models\ChildModel;
use cms\parent\Models\OtpVerificationModel;
use cms\parent\Models\ParentModel;
use cms\school\Models\SchoolClassMappingModel;
use cms\school\Models\SchoolModel;
use cms\schoolclass\Models\SchoolclassModel;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    use ApiResponse, AuthTrait, FileUploadTrait;

    //vue js frontend auth setup

    public function vuelogin(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required",
                "type" => "required|in:website,mobile",
            ]);

            // Find customer by email and type
            $customer = CustomerModel::where("email", $request->email)
                ->where("type", $request->type)
                ->first();

            if (
                !$customer ||
                !Hash::check($request->password, $customer->password)
            ) {
                return response()->json(
                    ["error" => "Invalid credentials"],
                    401
                );
            }

            // Generate Sanctum token
            $token = $customer->createToken("auth-token")->plainTextToken;

            return response()->json([
                "token" => $token,
                "customer" => $customer,
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function OtpSend(Request $request)
    {
        try {
            $request->validate(
                [
                    "email_id" => "required|email",
                    "otp_type" => "required",
                ],
                [
                    "email_id.required" => "Please Provide Email Address",
                ]
            );

            $otp_type = $request->otp_type;
            if ($otp_type == "login") {
                // if otp type login
                $Logincustomer = ParentModel::where([
                    "parent_email" => $request->email_id,
                ])->first();

                if (!@$Logincustomer) {
                    return $this->error(
                        "This Email Address $request->email_id is not registered. Please Register",
                        404
                    );
                }

                if ($Logincustomer->status == 0) {
                    return $this->success(
                        ["inactive" => 1],
                        "Your account has been deactivated by the admin. Please contact the admin for assistance.",
                        500
                    );
                }
            } elseif ($otp_type == "registration") {
                //registration type send otp

                $parent = ParentModel::withTrashed()
                    ->where([
                        "parent_email" => $request->email_id,
                    ])
                    ->first();

                if ($parent) {
                    return $this->error(
                        "This Email Address $request->email_id already exists in our system. Please log in or check if your account is inactive.",
                        500
                    );
                }
            }

            $response = $this->SendotpEmail($request->email_id);

            return $this->success($response, 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function Verifyotp(Request $request)
    {
        try {
            $request->validate(
                [
                    "otp" => "required",
                    "email_id" => "required",
                    "otp_type" => "required",
                ],
                [
                    "otp.required" => "Please Provide Otp",
                    "email_id.required" => "Please Provide Email Address",
                ]
            );

            if (
                OtpVerificationModel::where("email", "=", $request->email_id)
                    ->where("otpverify", "=", $request->otp)

                    ->exists()
            ) {
                $email = $request->email_id;
                $mytime = date("Y-m-d H:i:s"); // today
                $otp = $request->otp;
                $otpverify = OtpVerificationModel::where(
                    "otpverify",
                    $request->otp
                )->first();
                if ($otpverify->exp_time >= $mytime) {
                    $userverify = OtpVerificationModel::where([
                        ["email", "=", $request->email_id],
                        ["otpverify", "=", $request->otp],
                    ])->first();
                    if ($userverify) {
                        OtpVerificationModel::where(
                            "email",
                            "=",
                            $request->email_id
                        )->update(["otpverify" => null]);

                        if ($request->otp_type == "login") {
                            $input = $request->all();

                            $user = $this->CheckuserExists($input);

                            if ($user) {
                                $token = $user->createToken(
                                    Configurations::ISSUE_ACCESS_TOKEN .
                                        $user->id
                                )->plainTextToken;

                                return response(
                                    [
                                        "message" => "Suceesfully Verified",
                                        "email" => $request->email_id,
                                        "token" => $token,
                                        "user" => $user,
                                    ],
                                    200
                                );
                            }
                        } else {
                            return response(
                                [
                                    "message" =>
                                        "OTP Verification Suceesfully Completed for Registration ",
                                    "email" => $request->email_id,
                                ],
                                200
                            );
                        }
                    }

                    // ok
                } else {
                    OtpVerificationModel::where(
                        "email",
                        "=",
                        $request->email_id
                    )->update(["otpverify" => null]);
                    return response(
                        [
                            "message" => "Your Otp Expired",
                            "email" => $request->email_id,
                        ],
                        400
                    );
                }
            } else {
                return response(
                    [
                        "message" => "Please Enter Valid Otp",
                        "email" => $request->email_id,
                    ],
                    400
                );
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function GetSchools(Request $request)
    {
        $schools = SchoolModel::where("status", 1)
            ->pluck("school_name", "id")
            ->toArray();

        return $this->success($schools, "Fetched Successfully", 200);
    }

    public function GetSchoolsClass(Request $request, $school_id)
    {
        $school = SchoolModel::find($school_id);

        if (!@$school) {
            return $this->error("School Not Found", 500);
        }

        $mapped_claases = SchoolClassMappingModel::where(
            "school_master_id",
            $school_id
        )
            ->pluck("class_id")
            ->toArray();

        $classes = SchoolclassModel::whereIn("id", $mapped_claases)
            ->pluck("name", "id")
            ->toArray();

        return $this->success($classes, "Fetched Successfully", 200);
    }

    public function ConfirmRegistration(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            $input = $request->all();

            $parent = ParentModel::create([
                "first_name" => $input["parent_first_name"],
                "last_name" => $input["parent_last_name"],
                "parent_email" => $input["parent_email"],
                "parent_phone" => isset($input["parent_phone"])
                    ? $input["parent_phone"]
                    : null,
                "relationship" => isset($input["parent_relation"])
                    ? $input["parent_relation"]
                    : null,
            ]);

            // add children
            $child = ChildModel::create([
                "parent_id" => $parent->id,
                "school_id" => $input["school_id"],
                "class_id" => $input["class_id"],
                "first_name" => $input["child_first_name"],
                "last_name" => $input["child_last_name"],
                "dob" => isset($input["dob"]) ? $input["dob"] : null,
                "gender" => $input["gender"],
            ]);

            $token = $parent->createToken(
                Configurations::ISSUE_ACCESS_TOKEN . $parent->id
            )->plainTextToken;

            DB::commit();
            return $this->success(
                ["token" => $token, "user" => $parent],
                "Parent registered successfully.",
                201
            );
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), 500);
        }
    }

    public function getUser(Request $request)
    {
        $customer = CustomerModel::find($request->user()->id);

        return $customer;
    }

    public function UpdateProfile(Request $request)
    {
        // return $request->user();

        $validatedData = $request->validate(
            [
                "first_name" => "required",
                "last_name" => "required",
            ],
            [
                "first_name.required" => "Please Provide First Name",
                "last_name.required" => "Please Provide Last Name",
            ]
        );

        try {
            $customer = CustomerModel::find($request->user()->id);
            $input = $request->all();
            if (!@$customer) {
                return $this->error("Customer Not Found", 500);
            }

            $customer->update([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
            ]);

            if ($request->image) {
                // store images
                $tenantId =
                    $request->header("X-Tenant-ID") ??
                    $request->query("tenant_id");
                $mediaId = $this->updateProfileCustomerImage(
                    $customer,
                    $request->image,
                    $tenantId
                );
            }

            // update address
            if (!empty($customer->address)) {
                if (
                    empty(
                        ($address = AddressModel::prepareAddressArray($input))
                    )
                ) {
                    $customer->address->delete();
                }
                $customer->address->update($input);
            } else {
                if (
                    !empty(
                        ($address = AddressModel::prepareAddressArray($input))
                    ) &&
                    empty($customer->address)
                ) {
                    $ownerId = $customer->id;
                    $ownerType = CustomerModel::class;
                    AddressModel::create(
                        array_merge($address, [
                            "owner_id" => $ownerId,
                            "owner_type" => $ownerType,
                        ])
                    );
                }
            }

            return $this->success(
                $customer,
                "Profile Updated Successfully",
                200
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function UpdateDeviceToken(Request $request)
    {
        try {
            $customer = CustomerModel::find($request->user()->id);

            $customer->updateQuietly([
                "device_token" => $request->device_token,
            ]);

            return $this->success([], "Device Token Updated Successfully", 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json(["message" => "Successfully Logout"]);
    }

    public function sendNotification(Request $request)
    {
        $user = UserModel::find(1); // Example user

        event(new SocketEvent("Real Time Notification Socket"));

        return response()->json(["status" => "Event Notification sent!"]);
    }

    //update user means parent

    public function UpdateParent(Request $request)
    {
        try {
            $parent = ParentModel::with("address")->find($request->user()->id);

            $input = $request->all();

            //return $parent;

            $parent->update([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
            ]);

            if (isset($input["parent_image"])) {
                $this->updateProfileImage(
                    $parent,
                    $input["parent_image"],
                    ParentModel::COLLECTION_PARENT_PROFILE_PICTURES
                );
            }

            //update address

            if (!empty($parent->address)) {
                if (
                    empty(
                        ($address = AddressModel::prepareAddressArray($input))
                    )
                ) {
                    $parent->address->delete();
                }
                $input["phone_number"] = $parent->parent_phone
                    ? $parent->parent_phone
                    : null;
                $input["name"] = $parent->full_name ? $parent->full_name : null;
                $parent->address->update($input);
            } else {
                if (
                    !empty(
                        ($address = AddressModel::prepareAddressArray($input))
                    ) &&
                    empty($parent->address)
                ) {
                    $ownerId = $parent->id;
                    $ownerType = ParentModel::class;
                    AddressModel::create(
                        array_merge($address, [
                            "owner_id" => $ownerId,
                            "owner_type" => $ownerType,
                            "parent_id" => $parent->id,
                            "phone_number" => $parent->parent_phone
                                ? $parent->parent_phone
                                : null,
                            "name" => $parent->full_name,
                        ])
                    );
                }
            }

            return $this->success($parent, "Parent updated successfully");
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $input = $request->all();

            $parent = ParentModel::find($input["parent_id"]);

            if (!$parent) {
                return $this->error("Parent not found", 404);
            }
            $parent->update(["status" => 0]);

            $parent->delete();

            return $this->success([], "Parent deleted successfully");
        } catch (\Exception $e) {
            return $this->error("Error occured: " . $e->getMessage(), 500);
        }
    }
}
