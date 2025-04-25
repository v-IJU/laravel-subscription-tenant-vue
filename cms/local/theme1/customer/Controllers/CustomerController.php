<?php

namespace cms\customer\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cms\customer\Models\CustomerModel;

use Yajra\DataTables\Facades\DataTables;


use Session;
use DB;
use CGate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer::admin.edit',['layout'=>'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3|max:50|unique:'.(new CustomerModel())->getTable().',name',
            'desc' => 'required|min:3|max:190',
            'status' => 'required',
        ]);
        $obj = new CustomerModel;
        $obj->name = $request->name;
        $obj->desc = $request->desc;
        $obj->status = $request->status;
        $obj->save();

        Session::flash('success','saved successfully');
        return redirect()->route('customer.index');
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
        $data = CustomerModel::find($id);
        return view('customer::admin.edit',['layout'=>'edit','data'=>$data]);
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
        $this->validate($request,[
            'name' => 'required|min:3|max:50|unique:'.(new CustomerModel())->getTable().',name,'.$id,
            'desc' => 'required|min:3|max:190',
            'status' => 'required',
        ]);
        $obj = CustomerModel::find($id);
        $obj->name = $request->name;
        $obj->desc = $request->desc;
        $obj->status = $request->status;
        $obj->save();

        Session::flash('success','saved successfully');
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        if(!empty($request->selected_customer))
        {
            $delObj = new CustomerModel;
            foreach ($request->selected_customer as $k => $v) {

                if($delItem = $delObj->find($v))
                {
                    $delItem->delete();

                }

            }

        }

        Session::flash("success","data Deleted Successfully!!");
        return redirect()->route("customer.index");
    }
    /*
    * get data
    */
    public function getData(Request $request) {
        CGate::authorize('view-customer');
        $sTart = ctype_digit($request->get('start')) ? $request->get('start') : 0 ;

        DB::statement(DB::raw('set @rownum='.(int) $sTart));


        $data = CustomerModel::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'),"id","name","desc",
            DB::raw('(CASE WHEN '.DB::getTablePrefix().(new CustomerModel())->getTable().'.status = "0" THEN "Disabled"
            WHEN '.DB::getTablePrefix().(new CustomerModel())->getTable().'.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status'));

        $datatables = Datatables::of($data)
            ->addColumn('check', function($data) {
                if($data->id != '1')
                    return $data->rownum;
                else
                    return '';
            })
            ->addColumn('actdeact', function($data) {
                if($data->id != '1'){
                    $statusbtnvalue=$data->status=="Enabled" ? "<i class='glyphicon glyphicon-remove'></i>&nbsp;&nbsp;Disable" : "<i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Enable";
                    return '<a class="statusbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="">'.$statusbtnvalue.'</a>';
                }
                else
                    return '';
            })
            ->addColumn('action',function($data){
                return '<a class="editbutton btn btn-default" data-toggle="modal" data="'.$data->id.'" href="'.route("customer.edit",$data->id).'" ><i class="glyphicon glyphicon-edit"></i>&nbsp;Edit</a>';
                //return $data->id;
            });



        // return $data;
        if(count((array) $data)==0)
            return [];

        return $datatables->make(true);
    }

    /*
     * country bulk action
     * eg : trash,enabled,disabled
     * delete is destroy function
     */
    function statusChange(Request $request)
    {
        CGate::authorize('edit-customer');

        if(!empty($request->selected_customer))
        {
            $obj = new CustomerModel();
            foreach ($request->selected_customer as $k => $v) {

                if($item = $obj->find($v))
                {
                    $item->status = $request->action;
                    $item->save();

                }

            }

        }

        Session::flash("success","Status changed Successfully!!");
        return redirect()->back();
    }

}
