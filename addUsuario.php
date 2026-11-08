<?php $titulo = "Adicionar usuário"; include('head.php'); $old = pegarOld(); ?>
<body>
<?php include('menu.php'); ?>
<main>
    <form action="addUsuario.act.php" method="post" class="formAdd" enctype="multipart/form-data">
        <h1>Adicionar Usuário</h1>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" maxlength="255" value="<?php echo v('nome', $old); ?>" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" maxlength="255" value="<?php echo v('email', $old); ?>" required>
        <label for="senha1">Senha</label>
        <input type="password" name="senha1" id="senha1" required>
        <label for="senha2">Repita a senha</label>
        <input type="password" name="senha2" id="senha2" required>
        <label for="foto">Foto <small>(opcional)</small></label>
        <input type="file" name="foto" id="foto" accept="image/*">
        <input type="submit" value="Registrar">
    </form>
</main>
<?php include('rodape.php'); ?>
