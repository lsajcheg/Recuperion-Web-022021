<?php
include 'funciones.php';

$error = false;
$config = include 'config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $consultaSQL = "SELECT * FROM tb_user";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuarios = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}
?>

<?php include "templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="create.php"  class="btn btn-primary mt-4">Crear usuario</a>
      <hr>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3">Lista de usuarios</h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Código de Identificación</th>
            <th>Puesto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($usuarios && $sentencia->rowCount() > 0) {
            foreach ($usuarios as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["cod_user"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["apellido"]); ?></td>
                <td><?php echo escapar($fila["cod_identificacion"]); ?></td>
                <td><?php echo escapar($fila["puesto"]); ?></td>
                <td></td>
                <td>
                  <a href="<?= 'borrar.php?id=' . escapar($fila["cod_user"]) ?>">Borrar</a>
                  <a href="<?= 'editar.php?id=' . escapar($fila["cod_user"]) ?>" . >Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>