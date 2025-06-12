<?php

// fazer conexão com o banco
$conectar = mysql_connect("localhost","root","");
$banco = mysql_select_db("loja");

// if para a opção dos botões
if(isset($_POST['enviar'])){

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT login, senha from usuario WHERE login = '$login' and senha = '$senha'";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0){
        echo"<script language='javascript' type='text/javascript'>
                alert('Login ou Senha incorretos.');
                window.location.href='login.php'; 
             </script>'";
    }
    else{
        setcookie('login',$login);
        header('Location:menu.html');
    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Login de Usuário </title>
    <link rel="shortcut icon" href="icone.ico" /> 
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <header>

        <a href="pesquisa.php" id="logo"><img src="Logo.png" height=95></a>
        <a href="login.php" id="logologin"><img src="https://img.icons8.com/?size=100&id=23400&format=png&color=FFFFFF" height=45></a>

    </header>

    <div class="mainarea">

        <div id="menublock">

            <form name="formulario" method="post" action="login.php">

                <h2> Usuário: </h2>
                Login: <input type="text" name="login" id="login" size="10">
                <br><br>
                Senha: <input type="password" name="senha" id="senha" size="10">
                <br><br>
                <input type="submit" name="enviar" id="enviar" value="Entrar">

            </form>

        </div>

    </div>

</body>

</html>