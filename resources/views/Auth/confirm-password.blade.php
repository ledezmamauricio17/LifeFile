<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='css/app.css'>
    <link rel="shortcut icon" href="{{ asset('/storage/images/pagina/2nQVJg2qb4o7S7MSXMQzKdhkZo7UBxpKzZlxZp9d.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

    <title>Confirmar Contraseña</title>
</head>

<div class=" w-full">
    <div class="flex mt-3 ml-4 " id="password">
        <a href="{{ asset('admin') }}" class="flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-arrow-left-circle-fill mr-1 text-blue-400 hover:text-blue-600" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              </svg>Volver
		</a>
    </div>
    <div class="flex mb-6 justify-center" id="password">
        <a href="{{ asset('admin') }}">
			<img src="{{ asset('/storage/images/pagina/2nQVJg2qb4o7S7MSXMQzKdhkZo7UBxpKzZlxZp9d.png') }}" alt="logo" class="z-50 w-36 h-32">
		</a>
    </div>
    <form class="justify-center mt-10 items-center w-4/5 border-primary border shadow rounded-2xl bg-white px-6 flex flex-col md:w-1/2 lg:w-1/3 m-auto" action="{{ route('password.confirm') }}" method="post">
        @csrf
        <div class="grid mb-6 pt-3" id="login">
            <h1 class="w-full text-2xl font-semibold leading-tight text-center text-black">Contraseña Actual</h1>
        </div>
        <div class="w-full p-2 justify-start flex flex-col">
            <div class="my-4 flex flex-row">
                <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-400 border border-r-0" mode="render" block="">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" class="iconify iconify--carbon text-gray-500">
                        <path d="M21 2a8.998 8.998 0 0 0-8.612 11.612L2 24v6h6l10.388-10.388A9 9 0 1 0 21 2zm0 16a7.013 7.013 0 0 1-2.032-.302l-1.147-.348l-.847.847l-3.181 3.181L12.414 20L11 21.414l1.379 1.379l-1.586 1.586L9.414 23L8 24.414l1.379 1.379L7.172 28H4v-3.172l9.802-9.802l.848-.847l-.348-1.147A7 7 0 1 1 21 18z" fill="currentColor">
                        </path>
                        <circle cx="22" cy="10" r="2" fill="currentColor">
                        </circle>
                    </svg>
                </span>
                <input type="password" autofocus class="h-10 border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-primary w-full pl-1" name="password" placeholder="password">
            </div>
            @error('password')
                <label class="text-red-600 text-justify text-xs">{{$message}}</label>
            @enderror
            <div class="text-center">
                <button type="submit" class="py-2 rounded bg-primary text-black hover:bg-blue-500 hover:text-white my-4 w-2/5">Continuar</button>
            </div>
        </div>
    </form>
</div>
