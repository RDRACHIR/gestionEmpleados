<?php
include("../../db.php");
if (isset($_GET['txtID'])) {
  $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";

  $sentencia = $conexion->prepare("SELECT *, (SELECT nombredelpuesto FROM tbl_puestos 
  WHERE `tbl_puestos`.id=`tbl_empleados`.idpuesto LIMIT 1) AS puesto FROM tbl_empleados WHERE id=:id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
  $registro = $sentencia->fetch(PDO::FETCH_LAZY);

  // print_r($registro);

  $primernombre=$registro["primernombre"];
  $segundonombre=$registro["segundonombre"];
  $primerapellido=$registro["primerapellido"];
  $segundoapellido=$registro["segundoapellido"];

  $nombreCompleto = $primernombre. " ".$segundonombre. " ".$primerapellido." ".$segundoapellido;

  $foto = $registro["foto"];
  $cv = $registro["cv"];
  $idpuesto = $registro["idpuesto"];
  $puesto = $registro["puesto"];
  $fechadeingreso = $registro["fechadeingreso"];

  $fechaInicio = new DateTime($fechadeingreso);
  $fechaFin = new DateTime(date('Y-m-d'));
  $diferencia = date_diff($fechaInicio, $fechaFin);
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carta de recomendación</title>
</head>
<body>
  <h1>Carta de Recomendación Laboral</h1>
<br><br>
Cúcuta, Colombia a <strong><?php echo date("d-m-y");?></strong>
  <br><br>
  A quien pueda interesar:
  <br><br>
  Reciba un cordial y respetuoso saludo.
  <br><br>
A través de estas líneas deseo hacer de su conocimiento que Sr(a) <strong> <?php echo $nombreCompleto;?></strong>,
quien laboró en mi organización durante <strong> <?php echo $diferencia->y;?>año(s)</strong>
es un ciudadano con una conducta intachable. Ha demostrado ser un gran trabajador, comprometido, responsable y fiel cumplidor de sus tareas. 
Siempre ha manifestado preocupación por mejorar, capacitarse y actualizar sus conocimientos.
<br><br>
Durante estos años se ha desempeñado como: <strong> <?php echo $puesto;?> </strong>
Es por ello le sugiero considere esta recomendación, con la confianza de que estará siempre a la altura de sus compromisos y responsabilidades
<br><br>
Sin más nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi numero de contacto para cualquier información de interés.
<br><br><br><br><br><br>
_________________________
<br>
Atentamente,
<br>
Ing. Juan Martinez Uh
</body>
</html>

<?php 
// Convertir la plantilla de carta a archivo pdf mediante el uso de la lib de dompdf
$HTML = ob_get_clean();
require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array("isRemoteEnabled"=>true));

$dompdf->setOptions($options); 

$dompdf->loadHTML($HTML);

$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));
?>
