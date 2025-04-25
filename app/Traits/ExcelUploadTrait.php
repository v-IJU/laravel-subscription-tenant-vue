<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * Class SaveTenantID
 */
trait ExcelUploadTrait
{
    public function uploadAttachment($file, $type = null)
    {
        $path = storage_path("tmp/uploads/excel_files");
        if (!\Storage::exists("tmp/uploads/excel_files")) {
            \Storage::makeDirectory(
                "tmp/uploads/excel_files",
                0775,
                true,
                true
            );
        }

        $name = uniqid() . "_" . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return $name;
    }

    public function cleanExcel($file)
    {
        if ($file) {
            $fname = storage_path() . "/tmp/uploads/excel_files/" . $file;

            if (\File::exists($fname)) {
                unlink($fname);

                \Log::channel("import")->info("File Exists Clean");
                return true;
            } else {
                \Log::channel("import")->info("File Not Exists Clean");
                return false;
            }
        } else {
            return false;
        }
    }
}
