<?php

// fazer conexão com o banco
$conectar = mysql_connect("localhost","root","");
$banco = mysql_select_db("livraria");

// if para a opção dos botões
if(isset($_POST['enviar'])){

    // capturar as variáveis inseridas no HTML
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];

    // mandar executar comando SQL
    $sql = mysql_query("insert into autor(nome, pais) values('$nome', '$pais')");

    // analisar resultado
    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro atualizado com sucesso!'); window.location='cadastroautor.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível atualizar o cadastro: " . mysql_error() . "'); window.location='cadastroautor.php';</script>";
    }
}

if(isset($_POST['alterar'])){
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];

    $sql = mysql_query("update autor set nome = '$nome' where codigo = '$codigo'");

    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Dados alterados com sucesso!'); window.location='cadastroautor.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível atualizar o cadastro: " . mysql_error() . "'); window.location='cadastroautor.php';</script>";
    }
}

if(isset($_POST['excluir'])){
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];

    $sql = mysql_query("delete * from autor where codigo = '$codigo'");

    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro excluído com sucesso!'); window.location='cadastroautor.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível excluir o cadastro: " . mysql_error() . "'); window.location='cadastroautor.php';</script>";
    }
}

if(isset($_POST['pesquisar'])){
    $codigo = $_POST['codigo'];

    $sql = "select * from autor where codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if (mysql_affected_rows() > 0){
        echo "<script>alert('Não foi possível encontrar o cadastro: " . mysql_error() . "'); window.location='cadastrotipo.php';</script>";
    }
    else{
        echo "<b>"."Pesquisa de Autor: "."</b><br>";
        
        while ($dados = mysql_fetch_array($resultado)){
                echo "Código: ".$dados['codigo']."<br>"."Nome: ".$dados['nome']."<br>";
            }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Autor – Vermelha Books</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="pesquisa.php" id="logo">
        <img src="https://i.imgur.com/BBJg7Ee.png" alt="Vermelha Books Logo">
    </a>
    <a href="login.php" id="logologin">
        <img src="https://img.icons8.com/?size=100&id=9ZgJRZwEc5Yj&format=png&color=FFFFFF" alt="Login">
    </a>
</header>

<div class="mainarea">
    <div id="menublock">
        <h2>Cadastro de Autor</h2>
        <form action="cadastroautor.php" method="POST">
            <label for="nome">Nome do Autor:</label>
            <input type="text" id="nome" name="nome" required>

            <input type="submit" value="Cadastrar Autor" id="enviar">
        </form>
    </div>
</div>

</body>
</html>
