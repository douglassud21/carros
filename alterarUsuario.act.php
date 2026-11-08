<?php
require_once 'sec.php';
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:listarUsuarios.php");
    exit;
}

$codigo = inteiro($_POST['codigo'] ?? '');
$stmt = $pdo->prepare("Select * from tb_usuarios where codigo = :codigo");
$stmt->execute([':codigo' => $codigo ?: 0]);
$usuario = $stmt->fetch();
if (!$usuario) {
    setMensagem('erro', 'Usuário não encontrado.');
    header("location:listarUsuarios.php");
    exit;
}

$nome   = trim($_POST['nome'] ?? '');
$email  = trim($_POST['email'] ?? '');
$senha1 = $_POST['senha1'] ?? '';
$senha2 = $_POST['senha2'] ?? '';
$erros  = [];

if ($nome === '') $erros[] = "O campo nome é obrigatório.";
if (mb_strlen($nome) > 255) $erros[] = "O nome aceita no máximo 255 caracteres.";

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Informe um email válido.";
} else {
    // o email não pode ser de OUTRO usuário
    $stmt = $pdo->prepare("Select COUNT(*) from tb_usuarios where email = :email and codigo <> :codigo");
    $stmt->execute([':email' => $email, ':codigo' => $codigo]);
    if ($stmt->fetchColumn() > 0) $erros[] = "Email já utilizado por outro usuário!";
}

// senha em branco = mantém a atual
$trocaSenha = $senha1 !== '' || $senha2 !== '';
if ($trocaSenha && $senha1 !== $senha2) $erros[] = "As senhas não conferem!";

[$fotoNova, $erroFoto] = salvarImagem($_FILES['foto'] ?? null, 'imgsUsuarios');
if ($erroFoto) $erros[] = $erroFoto;

if (!empty($erros)) {
    apagarImagem($fotoNova, 'imgsUsuarios');
    guardarOld($_POST);
    setMensagem('erro', $erros);
    header("location:alterarUsuario.php?registro=$codigo");
    exit;
}

$foto  = $fotoNova ?? $usuario['foto'];
$senha = $trocaSenha ? password_hash($senha1, PASSWORD_DEFAULT) : $usuario['senha'];

try {
    $stmt = $pdo->prepare("Update tb_usuarios set nome = :nome, email = :email, senha = :senha, foto = :foto
                           where codigo = :codigo");
    $stmt->execute([
        ':nome'   => $nome,
        ':email'  => $email,
        ':senha'  => $senha,
        ':foto'   => $foto,
        ':codigo' => $codigo,
    ]);

    // trocou a foto: apaga a antiga
    if ($fotoNova !== null && $usuario['foto'] !== '') {
        $uso = $pdo->prepare("Select COUNT(*) from tb_usuarios where foto = :foto");
        $uso->execute([':foto' => $usuario['foto']]);
        if ($uso->fetchColumn() == 0) apagarImagem($usuario['foto'], 'imgsUsuarios');
    }

    // se alterou o próprio perfil, atualiza o menu
    if (($_SESSION['codigo'] ?? null) == $codigo) {
        $_SESSION['nome']  = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['foto']  = $foto;
    }
    setMensagem('sucesso', 'Alterações gravadas!');
    header("location:listarUsuarios.php");
} catch (PDOException $ex) {
    apagarImagem($fotoNova, 'imgsUsuarios');
    guardarOld($_POST);
    setMensagem('erro', 'Erro ao gravar: ' . $ex->getMessage());
    header("location:alterarUsuario.php?registro=$codigo");
}
exit;
