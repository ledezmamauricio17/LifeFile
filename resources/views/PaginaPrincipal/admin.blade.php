@extends('layouts.plantilla')
@section('title', 'Inicio')
@section('index')

    <!-- contenido -->
    <div class="row card card-default d-flex justify-content-center">
        <div class="card-header col-12" style="background:#154979">
            <h3 class="card-title">
                <div class="row">
                    <div class="col-12 col-sm-4 text-sm-left text-center my-1">
                        <img src="img/logo.jpg" class="img-fluid w-50" alt="Sample image">
                    </div>
                    <div class="col-12 col-sm-4 text-center align-items-center d-flex justify-content-center">
                        <h3 class="text-left">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                    </div>
                    <div class="col-12 col-sm-4 text-sm-right my-auto text-center">
                        <form class="" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary float-sm-right">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </h3>
        </div>
        <div class="card-body col-12">
            @if (Auth::user()->type == 1)
                <div class="col-12 my-2">
                    <h1>Ingreso employee</h1>
                </div>
            @endif
            @if (Auth::user()->type == 2)
                <div class="col-12 my-2">
                    <div class="card card-default">
                        <div class="card-header" style="background:#96b5cb">
                            <h3 class="card-title">
                                <div class="row">
                                    <form class="col-sm-6 text-sm-left text-center col-12" name="form_reloj">
                                        <h3 ><i class="fas fa-clock"></i> <span id="reloj"></span></h3>
                                    </form>
                                    <div class="col-sm-6 text-sm-right text-center col-12">
                                        <button class="btn btn-primary" title="Add User" onclick="CreateMdl(1)">
                                            <i class="fas fa-user-plus"></i>
                                            Add User
                                        </button>
                                    </div>
                                </div>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <button id="buttonReload" hidden="hidden"></button>
                                <table class="table table-sm text-sm-center w-100 table-striped" id="TableUsers">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Actions</th>
                                            <th>Document</th>
                                            <th>First_name</th>
                                            <th>Last_name</th>
                                            <th>Role</th>
                                            <th>Department</th>
                                            <th>Total Access</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (Auth::user()->type == 2)
        <!-- Modal created -->
        <div class="modal fade" id="CreateUserMdl" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <div class="col-10 d-flex justify-content-start">
                            <button type="button" id="btnCreate" onclick="CreateMdl(1)">
                                <i class="fas fa-user-plus"></i> Create
                            </button>
                            <button type="button" id="btnCSV" onclick="CreateMdl(2)">
                                <i class="fas fa-file-csv"></i> CSV Upload
                            </button>
                        </div>
                        <div class="col-2 text-right">
                            <button type="button" onclick="CleanFields()" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true" class="text-light">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body row" id="form-modal-body">
                        <div class="col-12" id="divCreate">
                            <form id="formCreate">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="user_id">
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <input type="text" class="form-control" placeholder="First Name"
                                            name="first_name" id="first_name" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <input type="text" class="form-control" placeholder="Last Name" name="last_name"
                                            id="last_name" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <input type="text" class="form-control" placeholder="Document" name="document"
                                            id="document" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-id-card"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <select class="custom-select" name="type" id="type" onchange="Role()"
                                            required>
                                            <option value="" selected>Role</option>
                                            <option value="1">Employee</option>
                                            <option value="2">Admin</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-users-cog"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3 password" hidden>
                                        <input type="password" class="form-control" placeholder="Password"
                                            name="password" id="password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-key"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <select class="custom-select" name="status" id="status" required>
                                            <option value="" selected>Can access ROOM_911</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-unlock-alt"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <select class="custom-select department" name="department" id="department"
                                            required>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="far fa-building"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12" id="divCSV">
                            <form id="formCSV">
                                <div class="input-group mb-3 text-justify">
                                    <span>Use la siguiente <a href="docs/plantilla.csv">Plantilla</a>
                                        para cargar la información.
                                    </span>
                                    <br>
                                </div>
                                <span> Por favor Seleccione el departamento al cual va a asignar los usuarios y el archivo a
                                    cargar.</span>
                                <div class="row mt-2">
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <select class="custom-select department" name="department" id="departmentCSV"
                                            required>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="far fa-building"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 col-sm-6 mb-3">
                                        <input type="file" class="form-control" placeholder="Upload CSV"
                                            accept=".csv" id="file" name="file">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-file-csv"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" onclick="CleanFields()" class="btn btn-danger float-left"
                                        data-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                        Cerrar
                                    </button>
                                </div>
                                <div class="col-6" id="btnSaveCreate">
                                    <button type="button" onclick="Create()" class="btn btn-success float-right">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                                <div class="col-6" id="btnSaveCSV">
                                    <button type="button" id="btnSaveCreateCSV" onclick="CSVtoJson()"
                                        class="btn btn-success float-right">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Update -->
        <div class="modal fade" id="UpdateUserMdl" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title nameModal">Actualizar Usuario</h5>
                        <button type="button" onclick="CleanFields()" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true" class="text-light">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="form-modal-body">
                        <form id="formUpdate">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="idUser" name="idUser" value="">

                                <div class="input-group col-12 col-sm-6 mb-3">
                                    <input type="text" class="form-control" placeholder="First Name"
                                        name="first_name_up" id="first_name_up" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-12 col-sm-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Last Name"
                                        name="last_name_up" id="last_name_up" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-12 col-sm-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Document" name="document_up"
                                        id="document_up" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-id-card"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-12 col-sm-6 mb-3">
                                    <select class="custom-select" name="type_up" id="type_up" onchange="Role()"
                                        required>
                                        <option value="" selected>Role</option>
                                        <option value="1">Employee</option>
                                        <option value="2">Admin</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-users-cog"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-12 col-sm-6 mb-3 password" hidden>
                                    <input type="password" class="form-control" placeholder="Password"
                                        name="password_up" id="password_up" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-key"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-12 col-sm-6 mb-3">
                                    <select class="custom-select" name="status_up" id="status_up" required>
                                        <option value="">Can access ROOM_911</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-unlock-alt"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group col-12 col-sm-6 mb-3">
                                    <select class="custom-select department" name="department_up" id="department_up"
                                        required>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="far fa-building"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" onclick="CleanFields()" class="btn btn-danger float-left"
                                        data-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                        Cerrar
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-success float-right" onclick="Update()">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal History -->
        <div class="modal fade" id="RecordsUserMdl" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title nameModal">History</h5>
                        <button type="button" class="close" onclick="CleanFields()" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true" class="text-light">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="form-modal-body">
                        <input type="hidden" id="id_user">
                        <div class="mb-3 row d-flex justify-content-center">
                            <div class="col-sm-4 col-12 text-center">
                                <span>Min date:</span>
                                <input type="date" id="min" name="min" onchange="FilterByDates()">
                            </div>
                            <div class="col-sm-4 col-12 text-center">
                                <span>Max date:</span>
                                <input type="date" id="max" name="max" onchange="FilterByDates()">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm text-sm-center w-100 table-striped" id="TableHistory">
                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>First_name</th>
                                        <th>Last_name</th>
                                        <th>Department</th>
                                        <th>action</th>
                                        <th>date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" onclick="CleanFields()" class="btn btn-danger float-left"
                                        data-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="js/logicHome.js"></script>

@endsection
