<?php


namespace App\Classes;


class Upload{
    protected $filename;
    protected $max_filesize = 2097152;
    protected $extension;
    protected $path;

    public function get_filename(){
        return $this->filename;
    }

    protected function set_name($file, $name=""){
        if($name === ''){
            $name = pathinfo($file, PATHINFO_FILENAME);
        }
        //Replace unwanted characters from the filename if any
        $name = strtolower(str_replace(['-',' '], '_', $name));
        $hash = md5(microtime());
        $ext = $this->fileExtension($file);
        $this->filename = "{$name}-{$hash}.{$ext}";
    }

    protected function fileExtension($file){
        return $this->extension = pathinfo($file, PATHINFO_EXTENSION);
    }

    public static function file_size($file){
        $fileObj = new static();
        return $file > $fileObj->max_filesize ? true : false;
    }

    public static function is_image($file){
        $fileObj = new static();
        $ext = $fileObj->fileExtension($file);
        $valid_ext = array('jpg', 'jpeg', 'png');
        if(!in_array(strtolower($ext), $valid_ext)){
            return false;
        }
        return true;
    }

    public function path(){
        return $this->path;
    }

    public static function move($temp_path, $folder, $file, $new_filename=""){
        $fileObj = new static();
        $ds =  DIRECTORY_SEPARATOR;

        $fileObj->set_name($file, $new_filename);
        $file_name = $fileObj->get_filename();
        if(!dir($folder)){
            mkdir($folder, 0777, true);
        }

        $fileObj->path = "{$folder}{$ds}{$file_name}";
        $absolute_path = BASE_PATH."{$ds}public{$ds}$fileObj->path";


        if(move_uploaded_file($temp_path, $absolute_path)){
            return $fileObj;
        }
        return null;
    }

}