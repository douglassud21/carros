<?php
require_once 'sec.php';
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:addCarro.php");
    exit;
}

[$d, $erros] = validarCarro($_POST);

// a foto é obrigatória ao cadastrar
[$foto, $erroFoto] = salvarImagem($_FILES['foto'] ?? null, 'imgsCarros');
if ($erroFoto) {
    $erros[] = $erroFoto;
} elseif ($foto === null) {
    $erros[] = "Envie uma foto do veículo.";
}

if (!empty($erros)) {
    apagarImagem($foto, 'imgsCarros');   // não deixa arquivo órfão
    guardarOld($_POST);
    setMensagem('erro', $erros);
    header("location:addCarro.php");
    exit;
}

try {
    $stmt = $pdo->prepare("Insert into tb_carros
        (modelo, montadora, ano_fabricacao, ano_modelo, motorizacao, foto, cor)
        VALUES (:modelo, :montadora, :anoFabricacao, :anoModelo, :motorizacao, :foto, :cor)");
    $stmt->execute([
        ':modelo'        => $d['modelo'],
        ':montadora'     => $d['montadora'],
        ':anoFabricacao' => $d['anoFabricacao'],
        ':anoModelo'     => $d['anoModelo'],
        ':motorizacao'   => $d['motorizacao'],
        ':foto'          => $foto,
        ':cor'           => $d['cor'],
    ]);
    setMensagem('sucesso', 'Veículo cadastrado com sucesso!');
    header("location:listarCarros.php");
} catch (PDOException $ex) {
    apagarImagem($foto, 'imgsCarros');
    guardarOld($_POST);
    setMensagem('erro', 'Erro ao gravar: ' . $ex->getMessage());
    header("location:addCarro.php");
}
exit;
