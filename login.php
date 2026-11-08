<?php $titulo = "Entrar"; include('head.php'); ?>
<body>
<?php include('menu.php'); ?>
<main>
    <form action="login.act.php" method="post" class="formAdd">
        <h1>Entrar</h1>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="senha1">Senha</label>
        <input type="password" name="senha1" id="senha1" required>
        <input type="submit" value="Entrar">
    </form>
</main>
<?php include('rodape.php'); ?>
