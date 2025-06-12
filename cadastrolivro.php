<?php

// fazer conexão com o banco
$conectar = mysql_connect("localhost","root","");
$banco = mysql_select_db("livraria");

// if para a opção dos botões
if(isset($_POST['enviar'])){
    // capturar as variáveis inseridas no HTML
    $titulo = $_POST['titulo'];
    $nrpaginas = $_POST['nrpaginas'];
    $ano = $_POST['ano'];
    $codautor = $_POST['codautor'];
    $codcategoria = $_POST['codcategoria'];
    $codeditora = $_POST['codeditora'];
    $resenha = $_POST['resenha'];
    $preco = $_POST['preco'];
    $fotocapa1 = $_FILES['fotocapa1'];
    $fotocapa2 = $_FILES['fotocapa2'];

    //criar pasta e mover fotos pra ela
    $diretorio = "imgbanco/";

    $extensao1 = strtolower(substr($_FILES['fotocapa1']['name'], -4));
    $novo_nome1 = md5(time().$extensao1);
    move_uploaded_file($_FILES['fotocapa1']['tmp_name'], $diretorio.$novo_nome1);

    //mudar nome foto2
    $extensao2 = strtolower(substr($_FILES['fotocapa2']['name'], -6));
    $novo_nome2 = md5(time().$extensao2);
    move_uploaded_file($_FILES['fotocapa2']['tmp_name'], $diretorio.$novo_nome2);

    // variável que guarda o comando SQL pro BD
    $sql = mysql_query("insert into livro(titulo, nrpaginas, ano, codautor, codcategoria, codeditora, resenha, preco, fotocapa1, fotocapa2) 
            values('$titulo','$nrpaginas', '$ano', '$codautor', '$codcategoria', '$codeditora', '$resenha', '$preco', '$novo_nome1', '$novo_nome2')");
   
    // analisar resultado
    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro atualizado com sucesso!'); window.location='cadastrolivro.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível atualizar o cadastro: " . mysql_error() . "'); window.location='cadastrolivro.php';</script>";
    }
}

if(isset($_POST['alterar'])){
    $codigo = $_POST['codigo'];
    $preco = $_POST['preco'];

    $sql = "update livro set preco='$preco' where codigo='$codigo'";

    $resultado = mysql_query($sql);

    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro atualizado com sucesso!'); window.location='cadastrolivro.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível atualizar o cadastro: " . mysql_error() . "'); window.location='cadastrolivro.php';</script>";
    }
}

if(isset($_POST['excluir']))
{
    $codigo = $_POST['codigo'];
    echo $codigo;

    $sql = mysql_query("delete from livro where codigo = '$codigo'");

    echo $sql;

    if (mysql_affected_rows() > 0) {
        echo "<script>alert('Cadastro excluído com sucesso!'); window.location='cadastrolivro.php';</script>";
    }
    else {
        echo "<script>alert('Não foi possível excluir o cadastro: " . mysql_error() . "'); window.location='cadastrolivro.php';</script>";
    }
}

if(isset($_POST['pesquisar'])){
    $codigo = $_POST['codigo'];

    $sql = "select * from livro where codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) == 0){
        echo "<script>alert('Não foi possível encontrar o cadastro: " . mysql_error() . "'); window.location='cadastrolivro.php';</script>";
    }
    else{
        echo "<b>"."Pesquisa de Livro: "."</b><br>";
        
        while ($dados = mysql_fetch_object($resultado)){
                echo "Título: ".$dados->titulo."<br>";
                echo "Número de Páginas: ".$dados->nrpaginas."<br>";
                echo "Ano de Publicação: ".$dados->ano."<br>";
                echo "Autor: ".$dados->codautor."<br>";
                echo "Categoria: ".$dados->codcategoria."<br>";
                echo "Editora: ".$dados->codeditora."<br>";
                echo "Resenha: ".$dados->resenha."<br>";
                echo "Preço: ".$dados->preco."<br>";

                echo '<img src="imgbanco/'.$dados->fotocapa1.'"height="200" widht="200" />'." ";
                echo '<img src="imgbanco/'.$dados->fotocapa2.'"height="200" widht="200" />';
            }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Livro – Vermelha Books</title>
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
        <h2>Cadastro de Livro</h2>
        <form action="cadastrolivro.php" method="POST" enctype="multipart/form-data">
            <label for="titulo">Título do Livro:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>

            <label for="editora">Editora:</label>
            <input type="text" id="editora" name="editora" required>

            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" required>

            <label for="arquivo">Imagem da Capa:</label>
            <input type="file" id="arquivo" name="arquivo" required>

            <input type="submit" value="Cadastrar Livro" id="enviar">
        </form>
    </div>
</div>

</body>
</html>