<?php

namespace App\Traits;

use Str;

trait UploadableFile
{
    /**
     * Returns one file path
     * @param $file
     * @param $folder
     * @param $disk
     * @param $filename
     *
     * @return mixed
     */
    public function uploadOne($file, $folder = null, $disk = 'public', $filename = null): mixed
    {
        $filename = Str::uuid() . '_' . $filename;
        return $file->store($folder, [
            'disk' => $disk,
            'filename' => $filename,
        ]);
    }


    /**
     * Returns multiple file paths
     * @param $files
     * @param $folder
     * @param $disk
     *
     * @return array
     */
    public function uploadMany($files, $folder = null, $disk = 'public'): array
    {
        foreach ($files as $file) {
            $filename = Str::uuid() . '_' .$file->getClientOriginalName();
            $file->storeAs($folder, $filename, [
                'disk' => $disk,
            ]);
            $data[] = $filename;
        }

        return $data;
    }
}
