<?php
// Conectar ao servidor e banco de dados
$conectar = mysql_connect('localhost', 'root', '');
$banco = mysql_select_db("livraria");

// Processar cadastro de editora
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];

    // Gerar código único para a editora
    $query = "SELECT MAX(codigo) as maxCodigo FROM editora";
    $resultado = mysql_query($query);
    $linha = mysql_fetch_assoc($resultado);
    $codigo = $linha['maxCodigo'] + 1;
    if(empty($codigo)) {
        $codigo = 1;
    }

    // Inserir nova editora
    $sql = "INSERT INTO editora (codigo, nome) VALUES ('$codigo', '$nome')";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "Editora cadastrada com sucesso!";
    } else {
        echo "Falha ao cadastrar a editora: " . mysql_error();
    }
}

// Processar exclusão de editora
if (isset($_POST['excluir'])) {
    $codigo = $_POST['codigo'];

    // Verificar se existem livros associados a esta editora
    $query = "SELECT COUNT(*) as total FROM livro WHERE codeditora = '$codigo'";
    $resultado = mysql_query($query);
    $linha = mysql_fetch_assoc($resultado);
    
    if ($linha['total'] > 0) {
        echo "Não é possível excluir esta editora pois existem livros associados a ela!";
    } else {
        // Excluir editora
        $sql = "DELETE FROM editora WHERE codigo = '$codigo'";
        $resultado = mysql_query($sql);

        if ($resultado) {
            echo "Editora excluída com sucesso!";
        } else {
            echo "Falha ao excluir a editora: " . mysql_error();
        }
    }
}

// Processar alteração de editora
if (isset($_POST['alterar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    // Alterar editora
    $sql = "UPDATE editora SET nome='$nome' WHERE codigo = '$codigo'";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "Editora alterada com sucesso!";
    } else {
        echo "Falha ao alterar a editora: " . mysql_error();
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
                <li><a href="../menu_livraria.html">Menu Principal</a></li>
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