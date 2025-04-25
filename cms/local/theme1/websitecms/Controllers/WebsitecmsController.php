<?php

namespace cms\websitecms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\websitecms\Models\WebsitecmsModel;

use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;
use cms\websitecms\Repositories\FrontSettingsCmsRepository;
use cms\websitecms\Models\FrontSettingCmsModel;

class WebsitecmsController extends Controller
{
    private $frontSettingCmsRepository;

    public function __construct(
        FrontSettingsCmsRepository $frontSettingCmsRepository
    ) {
        $this->frontSettingCmsRepository = $frontSettingCmsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $section = null)
    {
        $frontSettings = FrontSettingCmsModel::pluck("value", "key")->toArray();
        $sectionName = $section === null ? "cms" : $section;
        $view = "websitecms::admin.$sectionName";
        // dd($frontSettings);
        return view($view, compact("frontSettings"));
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
        if ($id == 1)  {
            $this->validate($request, [
                "home_page_title" => "required|min:3|max:20",
                "home_page_description" => "required|min:3|max:85",
            ]);
        }
        elseif ($id == 2) {
            $this->validate($request, [                                
                "about_us" => "required|min:3|max:20",
                "about_us_title" => "required|min:3|max:25",
                "about_us_section1_title" => "required|min:3|max:30",
                "about_us_section1_description" => "required|min:3|max:250",
                "about_us_section2_title" => "required|min:3|max:30",
                "about_us_section2_description" => "required|min:3|max:250",
                "about_us_section3" => "required|min:3|max:100",
                "about_us_section3_title" => "required|min:3|max:50",
                "about_us_section3_description" => "required|min:3|max:250",
            ]);
        }
        elseif ($id == 3) {
            $this->validate($request, [
                "services_banner_title" => "required|min:3|max:20",
                "services_banner_description" => "required|min:3|max:85",
                "services" => "required|min:3|max:10",
                "services_title" => "required|min:3|max:25",
                "services_description" => "required|min:3|max:85",
            ]);
        }
        elseif ($id == 4) {
            $this->validate($request, [
                "industries" => "required|min:3|max:10",
                "industries_title" => "required|min:3|max:30",
                "industries_description" => "required|min:3|max:85",
            ]);
        }
        elseif ($id == 5) {
            $this->validate($request, [
                "associator" => "required|min:3|max:10",
                "associator_title" => "required|min:3|max:30",
                "associator_description" => "required|min:3|max:85",
            ]);
        }
        elseif ($id == 6) {
            $this->validate($request, [
                "feedback" => "required|min:3|max:10",
                "feedback_title" => "required|min:3|max:30",
                "feedback_description" => "required|min:3|max:85",
            ]);
        }
        elseif ($id == 7) {
            $this->validate($request, [
                "contactus_banner_title" => "required|min:3|max:20",
                "contactus_banner_description" => "required|min:3|max:85",
                "contactus_section1_title" => "required|min:3|max:20",
                "contactus_section1_description" => "required|min:3|max:85",
                "contactus_section2_title" => "required|min:3|max:20",
                "contactus_section2_description" => "required|min:3|max:85",
                "contactus_section3_title" => "required|min:3|max:20",
                "contactus_section3_description" => "required|min:3|max:85",
            ]);
        }

        $input = $request->all();

        $this->frontSettingCmsRepository->update($input, $id);

        Session::flash("success", "saved successfully");
        return redirect()->route("websitecms.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!empty($request->selected_websitecms)) {
            $delObj = new WebsitecmsModel();
            foreach ($request->selected_websitecms as $k => $v) {
                if ($delItem = $delObj->find($v)) {
                    $delItem->delete();
                }
            }
        }

        Session::flash("success", "data Deleted Successfully!!");
        return redirect()->route("websitecms.index");
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

        $data = WebsitecmsModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "name",
            "desc",
            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new WebsitecmsModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new WebsitecmsModel())->getTable() .
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
                    route("websitecms.edit", $data->id) .
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
        CGate::authorize("edit-websitecms");

        if (!empty($request->selected_websitecms)) {
            $obj = new WebsitecmsModel();
            foreach ($request->selected_websitecms as $k => $v) {
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
