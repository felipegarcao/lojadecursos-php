<?php

require "connection.php";
require "classes/Curso.php";


$nome = "";
$descricao = "";
$imagem = "";
$id = isset($_GET["id"]) ? $_GET["id"] : "";
if ($id != "") {
    if (!is_numeric($id)) {
        header("Location: curso-list.php");
    }
    $acao = "Atualizar";
    $sql = "SELECT * FROM cursos WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $curso = $stmt->fetchObject("Curso");

    $nome = $curso->getNome();
    $descricao = $curso->getDescricao();
    $caminho_da_img = $curso->getImagePath();
} else {
    $acao = "Cadastrar";
}


if (isset($_POST["enviar"])) {
    try {

        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];

        $uploaddir = "uploads/";

        if ($acao == "Cadastrar") {


            if (empty($_POST["nome"]) || empty($_POST["descricao"])) {
                $flag_msg = false; //Erro 
                $msg = "Dados incompletos, preencha o formulário corretamente!";
            } else {

                $uploadfile = $uploaddir . basename($_FILES['imagem']["name"]);
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile)) {
                    $stmt = $conn->prepare("INSERT INTO cursos (nome, descricao, caminho_da_imagem, data_cadastro) VALUES (:nome, :descricao, :caminho_da_imagem, NOW())");

                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':descricao', $descricao);
                    $stmt->bindParam(':caminho_da_imagem', $uploadfile);

                    $stmt->execute();

                    $flag_msg = true; // Sucesso 
                    $msg = "Dados enviados com sucesso!";

                    $nome = "";
                    $imagem = "";
                    $descricao = "";
                } else {
                    $flag_msg = false;
                    $msg = "Falha ao enviar imagem!";
                }
            }
        } else {
            $nome = $_POST["nome"];
            $descricao = $_POST["descricao"];
            $uploadfile = "";

            if ($_FILES["imagem"]["size"] > 0) {
                $uploadfile = $uploaddir . basename($_FILES['imagem']["name"]);
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile)) {
                    # Remover imagem antiga
                    unlink($caminho_da_img);
                }
            }
            if ($uploadfile != "") {
                $stmt = $conn->prepare("UPDATE cursos SET nome=:nome, descricao=:descricao, caminho_da_imagem=:caminho_da_imagem WHERE id=:id");
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':descricao', $descricao);
                $stmt->bindParam(':caminho_da_imagem', $uploadfile);
            } else {
                $stmt = $conn->prepare("UPDATE cursos SET nome=:nome, descricao=:descricao WHERE id=:id");
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':descricao', $descricao);
            }
            $stmt->execute();
            $flag_msg = true; // Sucesso 
            $msg = "Dados enviados com sucesso!";

            $nome = "";
            $imagem = "";
            $descricao = "";
        }
    } catch (PDOException $e) {
        $flag_msg = false; //Erro 
        $msg = "Erro na conexão com o Banco de dados: " . $e->getMessage();
    }

    $conn = null;
}
require_once "header_inc.php";
?>
<div class="p-4 mb-4 bg-light">
    <h1 class="display-5">Cursos</h1>
    <hr class="my-3">
    <p class="lead">
        Bem-vindo à página de cadastro de cursos do painel administrativo! Aqui você pode adicionar novos cursos ao seu catálogo. Você também pode editar cursos existentes. Cadastre seus cursos agora e impulsione o sucesso da sua instituição!
    </p>
</div>

<div class="container">
    <?php if (isset($msg)) : ?>
        <div class='alert alert-<?= isset($curso) ? "success" : "warning" ?>' role='alert'>
            <?= $msg ?>
        </div>
    <?php endif ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome; ?>" required>
        </div>
        <br />

        <br />
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= $descricao; ?></textarea>
        </div>
        <br />
        <div class="form-group">
            <label for="imagem">Imagem:</label>
            <input type="file" accept="image/*" class="form-control" id="imagem" name="imagem">
        </div>
        <br />


        <button type="submit" class="btn btn-primary mb-2" name="enviar"><?= $acao ?></button>
        <a href="curso-add.php"><button type="button" class="btn btn-primary mb-2" name="limpar">Limpar</button></a>
    </form>
</div>

<?php require_once "footer_inc.php"; ?>