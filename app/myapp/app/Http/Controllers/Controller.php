<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

abstract class Controller
{
    // ファイルをS3にアップロードして公開URLを取得し、モデルに保存する
    protected function uploadImageToS3(Request $request, Model $item)
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('s3');
        $path = $disk->put('images', $request->file('image'));
        $url = $disk->url($path);

        $item->image_url = $url;
        $item->save();

        return $url;
    }
}