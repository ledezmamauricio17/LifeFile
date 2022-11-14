//variables globales
let FieldsForm = [
    { name: 'document', message: 'Document', required: true },
    { name: 'password', message: 'Password', required: true }
]

let user = [
    { id: '', status: '', type: '' }
]

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// ===========================================================
// funciones de carga principal de la pagina
// ===========================================================

//Obtener usuario y llenar arreglo User
const GetUser = (action) => {
    $.get('/issetDocument', { 'document': $('#document').val() }, function (res) {
        if (res.response.length > 0) {
            user[0].id = res.response[0].id;
            user[0].status = res.response[0].status;
            user[0].type = res.response[0].type;
        } else {
            user[0].id = 0;
        }
    }).done(function () {
        switch (action) {
            case 1:
                LoginEmployee();
                break;

            case 2:
                LoginAdmin();
                break;
        }
    });
}

//se crea un registro por cada accion de login
const Records = (user, action) => {
    $.get('/createRecord', { 'id': user, 'action': action }, function (res) {
        console.log(res);
    });
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
                } else if (user[0].id == 0) {
                    canISendForm = false;
                    swal.fire({
                        title: 'Advertencia!',
                        text: `No existe un usuario con este documento`,
                        icon: 'warning',
                    });
                    break;
                } else if (user[0].status == 0) {
                    canISendForm = false;
                    Records(user[0].id, 'try');
                    swal.fire({
                        title: 'Advertencia!',
                        text: `Este Usuario no puede ingresar porque se encuentra deshabilitado, por favor comuniquese con el administrador`,
                        icon: 'warning',
                    });
                    break;
                } else if (user[0].type == 1) {
                    canISendForm = false;
                    Records(user[0].id, 'try');
                    swal.fire({
                        title: 'Advertencia!',
                        text: `Este Usuario no es administrador`,
                        icon: 'warning',
                    });
                    break;
                } else {
                    canISendForm = true;
                }
            }
            break;

        case 2:
            if ($(`#document`).val() == '' || $(`#document`).val() == null) {
                canISendForm = false;
                swal.fire({
                    title: 'Advertencia!',
                    text: `El campo de document no puede quedar vacio`,
                    icon: 'warning',
                });
                break;
            } else if (user[0].id == 0) {
                canISendForm = false;
                swal.fire({
                    title: 'Advertencia!',
                    text: `No existe un usuario con este documento`,
                    icon: 'warning',
                });
                break;
            } else if (user[0].status == 0) {
                canISendForm = false;
                Records(user[0].id, 'try')
                swal.fire({
                    title: 'Advertencia!',
                    text: `Este Usuario no puede ingresar porque se encuentra deshabilitado, por favor comuniquese con el administrador`,
                    icon: 'warning',
                });
                break;
            }
            else if (user[0].type == 2) {
                canISendForm = false;
                Records(user[0].id, 'try');
                swal.fire({
                    title: 'Advertencia!',
                    text: `Este Usuario es un administrador, debe ingresar por el siguiente link http://127.0.0.1:8000/login`,
                    icon: 'warning',
                });
                break;
            } else {
                canISendForm = true;
            }
            break;
    }
    return canISendForm;
}

const LoginAdmin = () => {
    if (validateFields(1)) {
        $.ajax({
            url: '/loginAdmin',
            method: 'POST',
            data: $('#formLoginAdmin').serialize(),
            error: function (xhr, ajaxOptions, thrownerror) {
                swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON.message,
                    icon: 'error',
                });
            },
            success: function (res) {
                user.length = 0;
                window.location.reload();
            }
        });
    }
}

const LoginEmployee = () => {
    if (validateFields(2)) {
        $.ajax({
            url: '/login',
            method: 'POST',
            data: $('#formLogin').serialize(),
            error: function (xhr, ajaxOptions, thrownerror) {
                swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON.message,
                    icon: 'error',
                });
            },
            success: function (res) {
                if (res.response.length > 0) {
                    Records(user[0].id, 'entry');
                    user.length = 0;

                    window.location.reload();
                }
            }
        });
    }
}

//Validar caracteres
function PatternTextNumbers() {
    if (!/^[a-zA-Z0-9]*$/i.test($('.document').val())) {
        $('.document').val($('.document').val().replace(/[^a-zA-Z0-9]+/ig, ""));
    }

}


