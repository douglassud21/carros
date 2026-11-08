<?php
require_once 'funcoes.php';
require_once 'connect.php';

$texto  = "%" . trim($_GET['txt'] ?? '') . "%";
$limite = 4;

try {
    $stmtTotal = $pdo->prepare("Select COUNT(*) from tb_carros where modelo like :texto");
    $stmtTotal->execute([':texto' => $texto]);
    $totalPaginas = max(1, (int)ceil($stmtTotal->fetchColumn() / $limite));

    $pagina = min($totalPaginas, max(1, (int)($_GET['pagina'] ?? 1)));
    $offset = ($pagina - 1) * $limite;

    $stmt = $pdo->prepare("Select * from tb_carros WHERE modelo like :texto ORDER BY codigo DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':texto', $texto);
    $stmt->bindValue(':limit', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $logado = estaLogado();
    $achou = false;
    echo "<div class='cards'>";
    while ($linha = $stmt->fetch()) {
        $achou = true;
        echo cardCarro($linha, $logado);
    }
    if (!$achou) echo "<p class='vazio'>Nenhum veículo encontrado.</p>";
    echo "</div>";
    echo paginacao($pagina, $totalPaginas);
} catch (PDOException $ex) {
    echo "<p class='vazio'>Erro ao consultar o banco: " . e($ex->getMessage()) . "</p>";
}
