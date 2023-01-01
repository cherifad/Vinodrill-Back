<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Image;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $ids = [];
        // Validate the request
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Store the images
        foreach ($request->file('images') as $image) {
            $path = $image->store('uploads');
            $url = Storage::disk('public')->url($path);
            Image::create([
                'url' => $url
            ]);
            $image_id = Image::where('url', $url)->first()->id;
            array_push($ids, $image_id);
        }

        return response()->json([
            'success' => true,
            'data' => $urls
        ]);
    }
}