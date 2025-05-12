<?php
//conectar com o servidor e banco
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db("livraria");

if (isset($_POST['gravar']))
{
    $codigo            = $_POST['codigo'];
    $titulo            = $_POST['titulo'];
    $nrpaginas         = $_POST['nrpaginas'];
    $ano               = $_POST['ano'];
    $codautor          = $_POST['codautor'];
    $codcategoria      = $_POST['codcategoria'];
    $codeditora        = $_POST['codeditora'];
    $resenha           = $_POST['resenha'];
    $preco             = $_POST['preco'];
    $fotocapa1         = $_FILES['fotocapa1'];
    $fotocapa2         = $_FILES['fotocapa2'];

    // Criar pasta fotos no diretório raiz se não existir
    $diretorio = "../fotos/";
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    // Mover arquivos de imagem
    $extensao1 = strtolower(substr($_FILES['fotocapa1']['name'], -4));
    $novo_nome1 = md5(time().$extensao1);
    if (move_uploaded_file($_FILES['fotocapa1']['tmp_name'], $diretorio.$novo_nome1)) {
        // Sucesso ao mover
    } else {
        echo "Erro ao mover a foto da capa 1. Verifique as permissões do diretório fotos.";
    }

    $extensao2 = strtolower(substr($_FILES['fotocapa2']['name'], -4));
    $novo_nome2 = md5(time().$extensao2);
    if (move_uploaded_file($_FILES['fotocapa2']['tmp_name'], $diretorio.$novo_nome2)) {
        // Sucesso ao mover
    } else {
        echo "Erro ao mover a foto da capa 2. Verifique as permissões do diretório fotos.";
    }

    $sql = "INSERT INTO livro (titulo, nrpaginas, ano, codautor, codcategoria, codeditora, resenha, preco, fotocapa1, fotocapa2)
            VALUES ('$titulo', '$nrpaginas', '$ano', '$codautor', '$codcategoria', '$codeditora', '$resenha', '$preco', '$novo_nome1', '$novo_nome2')";
    
    $resultado = mysql_query($sql);

    if (!$resultado) {
        echo "Falha ao gravar os dados do livro: " . mysql_error(); // Mensagem de erro detalhada
    } else {
        echo "Livro cadastrado com sucesso";
    }
}

if (isset($_POST['excluir']))
{
   $codigo = $_POST['codigo'];
   $sql = "DELETE FROM livro WHERE codigo = '$codigo'";
   $resultado = mysql_query($sql);

   if ($resultado === TRUE) {
       echo 'Livro excluído com sucesso';
   } else {
       echo 'Erro ao excluir o livro: ' . mysql_error();
   }
}

if (isset($_POST['alterar']))
{
   $codigo     = $_POST['codigo'];
   $titulo     = $_POST['titulo'];
   $nrpaginas  = $_POST['nrpaginas'];
   $ano        = $_POST['ano'];
   $resenha    = $_POST['resenha'];
   $preco      = $_POST['preco'];
   
   $sql = "UPDATE livro SET titulo='$titulo', nrpaginas='$nrpaginas', ano='$ano', resenha='$resenha', preco='$preco' WHERE codigo = '$codigo'";
   $resultado = mysql_query($sql);

   if ($resultado === TRUE) {
       echo 'Dados do livro alterados com sucesso';
   } else {
       echo 'Erro ao alterar dados do livro: ' . mysql_error();
   }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pós Cadastro</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="cosmic-bg"></div>
    <div class="container">
        <nav class="nav-menu">
            <ul>
                <li><a href="../loja/menu.html">Menu</a></li>
            </ul>
        </nav>
        <div class="card">
            <h1>Voltar Para:</h1>
            <div class="menu-grid">
                <a href="../livro/cadastro_livro.html" class="btn">Cadastrar Livro</a>
                <a href="../autor/cadastro_autor.html" class="btn">Cadastrar Autor</a>
                <a href="../categoria/cadastro_categoria.html" class="btn">Cadastrar Categoria</a>
                <a href="../editora/cadastro_editora.html" class="btn">Cadastrar Editora</a>
            </div>
        </div>
    </div>
</body>
</html>