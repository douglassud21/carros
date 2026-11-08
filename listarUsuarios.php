<?php require('sec.php'); ?>
<?php $titulo = "Usuários"; include('head.php'); ?>
<body>
<?php include('menu.php'); require_once 'connect.php'; ?>
<main>
    <h1 class="titulo">Pilotos</h1>
    <?php
        try {
            $limite = 8;
            $total = (int)$pdo->query("Select COUNT(*) from tb_usuarios")->fetchColumn();
            $totalPaginas = max(1, (int)ceil($total / $limite));
            $pagina = min($totalPaginas, max(1, (int)($_GET['pagina'] ?? 1)));
            $offset = ($pagina - 1) * $limite;

            // a senha (hash) nunca é lida para a listagem
            $stmt = $pdo->prepare("Select codigo, nome, email, foto from tb_usuarios ORDER BY nome LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $linhas = $stmt->fetchAll();

            if (!$linhas) {
                echo "<p class='vazio'>Nenhum usuário cadastrado.</p>";
            } else {
                echo "<div class='tabelaBox'><table class='tabela'>";
                echo "<thead><tr><th>Foto</th><th>Nome</th><th>Email</th><th>Ações</th></tr></thead><tbody>";
                foreach ($linhas as $u) {
                    $eu = isset($_SESSION['codigo']) && $_SESSION['codigo'] == $u['codigo'];
                    echo "<tr>";
                    echo "<td>" . avatar($u['foto'], $u['nome'], 'avatar') . "</td>";
                    echo "<td>" . e($u['nome']) . ($eu ? " <em>(você)</em>" : "") . "</td>";
                    echo "<td>" . e($u['email']) . "</td>";
                    echo "<td class='botoes'>";
                    echo "<a href='alterarUsuario.php?registro=" . (int)$u['codigo'] . "'>Alterar</a>";
                    if (!$eu) {
                        echo "<a href='#' class='perigo' onclick='excluir(" . (int)$u['codigo'] . "); return false;'>Excluir</a>";
                    }
                    echo "</td></tr>";
                }
                echo "</tbody></table></div>";
            }
            echo paginacao($pagina, $totalPaginas, 'listarUsuarios.php?');
        } catch (PDOException $ex) {
            echo "<p class='vazio'>Erro ao consultar o banco: " . e($ex->getMessage()) . "</p>";
        }
    ?>
</main>
<script>
    function excluir(codigo) {
        if (!confirm("Confirma excluir este usuário?")) return;
        $.post("excluirUsuario.php", { cod: codigo }, function (r) {
            if (r.ok) { location.reload(); } else { alert(r.erro || "Erro ao excluir."); }
        }, "json").fail(function () { alert("Erro ao excluir."); });
    }
</script>
<?php include('rodape.php'); ?>
