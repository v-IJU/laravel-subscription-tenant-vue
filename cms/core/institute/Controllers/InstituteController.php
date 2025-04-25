<?php

namespace cms\core\institute\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\TenantInstituteJob;
use App\Models\DomainModel;
use App\Models\Multitenant;
use cms\institute\Models\InstituteModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;
use cms\core\user\Models\UserModel;
use cms\core\subscription\Models\SubscriptionModel;
use cms\core\subscription\Models\SubscriptionUser;
use Illuminate\Support\Facades\Hash;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("institute::admin.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plans = SubscriptionModel::all();
        return view("institute::admin.edit", [
            "layout" => "create",
            "plans" => $plans,
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
        $request->validate([
            "institute_name" => "required|string|max:255",

            "subscription_plan_id" => "required|exists:subscription_plans,id",
        ]);
        try {
            DB::beginTransaction();

            //save institute basic information

            $institute = InstituteModel::create([
                "institute_name" => $request->institute_name,
            ]);

            // Get Plan Details
            $plan = SubscriptionModel::find($request->subscription_plan_id);

            // Create Subscription
            $subscription = SubscriptionUser::create([
                "user_id" => $institute->id,
                "subscription_plan_id" => $plan->id,
                "plan_amount" => $plan->price,
                "plan_frequency" => $plan->frequency,
                "starts_at" => now(),
                "ends_at" => now()->addMonths($plan->duration),
                "trail_ends_at" => now()->addDays($plan->trail_period),
                "status" => 1,
            ]);

            $tenantId = strtolower(
                str_replace(" ", "_", $request->institute_name)
            ); // Unique ID
            $tenant = Multitenant::create([
                "id" => $tenantId,
                "data" => [
                    "institute_id" => $institute->id,
                ],
            ]);

            $domain = DomainModel::create([
                "tenant_id" => $tenant->id,
                "domain" => "cms1" . "." . config("app.domain"),
            ]);

            dispatch(new TenantInstituteJob($tenant, $institute));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        Session::flash("success", "saved successfully");
        return redirect()->route("institute.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = InstituteModel::find($id);
        return view("institute::admin.edit", [
            "layout" => "edit",
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
            "name" =>
                "required|min:3|max:50|unique:" .
                (new InstituteModel())->getTable() .
                ",name," .
                $id,
            "desc" => "required|min:3|max:190",
            "status" => "required",
        ]);
        $obj = InstituteModel::find($id);
        $obj->name = $request->name;
        $obj->desc = $request->desc;
        $obj->status = $request->status;
        $obj->save();

        Session::flash("success", "saved successfully");
        return redirect()->route("institute.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!empty($request->selected_institute)) {
            $delObj = new InstituteModel();
            foreach ($request->selected_institute as $k => $v) {
                if ($delItem = $delObj->find($v)) {
                    $delItem->delete();
                }
            }
        }

        Session::flash("success", "data Deleted Successfully!!");
        return redirect()->route("institute.index");
    }
    /*
     * get data
     */
    public function getData(Request $request)
    {
        CGate::authorize("view-institute");
        $sTart = ctype_digit($request->get("start"))
            ? $request->get("start")
            : 0;

        DB::statement(DB::raw("set @rownum=" . (int) $sTart));

        $data = InstituteModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "name",
            "desc",
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new InstituteModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new InstituteModel())->getTable() .
                    '.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status'
            )
        );

        $datatables = Datatables::of($data)
            ->addColumn("check", function ($data) {
                if ($data->id != "1") {
                    return $data->rownum;
                } else {
                    return "";
                }
            })
            ->addColumn("actdeact", function ($data) {
                if ($data->id != "1") {
                    $statusbtnvalue =
                        $data->status == "Enabled"
                            ? "<i class='glyphicon glyphicon-remove'></i>&nbsp;&nbsp;Disable"
                            : "<i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Enable";
                    return '<a class="statusbutton btn btn-default" data-toggle="modal" data="' .
                        $data->id .
                        '" href="">' .
                        $statusbtnvalue .
                        "</a>";
                } else {
                    return "";
                }
            })
            ->addColumn("action", function ($data) {
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="' .
                    $data->id .
                    '" href="' .
                    route("institute.edit", $data->id) .
                    '" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });

        // return $data;
        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables->make(true);
    }

    /*
     * country bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {
        CGate::authorize("edit-institute");

        if (!empty($request->selected_institute)) {
            $obj = new InstituteModel();
            foreach ($request->selected_institute as $k => $v) {
                if ($item = $obj->find($v)) {
                    $item->status = $request->action;
                    $item->save();
                }
            }
        }

        Session::flash("success", "Status changed Successfully!!");
        return redirect()->back();
    }
}
