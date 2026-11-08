<?php require('sec.php'); ?>
<?php
    require_once 'connect.php';
    $codigo = inteiro($_GET['registro'] ?? '');
    $carro = false;
    if ($codigo) {
        $stmt = $pdo->prepare("Select * from tb_carros where codigo = :codigo");
        $stmt->execute([':codigo' => $codigo]);
        $carro = $stmt->fetch();
    }
    if (!$carro) {
        setMensagem('erro', 'Veículo não encontrado.');
        header("location:listarCarros.php");
        exit;
    }
    $old = pegarOld();
    $titulo = "Alterar veículo";
    include('head.php');
?>
<body>
<?php include('menu.php'); ?>
<main>
    <form action="alterarCarro.act.php" method="post" class="formAdd" enctype="multipart/form-data">
        <input type="hidden" name="codigo" value="<?php echo (int)$carro['codigo']; ?>">
        <h1>Alterar Veículo</h1>
        <label for="modelo">Modelo</label>
        <input type="text" name="modelo" id="modelo" maxlength="20" value="<?php echo v('modelo', $old, $carro['modelo']); ?>" required>
        <label for="montadora">Montadora</label>
        <input type="text" name="montadora" id="montadora" maxlength="20" value="<?php echo v('montadora', $old, $carro['montadora']); ?>" required>
        <label for="anoFabricacao">Ano de Fabricação</label>
        <input type="number" name="anoFabricacao" id="anoFabricacao" value="<?php echo v('anoFabricacao', $old, $carro['ano_fabricacao']); ?>" required>
        <label for="anoModelo">Ano do Modelo</label>
        <input type="number" name="anoModelo" id="anoModelo" value="<?php echo v('anoModelo', $old, $carro['ano_modelo']); ?>" required>
        <label for="cor">Cor</label>
        <input type="text" name="cor" id="cor" maxlength="30" value="<?php echo v('cor', $old, $carro['cor']); ?>" required>
        <label for="motorizacao">Motorização</label>
        <input type="text" name="motorizacao" id="motorizacao" maxlength="20" value="<?php echo v('motorizacao', $old, $carro['motorizacao']); ?>" required>
        <label for="foto">Foto <small>(deixe em branco para manter a atual)</small></label>
        <div class="fotoAtual foto"><img src="<?php echo e($carro['foto']); ?>" alt="Foto atual"></div>
        <input type="file" name="foto" id="foto" accept="image/*">
        <input type="submit" value="Gravar alterações">
        <a class="cancelar" href="listarCarros.php">Cancelar</a>
    </form>
</main>
<?php include('rodape.php'); ?>
