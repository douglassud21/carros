<?php
require_once 'sec.php';
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:listarCarros.php");
    exit;
}

$codigo = inteiro($_POST['codigo'] ?? '');
$stmt = $pdo->prepare("Select * from tb_carros where codigo = :codigo");
$stmt->execute([':codigo' => $codigo ?: 0]);
$carro = $stmt->fetch();
if (!$carro) {
    setMensagem('erro', 'Veículo não encontrado.');
    header("location:listarCarros.php");
    exit;
}

[$d, $erros] = validarCarro($_POST);

// foto nova é opcional; se não enviar, mantém a atual
[$fotoNova, $erroFoto] = salvarImagem($_FILES['foto'] ?? null, 'imgsCarros');
if ($erroFoto) $erros[] = $erroFoto;

if (!empty($erros)) {
    apagarImagem($fotoNova, 'imgsCarros');
    guardarOld($_POST);
    setMensagem('erro', $erros);
    header("location:alterarCarro.php?registro=$codigo");
    exit;
}

$foto = $fotoNova ?? $carro['foto'];

try {
    $stmt = $pdo->prepare("Update tb_carros set
        modelo = :modelo,
        montadora = :montadora,
        ano_fabricacao = :anoFabricacao,
        ano_modelo = :anoModelo,
        cor = :cor,
        motorizacao = :motorizacao,
        foto = :foto
        where codigo = :codigo");
    $stmt->execute([
        ':modelo'        => $d['modelo'],
        ':montadora'     => $d['montadora'],
        ':anoFabricacao' => $d['anoFabricacao'],
        ':anoModelo'     => $d['anoModelo'],
        ':cor'           => $d['cor'],
        ':motorizacao'   => $d['motorizacao'],
        ':foto'          => $foto,
        ':codigo'        => $codigo,
    ]);

    // trocou a foto: apaga a antiga se nenhum outro veículo a usa
    if ($fotoNova !== null && $carro['foto'] !== $fotoNova) {
        $uso = $pdo->prepare("Select COUNT(*) from tb_carros where foto = :foto");
        $uso->execute([':foto' => $carro['foto']]);
        if ($uso->fetchColumn() == 0) apagarImagem($carro['foto'], 'imgsCarros');
    }
    setMensagem('sucesso', 'Alterações gravadas!');
    header("location:listarCarros.php");
} catch (PDOException $ex) {
    apagarImagem($fotoNova, 'imgsCarros');
    guardarOld($_POST);
    setMensagem('erro', 'Erro ao gravar: ' . $ex->getMessage());
    header("location:alterarCarro.php?registro=$codigo");
}
exit;
