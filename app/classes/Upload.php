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

    public static function resize($file, $destination_file, $square_size = 128, $temp_path){

        list($original_width, $original_height) = getimagesize($file);
        if($original_width > $original_height){
            $new_height = $square_size;
            $new_width = $new_height*($original_width/$original_height);
        }
        if($original_height > $original_width){
            $new_width = $square_size;
            $new_height = $new_width*($original_height/$original_width);
        }
        if($original_height == $original_width){
                $new_width = $square_size;
                $new_height = $square_size;
        }

        $new_width = round($new_width);
        $new_height = round($new_height);

        // load the image
        if(substr_count(strtolower($file), ".jpg") or substr_count(strtolower($file), ".jpeg")){
            $original_image = imagecreatefromjpeg($temp_path);
        }
        if(substr_count(strtolower($file), ".gif")){
            $original_image = imagecreatefromgif($file);
        }
        if(substr_count(strtolower($file), ".png")){
            $original_image = imagecreatefrompng($file);
        }

        $smaller_image = imagecreatetruecolor($new_width, $new_height);
        $square_image = imagecreatetruecolor($square_size, $square_size);

        imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        if($new_width>$new_height){
            $difference = $new_width-$new_height;
            $half_difference =  round($difference/2);
            return imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
        }
        if($new_height>$new_width){
            $difference = $new_height-$new_width;
            $half_difference =  round($difference/2);
            return imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
        }
        if($new_height == $new_width){
            return imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
        }

        // if no destination file was given then display a png
        if(!$destination_file){
            return imagepng($square_image,NULL,9);
        }

        if(substr_count(strtolower($destination_file), ".jpg")){
          dd(imagejpeg($square_image,$destination_file,100));
        }
        if(substr_count(strtolower($destination_file), ".gif")){
            imagegif($square_image,$destination_file);
        }
        if(substr_count(strtolower($destination_file), ".png")){
            imagepng($square_image,$destination_file,9);
        }
    }

}