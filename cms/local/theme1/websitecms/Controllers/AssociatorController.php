<?php

namespace cms\websitecms\Controllers;

use App\Http\Controllers\BaseResponseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\CmsAssociatorModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;

class AssociatorController extends BaseResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("websitecms::associator.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("websitecms:associator.edit", ["layout" => "create"]);
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
            "pimage" => "required|mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = new CmsAssociatorModel();
        $obj->save();
        if ($request->hasFile("pimage")) {
            $obj->addMedia($request->pimage)->toMediaCollection(
                CmsAssociatorModel::CMS_ASSOCIATOR_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("associator saved successfully"));
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
        $data = CmsAssociatorModel::find($id);
        return $this->sendResponse(
            $data,
            "Associator data fetched successfully"
        );
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
        $id = $request->edit_associator_id;
        $this->validate($request, [
            "pimage" => "mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = CmsAssociatorModel::find($id);

        if ($request->hasFile("pimage")) {
            $obj->clearMediaCollection(CmsAssociatorModel::CMS_ASSOCIATOR_PATH);
            $obj->addMedia($request->pimage)->toMediaCollection(
                CmsAssociatorModel::CMS_ASSOCIATOR_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Associator updated successfully"));
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
            CmsAssociatorModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Service deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("associator.index");
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

        $data = CmsAssociatorModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "image",
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new CmsAssociatorModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new CmsAssociatorModel())->getTable() .
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
                    "route" => "associator",
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
            $obj = CmsAssociatorModel::find($request->id);

            $obj->status = $request->status;

            $obj->save();
        }

        return response()->json([
            "success" => "success",

            "status" => $request->status,
        ]);
    }
}
