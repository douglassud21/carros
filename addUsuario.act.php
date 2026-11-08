<?php
require_once 'funcoes.php';
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:addUsuario.php");
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
    $stmt = $pdo->prepare("Select COUNT(*) from tb_usuarios where email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetchColumn() > 0) $erros[] = "Email já utilizado!";
}

if ($senha1 === '') $erros[] = "O campo senha é obrigatório.";
elseif ($senha1 !== $senha2) $erros[] = "As senhas não conferem!";

// foto é opcional; sem foto fica vazio e o sistema mostra a inicial do nome
[$foto, $erroFoto] = salvarImagem($_FILES['foto'] ?? null, 'imgsUsuarios');
if ($erroFoto) $erros[] = $erroFoto;

if (!empty($erros)) {
    apagarImagem($foto, 'imgsUsuarios');
    guardarOld($_POST);
    setMensagem('erro', $erros);
    header("location:addUsuario.php");
    exit;
}

try {
    $stmt = $pdo->prepare("Insert into tb_usuarios (nome, email, senha, foto)
                           VALUES (:nome, :email, :senha, :foto)");
    $stmt->execute([
        ':nome'  => $nome,
        ':email' => $email,
        ':senha' => password_hash($senha1, PASSWORD_DEFAULT),
        ':foto'  => $foto ?? '',
    ]);
    setMensagem('sucesso', 'Usuário cadastrado com sucesso!');
    header(estaLogado() ? "location:listarUsuarios.php" : "location:login.php");
} catch (PDOException $ex) {
    apagarImagem($foto, 'imgsUsuarios');
    guardarOld($_POST);
    setMensagem('erro', 'Erro ao gravar: ' . $ex->getMessage());
    header("location:addUsuario.php");
}
exit;
