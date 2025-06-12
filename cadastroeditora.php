<?php

// fazer conexão com o banco
$conectar = mysql_connect("localhost","root","");
$banco = mysql_select_db("livraria");

// if para a opção dos botões
if(isset($_POST['enviar'])){

    // capturar as variáveis inseridas no HTML
    $nome = $_POST['nome'];
    
    // mandar executar comando SQL
    $sql = mysql_query("insert into editora(nome) values('$nome')");

    // analisar resultado
    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro atualizado com sucesso!'); window.location='cadastroeditora.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível atualizar o cadastro: " . mysql_error() . "'); window.location='cadastroeditora.php';</script>";
    }
}

if(isset($_POST['alterar'])){
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = mysql_query("update editora set nome = '$nome' where codigo = '$codigo'");

    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Dados alterados com sucesso!'); window.location='cadastroeditora.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível atualizar o cadastro: " . mysql_error() . "'); window.location='cadastroeditora.php';</script>";
    }
}

if(isset($_POST['excluir'])){
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = mysql_query("delete * from editora where codigo = '$codigo'");

    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro escluído com sucesso!'); window.location='cadastroeditora.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível excluir o cadastro: " . mysql_error() . "'); window.location='cadastroeditora.php';</script>";
    }
}

if(isset($_POST['pesquisar'])){
    $codigo = $_POST['codigo'];

    $sql = "select * from editora where codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0){
        echo "<script>alert('Não foi possível encontrar o cadastro: " . mysql_error() . "'); window.location='cadastroeditora.php';</script>";
    }
    else{
        echo "<b>"."Pesquisa de Editora: "."</b><br>";
        
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
    <title>Cadastro de Editora – Vermelha Books</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
        <h2>Cadastro de Editora</h2>
        <form action="cadastroeditora.php" method="POST">
            <label for="nome">Nome da Editora:</label>
            <input type="text" id="nome" name="nome" required>

            <input type="submit" value="Cadastrar Editora" id="enviar">
        </form>
    </div>
</div>

</body>
</html>
