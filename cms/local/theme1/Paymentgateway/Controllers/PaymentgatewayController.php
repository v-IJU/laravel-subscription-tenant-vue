<?php

namespace cms\Paymentgateway\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\Paymentgateway\Models\PaymentgatewayModel;
use cms\Paymentgateway\Repositories\PaymentGatewayRepository;
use cms\core\configurations\helpers\Configurations;
use Yajra\DataTables\Facades\DataTables;

use Session;
use DB;
use CGate;

class PaymentgatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $paymentGatewayRepository;

    public function __construct(
        PaymentGatewayRepository $paymentGatewayRepository
    ) {
        $this->paymentGatewayRepository = $paymentGatewayRepository;
    }
    public function index()
    {
        return view("Paymentgateway::admin.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Paymentgateway::admin.edit", [
            "razorpay_modes" => Configurations::RAZORPAY_MODE,
            "layout" => "create",
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
        $selected_rpaymode = $request->razorpay_mode;

        // name & mode validation
        $this->validate($request, [
            "gateway_name" =>
                "required|min:3|max:50|unique:" .
                (new PaymentgatewayModel())->getTable() .
                ",gateway_name",
            "razorpay_mode" => "required",
        ]);

        // return array based on selected razorpay mode
        $idKeyValidation = $this->getValidated($selected_rpaymode);

        // validate id & key
        $this->validate($request, $idKeyValidation);

        try {
            $this->paymentGatewayRepository->createPaymentGateway(
                $request->all()
            );
            Session::flash("success", "New Payment gateway added successfully");
            return redirect()->route("paymentgateway.index");
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->paymentGatewayRepository->findGateway($id);

        return view("Paymentgateway::admin.show", [
            "razorpay_modes" => Configurations::RAZORPAY_MODE,
            "data" => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->paymentGatewayRepository->findGateway($id);

        return view("Paymentgateway::admin.edit", [
            "razorpay_modes" => Configurations::RAZORPAY_MODE,
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
        $selected_rpaymode = $request->razorpay_mode;

        // will validate unique payment gateway name
        $this->validate($request, [
            "gateway_name" =>
                "required|min:3|max:50|unique:" .
                (new PaymentgatewayModel())->getTable() .
                ",gateway_name," .
                $id,
            "razorpay_mode" => "required",
        ]);

        // return array based on selected razorpay mode
        $idKeyValidation = $this->getValidated($selected_rpaymode);

        // validate id & key
        $this->validate($request, $idKeyValidation);

        try {
            //dd($request->all());
            $this->paymentGatewayRepository->updatePaymentGateway(
                $request->all(),
                $id
            );
            Session::flash(
                "success",
                "Payment gateway details updated successfully"
            );
            return redirect()->route("paymentgateway.index");
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
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
            PaymentgatewayModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Payment gateway deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No details found!!");
        }
        return redirect()->route("paymentgateway.index");
    }

    /*
     * get data
     */
    public function getData(Request $request)
    {
        //CGate::authorize('view-schoolclass');

        $data = PaymentgatewayModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "id",
            "gateway_name",
            "razorpay_mode",
            "status",

            DB::raw(
                "(CASE WHEN " .
                    DB::getTablePrefix() .
                    (new PaymentgatewayModel())->getTable() .
                    '.status = "0" THEN "Disabled"
            WHEN ' .
                    DB::getTablePrefix() .
                    (new PaymentgatewayModel())->getTable() .
                    '.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status'
            )
        );
        $data = $data->orderBy("gateway_name", "asc")->get();

        $datatables = Datatables::of($data)
            ->addColumn("status", function ($data) {
                return view("layout::datatable.statustoggle", [
                    "data" => $data,
                    "route" => "paymentgateway_status_change_from_admin",
                ]);
            })
            ->addColumn("action", function ($data) {
                return view("layout::datatable.actionnew", [
                    "data" => $data,
                    "id" => $data->id,
                    "route" => "paymentgateway",
                    "showEdit" => true,
                    "showDelete" => true,
                    "showView" => true,
                    "editRoute" => "paymentgateway.edit",
                    "deleteRoute" => "paymentgateway.destroy",
                    "viewRoute" => "paymentgateway.show",
                ]);
            });

        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables
            ->addIndexColumn()
            ->rawColumns(["status", "action"])
            ->make(true);

        // return $datatables->make(true);
    }

    function statusChange(Request $request)
    {
        // dd("its status");
        if ($request->ajax()) {
            $data = PaymentgatewayModel::find($request->id);

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
        // Session::flash("success", "Status changed Successfully!!");
        return redirect()->back();
    }

    protected function getValidated(string $selected_rpaymode): array
    {
        return $selected_rpaymode == "live"
            ? [
                "live_key_id" => "required|min:3|max:50|",
                "live_key_secret" => "required|min:3|max:50|",
            ]
            : [
                "test_key_id" => "required|min:3|max:50|",
                "test_key_secret" => "required|min:3|max:50|",
            ];
    }
}
