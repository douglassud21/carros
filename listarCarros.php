<?php $titulo = "Veículos"; include('head.php'); ?>
<body>
<?php include('menu.php'); require_once 'connect.php'; ?>
<main>
    <h1 class="titulo">Garagem</h1>
    <?php
        try {
            $limite = 4;
            $total = (int)$pdo->query("Select COUNT(*) from tb_carros")->fetchColumn();
            $totalPaginas = max(1, (int)ceil($total / $limite));

            $pagina = max(1, (int)($_GET['pagina'] ?? 1));
            if ($pagina > $totalPaginas) $pagina = $totalPaginas;   // ex.: excluiu o último da página
            $offset = ($pagina - 1) * $limite;

            $stmt = $pdo->prepare("Select * from tb_carros ORDER BY codigo DESC LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            echo "<div class='cards'>";
            $logado = estaLogado();
            $achou = false;
            while ($linha = $stmt->fetch()) {
                $achou = true;
                echo cardCarro($linha, $logado);
            }
            if (!$achou) echo "<p class='vazio'>Nenhum veículo cadastrado ainda.</p>";
            echo "</div>";
            echo paginacao($pagina, $totalPaginas, 'listarCarros.php?');
        } catch (PDOException $ex) {
            echo "<p class='vazio'>Erro ao consultar o banco: " . e($ex->getMessage()) . "</p>";
        }
    ?>
</main>
<script>
    function excluir(codigo) {
        if (!confirm("Confirma excluir o veículo Nº " + codigo + "?")) return;
        $.post("excluirCarro.php", { cod: codigo }, function (r) {
            if (r.ok) { location.reload(); } else { alert(r.erro || "Erro ao excluir."); }
        }, "json").fail(function () { alert("Erro ao excluir."); });
    }
</script>
<?php include('rodape.php'); ?>
