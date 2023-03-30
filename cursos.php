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
    <h1 class="display-5">Cursos</h1>
    <hr class="my-3">
    <p class="lead">Conheça os cursos disponíveis em nossa plataforma.</p>
</div>

<br />
<div class="container">
    <?php

    foreach ($cursos as $curso) {
    ?>
        <div class="row featurette border p-3 mt-4">
            <div class="col-md-7">
                <div class="d-flex flex-column justify-content-between h-100">
                    <div>
                        <h2 class="featurette-heading"><?= $curso->getNome() ?></h2>
                        <p class="lead"><?= $curso->getDescricao() ?></p>
                    </div>
                    <p class="lead"><a href="#"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Saiba mais</button></a></p>
                </div>
            </div>
            <div class="col-md-5">
                <figure class="figure">
                    <img src="<?= $curso->getImagePath() ?>" class="figure-img img-fluid rounded" alt="Curso de PHP">
                </figure>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php require_once "footer_inc.php"; ?>