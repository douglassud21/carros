<?php require_once __DIR__ . '/funcoes.php'; ?>
<header class="topo">
    <a class="logo" href="listarCarros.php">Carros <span>Lendários</span></a>
    <nav>
        <ul class="menu">
            <li class="dropdown" tabindex="0">
                <span>Adicionar ▾</span>
                <ul class="drop">
                    <li><a href="addCarro.php">+ Veículo</a></li>
                    <li><a href="addUsuario.php">+ Usuário</a></li>
                </ul>
            </li>
            <li class="dropdown" tabindex="0">
                <span>Listar ▾</span>
                <ul class="drop">
                    <li><a href="listarCarros.php">Veículos</a></li>
                    <li><a href="listarUsuarios.php">Usuários</a></li>
                </ul>
            </li>
            <li><a href="pesquisarCarro.php">Pesquisar</a></li>
            <?php if (estaLogado()): ?>
                <li class="usuario">
                    <?php
                        $perfil = !empty($_SESSION['codigo']) ? "alterarUsuario.php?registro=" . (int)$_SESSION['codigo'] : "#";
                    ?>
                    <a href="<?php echo e($perfil); ?>" title="Meu perfil">
                        <?php echo avatar($_SESSION['foto'] ?? '', $_SESSION['nome'] ?? '', 'fotoMenu'); ?>
                        <span>Olá, <?php echo e($_SESSION['nome'] ?? ''); ?></span>
                    </a>
                </li>
                <li><a href="logoff.php">Sair</a></li>
            <?php else: ?>
                <li><a href="login.php">Entrar</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
