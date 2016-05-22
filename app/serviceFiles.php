<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceFiles extends Model
{
    protected $table = 'service_files';
    protected $fillable = ['name','filename','description'];
    
    static function uploadServiceFile($file){
        if($file){
            $filename = $file->getClientOriginalName();
            $file_extension = $file->getClientOriginalExtension();

            if(in_array($filename, ['index.htm','index.html','index.php','start.htm','start.html','start.php'])
                || in_array($file_extension, ['sh','exe','js'])){
                return false;
            }

            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/';
            $upload_success = $file->move($upload_path, $filename);

            if($upload_success){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}