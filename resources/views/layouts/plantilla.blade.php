<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="css/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="css/datatable/buttons.bootstrap4.min.css">

    <script src="js/jquery-3.6.1.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert2011.js"></script>
    <script src="js/datatable/jquery.dataTables.min.js"></script>
    <script src="js/datatable/dataTables.buttons.min.js"></script>
    <script src="js/datatable/buttons.bootstrap4.min.js"></script>
    <script src="js/datatable/jszip.min.js"></script>
    <script src="js/datatable/pdfmake.min.js"></script>
    <script src="js/datatable/vfs_fonts.js"></script>
    <script src="js/datatable/buttons.html5.min.js"></script>
    <script src="js/datatable/buttons.print.min.js"></script>
    <script src="js/datatable/buttons.colVis.min.js"></script>
    <script src="js/datatable/dataTables.responsive.min.js"></script>




    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>@yield('title')</title>
</head>

<body style="background: #0c242b">
    <div class="px-5 py-3">
        <div class="wrapper">
            <!-------------------------------------  CONTENIDO  ----------------------------------------->
            <!------home------>
            @yield('index')
            @yield('login')
            <!------login------>
            @yield('login_admin')
        </div>
    </div>
</body>

</html>
