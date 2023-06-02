<?php


namespace App\Helper;


class UploadFile
{

    public static function upload($file, $path)
    {
        if (!$file) {
            return null;
        }

        // $filePath =  UploadFile::upload($request->image, '/repair/order/');

        $pathDir = storage_path('app' . DIRECTORY_SEPARATOR . 'public').$path;
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $data_name = md5($name.microtime());
        $data = $data_name.'.'.$extension;
        $res = $file->move($pathDir, $data);
        $filePath = "/storage". $path . $data;

        if (!$res) {
            return null;
        }

        return $filePath;
    }
}