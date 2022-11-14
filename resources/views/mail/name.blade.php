<!DOCTYPE html>
<html lang="es">

<body class="antialiased">
    <div>
        <h1>Registro Exitoso</h1>
        <p>Bienvenido {{ $request->name}}</p>
        <p>Se ha creado su cuenta exitosamente sus credenciales son las siguientes:</p>
        <p> </p>
        <p>usuario: {{ $request->email}}</p>
        <p>Contraseña: {{ $request->password}}</p>
        <p> </p>
        <p>Ya puedes iniciar sesion en en el siguiente link http://localhost:3000/</p>
    </div>
</body>

</html>