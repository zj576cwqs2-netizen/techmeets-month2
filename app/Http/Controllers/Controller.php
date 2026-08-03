<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as StorageFacade;

class Controller
{
    // ファイルをS3にアップロードして公開URLを取得し、モデルに保存する
    protected function uploadImageToS3(\Illuminate\Http\Request $request, $item)
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $path = Storage::disk('s3')->put('images', $request->file('image'));
        $url = Storage::disk('s3')->url($path);

        // DBに保存
        $item->image_url = $url;
        $item->save();

        use Illuminate\Support\Facades\Storage;

        $path = Storage::disk('s3')->put('images', $request->file('image'));
        $url = Storage::disk('s3')->url($path);

        $item->image_url = $url;
        $item->save();
        return $url;
    }
}
