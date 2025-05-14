<?php

namespace cms\core\institute\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\TenantInstituteJob;
use App\Models\DomainModel;
use App\Models\Multitenant;
use cms\core\institute\Models\InstituteModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;
use cms\core\user\Models\UserModel;
use cms\core\subscription\Models\SubscriptionModel;
use cms\core\subscription\Models\SubscriptionUser;
use Illuminate\Support\Facades\Hash;
use cms\core\module\Models\ModuleModel;
use cms\core\subscription\Models\PlanFeatureModel;

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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect()
                ->route("institute.index")
                ->with("error", $message);
        }

        Session::flash("success", "saved successfully");
        return redirect()->route("institute.index");
    }

    public function onboard(Request $request, $id)
    {
        $tenant = null;
        ini_set("max_execution_time", 600);
        try {
            $institute = InstituteModel::find($id);
            $tenantId = strtolower(
                str_replace(" ", "_", $institute->institute_name)
            ); // Unique ID
            $tenant = Multitenant::create([
                "id" => $tenantId,
                "data" => [
                    "institute_id" => $institute->id,
                ],
            ]);

            $words = array_filter(explode(" ", $institute->institute_name));

            // Take first character of each word, make lowercase
            $abbr = "";
            foreach ($words as $word) {
                $abbr .= strtolower($word[0]);
            }
            $domain = DomainModel::create([
                "tenant_id" => $tenant->id,
                "domain" => $abbr . "." . config("app.domain"),
            ]);

            $subuser = SubscriptionUser::where(
                "user_id",
                $institute->id
            )->first();
            // $plan = SubscriptionModel::find($subuser->subscription_plan_id);
            $filterList = PlanFeatureModel::where(
                "subscription_plan_id",
                $subuser->subscription_plan_id
            )
                ->pluck("module_id")
                ->toArray();
            $modulesArray = ModuleModel::whereIn("id", $filterList)
                ->pluck("name")
                ->toArray();
            $moduleList = $modulesArray;
            Session::put(["module_list" => $moduleList]);
            dispatch(new TenantInstituteJob($tenant, $institute));
            $institute->tenant_id = $tenant->id;
            $institute->onboard_status = 1;
            $institute->save();
            \Log::channel("debug")->error("TenantUpdate2: ");

            \Log::channel("debug")->error("TenantUpdate3: ");
        } catch (\Exception $e) {
            if ($tenant) {
                $tenant->domains()->delete();
                $tenant->delete();
            }
            $message = $e->getMessage();
            return redirect()
                ->route("institute.index")
                ->with("error", $message);
        }
        Session::flash("success", "Onboarded successfully");
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
            "institute_name",
            "created_at",
            "onboard_status",
            "tenant_id",
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
            ->addColumn("created_date", function ($data) {
                return $data->created_at->format("d-m-Y");
            })
            ->addColumn("status", function ($data) {
                return view("layout::datatable.statustoggle", [
                    "data" => $data,
                ])->render();
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
                $domain = null;
                if ($data->tenant_id) {
                    $domain_info = DomainModel::where(
                        "tenant_id",
                        $data->tenant_id
                    )->first();
                    if ($domain_info) {
                        $domain = $domain_info->domain;
                    }
                }
                return view("layout::datatable.action", [
                    "data" => $data,
                    "route" => "institute",
                    "domain" => $domain,
                    // "authorize_edit" => CGate::authorizeEdit(
                    //     "edit-academicyear"
                    // ),
                    // "authorize_delete" => CGate::authorizeEdit(
                    //     "delete-academicyear"
                    // ),

                    //  "route1" => "examterm",
                ])->render();
            });

        // return $data;
        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables->rawColumns(["status", "action"])->make(true);
    }

    /*
     * country bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {
        CGate::authorize("edit-institute");

        if ($request->ajax()) {
            $data = InstituteModel::find($request->id);
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
