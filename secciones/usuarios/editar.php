<?php 
include("../../db.php");

if (isset($_GET['txtID'])) {
  $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";

  $sentencia = $conexion->prepare("SELECT * FROM tbl_usuarios WHERE id=:id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
  $registro = $sentencia->fetch(PDO::FETCH_LAZY);
  $usuario=$registro["usuario"];
  $contrasena=$registro["contrasena"];
  $correo=$registro["correo"];
}

if ($_POST) {
  // Recoleccion de datos mediante metodo POST
  $txtID = (isset($_GET["txtID"]))?$_GET["txtID"]:"";
  $usuario = (isset($_POST["usuario"])?$_POST["usuario"]:"");
  $contrasena = (isset($_POST["contrasena"])?$_POST["contrasena"]:"");
  $correo = (isset($_POST["correo"])?$_POST["correo"]:"");
  // Inserccion de los datos
  $sentencia = $conexion->prepare("UPDATE tbl_usuarios SET usuario=:usuario, contrasena=:contrasena, correo=:correo WHERE id=:id");
// Asignacion de valores}
$sentencia->bindParam(":usuario", $usuario);
$sentencia->bindParam(":contrasena", $contrasena);
$sentencia->bindParam(":correo", $correo);
$sentencia->bindParam(":id", $txtID);
$sentencia->execute();
$mesaje = "Registro actualizado";
header("Location: index.php?mensaje=".$mesaje);
}
?>

<?php include("../../templates/header.php"); ?>

<br>
<div class="card">
  <div class="card-header">
    Datos del usuario
  </div>
  <div class="card-body">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="usuario" class="form-label">Nombre del usurio:</label>
      <input type="text"  value="<?php echo $usuario;?>"
        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
    </div>
    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña:</label>
      <input type="password"  value="<?php echo $contrasena;?>"
        class="form-control" name="contrasena" id="contrasena" aria-describedby="helpId" placeholder="Contraseña">
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo:</label>
      <input type="email"  value="<?php echo $correo;?>"
        class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo@ejemplo.com">
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
  </form>
  </div>
</div>

<?php include("../../templates/footer.php");?>