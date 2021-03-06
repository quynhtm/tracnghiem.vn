<?php

namespace App\Library\AdminFunction;

use Illuminate\Support\Facades\Config;
use App\Services\UploadFile\UploadFileServices;

class Upload
{
    const APP_PATH_UPLOAD = 'uploads/images/';

    public function uploadFile($_name = '', $_file_ext = '', $folder = '', $_max_file_size = 5 * 1024 * 1024,$id=0, $is_return_path = true)
    {
        $_file_ext = ($_file_ext != '')?explode(',', $_file_ext):array("jpg", "jpeg", "png", "gif","mp3","mp4");
        if ($_name != '' && isset($_FILES[$_name]) && count($_FILES[$_name]) > 0) {
            $max_file_size = ($_max_file_size) ? $_max_file_size : 5 * 1024 * 1024;
            $file_name = strtolower($_FILES[$_name]['name']);
            $file_tmp = $_FILES[$_name]["tmp_name"];
            $file_size = $_FILES[$_name]['size'];
            $file_ext = @end(explode('.', $file_name));
            $name = date('d-m-Y-h-i-s', time()).'_'.Upload::preg_replace_string_upload($file_name);
            $name_file = $name ? $name : '';
            $ext = !in_array($file_ext, $_file_ext)? 0 : 1;

            $path_folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . env('APP_PATH_UPLOAD_MIDDLE',self::APP_PATH_UPLOAD) : Config::get('config.DIR_ROOT') .env('APP_PATH_UPLOAD_MIDDLE',self::APP_PATH_UPLOAD);
            if ($file_name != '' && $ext == 1 && $file_size <= $max_file_size) {
                $_folder = ($folder != '')? $folder: FOLDER_FILE_DEFAULT;
                $folder_upload = ($id > 0)? $path_folder_upload. '/' . $_folder.'/'.date('Y.m.d').'/'.$id : $path_folder_upload. '/' . $_folder.'/'.date('Y.m.d');
                $path_file = ($id > 0)? $_folder . '/' .date('Y.m.d').'/'.$id.'/'. $name : $_folder . '/' .date('Y.m.d').'/'. $name;

                if (!is_dir($folder_upload)) {
                    @mkdir($folder_upload, 0777, true);
                    chmod($folder_upload, 0777);
                }
                if (move_uploaded_file($file_tmp, $folder_upload . '/' . $name_file)) {
                    return ($is_return_path) ? $path_file : $name_file;
                } else {
                    return '';
                }
            }
            return '';
        }
    }

    public function removeFile($path_file=''){
        if(trim($path_file) != ''){
            $path_folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . env('APP_PATH_UPLOAD_MIDDLE',self::APP_PATH_UPLOAD) : Config::get('config.DIR_ROOT') .env('APP_PATH_UPLOAD_MIDDLE',self::APP_PATH_UPLOAD);
            $dir = $path_folder_upload.'/' .$path_file;
            if (is_file($dir)) {
                unlink($dir);
            }
        }
    }

    /*
     * Auth: danghung111
     * Function uploadFileToServer using FPT
     * */
    public function uploadFileToServer($_name = '', $_file_ext = '', $_folder = '', $_max_file_size = 5 * 1024 * 1024, $is_return_path = true, $_outermost_folder = 'uploads', $pathUploadServer='')
    {
        $_file_ext = ($_file_ext != '')?explode(',', $_file_ext):array("jpg", "jpeg", "png", "gif","mp3","mp4");
        if ($_name != '' && isset($_FILES[$_name]) && count($_FILES[$_name]) > 0) {
            $max_file_size = ($_max_file_size) ? $_max_file_size : 5 * 1024 * 1024;
            $file_name = strtolower($_FILES[$_name]['name']);
            $file_tmp = $_FILES[$_name]["tmp_name"];
            $file_size = $_FILES[$_name]['size'];
            $file_ext = @end(explode('.', $file_name));
            $name = date('h-i-s-d-m-Y', time()) . '-' . Upload::preg_replace_string_upload($file_name);
            $name_file = $name ? $name : '';
            $ext = !in_array($file_ext, $_file_ext)? 0 : 1;

            if ($file_name != '' && $ext == 1 && $file_size <= $max_file_size) {
                if ($_folder != '') {
                    if($_name == 'audio'){
                        $folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . $_folder : Config::get('config.DIR_ROOT') .$_outermost_folder. '/' . $_folder.'/'.date('Y.m.d');
                        $path_file = $_folder . '/' .date('Y.m.d').'/'. $name;
                    }
                    else{
                        $folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . $_folder : Config::get('config.DIR_ROOT') .$_outermost_folder. '/' . $_folder;
                        $path_file = $_folder . '/' . $name;
                    }

                } else {
                    $folder_upload = env('IS_LIVE') ? env('APP_PATH_UPLOAD') . 'default' : Config::get('config.DIR_ROOT') . 'uploads/default';
                    $path_file = 'default/' . $name;
                }

                if (!is_dir($folder_upload)) {
                    @mkdir($folder_upload, 0777, true);
                    chmod($folder_upload, 0777);
                }

                if (move_uploaded_file($file_tmp, $folder_upload . '/' . $name_file)) {
                    if((new UploadFileServices())->UploadFileToServer($path_file, $_folder, $pathUploadServer))
                        return ($is_return_path) ? (empty($pathUploadServer) ? $path_file : $pathUploadServer.'/'.$path_file) : $name_file;
                } else {
                    return '';
                }
            }
            return '';
        }
    }

    //rename file upload
    public function preg_replace_string_upload($str = '')
    {
        if (!$str) return '';
        if ($str != '') {
            $str = str_replace(array('^', '$', '\\', '/', '(', ')', '|', '?', '+', '_', '*', '[', ']', '{', '}', ',', '%', '<', '>', '=', '"', '“', '”', '!', ':', ';', '&', '~', '#', '`', "'", '@'), array(''), trim($str));

            $unicode = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd' => 'đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i' => 'í|ì|ỉ|ĩ|ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
                'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'D' => 'Đ',
                'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
                'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            );
            foreach ($unicode as $nonUnicode => $uni) {
                $str = preg_replace("/($uni)/i", $nonUnicode, $str);
            }

            $str = preg_replace("/\s+/", "-", $str);
            $str = preg_replace("/\-+/", "-", $str);

            return strtolower($str);
        }
    }

    //check upload and unlink img current
    public function check_upload_file($name_input_file, $current_path_img = '', $name_folder = '')
    {
        $path_img = '';
        $path_img = self::uploadFile($_name = $name_input_file, $_file_ext = 'jpg,jpeg,png,gif,swf', $_max_file_size = 20 * 1024 * 1024, $name_folder, $type_json = 0);
        if ($path_img != '') {
            if ($current_path_img != '') {
                $dir = Config::get('config.DIR_ROOT') . 'uploads/' . $name_folder . '/' . $current_path_img;
                if (is_file($dir)) {
                    unlink($dir);
                }
            }
        }
        return $path_img;
    }

    //check upload and unlink img current
    public function check_upload_file_download($name_input_file, $current_path_img = '', $name_folder = '')
    {
        $path_img = '';
        $path_img = self::uploadFile($_name = $name_input_file, $_file_ext = 'xls,xlsx,doc,docx,pdf,rar,zip,tar', $_max_file_size = 20 * 1024 * 1024, $name_folder, $type_json = 0);
        if ($path_img != '') {
            if ($current_path_img != '') {
                $dir = Config::get('config.DIR_ROOT') . 'uploads/' . $name_folder . '/' . $current_path_img;
                if (is_file($dir)) {
                    unlink($dir);
                }
            }
        }
        return $path_img;
    }
}