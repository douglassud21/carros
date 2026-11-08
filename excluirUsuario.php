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

// ninguém exclui a própria conta enquanto está logado
if (($_SESSION['codigo'] ?? null) == $codigo) {
    resposta(false, 'Você não pode excluir o usuário com o qual está logado.');
}

try {
    $stmt = $pdo->prepare("Select foto from tb_usuarios where codigo = :codigo");
    $stmt->execute([':codigo' => $codigo]);
    $foto = $stmt->fetchColumn();
    if ($foto === false) resposta(false, 'Usuário não encontrado.');

    $pdo->prepare("Delete from tb_usuarios where codigo = :codigo")->execute([':codigo' => $codigo]);

    if ($foto !== '') {
        $uso = $pdo->prepare("Select COUNT(*) from tb_usuarios where foto = :foto");
        $uso->execute([':foto' => $foto]);
        if ($uso->fetchColumn() == 0) apagarImagem($foto, 'imgsUsuarios');
    }
    resposta(true);
} catch (PDOException $ex) {
    resposta(false, 'Erro ao excluir: ' . $ex->getMessage());
}
