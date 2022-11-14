//variables globales
let tableUsers = "";
let tableHistory = "";
var minDate, maxDate;

let FieldsForm = [
    { name: 'first_name', message: 'First name', required: true },
    { name: 'last_name', message: 'Last name', required: true },
    { name: 'document', message: 'Document', required: true },
    { name: 'type', message: 'Role', required: true },
    { name: 'password', message: 'Password', required: false },
    { name: 'status', message: 'Can access ROOM911', required: true },
    { name: 'department', message: 'Departament', required: true }
];

//configuracion de ajax para realizar post
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// ===========================================================
// funciones de carga principal de la pagina
// ===========================================================

$(document).ready(function () {
    Reloj();
    loadTable();

    var date = new Date();
    date = FormatDate(date, 'yyyy-mm-dd')
    $('#max').attr('max', date);
    $('#min').attr('max', date);
});

//carga la hora actual
const Reloj = () => {
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
    segundo = momentoActual.getSeconds()

    str_segundo = new String(segundo)
    if (str_segundo.length == 1)
        segundo = "0" + segundo

    str_minuto = new String(minuto)
    if (str_minuto.length == 1)
        minuto = "0" + minuto

    str_hora = new String(hora)
    if (str_hora.length == 1)
        hora = "0" + hora

    horaImprimible = hora + ":" + minuto + ":" + segundo

    $('#reloj').text(horaImprimible);

    setTimeout("Reloj()", 1000)
}

//modal para la creacion de un usuario
const CreateMdl = (action) => {
    switch (action) {
        case 1:
            $('#btnCreate').prop('class', 'btn btn-success float-right');
            $('#btnCSV').prop('class', 'btn btn-info float-right ml-1');

            $('#divCreate').prop('hidden', false);
            $('#divCSV').prop('hidden', true);
            $('#btnSaveCreate').prop('hidden', false);
            $('#btnSaveCSV').prop('hidden', true);


            break;

        case 2:
            $('#btnCreate').prop('class', 'btn btn-info  float-right');
            $('#btnCSV').prop('class', 'btn btn-success float-right ml-1');

            $('#divCreate').prop('hidden', true);
            $('#divCSV').prop('hidden', false);
            $('#btnSaveCreate').prop('hidden', true);
            $('#btnSaveCSV').prop('hidden', false);
            break;


    }
    loadDepartments();
    $('#CreateUserMdl').modal('show');
}

//Identifica el rol del usuario
const Role = () => {
    if ($('#type').val() == 2 || $('#type_up').val() == 2) {
        $('.password').prop('hidden', false);
    } else {
        $('.password').prop('hidden', true);
    }
}

//carga los departamentos en el select
const loadDepartments = () => {
    $.get('/loadDepartments', function (res) {
        let html = `<option value="" selected>Department</option>`;
        res.data.forEach(department => {
            html += `<option value="${department['id']}">${department['name']}</option>`;
        });
        $('.department').html(html);
    });
}

//cargar el modal para ver el historial

const LoadModalHistory = (id) => {
    $('#id_user').val(id);
    FilterByDates();
}

//se da formato a un fecha
const FormatDate = (date, format) => {
    let map = {
        dd: date.getDate(),
        mm: date.getMonth() + 1,
        yyyy: date.getFullYear()
    }

    return format.replace(/dd|mm|yyyy/gi, matched => map[matched])
}

//cargar datos de historial por fechas
const FilterByDates = () => {
    if ($('#min').val() != '' && $('#max').val() != '') {
        $.get('/loadHistoryByDates', { id: $('#id_user').val(), min: $('#min').val(), max: $('#max').val() }, function (res) {
            History(res.data)
        });
    } else {
        $.get('/loadHistory', { id: $('#id_user').val() }, function (res) {
            History(res.data)
        });
    }
}

//validaciones para enviar formularios
const validateFields = (action) => {
    canISendForm = false;
    switch (action) {
        case 1:
            for (let i = 0; i < FieldsForm.length; i++) {
                if (($(`#${FieldsForm[i].name}`).val() == '' || $(`#${FieldsForm[i].name}`).val() == null) && FieldsForm[i].required == true) {
                    canISendForm = false;
                    swal.fire({
                        title: 'Advertencia!',
                        text: `${FieldsForm[i].message} no puede quedar vacio`,
                        icon: 'warning',
                    });
                    break;
                } else if ($('#type').val() == 2 && $("#password").val() == '') {
                    canISendForm = false;
                    swal.fire({
                        title: 'Advertencia!',
                        text: `Password no puede quedar vacio`,
                        icon: 'warning',
                    });
                    break;
                }
                else {
                    canISendForm = true;
                }
            }
            break;
        case 2:
            for (let i = 0; i < FieldsForm.length; i++) {
                if (($(`#${FieldsForm[i].name}_up`).val() == '' || $(`#${FieldsForm[i].name}_up`).val() == null) && FieldsForm[i].required == true) {
                    canISendForm = false;
                    swal.fire({
                        title: 'Advertencia!',
                        text: `${FieldsForm[i].message} no puede quedar vacio`,
                        icon: 'warning',
                    });
                    break;
                } else if ($('#type_up').val() == 2 && $("#password_up").val() == '') {
                    canISendForm = false;
                    swal.fire({
                        title: 'Advertencia!',
                        text: `Password no puede quedar vacio`,
                        icon: 'warning',
                    });
                    break;
                }
                else {
                    canISendForm = true;
                }
            }
            break;
        case 3:
            var file = document.getElementById('file').files[0];
            if ($('#departmentCSV').val() == '' || $('#departmentCSV').val() == null) {
                canISendForm = false;
                swal.fire({
                    title: 'Advertencia!',
                    text: `Department no puede quedar vacio`,
                    icon: 'warning',
                });
            } else if (!file) {
                canISendForm = false;
                swal.fire({
                    title: 'Advertencia!',
                    text: `Debe seleccionar un archivo`,
                    icon: 'warning',
                });
            }
            else if (file.type != 'text/csv') {
                canISendForm = false;
                swal.fire({
                    title: 'Advertencia!',
                    text: `El archivo debe tener una extension .csv`,
                    icon: 'warning',
                });
            }
            else {
                canISendForm = true;
            }
    }
    return canISendForm;
}

//validaciones entre headers de csv y FieldsForm
const validateHeaders = (headers) => {
    validate = false;
    if (headers.length == (FieldsForm.length - 1)) {
        for (let i = 0; i < headers.length; i++) {
            if (headers[i] != FieldsForm[i].name) {
                validate = false;
                swal.fire({
                    title: 'Advertencia!',
                    text: `No debe cambiar el nombre de los titulos de la plantilla, usted puso ${headers[i]} y debe ser ${FieldsForm[i].name}`,
                    icon: 'warning',
                });
                break;
            }
            else {
                validate = true;
            }
        }
    } else {
        swal.fire({
            title: 'Advertencia!',
            text: `Falta una columna en la plantilla`,
            icon: 'warning',
        });
    }
    return validate;
}

//validaciones para enviar formularios csv
const validateJSON = (headers, data) => {
    let canISendForm = false;
    if (validateHeaders(headers)) {
        for (let i = 1; i < data.length; i++) {
            let user = data[i].split(",");
            for (let j = 0; j < headers.length; j++) {
                if ((user[j] == '' || user[j] == null || !user[j]) && FieldsForm[j].required == true) {
                    canISendForm = false;
                    $('#file').val("");
                    swal.fire({
                        title: 'Advertencia!',
                        text: `${FieldsForm[j].message} no puede quedar vacio, el error esta en la fila ${i}`,
                        icon: 'warning',
                    });
                    break;
                } else if (user[5] > 1) {
                    canISendForm = false;
                    $('#file').val("");
                    swal.fire({
                        title: 'Advertencia!',
                        text: `El status de un usuario solo puede ser un valor de 0 para desactivado y 1 para activo, el error esta en la fila ${i}`,
                        icon: 'warning',
                    });
                    break;
                } else if (FieldsForm[j].name == 'type' && user[j] == 2 && user[4] == '') {
                    $('#file').val("");
                    canISendForm = false;
                    swal.fire({
                        title: 'Advertencia!',
                        text: `Si un usuario es tipo 2 osea Administrator no puede quedar el campo password vacio, el error esta en la fila ${i}`,
                        icon: 'warning',
                    });
                    break;
                } else {
                    canISendForm = true;
                }
            }
        }
    }
    return canISendForm;
}

//validaciones para enviar formularios
const CleanFields = () => {
    $('#max').val("");
    $('#min').val("");
    $('#file').val("");

    //create
    $('#first_name').val("");
    $('#last_name').val("");
    $('#document').val("");
    $('#type').val("");
    $('#status').val("");
    $('#department').val("");
    $('.password').val("");

    //update
    $('#up_user_id').val("");
    $('#first_name_up').val("");
    $('#last_name_up').val("");
    $('#document_up').val("");
    $('#type_up').val("");
    $('#status_up').val("");
    $('#department_up').val("");
    Role();
}

//tabla de usuarios
const loadTable = () => {
    tableUsers = $("#TableUsers").DataTable({
        destroy: true,
        info: true,
        responsive: true,
        paging: true,
        scrollY: '300px',
        order: [
            [1, 'desc'],
        ],
        language: {
            'search': '<i class="fa fa-search"></i>',
            'paginate': {
                "previous": '<i class="fa fa-angle-left mr-2"></i>',
                "next": '<i class="fa fa-angle-right ml-2"></i>'
            }
        },
        ajax: {
            url: '/loadUsers',
            method: 'GET'
        },
        columnDefs: [{ "defaultContent": "-", "targets": "_all" }],
        columns: [

            {
                render: (data, type, row) => {


                    return " ";
                },
            },
            {
                render: (data, type, row) => {
                    let buttons = "";

                    if (row['status'] == 1) {
                        buttons = `<button type="button" class="btn btn-sm btn-primary" title="Edit" onclick="Edit(${row['id']})">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" title="History" onclick="LoadModalHistory(${row['id']})" >
                                        <i class="far fa-list-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success mt-1 mr-1 mr-sm-0 mt-sm-0" title="Deactivate" onclick="ChangeStatus(${row['id']},0)" >
                                        <i class="fas fa-thumbs-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger mt-1 mt-sm-0" title="Delete" onclick="Delete(${row['id']})" >
                                        <i class="fas fa-trash"></i>
                                    </button>`;

                    } else {
                        buttons = `<button type="button" class="btn btn-sm btn-primary" title="Edit" onclick="Edit(${row['id']})">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" title="History" onclick="LoadModalHistory(${row['id']})" >
                                    <i class="far fa-list-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary mt-1 mr-1 mr-sm-0 mt-sm-0" title="Activate" onclick="ChangeStatus(${row['id']},1)" >
                                    <i class="fas fa-thumbs-down"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mt-1 mt-sm-0" title="Delete" onclick="Delete(${row['id']})" >
                                    <i class="fas fa-trash"></i>
                                </button>`;
                    }
                    return buttons;
                },
            },
            { data: 'document' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'type' },
            { data: 'department_name' },
            { data: 'total' },
        ]
    });
}

//tabla de historial
const History = (data) => {

    tableHistory = $("#TableHistory").DataTable({
        destroy: true,
        info: true,
        responsive: true,
        paging: true,
        scrollY: '250px',
        language: {
            'search': '<i class="fa fa-search"></i>',
            'paginate': {
                "previous": '<i class="fa fa-angle-left mr-2"></i>',
                "next": '<i class="fa fa-angle-right ml-2"></i>'
            }
        },
        order: [
            [5, 'desc'],
        ],
        sDom: 'lBfrtip',
        buttons: [{
            extend: 'excelHtml5',
            className: 'btn btn-success',
            text: '<i class="fas fa-file-excel"></i>',
            filename: 'History',
            titleAttr: 'Excel'
        },
        {
            extend: 'csvHtml5',
            className: ' btn btn-success',
            text: '<i class="fas fa-file-csv"></i>',
            filename: 'History',
            titleAttr: 'CSV'
        },
        {
            extend: 'pdfHtml5',
            className: ' btn btn-success',
            text: '<i class="fas fa-file-pdf"></i>',
            filename: 'History',
            titleAttr: 'PDF'
        }
        ],
        columnDefs: [{ "defaultContent": "-", "targets": "_all" }],
        data: data,
        columns: [
            { data: 'document' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'department' },
            { data: 'action' },
            { data: 'date' },
        ]
    });
    $('#RecordsUserMdl').modal('show');
}

const CSVtoJson = () => {
    if (validateFields(3)) {
        var file = document.getElementById('file').files[0];
        var department = $('#departmentCSV').val();
        var reader = new FileReader();
        reader.readAsText(file);
        reader.onload = function (e) {
            // convert csv to json
            let lines = [];
            let linesArray = e.target.result.split('\n');
            // for trimming and deleting extra space
            linesArray.forEach(e => {
                let row = e.replace(/[\s]+[,]+|[,]+[\s]+/g, ',').trim();
                row = row.replace(/[^a-z0-9ñ',_]+/ig, "");

                lines.push(row);
            });
            // for removing empty record
            lines.splice(lines.length - 1, 1);

            let headers = lines[0].split(",");

            if (validateJSON(headers, lines)) {
                for (let i = 1; i < lines.length; i++) {
                    let user = lines[i].split(",");
                    SetForm(user[0], user[1], user[2], user[3], user[4], user[5],department);
                    setTimeout(() => {
                        response = CreateCSV();
                    }, 300);

                    if (response[0].result) {
                        if (lines.length == (i + 1)) {
                            swal.fire({
                                title: 'Creación Exitosa!',
                                text: 'Se han creado  todos los usuarios del archivo CSV',
                                icon: 'success',
                            }).then((result) => {
                                $('#CreateUserMdl').modal('hide');
                            });
                        }
                    } else {
                        $('#file').val("");
                        swal.fire({
                            title: 'Error',
                            text: response[1].message + ' Error con el documento ' + user[2],
                            icon: 'error',
                        });
                        break;
                    }
                }
            }
        };
    }
}

//Setear info en el form de creacion
const SetForm = (first_name, last_name, document, type, password, status, department) => {
    $('#first_name').val(first_name);
    $('#last_name').val(last_name);
    $('#document').val(document);
    $('#type').val(type);
    $('#password').val(password);
    $('#status').val(status);
    $('#department').val(department);
    Role();
}

// ===========================================================
// CRUD
// ===========================================================

// creacion de usuario

const Create = () => {
    if (validateFields(1)) {
        $.get('/issetDocument', { document: $('#document').val() }, function (result) {
            if (result.response.length > 0) {
                swal.fire({
                    title: 'Advertencia!',
                    text: `Ya existe un usuario con este documento`,
                    icon: 'warning',
                });
            } else {
                $.ajax({
                    url: '/create',
                    method: 'POST',
                    data: $('#formCreate').serialize(),
                    error: function (xhr, ajaxOptions, thrownerror) { alert(thrownerror); },
                    success: function (res) {
                        if (res.response == "done") {
                            swal.fire({
                                title: 'Creación Exitosa!',
                                text: 'Se ha creado el usuario',
                                icon: 'success',
                            }).then((result) => {
                                CleanFields();
                                tableUsers.ajax.reload();
                                $('#CreateUserMdl').modal('hide');
                            });
                        }
                    }
                });
            }
        });
    }
}

const CreateCSV = () => {
    let response = [{ 'result': '' }, { 'message': '' }];
    $.ajax({
        url: '/create',
        method: 'POST',
        data: $('#formCreate').serialize(),
        error: function (xhr) {
            response[0]['result'] = false;
            response[1]['message'] = xhr.responseJSON.message;
        },
        success: function (res) {
            if (res.response = 'done') {
                CleanFields();
                tableUsers.ajax.reload();
                response[0]['result'] = true;
            }
        },
    });

    return response;
}

//carga la informacion de un usuario
const Edit = (id) => {
    loadDepartments();
    $.get('/loadEditUser', { 'id': id }, function (res) {
        let user = res.user;
        $('#idUser').val(user.id);
        $('#first_name_up').val(user.first_name);
        $('#last_name_up').val(user.last_name);
        $('#document_up').val(user.document);
        $('#type_up').val(user.type);
        $('#status_up').val(user.status);
        $('#department_up').val(user.department_id);
        Role();
    });
    $('#UpdateUserMdl').modal('show');

}

//Update de usuario
const Update = () => {
    if (validateFields(2)) {
        $.ajax({
            url: '/update',
            method: 'POST',
            data: $('#formUpdate').serialize(),
            error: function (xhr, ajaxOptions, thrownerror) { alert(thrownerror); },
            success: function (res) {
                if (res.response == "done") {
                    swal.fire({
                        title: 'Actualiación Exitosa!',
                        text: 'Se ha actualizado el usuario',
                        icon: 'success',
                    }).then((result) => {
                        $('#UpdateUserMdl').modal('hide');
                        CleanFields();
                        tableUsers.ajax.reload();
                    });
                }
            }
        });
    }
}

//cambia el estado de un usuario
const ChangeStatus = (id, status) => {
    swal.fire({
        title: 'Atención!',
        text: 'Realmente desea ' + ((status) ? "activar" : "desactivar") + ' este usuario',
        icon: 'question',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#001f3f',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#FF0202',
        reverseButtons: true
    }).then((willActive) => {
        if (willActive.isConfirmed) {
            $.get("/changeStatus/", { "id": id, "status": status }, function (res) {
                if (res.response == "done") {
                    swal.fire({
                        text: "Usuario " + ((status) ? "activado" : "desactivado") + " con éxito!",
                        icon: "success",
                    }).then((complete) => {
                        if (complete.isConfirmed) {
                            tableUsers.ajax.reload();
                        }
                    });
                } else {
                    swal.fire("Ha ocurrido un error, por favor intente mas tarde!", {
                        icon: "error",
                    }).then((complete) => {
                        if (complete.isConfirmed) {
                            tableUsers.ajax.reload();
                        }
                    });
                }
            })
        }
    });
}

//elimina un usuario
const Delete = (id) => {
    swal.fire({
        title: "¿Está seguro de eliminar este usuario?",
        text: "Una vez eliminado, tendrá que crearlo de nuevo!",
        icon: "warning",
        dangerMode: true,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#001f3f',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#FF0202',
        reverseButtons: true

    }).then((willDelete) => {
        if (willDelete.isConfirmed) {
            $.get("/delete", { id: id }, function (res) {
                if (res.response == "done") {
                    swal.fire({
                        text: "Usuario eliminado con éxito!",
                        icon: "success",
                    }).then((complete) => {
                        if (complete.isConfirmed) {
                            tableUsers.ajax.reload();
                        }
                    });
                } else {
                    swal.fire("Ha ocurrido un error, por favor intente mas tarde!", {
                        icon: "error",
                    }).then((complete) => {
                        if (complete.isConfirmed) {
                            tableUsers.ajax.reload();
                        }
                    });
                }

            })
        }
    });
}


