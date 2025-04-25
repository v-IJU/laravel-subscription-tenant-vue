<?php

namespace cms\product\Repositories;

use cms\product\Models\ProductModel;
use cms\product\Models\ProductVariantModel;
use cms\core\configurations\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use DB;

class ProductRepository
{
    use FileUploadTrait;

    protected $productModel;

    public function __construct(productModel $productModel)
    {
        $this->productModel = $productModel;
    }

    public function createproduct($request)
    {
        
        $inputData = [];
        try {
            // start a db transaction
            DB::beginTransaction();

            $inputData["product_code"] = $this->Generateproductcode();
            $inputData["school_id"] = $request["school_name"];
            $inputData["gender_id"] = $request["child_gender"];
            $inputData["product_name"] = $request["product_name"];
            $inputData["product_description"] = $request["product_desc"];
            $inputData["is_variable_product"] = isset(
                $request["is_variable_product"]
            )
                ? 1
                : 0;
            $inputData["rate"] = $request["inclusive_rate"];
            $inputData["gst"] = $request["product_gst"];
            $inputData["base_rate"] = $request["product_rate"];
            $inputData["class_id"] = $request["school_class"];
            $inputData["category_attribute_id"] = $request["product_category"];

            $product = $this->productModel->create($inputData);

            //[2] upload image
            if (isset($request["pimage"])) {
                // loop multiple images
                foreach ($request["pimage"] as $file) {
                    //dd($request["pimage"]);
                    $product
                        ->addMedia($file)
                        ->toMediaCollection(
                            ProductModel::COLLECTION_PRODUCT_PICTURES,
                            config("app.media_disc")
                        );
                }
            }

            //[3] get variant product details in array
            if (isset($request["is_variable_product"])) {
                foreach ($request["addmore"] as $singleVariant) {
                    $variant = ProductVariantModel::create([
                        "product_id" => $product->id,
                        "product_size_id" => $singleVariant["pvsizes"],
                        "rate" => isset($singleVariant["inclusive_rate"])
                            ? $singleVariant["inclusive_rate"]
                            : $singleVariant["pvrate"],
                        "base_rate" => $singleVariant["pvrate"],
                        "gst" => $product->gst,
                        "item_code" =>
                            $inputData["product_code"] .
                            "-" .
                            $singleVariant["pvsizes"],
                        "created_at" => now(),
                        "updated_at" => now(),
                        //"gst" => $singleVariant["pvgst"],
                    ]);

                    // store multiple variant images
                    if (isset($singleVariant["pvimage"])) {
                        $this->storeProfileImage(
                            $variant,
                            $singleVariant["pvimage"],
                            ProductVariantModel::COLLECTION_PRODUCT_VARIANT_PICTURES
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception(
                "Failed to create product. " . $e->getMessage()
            );
        }
    }

    public function updateProduct($id, $request)
    {
       
        $inputData = [];

        try {
            // start a db transaction
            DB::beginTransaction();

            // updates parent information in parent table
            $product = $this->productModel->findOrFail($id);

            $inputData["school_id"] = $request["school_name"];
            $inputData["gender_id"] = $request["child_gender"];
            $inputData["product_name"] = $request["product_name"];
            $inputData["product_description"] = $request["product_desc"];
            $inputData["is_variable_product"] =
                isset($request["is_variable_product"]) &&
                $request["is_variable_product"] == "on"
                    ? 1
                    : 0;
            $inputData["rate"] = $request["inclusive_rate"];
            $inputData["base_rate"] = $request["product_rate"];
            $inputData["gst"] = $request["product_gst"];
            $inputData["class_id"] = $request["school_class"];

            $product->update($inputData);

            //upload image
            if (isset($request["pimage"])) {
                // loop multiple images
                foreach ($request["pimage"] as $file) {
                    $this->updateProfileImage(
                        $product,
                        $file,
                        ProductModel::COLLECTION_PRODUCT_PICTURES
                    );
                }
            }

            if (
                isset($request["is_variable_product"]) &&
                $request["is_variable_product"] == "on"
            ) {
                //get variant product details in array
                foreach ($request["addmore"] as $singleVariant) {
                    // save variant's info to db
                    $variant = ProductVariantModel::findOrFail(
                        $singleVariant["variant_id"]
                    );

                    $variant->update([
                        "product_id" => $product->id,

                        "product_size_id" => $singleVariant["pvsizes"],
                        "rate" => isset($singleVariant["inclusive_rate"])
                            ? $singleVariant["inclusive_rate"]
                            : $singleVariant["pvrate"],
                        "base_rate" => $singleVariant["pvrate"],
                        "gst" => $request["product_gst"],
                        "updated_at" => now(),
                    ]);

                    // store multiple variant images
                    if (isset($singleVariant["pvimage"])) {
                        $this->updateProfileImage(
                            $variant,
                            $singleVariant["pvimage"],
                            ProductVariantModel::COLLECTION_PRODUCT_VARIANT_PICTURES
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception(
                "Failed to update product details. " . $e->getMessage()
            );
        }
    }

    public function findproduct($id)
    {
        try {
            $data = $this->productModel
                ->with(
                    "variant.sizecategoryinfo:id,category_name",
                    "variant.sizeinfo:id,size"
                )
                ->find($id);

            return $data;
        } catch (\Exception $e) {
            throw new \Exception(
                "Failed to get product information. " . $e->getMessage()
            );
        }
    }

    public static function Generateproductcode()
    {
        $lastProductCode = ProductModel::orderBy(
            "product_code",
            "desc"
        )->first();

        if ($lastProductCode) {
            $lastNumber = (int) substr($lastProductCode->product_code, 9);
        } else {
            $lastNumber = 0;
        }

        $newNumber = $lastNumber + 1;
        $currentYear = date("Y");
        $formattedNumber =
            "SCH-" .
            $currentYear .
            "-" .
            str_pad($newNumber, 3, "0", STR_PAD_LEFT);
        //dd($formattedNumber);

        return $formattedNumber;
    }
}
