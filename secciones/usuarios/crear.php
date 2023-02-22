<?php
include("../../db.php");

if ($_POST) {
  // Validacion
  $usuario = (isset($_POST["usuario"])?$_POST["usuario"]:"");
  $contrasena = (isset($_POST["contrasena"])?$_POST["contrasena"]:"");
  $correo = (isset($_POST["correo"])?$_POST["correo"]:"");

  $sentencia = $conexion->prepare("INSERT INTO tbl_usuarios(id,usuario,contrasena,correo) VALUES(NULL, :usuario, :contrasena, :correo)");
// Asigna valores que tienen uso de :variable
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->bindParam(":contrasena", $contrasena);
  $sentencia->bindParam(":correo", $correo);
  $sentencia->execute();
  $mesaje = "Registro agregado";
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
      <input type="text"
        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
    </div>
    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña:</label>
      <input type="password"
        class="form-control" name="contrasena" id="contrasena" aria-describedby="helpId" placeholder="Contraseña">
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo:</label>
      <input type="email"
        class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Correo@ejemplo.com">
    </div>
    <button type="submit" class="btn btn-success">Agregar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
  </form>
  </div>
</div>

<?php include("../../templates/footer.php");?>