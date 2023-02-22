<?php 
include("../../db.php");

$sentencia = $conexion->prepare("SELECT *, 
-- Utilizacion de sub-consulta para obtener el nombre del puesto requerido
(SELECT nombredelpuesto 
FROM tbl_puestos 
WHERE tbl_puestos.id=tbl_empleados.idpuesto LIMIT 1) AS puesto 

FROM `tbl_empleados`");

$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Eliminacion de registro
if (isset($_GET['txtID'])) {
  $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";

  // Buscar el archivo relacionado con el empleado
  $sentencia = $conexion->prepare("SELECT foto, cv FROM `tbl_empleados` WHERE id=:id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
  $registro_recuperado= $sentencia->fetch(PDO::FETCH_LAZY); //Nos arroja un solo dato

  // print_r($registro_recuperado);

if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] !=""){
  if (file_exists("./".$registro_recuperado["foto"])) { //Valida si el archivo existe
    unlink("./".$registro_recuperado["foto"]); //Elimina el archivo
  }
}

if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] !=""){
  if (file_exists("./".$registro_recuperado["cv"])) { //Valida si el archivo existe
    unlink("./".$registro_recuperado["cv"]); //Elimina el archivo
  }
}

  $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
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
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>
  </div>
  <div class="card-body">
    <div class="table-responsive-sm">
      <table class="table" id="tabla_id">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Foto</th>
            <th scope="col">CV</th>
            <th scope="col">Puesto</th>
            <th scope="col">Fecha de ingreso</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lista_tbl_empleados as $empleado) {?>
          <tr class="">
            <td scope="row"><?php echo $empleado['id'];?></td>
            <td scope="row">
              <?php echo $empleado['primernombre'];?>
              <?php echo $empleado['segundonombre'];?>
              <?php echo $empleado['primerapellido'];?>
              <?php echo $empleado['segundoapellido'];?>
          </td>
            <td>
              <img width="50" 
              src="<?php echo $empleado['foto'];?>" 
              class="img-fluid rounded" alt=""/>
            </td>
            <td>
              <a href="<?php echo $empleado['cv'];?>">
              <?php echo $empleado['cv'];?>
              </a>
            </td>
            <td><?php echo $empleado['puesto'];?></td>
            <td><?php echo $empleado['fechadeingreso'];?></td>
          <td>
            <a class="btn btn-primary" href="carta_recomendacion.php?txtID=<?php echo $empleado['id']?>" role="button">Carta</a>| 
            <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $empleado['id']?>" role="button">Editar</a>| 
            <a class="btn btn-danger" href="javascript:borrar(<?php echo $empleado['id'];?>)" role="button">Eliminar</a>
          </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    
  </div>
</div>

<?php include("../../templates/footer.php");?>