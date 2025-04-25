<?php

namespace cms\websitecms\Controllers;

use App\Http\Controllers\BaseResponseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\CmsFeedbackModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;

class FeedbackController extends BaseResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("websitecms::feedback.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("websitecms::feedback.edit", ["layout" => "create"]);
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
            "name" =>
                "required|min:3|max:50|unique:" .
                (new CmsFeedbackModel())->getTable() .
                ",name",
            "designation" => "required|min:3|max:190",
            "message" => "nullable|min:3|max:190",
            "pimage" => "required|mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = new CmsFeedbackModel();
        $obj->name = $request->name;
        $obj->designation = $request->designation;
        $obj->message = $request->message;
        $obj->save();

        if ($request->hasFile("pimage")) {
            $obj->addMedia($request->pimage)->toMediaCollection(
                CmsFeedbackModel::CMS_FEEDBACK_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Feedback saved successfully"));
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
        $data = CmsFeedbackModel::find($id);
        return $this->sendResponse($data, "Feedback data fetched successfully");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        //dd($request->hasFile("pimage"));
        $id = $request->edit_feedback_id;
        $this->validate($request, [
            "name" => "required|min:3|max:50|",
            "designation" => "nullable|min:2|max:190",
            "message" => "nullable|min:3|max:190",
            "pimage" => "mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = CmsFeedbackModel::find($id);
        $obj->name = $request->name;
        $obj->designation = $request->designation;
        $obj->message = $request->message;
        $obj->save();

        if ($request->hasFile("pimage")) {
            $obj->clearMediaCollection(CmsFeedbackModel::CMS_FEEDBACK_PATH);
            $obj->addMedia($request->pimage)->toMediaCollection(
                CmsFeedbackModel::CMS_FEEDBACK_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Feedback updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($id) {
            CmsFeedbackModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Service deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("feedback.index");
    }
    /*
     * get data
     */
    public function getData(Request $request)
    {
        CGate::authorize("view-websitecms");
        $sTart = ctype_digit($request->get("start"))
            ? $request->get("start")
            : 0;

        DB::statement(DB::raw("set @rownum=" . (int) $sTart));

        $data = CmsFeedbackModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "name",
            DB::raw("IFNULL(designation, 'N/A') AS designation"),
            DB::raw("IFNULL(message, 'N/A') AS message"),
            DB::raw("IFNULL(image, 'NA') AS image"),
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new CmsFeedbackModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new CmsFeedbackModel())->getTable() .
                    '.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status'
            )
        );

        $datatables = Datatables::of($data)

            ->addColumn("status", function ($data) {
                return view("layout::datatable.statustoggle", [
                    "data" => $data,
                ])->render();
            })
            ->addColumn("pimage", function ($data) {
                if ($data->image != null) {
                    $url = asset($data->image);
                    return '<img src="' .
                        $url .
                        '" border="0" width="40" class="img-rounded" align="center" />';
                } else {
                    $url = asset("build/images/users/user-dummy-img.jpg");
                    return '<img src="' .
                        $url .
                        '" border="0" width="40" class="img-rounded" align="center" />';
                }
            })
            ->addColumn("action", function ($data) {
                return view("layout::datatable.popupaction", [
                    "data" => $data,
                    "route" => "feedback",
                ])->render();
            });

        // return $data;
        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables
            ->addIndexColumn()
            ->rawColumns(["status", "action", "pimage"])
            ->make(true);
    }

    /*
     * country bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {
        CGate::authorize("edit-websitecms");
        if ($request->ajax()) {
            $obj = CmsFeedbackModel::find($request->id);

            $obj->status = $request->status;

            $obj->save();
        }

        return response()->json([
            "success" => "success",

            "status" => $request->status,
        ]);
    }
}
