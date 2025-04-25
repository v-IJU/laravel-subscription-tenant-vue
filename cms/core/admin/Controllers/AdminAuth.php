<?php

namespace cms\core\admin\Controllers;

use cms\core\user\helpers\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

//models
use cms\core\user\Models\UserModel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuth extends Controller
{
    /*
     * back end login
     */
    public function login()
    {
        return view("admin::login");
    }
    /*
     * back end do login
     */
    public function dologin(Request $request)
    {
        $this->validate($request, [
            "username" => "required|exists:users,username|max:191",
            "password" => "required",
        ]);

        $user = User::check([
            "username" => $request->username,
            "password" => $request->password,
        ]);

        if ($user) {
            $users = UserModel::where(
                "username",
                "=",
                $request->username
            )->first();
            $request->session()->put([
                "ACTIVE_USER" => strval($users->id),
                "ACTIVE_USERNAME" => $users->username,
                "ACTIVE_GROUP" => "Super Admin",
                "ACTIVE_EMAIL" => $users->email,
                "ACTIVE_MOBILE" => $users->mobile,
                "ACTIVE_USERIMAGE" => $users->images,
            ]);
            //change offline to online
            $users->online = 1;
            $users->ip = request()->ip();
            $users->lastactive = Carbon::now();
            $users->save();
            return redirect()->route("backenddashboard");
        } else {
            return redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors([
                    "This Credentials Doesn't Match our Records | Please Enter Valid Credentials",
                ]);
        }
    }
    /*
     * back end dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $userImage = UserModel::find($user->id);

        //accessing the image_url property on an instance of UserModel
        // it will indirectly call the getImageUrlAttribute method automatically through the accessor
        $image_url = $userImage->image_url;
        return view("admin::main", ["image_url" => $image_url]);
    }

    public function getdashboarddata(Request $request, $type = null)
    {
        switch ($type) {
            case "counts":
                # code...
                break;

            case "graph":
                # code...
                break;

            default:
                # code...
                break;
        }
    }
    /*
     * back end log out
     *
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

        $request->session()->flash("success", "Logout Successfull");
        return redirect("administrator/login");
    }
}
