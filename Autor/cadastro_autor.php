<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "livraria";

// Criar conexão usando mysql (compatível com PHP 5.3)
$conexao = mysql_connect($servername, $username, $password);
if (!$conexao) {
    die("Falha na conexão: " . mysql_error());
}

$db_selected = mysql_select_db($dbname, $conexao);
if (!$db_selected) {
    die("Erro ao selecionar banco: " . mysql_error());
}

// Definir charset para UTF-8
mysql_query("SET NAMES 'utf8'", $conexao);

$message = "";
$messageType = "";

// Processar cadastro de autor
if (isset($_POST['cadastrar'])) {
    $nome = mysql_real_escape_string($_POST['nome'], $conexao);
    $pais = mysql_real_escape_string($_POST['pais'], $conexao);

    // Gerar código único para o autor
    $query = "SELECT MAX(codigo) as maxCodigo FROM autor";
    $resultado = mysql_query($query, $conexao);
    
    if ($resultado) {
        $linha = mysql_fetch_assoc($resultado);
        if ($linha['maxCodigo']) {
            $codigo = $linha['maxCodigo'] + 1;
        } else {
            $codigo = 1; // Primeiro autor
        }

        // Inserir novo autor
        $sql = "INSERT INTO autor (codigo, nome, pais) VALUES ('$codigo', '$nome', '$pais')";
        $resultado = mysql_query($sql, $conexao);

        if ($resultado) {
            $message = "Autor cadastrado com sucesso! Código: " . $codigo;
            $messageType = "success";
        } else {
            $message = "Falha ao cadastrar o autor: " . mysql_error();
            $messageType = "error";
        }
    } else {
        $message = "Erro ao gerar código do autor: " . mysql_error();
        $messageType = "error";
    }
}

// Processar exclusão de autor
if (isset($_POST['excluir'])) {
    $codigo = intval($_POST['codigo']);

    // Verificar se existem livros associados a este autor
    $query = "SELECT COUNT(*) as total FROM livro WHERE codautor = '$codigo'";
    $resultado = mysql_query($query, $conexao);
    
    if ($resultado) {
        $linha = mysql_fetch_assoc($resultado);
        
        if ($linha['total'] > 0) {
            $message = "Não é possível excluir este autor pois existem " . $linha['total'] . " livro(s) associado(s) a ele!";
            $messageType = "error";
        } else {
            // Verificar se o autor existe
            $query = "SELECT nome FROM autor WHERE codigo = '$codigo'";
            $resultado = mysql_query($query, $conexao);
            
            if ($resultado && mysql_num_rows($resultado) > 0) {
                $autorData = mysql_fetch_assoc($resultado);
                $autorNome = $autorData['nome'];
                
                // Excluir autor
                $sql = "DELETE FROM autor WHERE codigo = '$codigo'";
                $resultado = mysql_query($sql, $conexao);

                if ($resultado) {
                    $message = "Autor '" . $autorNome . "' excluído com sucesso!";
                    $messageType = "success";
                } else {
                    $message = "Falha ao excluir o autor: " . mysql_error();
                    $messageType = "error";
                }
            } else {
                $message = "Autor com código " . $codigo . " não encontrado!";
                $messageType = "error";
            }
        }
    } else {
        $message = "Erro na consulta: " . mysql_error();
        $messageType = "error";
    }
}

// Processar alteração de autor
if (isset($_POST['alterar'])) {
    $codigo = intval($_POST['codigo']);
    $nome = mysql_real_escape_string($_POST['nome'], $conexao);
    $pais = mysql_real_escape_string($_POST['pais'], $conexao);

    // Verificar se o autor existe
    $query = "SELECT nome FROM autor WHERE codigo = '$codigo'";
    $resultado = mysql_query($query, $conexao);
    
    if ($resultado && mysql_num_rows($resultado) > 0) {
        // Alterar autor
        $sql = "UPDATE autor SET nome='$nome', pais='$pais' WHERE codigo = '$codigo'";
        $resultado = mysql_query($sql, $conexao);

        if ($resultado) {
            $message = "Autor alterado com sucesso!";
            $messageType = "success";
        } else {
            $message = "Falha ao alterar o autor: " . mysql_error();
            $messageType = "error";
        }
    } else {
        $message = "Autor com código " . $codigo . " não encontrado!";
        $messageType = "error";
    }
}

mysql_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Operação</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .auto-redirect {
            font-style: italic;
            margin-top: 10px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="cosmic-bg"></div>
    <div class="container">
        <nav class="nav-menu">
            <ul>
                <li><a href="../menu_html.html">Menu Principal</a></li>
                <li><a href="cadastro_autor.html">Voltar para Autores</a></li>
            </ul>
        </nav>
        <div class="card">
            <h1>Resultado da Operação</h1>
            
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                    <?php if ($messageType === 'success'): ?>
                        <div class="auto-redirect">Redirecionando em 3 segundos...</div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="menu-grid">
                <a href="cadastro_autor.html" class="btn">Voltar para Autores</a>
                <a href="../livro/cadastro_livro.html" class="btn">Cadastrar Livro</a>
                <a href="../categoria/cadastro_categoria.html" class="btn">Cadastrar Categoria</a>
                <a href="../editora/cadastro_editora.html" class="btn">Cadastrar Editora</a>
                <a href="menu_livraria.html" class="btn">Menu Principal</a>
            </div>
        </div>
    </div>

    <?php if ($messageType === 'success'): ?>
    <script>
        setTimeout(function() {
            window.location.href = 'cadastro_autor.html';
        }, 3000);
    </script>
    <?php endif; ?>
</body>
</html>