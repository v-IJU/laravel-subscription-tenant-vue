<?php

namespace cms\core\configurations\Traits;
use Image;
use Auth;
use Session;
use File;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Facades\Image as FacadesImage;
trait FileUploadTrait
{
    public function uploadImage(
        $image = null,
        $type = null,
        $disk = "s3",
        $model = null,
        $collection = null,
        $is_delete = false,
        $is_custom = false,
        $is_url = false,
        $url = null
    ) {
        if ($disk == "s3") {
            // for s3 storage
            if ($is_delete) {
                // delete image and add new
                $model->clearMediaCollection($collection);
            }

            if ($is_url) {
                $mediaId = $model
                    ->addMediaFromUrl($url)
                    ->toMediaCollection($collection, $disk);
            } else {
                $mediaId = $model
                    ->addMedia($image)
                    ->toMediaCollection($collection, $disk);
            }

            if ($is_custom) {
                // getting download url

                return $mediaId->getFullUrl();
            }

            return $mediaId->id;
        } else {
            if ($is_delete) {
                $model->clearMediaCollection($collection);
            }
            // for local storage
            $mediaId = $model
                ->addMedia($image)
                ->toMediaCollection($collection, config("app.media_disc"))->id;
        }
    }

    public function storeProfileImage($model, $image, $collection)
    {
        try {
            $mediaId = $model
                ->addMedia($image)
                ->toMediaCollection($collection, config("app.media_disc"))->id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateProfileImage($model, $image, $collection)
    {
        $model->clearMediaCollection($collection);
        $mediaId = $model
            ->addMedia($image)
            ->toMediaCollection($collection, config("app.media_disc"))->id;
    }

    public function retrieveMediaFiles($model, $collection)
    {
        $files = [];
        if ($model) {
            $mediaItems = $model->getMedia($collection);

            foreach ($mediaItems as $key => $mediaItem) {
                $url = $mediaItem->getFullUrl();
                $name = $mediaItem->getCustomProperty("name");
                if (!$name) {
                    $name = $mediaItem->name;
                }
                array_push($files, [
                    "id" => $mediaItem->id,
                    "url" => $url,
                    "mime" => $mediaItem->mime_type,
                    "timestamp" => $mediaItem->created_at->format(
                        "Y-m-d H:i A"
                    ),

                    "name" => preg_replace(
                        "/[^A-Za-z0-9]/",
                        " ",
                        preg_replace('/\.\w+$/', "", $name)
                    ),
                ]);
            }
        }

        return $files;
    }

    public function CoverImage($image, $path)
    {
        $make_name =
            hexdec(uniqid()) . "." . $image->getClientOriginalExtension();
        Image::make($image)
            ->resize(1920, 1080)
            ->save($path . $make_name);
        $uploadPath = "/" . $path . $make_name;

        return $uploadPath;
    }
    public function ProductImage($image, $path)
    {
        $make_name =
            hexdec(uniqid()) . "." . $image->getClientOriginalExtension();
        Image::make($image)
            ->resize(200, 200)
            ->save($path . $make_name);
        $uploadPath = "/" . $path . $make_name;

        return $uploadPath;
    }
    public function uploadAttachment($image, $type = null, $path = null)
    {
        $extensions = ["jpeg", "png", "gif", "svg", "jpg"];

        $type = $image->getClientOriginalExtension();

        if (!file_exists(public_path($path . "/"))) {
            File::makeDirectory(
                public_path($path . "/"),
                $mode = 0775,
                true,
                true
            );
        }

        // dd($type);

        $make_name =
            hexdec(uniqid()) . "." . $image->getClientOriginalExtension();

        if (in_array($type, $extensions)) {
            Image::make($image)->save($path . $make_name);
        } else {
            $image->move($path, $make_name);
        }

        $uploadPath = "/" . $path . $make_name;

        //  dd($uploadPath);

        return $uploadPath;
    }
    public function uploadFile($file, $type = null)
    {
        $make_name =
            hexdec(uniqid()) . "." . $file->getClientOriginalExtension();
        $file->move("files/certificates", $make_name);
        $uploadPath = "/files/certificates/" . $make_name;

        return $uploadPath;
    }
    public function deleteImage($path_to_image_directory = "/", $image = "")
    {
        if ($image) {
            $fname = public_path() . $image;

            if ($this->fileexistcheck($fname)) {
                unlink($fname);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function fileexistcheck($filename)
    {
        if (File::exists($filename)) {
            return true;
        } else {
            return false;
        }
    }

    public function resizeAndStoreFile(
        $model,
        $file,
        $driver = "s3",
        $collection,
        $uuid,
        $dimension = [],
        $is_delete = false
    ) {
        try {
            if (!file_exists(storage_path("tmp/uploads/" . $uuid . "/"))) {
                File::makeDirectory(
                    storage_path("tmp/uploads/" . $uuid . "/"),
                    $mode = 0775,
                    true,
                    true
                );
            }
            try {
                $fileName = $file->getClientOriginalName();
            } catch (\Throwable $th) {
                $fileName = $file->getBasename();
            }

            $fileName = hexdec(uniqid()) . "_" . $fileName;

            // Move the uploaded file to the temporary folder without resizing
            $file->move(storage_path("tmp/uploads/" . $uuid), $fileName);

            // Full file path of the stored image
            $imagePath = storage_path("tmp/uploads/" . $uuid . "/" . $fileName);

            if ($is_delete) {
                // delete image and add new
                $model->clearMediaCollection($collection);
            }
            $mediaId = $model
                ->addMedia($imagePath)
                ->preservingOriginal()
                ->withCustomProperties([
                    "source" => "local",
                    "name" => $fileName,
                    "created_by" => $uuid,
                ])
                ->usingFileName($fileName)
                ->toMediaCollection($collection, "s3");

            $this->CleanDirectoryTemp($uuid);
            $url = $mediaId->getFullUrl();
            // $url =
            //     config("services.awss3.aws_url") . "/" . $mediaId->id . "/" . $fileName;

            return [$url, $fileName, $mediaId->id];
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    public function CleanDirectoryTemp($id)
    {
        $file = new Filesystem();
        $file->cleanDirectory("tmp/uploads/" . $id);
        $file->cleanDirectory(storage_path("tmp/uploads/" . $id));
    }
}
