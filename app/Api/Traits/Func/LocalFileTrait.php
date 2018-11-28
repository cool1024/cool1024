<?php

namespace App\Api\Traits\Func;

trait LocalFileTrait
{
    /**
     * 保存文件到指定文件夹
     * @param UploadedFile $file 文件对象
     * @return string 访问路径
     */
    public function saveFileTo($file, $folderName, $fileName = ''){
        $savePath = realpath(__DIR__.'/../../../../public').'/';
        if ($file->isValid()) {
            $fileName = sprintf("%s.%s", $fileName ? $fileName : md5(uniqid()), $file->getClientOriginalExtension());
            $file->move($savePath . $folderName, $fileName);
            return sprintf("%s/%s", $folderName, $fileName);
        } else {
            return "file upload error";
        }
    }
    
}
