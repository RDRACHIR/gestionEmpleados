<?php
error_reporting(E_ERROR | E_PARSE);
include("../../db.php");

// Mostrar los datos a editar
if (isset($_GET['txtID'])) {
  $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";

  $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();

  $registro = $sentencia->fetch(PDO::FETCH_LAZY);
  $primernombre=$registro["primernombre"];
  $segundonombre=$registro["segundonombre"];
  $primerapellido=$registro["primerapellido"];
  $segundoapellido=$registro["segundoapellido"];

  $foto = $registro["foto"];
  $cv = $registro["cv"];

  $idpuesto = $registro["idpuesto"];
  $fechadeingreso = $registro["fechadeingreso"];

  $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
  $sentencia->execute();
  $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
}
// Enviar los nuevos datos
if ($_POST) {
  $txtID = (isset($_GET['txtID']))?$_GET['txtID']:"";
  $primernombre= (isset($_POST["primernombre"])?$_POST["primernombre"]:"");
  $segundonombre = (isset($_POST["segundonombre"])?$_POST["segundonombre"]:"");
  $primerapellido = (isset($_POST["primerapellido"])?$_POST["primerapellido"]:"");
  $segundoapellido = (isset($_POST["segundoapellido"])?$_POST["segundoapellido"]:""); 
  $idpuesto = (isset($_POST["idpuesto"])?$_POST["idpuesto"]:"");
  $fechadeingreso = (isset($_POST["fechadeingreso"])?$_POST["fechadeingreso"]:"");

  $sentencia = $conexion->prepare("
  UPDATE `tbl_empleados`
  SET 
    primernombre=:primernombre,
    segundonombre=:segundonombre,
    primerapellido=:primerapellido,
    segundoapellido=:segundoapellido,
    idpuesto=:idpuesto,
    fechadeingreso=:fechadeingreso
  WHERE `tbl_empleados`.id=:id");

// Asigna valores que tienen uso de :variable
  $sentencia->bindParam(":primernombre", $primernombre);
  $sentencia->bindParam(":segundonombre", $segundonombre);
  $sentencia->bindParam(":primerapellido", $primerapellido);
  $sentencia->bindParam(":segundoapellido", $segundoapellido);
  $sentencia->bindParam(":idpuesto", $idpuesto);
  $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
  $sentencia->bindParam(":id", $txtID);
  $sentencia->execute();
// --- Foto-----
  $foto = (isset($_FILES['foto']['name'])?$_FILES['foto']['name']:"");
  $fecha_= new DateTime(); //Odtener el tiempo
  
  //Adjuntar foto 
  $nombreArchivo_foto = ($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]['name']:"";
  $tmp_foto =  $_FILES["foto"]['tmp_name'];
  if ($tmp_foto!='') {
    move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto); //Mover el archivo temp a un nuevo destino 

    $sentencia = $conexion->prepare("SELECT foto FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
    if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!="") {
      if (file_exists("./".$resgistro_recuperado["foto"])) {
        unlink("./".$registro_recuperado["foto"]); //Elimina el registro
      }
    }

    $sentencia = $conexion->prepare("UPDATE `tbl_empleados` SET foto=:foto WHERE `tbl_empleados`.id=:id");
    $sentencia->bindParam(":foto", $nombreArchivo_foto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
  }
// ----CV----
  $cv = (isset($_FILES['cv']['name'])?$_FILES['cv']['name']:"");
  $nombreArchivo_cv = ($cv!='')?$fecha_->getTimestamp()."_".$_FILES["cv"]['name']:"";
  $tmp_cv =  $_FILES["cv"]['tmp_name'];
  if ($tmp_cv!='') {
    move_uploaded_file($tmp_cv,"./".$nombreArchivo_cv); //Mover el archivo temp a un nuevo destino 

    $sentencia = $conexion->prepare("SELECT cv FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
    if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!="") {
      if (file_exists("./".$resgistro_recuperado["cv"])) {
        unlink("./".$registro_recuperado["cv"]); //Elimina el registro
      }
    }

    $sentencia = $conexion->prepare("UPDATE tbl_empleados SET cv=:cv WHERE `tbl_empleados`.id = :id");
    $sentencia->bindParam(":cv", $nombreArchivo_cv);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
  }
  $mesaje = "Registro actualizado";
  header("Location: index.php?mensaje=".$mesaje);
}
?>

<?php include("../../templates/header.php"); ?>

<br>
<div class="card">
  <div class="card-header">
    Datos del empleado
  </div>
  <div class="card-body">
    <!-- Se debe añadir  enctype para poder agregar archivos al formulario-->
  <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="primernombre" class="form-label">Primer Nombre</label>
      <input type="text"  value="<?php echo $primernombre;?>"
        class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Pimer Nombre">
    </div>
    <div class="mb-3">
      <label for="segundonombre" class="form-label">Segundo Nombre</label>
      <input type="text"  value="<?php echo $segundonombre;?>"
        class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo Nombre">
    </div>
    <div class="mb-3">
      <label for="primerapellido" class="form-label">Primer Apellido</label>
      <input type="text"  value="<?php echo $primerapellido;?>"
        class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer Apellido">
    </div>
    <div class="mb-3">
      <label for="segundoapellido" class="form-label">Segundo Apellido</label>
      <input type="text"  value="<?php echo $segundoapellido;?>"
        class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo Apellido">
    </div>
    <div class="mb-3">
      <label for="foto" class="form-label">Foto:</label>
      <br>
      <img width="100" 
              src="<?php echo $foto;?>" 
              class="rounded" alt=""/>
      <br><br>
      <input type="file"
        class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
    </div>
    <div class="mb-3">
      <label for="cv" class="form-label">CV(PDF):</label>
      <a href="<?php echo $cv;?>"> <?php echo $cv;?></a>
      <input type="file"  class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
    </div>
    <div class="mb-3">
      <label for="idpuesto" class="form-label">Puesto:</label>
      <!-- "<?php echo $idpuesto;?>" -->
      <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
        <?php foreach ($lista_tbl_puestos as $registro) { ?>
        <option <?php echo ($idpuesto == $registro['id'])?"selected":""; ?> value="<?php echo $registro['id'];?>">
          <?php echo $registro['nombredelpuesto'];?>
        </option>
        <?php }?>
      </select>
    </div>
    <div class="mb-3">
      <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
      <input value="<?php echo $fechadeingreso;?>" type="date"  class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
    </div>
    <button type="submit" class="btn btn-success">Actualizar registro</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
  </form>

  </div>
</div>

<?php include("../../templates/footer.php");?>