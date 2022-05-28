@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{ route('perfil.store') }}" method="post"
            enctype="multipart/form-data"  {{-- Para subir archivos se necesita este atributo --}}
            class="mt-10 md:mt-0">
                @csrf {{-- Elemento de seguridad INDISPENSABLE --}}
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre de Usuario
                    </label>
                    <input type="text" id="username" name="username" placeholder="Tu Nombre de Usuario" class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror" value="{{ auth()->user()->username }}">
                    
                    @error('username')
                    <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input type="file" id="imagen" name="imagen" class="border p-3 w-full rounded-lg " value="" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        E-Mail
                    </label>
                    <input type="email" id="email" name="email" placeholder="Tu E-Mail" class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" value="{{ auth()->user()->email }}">
                    
                    @error('email')
                    <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="new_password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Contraseña Nueva
                    </label>
                    <input type="password" id="new_password" name="new_password" placeholder="Ingresa Constraseña Nueva" class="border p-3 w-full rounded-lg @error('new_password') border-red-500 @enderror" value="">
                    
                    @error('new_password')
                    <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Contraseña
                    </label>
                    <input type="password" id="password" name="password" placeholder="Tu Contraseña" class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" value="">
                    
                    @error('password')
                    <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>
                    @enderror

                    @if (session('mensaje'))
                        <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ session('mensaje') }}
                        </p>
                    @endif
                </div>

                <input type="submit" value="Guardar Cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection