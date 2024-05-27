
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Portal do Colaborador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/style.css">
    
  </head>
<body>

    <header>
        <div class="logo">
            <img class="m-2" src="../img/logoMarca.png" alt="">
            <div class="">
                <a href="../../index.html"><button type="button" class="btn btn-outline-light">Return</button></a>
            </div>
        </div>

        <nav class="">
            <div class="btn-group">
                <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">Sistemas</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./mv-sistemas.html">Soul MV</a></li>
                    <li><a class="dropdown-item" href="#">Saw</a></li>
                </ul>
            </div>

            <div class="btn-group">
                <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">Escalas</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Suporte de tecnologia</a></li>
                    <li><a class="dropdown-item" href="#">Saw</a></li>
                </ul>
            </div>

            <div class="btn-group">
                <a href="#" class="btn btn-outline-light m-4">Ramais</a>
            </div>

            <div class="btn-group">
                <a href="#" class="btn btn-outline-light m-4">E-mail</a>
            </div>
        </nav>

        <div class="btn-contact">
            <a href="https://api.whatsapp.com/send/?phone=5599991685060&text&type=phone_number&app_absent=0" target="_blank"><button type="button">Contato</button></a>
        </div>
    </header>

    <main class="list">
        <div class="list-title">
            <h1>Lista de ramais</h1>
        </div>
    
        <form class="frame" method="GET">
            <input id="name" type="text" name="pesquisa" placeholder="Setor ou ramal"/>
            <button class="custom-btn btn-search" type="submit" value="submit"><span>Pesquisar</span></button>
        </form>


        <div class="table-title">
            <table>
                <tr>
                    <th id="setor">Setor</th>
                    <th id="ramal">Ramal</th>
                </tr>
            </table>
        </div>

        <table>      
            <tbody>
                <?php
                    require_once '../php/conn.php';
            
                    $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
                    $resultsPerPage = 12; // Número de resultados por página
                    $startFrom = ($page - 1) * $resultsPerPage; // Primeiro resultado a ser exibido
            
                    $sqlCount = "SELECT COUNT(*) as total FROM ramais";
                    $sql = "SELECT ds_setor, cd_ramal FROM ramais";
            
                    if (!empty($pesquisa)) {
                        $sqlCount .= " WHERE ds_setor LIKE '%$pesquisa%' OR cd_ramal LIKE '%$pesquisa%'";
                        $sql .= " WHERE ds_setor LIKE '%$pesquisa%' OR cd_ramal LIKE '%$pesquisa%'";
                    }
            
                    $totalCount = $conexao->query($sqlCount)->fetch(PDO::FETCH_ASSOC)['total'];
            
                    $sql .= " LIMIT $startFrom, $resultsPerPage";
                    $result = $conexao->query($sql);
            
                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td id="ds-setor">' . $row['ds_setor'] . '</td>';
                            echo '<td id="cd-ramal">' . $row['cd_ramal'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="">Nenhum resultado encontrado.</td></tr>';
                    }
            
                    $conexao = null;
                ?>
            </tbody>
        </table>
    </main>

    <footer class="pagination" >
        <?php
        // Links de paginação
        $totalPages = ceil($totalCount / $resultsPerPage);
        if ($totalPages > 1) {
            echo '<div class="btn" id="pg" role="" aria-label="Páginas">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '&pesquisa=' . urlencode($pesquisa) . '" class="">' . $i . '</a>';
            }
            echo '</div>';
        }
        ?>
    </footer>
</body>
</html>