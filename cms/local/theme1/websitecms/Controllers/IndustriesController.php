<?php

namespace cms\websitecms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\CmsIndustiresModel;
use App\Http\Controllers\BaseResponseController;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;
class IndustriesController extends BaseResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("websitecms::industries.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "industry_name" =>
                "required|min:3|max:50|unique:" .
                (new CmsIndustiresModel())->getTable() .
                ",industry_name",
            "description" => "nullable|min:3|max:190",
            "image" => "required|mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = new CmsIndustiresModel();
        $obj->industry_name = $request->industry_name;
        $obj->description = $request->description;
        $obj->save();
        if ($request->hasFile("image")) {
            $obj->addMedia($request->image)->toMediaCollection(
                CmsIndustiresModel::CMS_INDUSTRIES_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Data saved successfully"));
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
        $data = CmsIndustiresModel::find($id);
        $data->type = "industry";
        $data->image = asset($data->image);
        return $this->sendResponse($data, "Data fetched successfully");
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
        // dd($request->all());
        $id = $id ?? $request->edit_industry_id;
        $this->validate($request, [
            "industry_name" =>
                "required|min:3|max:50|unique:" .
                (new CmsIndustiresModel())->getTable() .
                ",industry_name," .
                $id,
            "description" => "nullable|min:3|max:190",
        ]);
        $obj = CmsIndustiresModel::find($id);
        $obj->industry_name = $request->industry_name;
        $obj->description = $request->description;
        $obj->save();
        if ($request->hasFile("image")) {
            $obj->clearMediaCollection(CmsIndustiresModel::CMS_INDUSTRIES_PATH);
            $obj->addMedia($request->image)->toMediaCollection(
                CmsIndustiresModel::CMS_INDUSTRIES_PATH,
                config("app.media_disc")
            );
            // dd($obj);
            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            CmsIndustiresModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Service deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("industries.index");
    }

    public function getData(Request $request)
    {
        CGate::authorize("view-websitecms");
        $sTart = ctype_digit($request->get("start"))
            ? $request->get("start")
            : 0;

        DB::statement(DB::raw("set @rownum=" . (int) $sTart));

        $data = CmsIndustiresModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "industry_name",
            "description",
            "created_at",
            "image",
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new CmsIndustiresModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new CmsIndustiresModel())->getTable() .
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
            ->addColumn("image", function ($data) {
                return '<img src="' .
                    asset($data->image) .
                    '" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn("action", function ($data) {
                return view("layout::datatable.popupaction", [
                    "data" => $data,

                    "route" => "industries",
                ])->render();
            });

        // return $data;
        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables
            ->addIndexColumn()
            ->rawColumns(["status", "action", "image"])
            ->make(true);
    }

    function statusChange(Request $request)
    {
        CGate::authorize("edit-websitecms");
        if ($request->ajax()) {
            $obj = CmsIndustiresModel::find($request->id);

            $obj->status = $request->status;

            $obj->save();
        }

        return response()->json([
            "success" => "success",

            "status" => $request->status,
        ]);
    }
}
