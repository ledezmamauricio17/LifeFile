<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='css/app.css'>
    <link rel="shortcut icon" href="{{ asset('/storage/images/pagina/2nQVJg2qb4o7S7MSXMQzKdhkZo7UBxpKzZlxZp9d.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

    <title>Olvidó su Contraseña</title>
</head>

<div class=" w-full">

      <div class="flex mt-3 ml-4 " id="password">
        <a href="{{ asset('login') }}" class="flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-arrow-left-circle-fill mr-1 text-blue-400 hover:text-blue-600" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              </svg>Volver
		</a>
    </div>
    <div class="flex mb-6 justify-center" id="password">
        <a href="{{ route('home.index') }}">
			<img src="{{ asset('/storage/images/pagina/2nQVJg2qb4o7S7MSXMQzKdhkZo7UBxpKzZlxZp9d.png') }}" alt="logo" class="z-50 w-36 h-32">
		</a>
    </div>
    <form class="justify-center mt-10 items-center w-4/5 border-primary border shadow rounded-2xl bg-white px-6 flex flex-col md:w-1/2 lg:w-1/3 m-auto" action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="grid mb-6 pt-3" id="login">
            <p class="w-full text-base font-semibold leading-tight text-center text-black mb-3">¿Olvidaste tu contraseña?</p>
            <p class="w-full text-base leading-tight text-justify text-black">No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace para restablecer la contraseña que le permitirá elegir una nueva.</p>
        </div>
        <div class="w-full p-2 justify-start flex flex-col">
            <div class=" flex flex-row">
			    <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-400 border border-r-0" mode="render" block="">
		    		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 26 26" class="iconify iconify--wpf text-gray-500">
		    			<path d="M16.563 15.9c-.159-.052-1.164-.505-.536-2.414h-.009c1.637-1.686 2.888-4.399 2.888-7.07c0-4.107-2.731-6.26-5.905-6.26c-3.176 0-5.892 2.152-5.892 6.26c0 2.682 1.244 5.406 2.891 7.088c.642 1.684-.506 2.309-.746 2.397c-3.324 1.202-7.224 3.393-7.224 5.556v.811c0 2.947 5.714 3.617 11.002 3.617c5.296 0 10.938-.67 10.938-3.617v-.811c0-2.228-3.919-4.402-7.407-5.557z" fill="currentColor">
		    			</path>
		    		</svg>
			    </span>
                <input type="email" autofocus class="border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-primary w-full pl-1" name="email" placeholder="email">
		    </div>
            @error('email')
                <label class="text-red-600 text-justify text-xs mt-1">{{$message}}</label>
            @enderror
            <div class="text-center">
                <button type="submit" class="py-2 rounded bg-primary text-black hover:bg-blue-500 hover:text-white my-4 w-2/5">Enviar enlace</button>
            </div>
        </div>
    </form>
    @if (isset($res))
        <div class="min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none  focus:outline-none bg-no-repeat bg-center bg-cover" id="modal">
            <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
            <div class="w-full  max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
                <div class="">
                    <div class="text-center p-5 flex-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-full h-16 text-center" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Zm0 7.803a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 1 .172.686l-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 0 1 .686-.172Z"/>
                        </svg>
                        <h2 class="text-xl font-bold py-4 ">Enlace enviado</h3>
                        <p class="text-sm text-justify text-gray-500 px-8">Se ha enviado el enlace a su correo para crear su nueva contraseña.</p>
                    </div>
                    <div class="p-3  mt-2 text-center space-x-4 md:block">
                            <a href="{{ route('login') }}" class="mb-2 md:mb-0 bg-primary border px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-black rounded-full hover:shadow-lg hover:bg-blue-500 hover:text-white">Continuar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
