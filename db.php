<?php
// Conexion con la DB
$servidor ="localhost";
$baseDeDatos = "app";
$usuario="root";
$contrasena="";

try {
  $conexion= new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasena);
} catch (Exception $ex) {
  echo $ex->getMessage();
}
?>