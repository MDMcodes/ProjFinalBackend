<?php
    $connect = mysql_connect("localhost","root","");
    $db = mysql_select_db("livraria");

    session_start();
    $status="";

    if (isset($_POST['codigo']) && $_POST['codigo']!="") {
        $codigo = $_POST['codigo'];
        $resultado = mysql_query("SELECT nome, preco, foto1 FROM produto WHERE codigo = '$codigo'");

        $row = mysql_fetch_assoc($resultado);

        $nome = $row['nome'];
        $preco = $row['preco'];
        $foto1 = $row['foto1'];

        $cartArray = array($codigo=>array('nome'=>$nome,'preco'=>$preco,'quantity'=>1,'foto'=>$foto1));

        if(empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $status = "<div class='box'> O produto foi adicionado ao carrinho! </div>";
        }
        else {
            $array_keys = array_keys($_SESSION["shopping_cart"]);

            if(in_array($codigo,$array_keys)) {
                $status = "<div class='box'> Produto já está no carrinho! </div>";
            }
            else {
                $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
                $status = "<div class='box'> Produto foi adicionado ao carrinho! </div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pesquisa – Vermelha Books</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="pesquisa.php" id="logo">
        <img src="https://i.imgur.com/BBJg7Ee.png" alt="Vermelha Books Logo" height="80">
    </a>
</header>

<div class="slider">
    <img id="imgslide2" class="active" src="bannerimg/imgslide2.png"/>
    <img id="imgslide1" src="bannerimg/imgslide1.png"/>
    <img id="imgslide3" src="bannerimg/imgslide3.png"/>
</div>

<script>
    const imgs = document.querySelectorAll('.slider img');
    let current = 0;
    const total = imgs.length;
    const intervalTime = 4000;

    function showNextImage() {
        imgs[current].classList.remove('active'); 
        current = (current + 1) % total;
        imgs[current].classList.add('active');
    }

    setInterval(showNextImage, intervalTime);
</script>

<div class="messagebox" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>

<div id="homepage">
    <div id="barrapesquisa">
        <form name="formulario" method="post" action="pesquisa.php" id="formpesquisa">
            <label>Autor:</label>
            <select name="autor">
                <option value="" selected="selected">Selecione...</option>
                <?php
                $query = mysql_query("SELECT codigo, nome FROM autor");
                while($autor = mysql_fetch_array($query)) {
                    echo "<option value='{$autor['codigo']}'>{$autor['nome']}</option>";
                }
                ?>
            </select>

            <label>Categorias:</label>
            <select name="categoria">
                <option value="" selected="selected">Selecione...</option>
                <?php
                $query = mysql_query("SELECT codigo, nome FROM categoria");
                while($categorias = mysql_fetch_array($query)) {
                    echo "<option value='{$categorias['codigo']}'>{$categorias['nome']}</option>";
                }
                ?>
            </select>

            <label>Editora:</label>
            <select name="editora">
                <option value="" selected="selected">Selecione...</option>
                <?php
                $query = mysql_query("SELECT codigo, nome FROM editora");
                while($editora = mysql_fetch_array($query)) {
                    echo "<option value='{$editora['codigo']}'>{$editora['nome']}</option>";
                }
                ?>
            </select>

            <input type="submit" name="pesquisar" value="Pesquisar" id="pesquisar">
        </form>
    </div>

    <?php
    $sql_livros = "SELECT * FROM livro";
    $seleciona_livros = mysql_query($sql_livros);

    if (isset($_POST['pesquisar'])) {
        $autor = $_POST['autor'] ?? 'null';
        $categoria = $_POST['categoria'] ?? 'null';
        $editora = $_POST['editora'] ?? 'null';

        $condicoes = [];
        if ($autor !== 'null') $condicoes[] = "autor.codigo = '$autor'";
        if ($categoria !== 'null') $condicoes[] = "categoria.codigo = '$categoria'";
        if ($editora !== 'null') $condicoes[] = "editora.codigo = '$editora'";

        $where = count($condicoes) > 0 ? ' AND ' . implode(' AND ', $condicoes) : '';

        $sql_livros = "SELECT livro.* FROM livro, autor, categoria, editora
                        WHERE livro.codautor = autor.codigo
                        AND livro.codcategoria = categoria.codigo
                        AND livro.codeditora = editora.codigo" . $where;

        $seleciona_livros = mysql_query($sql_livros);
    }

    if(mysql_num_rows($seleciona_livros) == 0) {
        echo "<div id='prodgrid'><h1>Desculpe, sua busca não retornou resultados.</h1></div>";
    } else {
        echo "<div id='prodgrid'>";
        while ($dados = mysql_fetch_object($seleciona_livros)) {
            echo "<form method='post' action=''>";
            echo "<div id='divresult'>";
            echo "<div id='imgprods'><img src='imgbanco/{$dados->fotocapa1}' height='250'/></div>";
            echo "<div id='divprods'>";
            echo "<input type='hidden' name='codigo' value='{$dados->codigo}'>";
            echo "<h3>{$dados->titulo}</h3>";
            echo "<p>R${$dados->preco}</p>";
            echo "<button type='submit' class='buy'>Comprar</button>";
            echo "</div></div></form>";
        }
        echo "</div>";
    }
    ?>
</div>

</body>
</html>
