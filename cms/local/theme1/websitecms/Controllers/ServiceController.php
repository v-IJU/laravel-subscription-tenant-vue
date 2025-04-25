<?php

namespace cms\websitecms\Controllers;

use App\Http\Controllers\BaseResponseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\CmsSeviceModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;

class ServiceController extends BaseResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("websitecms::service.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("websitecms::admin.edit", ["layout" => "create"]);
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
            "service_name" =>
                "required|min:3|max:50|unique:" .
                (new CmsSeviceModel())->getTable() .
                ",service_name",
            "description" => "nullable|min:3|max:190",
        ]);
        $obj = new CmsSeviceModel();
        $obj->service_name = $request->service_name;
        $obj->description = $request->description;
        $obj->status = 1;
        $obj->save();

        return $this->sendSuccess(__("Service saved successfully"));
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
        $data = CmsSeviceModel::find($id);
        return $this->sendResponse($data, "Service fetched successfully");
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
            "service_name" =>
                "required|min:3|max:50|unique:" .
                (new CmsSeviceModel())->getTable() .
                ",service_name," .
                $id,
            "description" => "nullable|min:3|max:190",
        ]);
        $obj = CmsSeviceModel::find($id);
        $obj->service_name = $request->service_name;
        $obj->description = $request->description;
        $obj->status = 1;
        $obj->save();

        return $this->sendSuccess(__("Service updated successfully"));
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
            CmsSeviceModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Service deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("service.index");
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

        $data = CmsSeviceModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "service_name",
            "description",
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new CmsSeviceModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new CmsSeviceModel())->getTable() .
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
            ->addColumn("action", function ($data) {
                return view("layout::datatable.popupaction", [
                    "data" => $data,

                    "route" => "service",
                ])->render();
            });

        // return $data;
        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables
            ->addIndexColumn()
            ->rawColumns(["status", "action"])
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
            $obj = CmsSeviceModel::find($request->id);

            $obj->status = $request->status;

            $obj->save();
        }

        return response()->json([
            "success" => "success",

            "status" => $request->status,
        ]);
    }
}
