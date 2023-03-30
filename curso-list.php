<?php

require "connection.php";
require "classes/Curso.php";

$sql = "SELECT * FROM cursos ORDER BY id";
$stmt = $conn->query($sql);
$cursos = $stmt->fetchAll(PDO::FETCH_CLASS, "Curso");
require_once "header_inc.php";
?>

<?php require_once "header_inc.php"; ?>

<div class="p-4 mb-4 bg-light">
  <h1 class="display-5">Gerenciamento de Cursos</h1>
  <hr class="my-3">
  <p class="lead">Permite a inclusão, edição e exclusão dos cursos exibidos na página de cursos.</p>
</div>

<div class="container">
  <a class="btn btn-success" href="curso-add.php">Criar Novo Curso</a>
  <p></p>
  <table class="table table-bordered">
    <tr class="table-success text-center text-center">
      <th>#</th>
      <th>Data Cadastro</th>
      <th>Nome</th>
      <th>Descrição</th>
      <th>Imagem</th>
      <th>Ação</th>
    </tr>
    <?php foreach ($cursos as $c) { ?>
      <tr style="vertical-align: middle;">
        <td class="text-center table-light"><?= $c->getId() ?></td>
        <td class="text-center table-light"><?= date("d/m/Y H:i:s", strtotime($c->getDataCadastro())) ?></td>
        <td class="text-center table-light"><?= $c->getNome() ?></td>
        <td class="text-justify table-light"><?= $c->getDescricao() ?></td>
        <td class="table-light"><img src="<?= $c->getImagePath() ?>" style="widht: 80px; height: 80px"></td>
        <td class="table-light">
          <div class="btn-group d-flex flex-column gap-3" role="group">
            <a href="curso-add.php?id=<?= $c->getId(); ?>" class="btn btn-warning">Editar</a>
            <a href="curso-destroy.php?id=<?= $c->getId(); ?>" class="btn btn-danger">Excluir</a>
          </div>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

<?php require_once "footer_inc.php"; ?>