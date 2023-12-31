<?php
require_once("../../../base_datos/bd.php");
$daba = new Database();
$conex = $daba->conectar();
session_start();
include("../../../controller/validar.php");

$control = $conex->prepare("SELECT * From tip_user WHERE id_tip_user ");
$control->execute();
$query = $control->fetch();

$control1 = $conex->prepare("SELECT * From genero");
$control1->execute();
$query1 = $control1->fetch();

if (isset($_POST["validar_V"]) == "cli") {
    $cedula = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $fecha_n = $_POST['nacimiento'];
    
    $fecha_nacimiento = $fecha_n;
    $dia_actual = date("Y-m-d");
    $edad_diff = date_diff(date_create($fecha_nacimiento), date_create($dia_actual));
    $edad = $edad_diff->format('%y');

    $validar = $conex->prepare("SELECT * FROM usuarios where documento='$cedula' ");
    $validar->execute();
    $queryi = $validar->fetch();

    if ($cedula == "" || $nombre == "" || $genero == "" || $telefono == "" || $direccion == "" || $correo == "" || $fecha_n == "") {

        echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
        echo '<script>window.location="registrocli.php"</script>';
    } else if ($queryi) {
        echo '<script>alert ("DOCUMENTO YA EXISTEN // CAMBIELO//");</script>';
        echo 'script>windows.location="registrocli.php"</script>';
    } else {
        $insertsql = $conex->prepare("INSERT INTO usuarios(documento,cod_barras,nom_completo,edad,genero,fecha_nacimiento,tipo_usuario,telefono,direccion,correo,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $insertsql->execute([$cedula, $cedula, $nombre, $edad, $genero, $fecha_n, 3, $telefono, $direccion, $correo, 1]);
        echo '<script>alert ("Cliente Creado exitosamente, Gracias");</script>';
        echo '<script>window.location="../index.php"</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Crear Cliente</title>

    <link href="../../../img/logo_gym.png" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- direccion para que funcione solo numero -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body class="bg-gradient-primary">
<a class="btn btn success" href="../index.php" style="margin-left: 3.6%; margin-top:3%; position:absolute;">
        <i class="bi bi-chevron-left"
            style="padding:10px 14px 10px 10px; color:#fff; font-size:15px; background-color:#0d6efd; border-radius:10px;">
            REGRESAR</i>
    </a><br>
    <form method="post" autocomplete="off" name="cli">
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-6">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg-10">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Crear Clientes</h1>
                                </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 mb-3 mb-sm-2">
                                            <label>Documento</label>
                                            <input type="number" style="margin:0px;"
                                                class="form-control form-control-user" id="exampleFirstName" pattern="(?=.*\e)[0-9]{6,10}"
                                                maxlength="10" name="documento"  min="90000000" placeholder="Numero de documento"
                                                oninput="maxlengthNumber(this);" title="Solo se aceptan numeros" required>

                                        </div>
                                        <div class="col-sm-4 mb-3 mb-sm-2">
                                            <label>Nombre completo</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleLastName" maxlength="45"  oninput="validarletras(this);"
                                                onkeypress="return(sololetras(event));" name="nombre"  pattern="[A-Za-z].{20,45}" title="Solo se aceptan letras"
                                                placeholder="Nombre completo" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Genero</label>
                                            <select name="genero" class="form-control form-control-user"
                                                id="exampleFirstName" required>
                                                <option value="">Genero</option>
                                                <?php
                                                do {
                                                    ?>
                                                    <option value="<?php echo ($query1['id_genero']) ?>"> <?php echo ($query1['genero']) ?> </option>
                                                    <?php
                                                } while ($query1 = $control1->fetch());
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Estatura</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleFirstName" name="estatura" maxlength="4" pattern=".{4,.}" title="Solo se aceptan 3 numeros y un punto"
                                                oninput="maxlengthNumber(this);" onkeypress="return(solonumeros(event));" placeholder="Estatura" required>
                                        </div>
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <label>Telefono</label>
                                            <input type="number" class="form-control form-control-user"
                                                id="exampleLastName" name="telefono" min="3000000000" maxlength="10" pattern=".{10}" title="Solo se aceptan numeros" 
                                                oninput="maxlengthNumber(this);" placeholder="Telefono" required>
                                        </div>
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <label>Direccion</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleFirstName" name="direccion" maxlength="50"
                                                placeholder="Direccion" required>
                                        </div>
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <label>Correo electronico</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleLastName" name="correo" maxlength="35" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                placeholder="Correo electronico" required>
                                        </div>
                                        <div class="col-sm-4" style="height:70px;">
                                            <label>Fecha de nacimiento</label>
                                            <input type="date" class="form-control form-control-user"
                                                id="fecha" name="nacimiento" required>
                                            <br>
                                        </div>


                                        <!-- SOLO NUMERO,LONGITUD -->
                                        <script>
                                            function maxlengthNumber(obj) {
                                                console.log(obj.value);
                                                if (obj.value.length > obj.maxLength) {
                                                    obj.value = obj.value.slice(0, obj.maxLength);
                                                }
                                            }
                                        </script>

                                        <!-- LONGITUD DE LETRA -->
                                        <script>
                                            function validaletras(obj) {
                                                console.log(obj.value);
                                                if (obj.value.length > obj.maxLength) {
                                                    obj.value = obj.value.slice(0, obj.maxLength);
                                                }
                                            }
                                        </script>

                                        <!-- SOLO LETRA (ESPACIO DE LETRAS SE HACE EN LETRAS) -->
                                        <script>
                                            function sololetras(e) {
                                                key = e.keyCode || e.which;

                                                teclado = String.fromCharCode(key).toLowerCase();

                                                letras = "qwertyuiopasdfghjklñzxcvbnm ";

                                                especiales = "8-37-38-46-164-46";

                                                teclado_especial = false;

                                                for (var i in especiales) {
                                                    if (key == especiales[i]) {
                                                        teclado_especial = true;
                                                        break;
                                                    }
                                                }

                                                if (letras.indexOf(teclado) == -1 && !teclado_especial) {
                                                    return false;
                                                    a
                                                }
                                            }
                                        </script>

                                        <!-- SOLO NUMEROS () -->
                                        <script>
                                            function solonumeros(e) {
                                                key = e.keyCode || e.which;

                                                teclado = String.fromCharCode(key).toLowerCase();

                                                letras = "0123456789.";

                                                especiales = "8-37-38-46-164-46";

                                                teclado_especial = false;

                                                for (var i in especiales) {
                                                    if (key == especiales[i]) {
                                                        teclado_especial = true;
                                                        break;
                                                    }
                                                }

                                                if (letras.indexOf(teclado) == -1 && !teclado_especial) {
                                                    return false;
                                                    a
                                                }
                                            }
                                        </script>

                                        <!-- SOLO NUMERO -->
                                        <script>
                                            $(function() {
                                            $('input[type=number]').keypress(function(key) {
                                                if(key.charCode < 48 || key.charCode > 57) return false;
                                            });
                                        });

                                        </script>




                                        <input type="submit" style="margin-top:10px;"
                                            class="btn btn-primary btn-user btn-block" name="Suscribir">
                                        <input type="hidden" name="validar_V" value="user">
                              
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <script>
        // FUNCION DE JAVASCRIPT PARA VALIDAR LOS AÑOS DE RANGO PARA LA FECHA DE NACIMIENTO
        var fechaInput = document.getElementById('fecha');
        // Calcular las fechas mínima y máxima permitidas
        var fechaMaxima = new Date();
        fechaMaxima.setFullYear(fechaMaxima.getFullYear() - 14); // Restar 18 años para que la persona se registre 
        var fechaMinima = new Date();
        fechaMinima.setFullYear(fechaMinima.getFullYear() - 60); // Restar 80 años
        // Formatear las fechas mínima y máxima en formato de fecha adecuado (YYYY-MM-DD)
        var fechaMaximaFormateada = fechaMaxima.toISOString().split('T')[0];
        var fechaMinimaFormateada = fechaMinima.toISOString().split('T')[0];

        // Establecer los atributos min y max del campo de entrada de fecha
        fechaInput.setAttribute('min', fechaMinimaFormateada);
        fechaInput.setAttribute('max', fechaMaximaFormateada);
    </script>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>