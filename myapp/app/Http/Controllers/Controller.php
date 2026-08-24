<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function upload(Request $request)
    {
        // ...

        // use putFile to store uploaded file and get the generated path
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('s3');
        $path = $disk->putFile('images', $request->file('image'));
        $url = $disk->url($path);

        // Create or retrieve the item before setting image_url
        // Implement with your actual model class
        // $item = YourModel::create(['image_url' => $url]);
        // or $item = YourModel::find($id); $item->image_url = $url; $item->save();
        return $url;
    }
}
