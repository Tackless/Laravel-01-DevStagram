<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        /* Getting the file from the request. */
        $imagen = $request->file('file');

        /* Generating a unique name for the image. */
        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        /* Creating an image object from the file. */
        $imagenServidor = Image::make($imagen);

        /* Resizing the image to 1000x1000 pixels. */
        $imagenServidor->fit(1000, 1000);

        /* Creating a path to the image. */
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        /* Saving the image to the path specified. */
        $imagenServidor->save($imagenPath);

        return response()->json(['imagenes' => $nombreImagen]);
    }
}
