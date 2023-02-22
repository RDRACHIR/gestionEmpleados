<?php 
include("../../db.php");

// Mostrar los registros
$sentencia = $conexion->prepare("SELECT * FROM tbl_usuarios");
$sentencia->execute();
$lista_tbl_usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

// Eliminacion de registro
if (isset($_GET['txtID'])) {
  $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";

  $sentencia = $conexion->prepare("DELETE FROM tbl_usuarios WHERE id=:id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
  $mesaje = "Registro eliminado";
  header("Location: index.php?mensaje=".$mesaje);
}
?>

<?php include("../../templates/header.php"); ?>

<br>
<div class="card">
  <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar usuario</a>
  </div>
  <div class="card-body">
    <div class="table-responsive-sm">
  <table class="table"  id="tabla_id">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre del usuario</th>
        <th scope="col">Contraseña</th>
        <th scope="col">Correo</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($lista_tbl_usuarios as $usuario ) {?>
      <tr class="">
        <td scope="row"><?php echo $usuario['id'];?></td>
        <td><?php echo $usuario['usuario'];?></td>
        <td><?php echo $usuario['contrasena'];?></td>
        <td><?php echo $usuario['correo'];?></td>
        <td>
          <a class="btn btn-info" href="editar.php?txtID=<?php echo $usuario['id'];?>" role="button">Editar</a>
      <a class="btn btn-danger"  href="javascript:borrar(<?php echo $usuario['id'];?>)"role="button">Eliminar</a>
      </td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>
  </div>
</div>

<?php include("../../templates/footer.php");?>