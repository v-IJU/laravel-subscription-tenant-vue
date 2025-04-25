<?php
namespace cms\product\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ProductImportJob;
use App\Traits\ExcelUploadTrait;
use Bus;
use cms\core\configurations\helpers\Configurations;
use cms\product\Models\ProductModel;
use cms\product\Repositories\ProductRepository;
use cms\schoolclass\Models\SchoolclassModel;
use cms\school\Models\SchoolModel;
use cms\sizecategory\Models\ColorModel;
use cms\sizecategory\Models\SizecategoryModel;
use cms\sizecategory\Models\SizeModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Session;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use ExcelUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        return view("product::admin.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get master data
        $schoolNames = SchoolModel::where("status", 1)
            ->pluck("school_name", "id")
            ->toArray();

        $totalActiveClasses = SchoolclassModel::where("status", 1)
            ->pluck("name", "id")
            ->toArray();

        $totalActiveCategories = SizecategoryModel::where("status", 1)
            ->pluck("category_name", "id")
            ->toArray();

        $totalSizes = SizeModel::pluck("size", "id")->toArray();

        $genders = Configurations::GENDER;
        $pvsizes = Configurations::DRESS_SIZES;

        // store master data in a array
        $data = [
            "schoolNames"           => $schoolNames,
            "genders"               => $genders,
            "pvsizes"               => $pvsizes,
            "totalActiveClasses"    => $totalActiveClasses,
            "totalSizes"            => $totalSizes,
            "totalActiveCategories" => $totalActiveCategories,
            "layout"                => "create",
        ];

        return view("product::admin.edit", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "school_name"      => "required",
            "school_class"     => "required",
            "child_gender"     => "required",
            "product_category" => "required",

            "product_name"     =>
            "required|min:3|max:50|unique:products,product_name",
            "product_desc"     => "nullable|min:3|max:190",
            "product_rate"     => "required|numeric|between:0,10000",
            "product_gst"      => "required|numeric|between:0,100",
        ];
        $messages = [
            "school_name.required"      => "At least one school must be selected.",
            "school_class.required"     => "At least one class must be selected.",
            "child_gender.required"     => "At least one gender must be selected.",
            "product_category.required" =>
            "At least one category must be selected.",

            "product_rate.required"     => "Product rate is required.",
            "product_gst.required"      => "Product GST is required.",
            "product_rate.numeric"      => "Product rate allows number only",
            "product_gst.numeric"       => "Product GST allows number only.",
        ];

        if (isset($request["is_variable_product"])) {
            $rules = array_merge($rules, [
                "addmore"           => "required|array",
                "addmore.*.pvsizes" => "required|string",
                "addmore.*.pvrate"  => "required|numeric",
            ]);

            $messages = array_merge($messages, [
                "addmore.*.pvsizes.required" =>
                "Variant product size is required.",
                "addmore.*.pvrate.required"  =>
                "Variant product rate is required.",
                "addmore.*.pvrate.numeric"   =>
                "Variant product rate allows number only.",
            ]);
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->productRepository->createproduct($request->all());
        Session::flash("success", "Product saved successfully");
        return redirect()->route("product.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->productRepository->findProduct($id);

        $gender       = Configurations::GENDER[$data->gender_id];
        $sizeChartUrl = ProductModel::PRODUCT_SIZE_CHART;

        $datas = [
            "data"         => $data,
            "gender"       => $gender,
            "sizeChartUrl" => $sizeChartUrl,
        ];

        return view("product::admin.display", $datas);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cloneEdit($id)
    {
        $variantData = [];

        // get user selected parent data
        $data = $this->productRepository->findProduct($id);

        // get master classes data
        $totalActiveClasses = SchoolclassModel::where("status", 1)
            ->pluck("name", "id")
            ->toArray();

        $userSelectedCategory = SizecategoryModel::where(["status" => 1])
            ->pluck("category_name", "id")
            ->toArray();

        $totalSizes = SizeModel::where(
            "size_category_id",
            $data->category_attribute_id
        )
            ->pluck("size", "id")
            ->toArray();

        //get master school data
        $schoolNames = SchoolModel::where("status", 1)
            ->pluck("school_name", "id")
            ->toArray();

        $genders     = Configurations::GENDER;
        $pvsizes     = Configurations::DRESS_SIZES;
        $variantData = $data->variant;

        // store master data in a array
        $datas = [
            "data"                 => $data,
            "schoolNames"          => $schoolNames,
            "genders"              => $genders,
            "layout"               => "clone",
            "pvsizes"              => $pvsizes,
            "totalActiveClasses"   => $totalActiveClasses,
            "userSelectedCategory" => $userSelectedCategory,
            "totalSizes"           => $totalSizes,
            "variantData"          => $variantData,
        ];

        return view("product::admin.edit", $datas);
    }

    public function cloneStore(Request $request)
    {
        $rules = [
            "product_name" =>
            "required|min:3|max:50|unique:" .
            (new ProductModel())->getTable() .
            ",product_name",
            "product_desc" => "required|min:3|max:190",
            "school_name"  => "required",
            "child_gender" => "required",
            "school_class" => "required",
            "product_rate" => "required|numeric|between:0,10000",
            "product_gst"  => "required|numeric|between:0,100",
        ];
        $messages = [
            "school_name.required"  => "School name is required.",
            //"school_class.required" => "At least one class must be selected.",
            "child_gender.required" => "At least one gender must be selected.",
            "product_name.required" => "Product name is required.",
            "product_desc.required" => "Product description is required.",
            "product_rate.required" => "Product rate is required.",
            "product_gst.required"  => "Product GST is required.",
            "product_rate.numeric"  => "Product rate allows number only",
            "product_gst.numeric"   => "Product GST allows number only.",
        ];

        if (isset($request["is_variable_product"])) {
            $rules = array_merge($rules, [
                "addmore"           => "required|array",
                "addmore.*.pvsizes" => "required|string",
                "addmore.*.pvrate"  => "required|numeric",
            ]);

            $messages = array_merge($messages, [
                "addmore.*.pvsizes.required" =>
                "Variant product size is required.",
                "addmore.*.pvrate.required"  =>
                "Variant product rate is required.",
                "addmore.*.pvgst.required"   =>
                "Variant product GST is required.",
                "addmore.*.pvrate.numeric"   =>
                "Variant product rate allows number only.",
                //'addmore.*.pvgst.numeric' => 'Variant GST rate allows number only.',
            ]);
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->productRepository->createproduct($request->all());

        Session::flash("success", "Clone Product saved successfully");
        return redirect()->route("product.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $variantData = [];

        // get user selected parent data
        $data = $this->productRepository->findProduct($id);

        // get master classes data
        $totalActiveClasses = SchoolclassModel::where("status", 1)
            ->pluck("name", "id")
            ->toArray();

        $userSelectedCategory = SizecategoryModel::where(["status" => 1])
            ->pluck("category_name", "id")
            ->toArray();

        //dd($userSelectedCategory);
        $totalSizes = SizeModel::where(
            "size_category_id",
            $data->category_attribute_id
        )
            ->pluck("size", "id")
            ->toArray();

        //get master school data
        $schoolNames = SchoolModel::where("status", 1)
            ->pluck("school_name", "id")
            ->toArray();

        $genders     = Configurations::GENDER;
        $pvsizes     = Configurations::DRESS_SIZES;
        $variantData = $data->variant;

        // store master data in a array
        $datas = [
            "data"                 => $data,
            "schoolNames"          => $schoolNames,
            "genders"              => $genders,
            "layout"               => "edit",
            "pvsizes"              => $pvsizes,
            "totalActiveClasses"   => $totalActiveClasses,
            "userSelectedCategory" => $userSelectedCategory,
            "totalSizes"           => $totalSizes,
            "variantData"          => $variantData,
        ];

        return view("product::admin.edit", $datas);
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
        //dd($request->all());
        $this->validate($request, [
            "product_name" =>
            "required|min:3|max:50|unique:" .
            (new ProductModel())->getTable() .
            ",product_name," .
            $id,
            "product_desc" => "nullable|min:3|max:190",
            "school_name"  => "required",
            "child_gender" => "required",
            "school_class" => "required",
            "product_rate" => "required",
            "product_gst"  => "required",
        ]);

        //call product repository with validated data
        $this->productRepository->updateProduct($id, $request->all());

        Session::flash("success", "Product updated successfully");
        return redirect()->route("product.index");
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
            ProductModel::where("id", $id)->delete();
            Session::flash(
                "success",
                "Selected Product Deleted Successfully!!"
            );
        } else {
            Session::flash("error", "No Product details found!!");
        }
        return redirect()->route("product.index");
    }
    /*
     * get data
     */
    public function getData(Request $request)
    {
        $data = ProductModel::select(
            DB::raw("@rownum  := @rownum  + 1 AS rownum"),
            "products.id as id",
            "products.product_code as product_code",
            "products.product_name as product_name",
            "products.is_variable_product as is_variable_product",
            "products.status as p_sttaus",
            "school_master.school_name as school_name",
            "school_class.name as class_name",
            DB::raw(
                "(CASE WHEN " .
                DB::getTablePrefix() .
                (new ProductModel())->getTable() .
                '.status = "0" THEN "Disabled"
            WHEN ' .
                DB::getTablePrefix() .
                (new ProductModel())->getTable() .
                '.status = "-1" THEN "Trashed"
            ELSE "Enabled" END) AS status'
            )
        )
            ->leftjoin("school_master", "school_master.id", "=", "products.school_id")
            ->leftjoin("school_class", "school_class.id", "=", "products.class_id")
            ->orderBy("id", "desc");

        //$data = $data->orderBy("id", "desc")->get();

        $datatables = Datatables::of($data)
            ->addColumn("pimage", function ($data) {
                if ($data->image_url != null) {
                    $url = asset($data->image_url);
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
            ->addColumn("status", function ($data) {
                return view("layout::datatable.statustoggle", [
                    "data" => $data,
                ])->render();
            })
            ->addColumn("action", function ($data) {
                return view("layout::datatable.actionnew", [
                    "data"        => $data,
                    "id"          => $data->id,
                    "route"       => "product",
                    "showEdit"    => true,
                    "showDelete"  => true,
                    "showView"    => true,
                    "showClone"   => true,
                    "editRoute"   => "product.edit",
                    "deleteRoute" => "product.destroy",
                    "viewRoute"   => "product.show",
                    "cloneRoute"  => "product.clone",
                ])->render();
            });

        if (count((array) $data) == 0) {
            return [];
        }

        return $datatables
            ->addIndexColumn()
            ->rawColumns(["pimage", "status", "action"])
            ->make(true);
    }

    public function statusChange(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductModel::find($request->id);

            if ($data) {
                $data->update([
                    "status" => $request->status,
                ]);
                return response()->json([
                    "success" => "success",
                    "data"    => $data,
                    "status"  => $request->status,
                ]);
            }
            return response()->json([
                "success" => "fails",
                "data"    => $data,
                "status"  => $request->status,
            ]);
        }

        return redirect()->back();
    }

    public function filterCategoryList(Request $request)
    {
        $genderId = $request->input("genderId");

        if (! $genderId) {
            return response()->json(["error" => "Gender ID is required"], 400);
        }

        // Fetch the sizecategories
        $sizecategories = SizecategoryModel::where("gender", $genderId)
            ->where("status", 1)
            ->pluck("category_name", "id");

        $formattedData = [];

        foreach ($sizecategories as $id => $name) {
            $formattedData[] = ["id" => $id, "text" => $name];
        }

        return response()->json(["sizecategories" => $formattedData]);
    }

    public function filterSizeList(Request $request)
    {
        $sizeCategoryId = $request->input("sizeCategoryId");

        if (! $sizeCategoryId) {
            return response()->json(
                ["error" => "Category ID is required"],
                400
            );
        }

        // Fetch the sizes
        $sizes = SizeModel::where("size_category_id", $sizeCategoryId)
            ->where("status", 1)
            ->pluck("size", "id");

        $sizeData = [];

        foreach ($sizes as $id => $name) {
            $sizeData[] = [
                "id"   => $id,
                "size" => $name,
            ];
        }

        return response()->json(["sizes" => $sizeData]);
    }

    public function filterColorList(Request $request)
    {
        $sizeCategoryId = $request->input("sizeCategoryId");

        if (! $sizeCategoryId) {
            return response()->json(
                ["error" => "Category ID is required"],
                400
            );
        }

        // Fetch the colors
        $colors = ColorModel::where("size_category_id", $sizeCategoryId)
            ->where("status", 1)
            ->pluck("color", "id");

        $colorData = [];

        foreach ($colors as $id => $name) {
            $colorData[] = [
                "id"    => $id,
                "color" => $name,
            ];
        }

        return response()->json(["colors" => $colorData]);
    }

    public function fileManagerStore()
    {
        return view("product::admin.filemanager");
    }
    public function import(Request $request)
    {
        try {
            if ($request->isMethod("post")) {
                try {
                    if ($request->hasFile("upload_file")) {
                        $school_id = $request->school_name;
                        $classes   = $request->school_class;
                        $filename  = $this->uploadAttachment(
                            $request->file("upload_file")
                        );
                        $file = storage_path(
                            "tmp/uploads/excel_files/" . $filename
                        );

                        $data = file($file);

                        $header = [];

                        $chunks = array_chunk($data, 1000);

                        $batch = Bus::batch([])->dispatch();

                        foreach ($chunks as $key => $chunk) {
                            # code...
                            $data = array_map("str_getcsv", $chunk);
                            if ($key === 0) {
                                $header = $data[0];
                                unset($data[0]);
                            }

                            $batch->add(
                                new ProductImportJob(
                                    $filename,
                                    "product",
                                    $data,
                                    $header,
                                    $school_id,
                                    $classes
                                )
                            );
                        }
                        $this->cleanExcel($filename);

                        Session::flash("success", "Import Added to Queue");
                        return redirect(route("product.index"));
                    }
                } catch (\Exception $e) {
                    Session::flash("error", $e->getMessage());

                    return redirect(route("product.index"));
                }
            }

            $schoolNames = SchoolModel::where("status", 1)
                ->pluck("school_name", "id")
                ->toArray();

            //dd(storage_path("app/tmp/uploads/excel_files"));

            return view("product::admin.import", compact("schoolNames"));
        } catch (\Exception $e) {
            dd($e);
            Session::flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}
