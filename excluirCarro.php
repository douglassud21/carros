<?php
require_once 'sec.php';
require_once 'connect.php';
header('Content-Type: application/json; charset=utf-8');

function resposta($ok, $erro = '') {
    echo json_encode(['ok' => $ok, 'erro' => $erro]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    resposta(false, 'Método inválido.');
}

$codigo = inteiro($_POST['cod'] ?? '');
if (!$codigo) resposta(false, 'Código inválido.');

try {
    $stmt = $pdo->prepare("Select foto from tb_carros where codigo = :codigo");
    $stmt->execute([':codigo' => $codigo]);
    $foto = $stmt->fetchColumn();
    if ($foto === false) resposta(false, 'Veículo não encontrado.');

    $pdo->prepare("Delete from tb_carros where codigo = :codigo")->execute([':codigo' => $codigo]);

    // apaga a foto se nenhum outro veículo usa o mesmo arquivo
    $uso = $pdo->prepare("Select COUNT(*) from tb_carros where foto = :foto");
    $uso->execute([':foto' => $foto]);
    if ($uso->fetchColumn() == 0) apagarImagem($foto, 'imgsCarros');

    resposta(true);
} catch (PDOException $ex) {
    resposta(false, 'Erro ao excluir: ' . $ex->getMessage());
}
