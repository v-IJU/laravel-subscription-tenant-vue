<?php

namespace cms\core\user\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
//helpers
use Illuminate\Support\Facades\DB;
use cms\core\user\helpers\User;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use cms\core\configurations\helpers\Configurations;
use cms\core\configurations\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use cms\core\gate\helpers\CGate;
//events
use cms\core\user\Events\UserRegisteredEvent;
//models
use cms\core\user\Models\UserModel;
use cms\core\usergroup\Models\UserGroupModel;
use cms\core\usergroup\Models\UserGroupMapModel;
use App\Jobs\QueueCheckJob;
//mail
use cms\core\user\Mail\ForgetPasswordMail;
use cms\core\user\Repositories\UserRepository;

class UserController extends Controller
{
    use FileUploadTrait;
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(function ($request, $next) {
            CGate::resouce("user");
            return $next($request);
        });
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dispatch(new QueueCheckJob());
        return view("user::admin.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = $this->userRepository->Getgroups();
        return view("user::admin.edit", [
            "layout" => "create",
            "group" => $group,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|unique:users,email|max:191",
            "password" => "required|same:password2",
            "password2" => "required",
            "name" => "required",
            "username" => "required|unique:users,username|max:191",
            "mobile" => "max:15",
            "group" => "required|exists:user_groups,id",
        ]);

        // dd($request->all());

        $data = new UserModel();
        $data->first_name = mb_convert_case(
            $request->name,
            MB_CASE_TITLE,
            "UTF-8"
        );
        $data->last_name = mb_convert_case(
            $request->name,
            MB_CASE_TITLE,
            "UTF-8"
        );
        $data->username = $request->username;
        $data->email = $request->email;
        $data->mobile = $request->mobile;

        $Hash = Hash::make($request->password);
        $data->password = $Hash;
        $data->status = $request->status ? $request->status : 1;

        // save image
        if ($request->imagec) {
            $this->storeProfileImage(
                $data,
                $request->imagec,
                UserModel::COLLECTION_PROFILE_PICTURES
            );
        }

        if ($data->save()) {
            $usertypemap = new UserGroupMapModel();
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id = $request->group;
            $usertypemap->save();

            $msg = "Users save successfully";
            $class_name = "success";
        } else {
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect(route("user.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "hai";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = UserModel::with("group")->find($id);
        //print_r($data->group[0]->group);exit;
        $group = UserGroupModel::where("status", 1)
            ->orderBy("group", "Asc")
            ->pluck("group", "id");
        return view("user::admin.edit", [
            "layout" => "edit",
            "group" => $group,
            "data" => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "email" => "required|unique:users,email," . $id,
            "password" => "sometimes|same:password2",
            "password2" => "sometimes",
            "name" => "required",
            "username" => "required|unique:users,username," . $id,
            "mobile" => "sometimes|max:15",
            "group" => "required|exists:user_groups,id",
            // "status" => "required",
        ]);

        $data = UserModel::find($id);
        $data->first_name = mb_convert_case(
            $request->name,
            MB_CASE_TITLE,
            "UTF-8"
        );
        $data->last_name = mb_convert_case(
            $request->name,
            MB_CASE_TITLE,
            "UTF-8"
        );
        $data->username = $request->username;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->images = $request->image;
        $data->status = 1;
        if ($request->password) {
            $Hash = Hash::make($request->password);
            $data->password = $Hash;
        }
        $data->status = 1;

        if ($data->save()) {
            UserGroupMapModel::where("user_id", "=", $id)->delete();
            $usertypemap = new UserGroupMapModel();
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id = $request->group;
            $usertypemap->save();

            $msg = "Users save successfully";
            $class_name = "success";
        } else {
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }
        Cache::forget("users_datatable");
        Session::flash($class_name, $msg);
        return redirect(route("user.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!empty($request->selected_users)) {
            if (($key = array_search(1, $request->selected_users)) !== false) {
                $request->selected_users = Arr::except(
                    $request->selected_users,
                    [$key]
                );
            }
            $delObj = new UserModel();
            foreach ($request->selected_users as $k => $v) {
                //echo $v;
                if ($delItem = $delObj->find($v)) {
                    $delItem->delete();
                }
            }
        }

        Session::flash("success", "User Deleted Successfully!!");
        return redirect()->route("user.index");
    }

    /*
     * *********************additional methods*************************
     */

    /*
     * get user data
     */
    // public function getData(Request $request)
    // {
    //     CGate::authorize("view-user");

    //     $sTart = ctype_digit($request->get("start"))
    //         ? $request->get("start")
    //         : 0;
    //     //$sTart = 0;
    //     DB::statement(DB::raw("set @rownum=" . $sTart));

    //     $data = UserModel::select(
    //         DB::raw("@rownum  := @rownum  + 1 AS rownum"),
    //         "users.id as id",
    //         "users.first_name",
    //         "users.last_name",
    //         "username",
    //         "email",
    //         "mobile",
    //         "user_groups.group",
    //         "users.status",
    //         DB::raw(
    //             "(CASE WHEN " .
    //                 DB::getTablePrefix() .
    //                 (new UserModel())->getTable() .
    //                 '.status = "0" THEN "Disabled"
    //         WHEN ' .
    //                 DB::getTablePrefix() .
    //                 (new UserModel())->getTable() .
    //                 '.status = "-1" THEN "Trashed"
    //         ELSE "Enabled" END) AS status'
    //         )
    //     )
    //         ->join("user_group_map", "user_group_map.user_id", "=", "users.id")
    //         ->join(
    //             "user_groups",
    //             "user_groups.id",
    //             "=",
    //             "user_group_map.group_id"
    //         );

    //     $datatables = Datatables::of($data)
    //         //->addColumn('check', '{!! Form::checkbox(\'selected_users[]\', $id, false, array(\'id\'=> $rownum, \'class\' => \'catclass\')); !!}{!! Html::decode(Form::label($rownum,\'<span></span>\')) !!}')
    //         ->addColumn("check", function ($data) {
    //             if ($data->id != "1") {
    //                 return $data->rownum;
    //             } else {
    //                 return "";
    //             }
    //         })
    //         ->addColumn("pimage", function ($data) {
    //             if ($data->image_url != null) {
    //                 $url = asset($data->image_url);
    //                 return '<img src="' .
    //                     $url .
    //                     '" border="0" width="40" class="img-rounded" align="center" />';
    //             } else {
    //                 $url = asset("build/images/users/user-dummy-img.jpg");
    //                 return '<img src="' .
    //                     $url .
    //                     '" border="0" width="40" class="img-rounded" align="center" />';
    //             }
    //         })
    //         ->addColumn("status", function ($data) {
    //             return view("layout::datatable.statustoggle", [
    //                 "data" => $data,
    //             ])->render();
    //         })
    //         ->addColumn("action", function ($data) {
    //             return '<a class="editbutton btn btn-default" data-toggle="modal" data="' .
    //                 $data->id .
    //                 '" href="' .
    //                 route("user.edit", $data->id) .
    //                 '" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
    //             //return $data->id;
    //         });

    //     // return $data;
    //     if (count((array) $data) == 0) {
    //         return [];
    //     }

    //     return $datatables
    //         ->rawColumns(["pimage", "status", "action"])
    //         ->make(true);
    //     //return $datatables->make(true);
    // }

    //cache redis data

    public function getData(Request $request)
    {
        CGate::authorize("view-user");

        $start = ctype_digit($request->get("start"))
            ? $request->get("start")
            : 0;

        // Unique cache key based on start value
        $cacheKey = "users_datatable";

        // Check if cached data exists
        $data = Cache::remember(
            $cacheKey,
            now()->addMinutes(10),
            function () use ($start) {
                DB::statement(DB::raw("set @rownum=" . $start));

                return UserModel::select(
                    DB::raw("@rownum  := @rownum  + 1 AS rownum"),
                    "users.id as id",
                    "users.first_name",
                    "users.last_name",
                    "username",
                    "email",
                    "mobile",
                    "user_groups.group",
                    "users.status",
                    DB::raw(
                        "(CASE WHEN users.status = '0' THEN 'Disabled'
                       WHEN users.status = '-1' THEN 'Trashed'
                       ELSE 'Enabled' END) AS status"
                    )
                )
                    ->join(
                        "user_group_map",
                        "user_group_map.user_id",
                        "=",
                        "users.id"
                    )
                    ->join(
                        "user_groups",
                        "user_groups.id",
                        "=",
                        "user_group_map.group_id"
                    )
                    ->get(); // Fetch data only once
            }
        );

        $datatables = Datatables::of($data)
            ->addColumn("check", function ($data) {
                return $data->id != "1" ? $data->rownum : "";
            })
            ->addColumn("pimage", function ($data) {
                $url = $data->image_url
                    ? asset($data->image_url)
                    : asset("build/images/users/user-dummy-img.jpg");
                return '<img src="' .
                    $url .
                    '" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn("status", function ($data) {
                return view("layout::datatable.statustoggle", [
                    "data" => $data,
                ])->render();
            })
            ->addColumn("action", function ($data) {
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="' .
                    $data->id .
                    '" href="' .
                    route("user.edit", $data->id) .
                    '" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
            });

        return $datatables
            ->rawColumns(["pimage", "status", "action"])
            ->make(true);
    }

    /*
     * user bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {
        if ($request->ajax()) {
            $data = UserModel::find($request->id);
            if ($data) {
                $data->update([
                    "status" => $request->status,
                ]);
                return response()->json([
                    "success" => "success",
                    "data" => $data,
                    "status" => $request->status,
                ]);
            }
            return response()->json([
                "success" => "fails",
                "data" => $data,
                "status" => $request->status,
            ]);
        }
        // Session::flash("success", "Status changed Successfully!!");
        return redirect()->back();
    }
    /*
     * user registration from frond end using ajax
     */
    public function ajaxRegister(Request $request)
    {
        $this->validate($request, [
            "email" => "required|unique:users,email|email|max:191",
            "password" => "required|min:4",
            "username" => "required|unique:users,username|max:191",
        ]);

        $data = new UserModel();
        $data->name = mb_convert_case(
            $request->username,
            MB_CASE_TITLE,
            "UTF-8"
        );
        $data->username = $request->username;
        $data->email = $request->email;

        $Hash = Hash::make($request->password);
        $data->password = $Hash;

        $config = Configurations::getParm("user", 1);
        $verification_type = $config->register_verification;
        if ($verification_type == 0) {
            $data->status = 1;
        } else {
            $data->status = 0;
        }

        $data->remember_token = md5(time() . rand());

        if ($data->save()) {
            $usertypemap = new UserGroupMapModel();
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id = 2;
            $usertypemap->save();
            Event::fire(new UserRegisteredEvent($data->id));
            $msg = "Users save successfully,Please Chack Your Mail Id";
        } else {
            $msg = "Something went wrong !! Please try again later !!";
        }
        $url = @Configurations::getParm("user", 1)->login_redirection_url;
        if (!$url) {
            $url = route("home");
        } else {
            $url = url("/") . $url;
        }

        return ["status" => 1, "message" => $msg, "url" => $url];
    }
    /*
     * user registration from frond end
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            "email" => "required|unique:users,email|email|max:191",
            "password" => "required",
            "username" => "required|unique:users,username|max:191",
        ]);

        if (Configurations::getParm("user", 1)->allow_user_registration != 1) {
            Session::flash("error", "Register is blocked");
            return redirect()->route("home");
        }
        $this->validate($request, [
            "email" => "required|unique:users,email|max:191",
            "password" => "required|min:4",
            "username" => "required|unique:users,username|max:191",
        ]);

        $data = new UserModel();
        $data->name = mb_convert_case(
            $request->username,
            MB_CASE_TITLE,
            "UTF-8"
        );
        $data->username = $request->username;
        $data->email = $request->email;

        $Hash = Hash::make($request->password);
        $data->password = $Hash;
        $config = Configurations::getParm("user", 1);
        $verification_type = @$config->register_verification;
        if ($verification_type == 0) {
            $data->status = 1;
        } else {
            $data->status = 0;
        }

        $data->remember_token = md5(time() . rand());

        if ($data->save()) {
            $usertypemap = new UserGroupMapModel();
            $usertypemap->user_id = $data->id;
            $usertypemap->group_id = 2;
            $usertypemap->save();
            Event::fire(new UserRegisteredEvent($data->id));
            $msg = "Users save successfully,Please Chack Your Mail Id";
        } else {
            $msg = "Something went wrong !! Please try again later !!";
        }

        Session::flash("success", $msg);
        return redirect()->back();

        //return ['status'=>1,'message'=>$msg];
    }
    /*
     * user login using ajax
     */
    public function ajaxLogin(Request $request)
    {
        $this->validate($request, [
            "username" => "required|exists:users,username|max:191",
            "password" => "required",
        ]);

        $user = User::check([
            "username" => $request->username,
            "password" => $request->password,
            "status" => 1,
        ]);

        if ($user) {
            $users = UserModel::where(
                "username",
                "=",
                $request->username
            )->first();
            Session::put([
                "ACTIVE_USER" => strval($users->id),
                "ACTIVE_USERNAME" => $users->username,
                "ACTIVE_EMAIL" => $users->email,
            ]);
            //change offline to online
            $users->online = 1;
            $users->ip = request()->ip();
            $users->lastactive = Carbon::now();
            $users->save();

            $url = @Configurations::getParm("user", 1)->login_redirection_url;

            if (!$url) {
                $url = route("home");
            } else {
                $url = url("/") . $url;
            }

            return ["status" => 1, "message" => "Success", "url" => $url];
        } else {
            return [
                "status" => 0,
                "message" => "user name and password is missmatch",
            ];
        }
    }
    /*
     * user login
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            "username" => "required|exists:users,username|max:191",
            "password" => "required",
        ]);

        $user = User::check([
            "username" => $request->username,
            "password" => $request->password,
            "status" => 1,
        ]);

        if ($user) {
            $users = UserModel::where(
                "username",
                "=",
                $request->username
            )->first();
            Session::put([
                "ACTIVE_USER" => strval($users->id),
                "ACTIVE_USERNAME" => $users->username,
                "ACTIVE_EMAIL" => $users->email,
            ]);
            //change offline to online
            $users->online = 1;
            $users->ip = request()->ip();
            $users->lastactive = Carbon::now();
            $users->save();

            $url = @Configurations::getParm("user", 1)->login_redirection_url;

            if (!$url) {
                $url = route("home");
            } else {
                $url = url("/") . $url;
            }

            Session::flash("success", "Login Successfull");
            return redirect($url);
        } else {
            Session::flash("error", "user name or password is missmatch");
            return redirect()->back();
        }
    }
    /*
     * activate user
     */
    public function activate($token)
    {
        $users = UserModel::where("remember_token", "=", $token)->first();
        if (count((array) $users)) {
            $users->status = 1;
            $users->remember_token = "";
            $users->save();
            Session::flash("success", "Account activated Successfully");
        } else {
            Session::flash("error", "Wrong Datas");
        }

        return redirect()->route("home");
    }
    /*
     * forget password
     */
    public function forgetPassword(Request $request)
    {
        $users = UserModel::with("group")
            ->where("email", "=", $request->email)
            ->first();
        if (count((array) $users)) {
            $user_group = User::getUserGroup($users->id);

            if (in_array(1, $user_group)) {
                return ["status" => 0, "message" => "Restricted Area"];
            }
            $users->remember_token = md5(time() . rand());
            $users->save();
            \CmsMail::setMailConfig();
            Mail::to($users->email)->queue(new ForgetPasswordMail($users));
            Session::flash("success", "Please Check Your Mail");

            if ($request->ajax()) {
                return ["status" => 1, "message" => "Please Check Your Mail"];
            }
        } else {
            Session::flash("error", "Wrong Email");
        }

        if ($request->ajax()) {
            return ["status" => 0, "message" => "Wrong Email"];
        }

        return redirect()->route("home");
    }
    /*
     * verifyForgetPassword from mail
     */
    public function verifyForgetPassword($token)
    {
        $users = UserModel::where("remember_token", "=", $token)->first();
        if (count((array) $users)) {
            return view("user::site.password_change", ["token" => $token]);
        } else {
            Session::flash("error", "Wrong Datas,Please Try agin Later");
        }

        return redirect()->route("home");
    }
    public function dochangePassword(Request $request)
    {
        $this->validate($request, [
            "password" => "required|same:re-enter-password",
            "re-enter-password" => "required",
            "token" => "required",
        ]);

        $users = UserModel::where(
            "remember_token",
            "=",
            $request->token
        )->first();
        if (count((array) $users)) {
            $users->remember_token = "";
            $Hash = Hash::make($request->password);
            $users->password = $Hash;
            $users->save();
            Session::flash("success", "Password Update Successfully");
        } else {
            Session::flash("error", "Wrong Datas,Please Try agin Later");
        }

        return redirect()->route("home");
    }
    /*
     * user logout
     */
    public function logout(Request $request)
    {
        $user = User::getUser();
        $users = UserModel::find($user->id);

        //change online to offline
        $users->online = 1;
        $users->ip = request()->ip();
        $users->lastactive = Carbon::now();
        $users->save();

        $request->session()->flush();

        $url = @Configurations::getParm("user", 1)->logout_redirection_url;
        if (!$url) {
            $url = "/";
        }
        Session::flash("success", "Logout Successfull");
        return redirect($url);
    }
    /*
     * my account page
     */
    public function account()
    {
        $user = User::getUser();

        return view("user::site.user", ["data" => $user]);
    }
    /*
     * update account
     */
    public function updateAccount(Request $request)
    {
        $id = User::getUser()->id;
        $this->validate($request, [
            "email" => "required|email|unique:users,email," . $id,
            "password" => "sometimes",
            "name" => "required",
            "username" => "required|unique:users,username," . $id,
            "mobile" => "min:9|max:15",
        ]);

        $data = UserModel::find($id);
        $data->name = mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8");
        $data->username = $request->username;
        $data->email = $request->email;
        if ($request->mobile) {
            $data->mobile = $request->mobile;
        }
        if ($request->image) {
            $user_obj = new User();
            $img = $user_obj->imageCreate(
                $request->image,
                "user" . DIRECTORY_SEPARATOR
            );
            $data->images = $img;
        }
        if ($request->password) {
            $Hash = Hash::make($request->password);
            $data->password = $Hash;
        }

        if ($data->save()) {
            $msg = "Account updated successfully";
            $class_name = "success";
        } else {
            $msg = "Something went wrong !! Please try again later !!";
            $class_name = "error";
        }

        Session::flash($class_name, $msg);
        return redirect()->back();
    }
    /*
     * configurations option
     */
    public function getConfigurationData()
    {
        $group = UserGroupModel::where("status", 1)
            ->where("id", "!=", 1)
            ->orderBy("group", "Asc")
            ->pluck("group", "id");

        return ["user_group" => $group];
    }
}
