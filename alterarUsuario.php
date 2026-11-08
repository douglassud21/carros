<?php require('sec.php'); ?>
<?php
    require_once 'connect.php';
    $codigo = inteiro($_GET['registro'] ?? '');
    $usuario = false;
    if ($codigo) {
        $stmt = $pdo->prepare("Select codigo, nome, email, foto from tb_usuarios where codigo = :codigo");
        $stmt->execute([':codigo' => $codigo]);
        $usuario = $stmt->fetch();
    }
    if (!$usuario) {
        setMensagem('erro', 'Usuário não encontrado.');
        header("location:listarUsuarios.php");
        exit;
    }
    $old = pegarOld();
    $titulo = "Alterar usuário";
    include('head.php');
?>
<body>
<?php include('menu.php'); ?>
<main>
    <form action="alterarUsuario.act.php" method="post" class="formAdd" enctype="multipart/form-data">
        <input type="hidden" name="codigo" value="<?php echo (int)$usuario['codigo']; ?>">
        <h1>Alterar Usuário</h1>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" maxlength="255" value="<?php echo v('nome', $old, $usuario['nome']); ?>" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" maxlength="255" value="<?php echo v('email', $old, $usuario['email']); ?>" required>
        <label for="senha1">Nova senha <small>(deixe em branco para manter a atual)</small></label>
        <input type="password" name="senha1" id="senha1" autocomplete="new-password">
        <label for="senha2">Repita a nova senha</label>
        <input type="password" name="senha2" id="senha2" autocomplete="new-password">
        <label for="foto">Foto <small>(deixe em branco para manter a atual)</small></label>
        <div class="fotoAtual"><?php echo avatar($usuario['foto'], $usuario['nome'], 'avatarGrande'); ?></div>
        <input type="file" name="foto" id="foto" accept="image/*">
        <input type="submit" value="Gravar alterações">
        <a class="cancelar" href="listarUsuarios.php">Cancelar</a>
    </form>
</main>
<?php include('rodape.php'); ?>
