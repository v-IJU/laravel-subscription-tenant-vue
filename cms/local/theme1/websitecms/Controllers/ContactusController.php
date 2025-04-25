<?php

namespace cms\websitecms\Controllers;

use App\Http\Controllers\BaseResponseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\ContactusModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;

class ContactusController extends BaseResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("websitecms::contactus.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("websitecms::contactus.create", ["layout" => "create"]);
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
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "nullable",
            "description" => "required",
        ]);
        $obj = new ContactusModel();
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->phone = $request->phone;
        $obj->email = $request->email;
        $obj->subject = $request->subject;
        $obj->description = $request->description;
        $obj->save();

        return $this->sendSuccess(__("Details saved successfully"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ContactusModel::where("id", $id)->first();
        return view("websitecms::contactus.display", ["data" => $data]);
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
            ContactusModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected details deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("contactus.index");
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

        $data = ContactusModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            DB::raw("CONCAT(first_name, ' ', last_name) AS first_name"),
            "email",
            "phone",
            "subject",
            "description"
        );

        $datatables = Datatables::of($data)->addColumn("action", function (
            $data
        ) {
            return view("layout::datatable.actionnew", [
                "data" => $data,
                "id" => $data->id,
                "route" => "contactus",
                "showEdit" => false,
                "showDelete" => true,
                "showView" => true,
                "editRoute" => "contactus.edit",
                "deleteRoute" => "contactus.destroy",
                "viewRoute" => "contactus.show",
            ])->render();
        });

        // return $data;
        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables
            ->addIndexColumn()
            ->rawColumns(["action"])
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
            $obj = ContactusModel::find($request->id);

            $obj->status = $request->status;

            $obj->save();
        }

        return response()->json([
            "success" => "success",

            "status" => $request->status,
        ]);
    }
}
