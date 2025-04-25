<?php

namespace cms\websitecms\Controllers;

use App\Http\Controllers\BaseResponseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\CmsAboutusShopModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;

class AboutusShopController extends BaseResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("websitecms::aboutusshop.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("websitecms::aboutusshop.create", ["layout" => "create"]);
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
            "category" =>
                "required|min:3|max:50|unique:" .
                (new CmsAboutusShopModel())->getTable() .
                ",category",
            "title" => "required|min:3|max:190",
            "description" => "nullable|min:3|max:500",
            "pimage" => "required|mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = new CmsAboutusShopModel();
        $obj->category = $request->category;
        $obj->title = $request->title;
        $obj->description = $request->description;
        $obj->save();

        if ($request->hasFile("pimage")) {
            $obj->addMedia($request->pimage)->toMediaCollection(
                CmsAboutusShopModel::CMS_ABOUTUSSHOP_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Category saved successfully"));
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
        $data = CmsAboutusShopModel::find($id);
        return $this->sendResponse($data, "Category data fetched successfully");
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
        $id = $request->edit_aboutusshop_id;
        $this->validate($request, [
            "edit_category" => "min:3|max:50|",
            "edit_title" => "required|min:3|max:190",
            "edit_description" => "nullable|min:3|max:500",
            "pimage" => "mimes:jpg,jpeg,png,svg|max:2048",
        ]);
        $obj = CmsAboutusShopModel::find($id);
        $obj->category = $request->edit_category;
        $obj->title = $request->edit_title;
        $obj->description = $request->edit_description;
        $obj->save();

        if ($request->hasFile("pimage")) {
            $obj->clearMediaCollection(
                CmsAboutusShopModel::CMS_ABOUTUSSHOP_PATH
            );
            $obj->addMedia($request->pimage)->toMediaCollection(
                CmsAboutusShopModel::CMS_ABOUTUSSHOP_PATH,
                config("app.media_disc")
            );

            $obj->update(["image" => $obj->image_url]);
        }

        return $this->sendSuccess(__("Data updated successfully"));
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
            CmsAboutusShopModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Service deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("aboutusshop.index");
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

        $data = CmsAboutusShopModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "category",
            "title",
            DB::raw("IFNULL(description, 'N/A') AS description"),
            "image",
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new CmsAboutusShopModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new CmsAboutusShopModel())->getTable() .
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
                    "route" => "aboutusshop",
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
            $obj = CmsAboutusShopModel::find($request->id);

            $obj->status = $request->status;

            $obj->save();
        }

        return response()->json([
            "success" => "success",

            "status" => $request->status,
        ]);
    }
}
