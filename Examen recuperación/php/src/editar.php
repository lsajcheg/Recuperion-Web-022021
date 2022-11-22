<?php
include 'funciones.php';

$config = include 'config.php';

$timestamps = false;

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El usuario no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = [
      "id"        => $_GET['id'],
      "nombre"   => $_POST['nombre'],
      "apellido" => $_POST['apellido'],
      "puesto"    => $_POST['puesto'],
      "cod_identificacion"     => $_POST['cod_identificacion']
    ];

   
    
    $consultaSQL = "UPDATE tb_user SET
        nombre = :nombre,
        apellido = :apellido,
        puesto = :puesto,
        cod_identificacion = :cod_identificacion
        WHERE cod_user = :id";
    
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($usuario);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET["id"];

  $consultaSQL = "SELECT * FROM tb_user WHERE cod_user =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el usuario';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El usuario ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($usuario) && $usuario) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el usuario <?= escapar($usuario['nombre']) . ' ' . escapar($usuario['apellido'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['nombre']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= escapar($usuario['apellido']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="puesto">Puesto</label>
            <input type="puesto" name="puesto" id="puesto" value="<?= escapar($usuario['puesto']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="edad">Código de Identificación</label>
            <input type="text" name="cod_identificacion" id="cod_identificacion" value="<?= escapar($usuario['cod_identificacion']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary"  value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "templates/footer.php"; ?>