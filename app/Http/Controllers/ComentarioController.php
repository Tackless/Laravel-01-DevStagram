<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // Validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        // Almacenar el resultado
        /*  
            Si existe error:
            Add [user_id] to fillable property to allow mass assignment on [App\Models\Comentario].

            Agregar al modelo en cuestion:
            protected $fillable = []
        */
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Imprimir el mensaje
        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }
}