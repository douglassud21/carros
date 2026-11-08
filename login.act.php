<?php
require_once 'funcoes.php';
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha1'] ?? '';

$stmt = $pdo->prepare("Select * from tb_usuarios where email = :email");
$stmt->execute([':email' => $email]);
$usuario = $stmt->fetch();

if ($usuario && password_verify($senha, $usuario['senha'])) {
    session_regenerate_id(true);
    $_SESSION['login']  = true;
    $_SESSION['codigo'] = $usuario['codigo'];
    $_SESSION['nome']   = $usuario['nome'];
    $_SESSION['email']  = $usuario['email'];
    $_SESSION['foto']   = $usuario['foto'];
    header("location:listarCarros.php");
} else {
    setMensagem('erro', 'Email ou senha incorretos.');
    header("location:login.php");
}
exit;
