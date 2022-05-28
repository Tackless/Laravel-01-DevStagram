<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);
        
        $this->validate($request, [
            'username' => [
                'required',
                'unique:users,username,'.auth()->user()->id,
                'min:3',
                'max:20',
                'not_in:twitter,editar-perfil'
            ],
            'email' => [
                'required',
                'unique:users,email,'.auth()->user()->id,
                'email',
                'max:60'
            ]
        ]);

        if ($request->imagen) {
            /* Getting the file from the request. */
            $imagen = $request->file('imagen');

            /* Generating a unique name for the image. */
            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            /* Creating an image object from the file. */
            $imagenServidor = Image::make($imagen);

            /* Resizing the image to 1000x1000 pixels. */
            $imagenServidor->fit(1000, 1000);

            /* Creating a path to the image. */
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;

            /* Saving the image to the path specified. */
            $imagenServidor->save($imagenPath);
        }

        

        // Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

        // Confirmar Constraseña
        if ($request->new_password) {

            $this->validate($request, [
                'new_password' => 'required|min:6',
                'password' => 'required'
            ]);
    
            if (!Hash::check($request->password, $usuario->password)) {
                return back()->with('mensaje', 'Contraseña Incorrecta');
            }
            $usuario->password = Hash::make($request->new_password);
        }
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
