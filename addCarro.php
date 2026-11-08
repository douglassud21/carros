<?php require('sec.php'); ?>
<?php $titulo = "Adicionar veículo"; include('head.php'); $old = pegarOld(); ?>
<body>
<?php include('menu.php'); ?>
<main>
    <form action="addCarro.act.php" method="post" class="formAdd" enctype="multipart/form-data">
        <h1>Adicionar Veículo</h1>
        <label for="modelo">Modelo</label>
        <input type="text" name="modelo" id="modelo" maxlength="20" value="<?php echo v('modelo', $old); ?>" required>
        <label for="montadora">Montadora</label>
        <input type="text" name="montadora" id="montadora" maxlength="20" value="<?php echo v('montadora', $old); ?>" required>
        <label for="anoFabricacao">Ano de Fabricação</label>
        <input type="number" name="anoFabricacao" id="anoFabricacao" value="<?php echo v('anoFabricacao', $old); ?>" required>
        <label for="anoModelo">Ano do Modelo</label>
        <input type="number" name="anoModelo" id="anoModelo" value="<?php echo v('anoModelo', $old); ?>" required>
        <label for="cor">Cor</label>
        <input type="text" name="cor" id="cor" maxlength="30" value="<?php echo v('cor', $old); ?>" required>
        <label for="motorizacao">Motorização</label>
        <input type="text" name="motorizacao" id="motorizacao" maxlength="20" value="<?php echo v('motorizacao', $old); ?>" required>
        <label for="foto">Foto</label>
        <input type="file" name="foto" id="foto" accept="image/*" required>
        <input type="submit" value="Gravar">
    </form>
</main>
<?php include('rodape.php'); ?>
