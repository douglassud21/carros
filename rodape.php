    <?php mostrarMensagem(); ?>
    <script>
        // clique no aviso para fechar; some sozinho depois de 6 segundos
        $(document).on('click', '.aviso', function () { $(this).fadeOut(300); });
        setTimeout(function () { $('.aviso').fadeOut(600); }, 6000);
    </script>
</body>
</html>
