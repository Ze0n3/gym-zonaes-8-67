<?php
session_start();
require_once("../../../base_datos/bd.php");
$daba = new Database();
$conex = $daba->conectar();
include("../../../controller/validar.php");

$docu = $_SESSION['docu'];

$SQL = $conex->prepare ("SELECT * FROM venta_serv");
$SQL -> execute();
$resul=$SQL->fetchAll();

$por_pagina = 5;
if(isset($_GET['pagina'])){
$pagina = $_GET['pagina'];
}
else
{
$pagina = 1;
}
$empieza = ($pagina - 1) * $por_pagina;
$sql1 = $conex->prepare("SELECT * FROM venta_serv WHERE venta_serv.doc_coach = '$docu'
ORDER BY id_vent_servi LIMIT $empieza, $por_pagina");
$sql1->execute();
$resultado1 = $sql1->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
$sql = $conex->prepare("SELECT COUNT(*) FROM venta_serv  ORDER BY id_vent_servi");
$sql->execute();
$resul = $sql->fetchColumn();
$total_paginas = ceil($resul / $por_pagina);
if ($total_paginas == 0)
{
echo "<center>".'Lista Vacia'."</center>";
} else

echo "<center><a href='tabla_venta_s.php?pagina=1'>" . "<i class='fa fa-arrow-left'></i>" . "</a>";
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/stiledi.css">
    <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <title>Lista de ventas de sericio</title>
    <link href="../../../img1/logo9.png" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <a class="btn btn success" href="../index.php" style="margin-left: 3.6%; margin-top:3%; position:absolute;">  
    <i class="bi bi-chevron-left" style="padding:10px 14px 10px 10px; color:#fff; font-size:15px; background-color:#0d6efd; border-radius:10px;"> REGRESAR</i>
    </a>

    <br>
    <a class="btn btn success" style="margin-left: 90%; margin-top:0%;" href="../excel/excel_horario.php">  
    <i class="bi bi-file-earmark-excel" style="padding:10px 10px 10px 10px; border-radius:10px; color:#fff; font-size:15px; background-color:#198754;">EXCEL</i>
    </a>
    <br>

    <a  class="btn btn success" href="../reporte/repor_venta_s.php" style="margin-left: 88%; margin-top:1%;">  
    <i class="bi bi-printer" style="padding:10px 16px 10px 16px; border-radius:10px; color:#fff; font-size:15px; background-color:#E00000;">  IMPRIMIR</i>
    </a>
    <!--creamos la tabla-->
    <table>
        <!--El tr nos sirve sirve para crear las filas-->
        <!--El th se crea la cabecera-->
        <thead>
            <tr>
                
                <th>FECHA INICIAL</th>
                <th>DOCUMENTO DEL COACH</th>
                <th>DOCUMENTO DEL CLIENTE</th>
                <th>TIPO DE SERVICIO</th>
                <th>FECHA FINAL</th>
                
                
               
            </tr>
        </thead>

        <?php
        foreach ($resultado1 as $usu) {
            //se abre el ciclo con la llave
        ?>
            <!--El td sirve para sirve para crear las columnas-->
            <!--En cada td se va a mostrar los datos de una tabla usando variables por ejemplo: $variable['nombre del campo de la tabla que queremos que se vea']-->
            <tr>
            
          
                <td><?= $usu['fecha_ini'] ?></td>
                <td><?= $usu['doc_coach'] ?></td>
                <td><?= $usu['doc_cliente'] ?></td>
                <td><?= $usu['id_tip_servi'] ?></td>
                <td><?= $usu['fecha_fin'] ?></td>
               
            </tr>

        <?php
        } //se cierra el recorrido cerrando la llave
        ?>
    </table>
    <br>
        <div class="text-center" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="First group" aling>
                    <?php
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        echo "<a class='btn btn-primary'  href='tabla_venta_s.php?pagina=" . $i . "'> " . $i . " </a>";
                    }
                    echo "<a href='tabla_venta_s.php?pagina=$total_paginas'>" . "<i class='fa fa-arrow-right'></i>"
                        . "</a></center>";
                    ?>
                </div>
            </div>

</body>

</html>