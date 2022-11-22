<?php

include 'funciones.php';

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El usuario ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = array(
     
      "nombre"   => $_POST['nombre'],
      "apellido" => $_POST['apellido'],
      "puesto"    => $_POST['puesto'],
      "cod_identificacion"     => $_POST['cod_identificacion'],
    );

    $consultaSQL = "INSERT INTO tb_user (nombre, apellido, cod_identificacion, puesto) values (:" . implode(", :", array_keys($usuario)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($usuario);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<?php include "templates/header.php"; ?>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un usuario</h2>
      <hr>
      <form method="post">
      
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" name="apellido" id="apellido" class="form-control">
        </div>
        <div class="form-group">
          <label for="puesto">Puesto</label>
          <input type="puesto" name="puesto" id="puesto" class="form-control">
        </div>
        <div class="form-group">
          <label for="cod_identificacion">Código de Identificación</label>
          <input type="text" name="cod_identificacion" id="cod_identificacion" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>