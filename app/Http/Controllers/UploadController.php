<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function save(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Dosya türü kontrolü
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedTypes)) {
                return response()->json(['error' => 'Only JPG and PNG files are allowed.'], 400);
            }

            $filename = time() . '.' . $extension;

            $file->move(public_path('uploads'), $filename);

            $path = 'uploads/' . $filename;
            $url = asset('uploads/' . $filename);

            return response()->json(['url' => $url, 'path' => $path]);
        }

        return response()->json(['error' => 'File not provided.'], 400);
    }
}
