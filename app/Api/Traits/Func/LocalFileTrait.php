<?php

namespace App\Api\Traits\Func;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

trait LocalFileTrait
{

    private $filesystem;

    private function initDisk()
    {
        $adapter = new Local(storage_path('app'));
        $this->filesystem = new Filesystem($adapter);
    }

    public function safeSaveFile($file, $dirName, $fileName = '')
    {
        $result = ['result' => false, 'path' => ''];
        if (!isset($filesystem)) {
            $this->initDisk();
        }
        if ($file->isValid()) {
            $stream = fopen($file->getRealPath(), 'r+');
            $fileName = sprintf("%s.%s", $dirName . '/' . ($fileName ? $fileName : md5(uniqid())), $file->getClientOriginalExtension());
            $result['result'] = $this->filesystem->writeStream($fileName, $stream);
            $result['path'] = $fileName;
            fclose($stream);
        }

        return $result;
    }

    /**
     * 保存文件到指定文件夹
     * @param UploadedFile $file 文件对象
     * @return string 访问路径
     */
    public function saveFileTo($file, $folderName, $fileName = '')
    {
        $savePath = realpath(__DIR__ . '/../../../../public') . '/';
        if ($file->isValid()) {
            $fileName = sprintf("%s.%s", $fileName ? $fileName : md5(uniqid()), $file->getClientOriginalExtension());
            $file->move($savePath . $folderName, $fileName);
            return sprintf("%s/%s", $folderName, $fileName);
        } else {
            return "file upload error";
        }
    }

}
