@extends('layouts.plantilla')

@section('title', 'Login')

@section('login_admin')

    <section class="mt-2">
        <div class="my-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 d-flex justify-content-center mb-4">
                    <img src="img/logo.jpg" class="img-fluid w-50" alt="Sample image">
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <form class="row justify-content-center" id="formLoginAdmin">
                        @csrf
                        <h1 class="text-center text-white">Login</h1>

                        <!-- document input -->
                        <div class="form-outline col-12 mt-2 mb-4">
                            <input type="text" id="document" name="document" class="form-control form-control-lg document" onchange="PatternTextNumbers()"
                                placeholder="Ingrese su documento" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline col-12 mb-3">
                            <input type="password" id="password" name="password" class="form-control form-control-lg"
                                placeholder="Ingrese su contraseña" />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="button" onclick="GetUser(2)" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <script src="js/logicLogin.js"></script>


@endsection
