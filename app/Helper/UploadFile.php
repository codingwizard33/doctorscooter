<?php


namespace App\Helper;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Picqer\Barcode\BarcodeGeneratorPNG;

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

    public static function base64($base64fileString, $typeFile = 'image')
    {
        if (!$base64fileString) {
            return null;
        }
        $random = Str::random(40);
        $f = finfo_open();

        $fileKay = 1;
        if ($typeFile === 'image'){
            $mime_type = finfo_buffer($f, base64_decode(explode(',',$base64fileString)[1]), FILEINFO_MIME_TYPE);
        }elseif ($typeFile === 'zip'){
            $mime_type = finfo_buffer($f, base64_decode($base64fileString), FILEINFO_MIME_TYPE);
        }elseif ($typeFile === 'pdf'){
            $fileKay = 0;
            $mime_type = finfo_buffer($f, base64_decode(explode(',',$base64fileString)[$fileKay]), FILEINFO_MIME_TYPE);
        }

        $type = explode('/',$mime_type);

        if (!is_dir(storage_path("/app/public/repair/order"))) {
            if(!is_dir(storage_path("/app/public/repair"))) {
                File::makeDirectory(storage_path("app/public/repair"));
            }
            File::makeDirectory(storage_path("app/public/repair/order"));
        }

        file_put_contents(storage_path('app/public/repair/order/'.$random.'.'.$type[1]),print_r(base64_decode(explode(',',$base64fileString)[$fileKay]),true));
        $req = 'storage/repair/order/'.$random.'.'.$type[1];

        if (!$req) {
            return null;
        }

        return $req;
    }


    public static function barCode($data)
    {
        //  https://github.com/picqer/php-barcode-generator

        $random = Str::random(40);
        $redColor = [0, 0, 0];
        $generator = new BarcodeGeneratorPNG();
        $bar = $generator->getBarcode($data, $generator::TYPE_CODE_128, 3, 50, $redColor);



//        $pathArray = explode('/', $path);
//        $pathArray = array_filter($pathArray);
//        $path = implode('/', $pathArray);
//
//        if (!is_dir(storage_path("/app/public/". $path))) {
//            $namePath = '';
//            foreach ($pathArray as $item){
//                $namePath = $namePath.'/'.$item;
//                if(!is_dir(storage_path("/app/public".$namePath))) {
//                    File::makeDirectory(storage_path("app/public".$namePath));
//                }
//            }
//        }


        if (!is_dir(storage_path("/app/public/repair/order/barcode"))) {
            if(!is_dir(storage_path("/app/public/repair"))) {
                File::makeDirectory(storage_path("app/public/repair"));
            }
            if(!is_dir(storage_path("/app/public/repair/order"))) {
                File::makeDirectory(storage_path("app/public/repair/order"));
            }
            File::makeDirectory(storage_path("app/public/repair/order/barcode"));
        }



        file_put_contents(storage_path('app/public/repair/order/barcode/'.$random.'.png'), $bar);
        $req = 'storage/repair/order/barcode/'.$random.'.png';
        return $req;
    }

}
