@extends('layouts.dashboard')
@section('create')
<div class="w-full p-4 h-screen " name="crud">
    <div class="flex ml-4 " id="">
        <a href="{{ asset('crud-admin') }}" class="flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-arrow-left-circle-fill mr-1 text-blue-400 hover:text-blue-600" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              </svg>Volver
		</a>
    </div>
    <div class="w-full p-4 text-md ">
        <div class="grid">
            <h1 class="text-center text-4xl font-semibold">Crear Administrador</h1>
            <div class="h-1 w-16 mt-1 place-self-center bg-primary rounded mb-10"></div>
        </div>

        @if (session('mensaje'))
            <label class="text-green-800 font-semibold rounded p-2 bg-green-400 flex mx-auto justify-center w-1/3">{{session('mensaje')}}</label>
        @endif

        <!--Crear--->
        <form class="bg-white w-full rounded flex justify-center" action="{{ route('register')}}" method="post">
            @csrf
            <div class="w-2/3">
                <div class="mb-5 w-full">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="nombre">
                        Nombre*
                    </label>
                    <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="nombre" autocomplete="off" type="text" value="{{ old('nombre')}}"/>
                    @error('nombre')
                    <label class="text-red-600 text-justify text-xs">{{$message}}</label>
                    @enderror
                </div>
                <div class="w-full mb-5">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                        Email*
                    </label>
                    <input class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="email" type="email" value="{{ old('email')}}"/>
                    @error('email')
                    <label class="text-red-600 text-justify text-xs">{{$message}}</label>
                    @enderror
                </div>
                <div class="mb-6 text-center">
                    <button class="w-2/5 px-4 py-2 font-semibold text-black bg-primary rounded-full hover:bg-blue-500 hover:text-white" type="submit">
                        Crear
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
