<?php $titulo = "Pesquisar"; include('head.php'); ?>
<body>
<?php include('menu.php'); ?>
<main>
    <h1 class="titulo">Pesquisar</h1>
    <div class="divPesquisar">
        <label for="txtPesquisar">Digite o modelo do veículo</label>
        <input type="text" name="txtPesquisa" id="txtPesquisar" autocomplete="off">
    </div>
    <div id="retorno"></div>
</main>
<script>
    var paginaAtual = 1, timer;

    function pesquisar(pagina) {
        paginaAtual = pagina;
        $.get("pesquisarCarro.act.php", { txt: $('#txtPesquisar').val(), pagina: pagina }, function (html) {
            $('#retorno').html(html);
        });
    }
    function excluir(codigo) {
        if (!confirm("Confirma excluir o veículo Nº " + codigo + "?")) return;
        $.post("excluirCarro.php", { cod: codigo }, function (r) {
            if (r.ok) { pesquisar(paginaAtual); } else { alert(r.erro || "Erro ao excluir."); }
        }, "json").fail(function () { alert("Erro ao excluir."); });
    }

    // pesquisa enquanto digita (espera 250 ms depois da última tecla)
    $('#txtPesquisar').on('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { pesquisar(1); }, 250);
    });
    // paginação sem recarregar a página
    $('#retorno').on('click', '.paginacao a', function (e) {
        e.preventDefault();
        pesquisar($(this).data('pagina'));
    });

    pesquisar(1);   // já mostra todos ao abrir
</script>
<?php include('rodape.php'); ?>
