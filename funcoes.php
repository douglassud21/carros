<?php
// Funções compartilhadas por todo o sistema

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Escapa texto para exibir no HTML (evita XSS) */
function e($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

function estaLogado() {
    return !empty($_SESSION['login']);
}

/** Guarda uma mensagem (string ou lista) para ser exibida na próxima página */
function setMensagem($tipo, $textos) {
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => (array)$textos];
}

/** Mostra e limpa a mensagem guardada */
function mostrarMensagem() {
    if (empty($_SESSION['mensagem'])) return;
    $m = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
    $classe = $m['tipo'] === 'sucesso' ? 'sucesso' : 'erro';
    echo "<div class='aviso $classe'>";
    foreach ($m['texto'] as $t) {
        echo "<p>" . e($t) . "</p>";
    }
    echo "<small>clique para fechar</small></div>";
}

/** Guarda o que foi digitado para repreencher o formulário após um erro */
function guardarOld($dados) {
    unset($dados['senha1'], $dados['senha2']);
    $_SESSION['old'] = $dados;
}
function pegarOld() {
    $o = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
    return $o;
}
/** Valor de um campo: o que foi digitado (old) ou o valor padrão (banco) */
function v($campo, $old, $padrao = '') {
    return e($old[$campo] ?? $padrao);
}

/** Lê um inteiro positivo de GET/POST; retorna false se inválido */
function inteiro($valor) {
    return filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
}

/* ---------------- IMAGENS ---------------- */

/**
 * Valida e salva uma imagem enviada.
 * Retorna [caminho, erro]. Se nenhum arquivo foi enviado: [null, null].
 */
function salvarImagem($arquivo, $pasta) {
    if (!$arquivo || $arquivo['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        return [null, "Erro ao enviar a foto (código {$arquivo['error']})."];
    }
    if ($arquivo['size'] > 5 * 1024 * 1024) {
        return [null, "A foto deve ter no máximo 5 MB."];
    }
    $info = @getimagesize($arquivo['tmp_name']);
    $tipos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];
    if (!$info || !isset($tipos[$info['mime']])) {
        return [null, "A foto precisa ser JPG, PNG, WEBP ou GIF."];
    }
    $caminho = $pasta . "/" . bin2hex(random_bytes(16)) . "." . $tipos[$info['mime']];
    if (!move_uploaded_file($arquivo['tmp_name'], __DIR__ . "/" . $caminho)) {
        return [null, "Não foi possível salvar a foto no servidor."];
    }
    return [$caminho, null];
}

/** Apaga uma imagem do disco (só dentro da pasta informada) */
function apagarImagem($caminho, $pasta) {
    if (!$caminho || strpos($caminho, $pasta . "/") !== 0) return;
    $arquivo = __DIR__ . "/" . $pasta . "/" . basename($caminho);
    if (is_file($arquivo)) @unlink($arquivo);
}

/* ---------------- CARROS ---------------- */

/** Valida os dados do formulário de carro. Retorna [dados, erros] */
function validarCarro($post) {
    $erros = [];
    $anoMax = (int)date('Y') + 2;

    $d = [
        'modelo'      => trim($post['modelo'] ?? ''),
        'montadora'   => trim($post['montadora'] ?? ''),
        'cor'         => trim($post['cor'] ?? ''),
        'motorizacao' => trim($post['motorizacao'] ?? ''),
    ];
    $campos = ['modelo' => ['Modelo', 20], 'montadora' => ['Montadora', 20],
               'cor' => ['Cor', 30], 'motorizacao' => ['Motorização', 20]];
    foreach ($campos as $c => [$nome, $max]) {
        if ($d[$c] === '') {
            $erros[] = "O campo $nome é obrigatório.";
        } elseif (mb_strlen($d[$c]) > $max) {
            $erros[] = "O campo $nome aceita no máximo $max caracteres.";
        }
    }

    $opcoes = ['options' => ['min_range' => 1886, 'max_range' => $anoMax]];
    $d['anoFabricacao'] = filter_var($post['anoFabricacao'] ?? '', FILTER_VALIDATE_INT, $opcoes);
    if ($d['anoFabricacao'] === false) {
        $erros[] = "Ano de fabricação inválido (entre 1886 e $anoMax).";
    }
    $d['anoModelo'] = filter_var($post['anoModelo'] ?? '', FILTER_VALIDATE_INT, $opcoes);
    if ($d['anoModelo'] === false) {
        $erros[] = "Ano do modelo inválido (entre 1886 e $anoMax).";
    }
    return [$d, $erros];
}

/** Desenha o card de um carro. $logado mostra os botões Alterar/Excluir */
function cardCarro($c, $logado) {
    $h  = "<article class='card'>";
    $h .= "<span class='numero'>Nº " . str_pad($c['codigo'], 2, '0', STR_PAD_LEFT) . "</span>";
    $h .= "<header><p class='montadora'>" . e($c['montadora']) . "</p><h2>" . e($c['modelo']) . "</h2></header>";
    $h .= "<div class='foto'><img src='" . e($c['foto']) . "' alt='" . e($c['modelo']) . "' loading='lazy'></div>";
    $h .= "<dl class='ficha'>";
    $h .= "<div><dt>Fabricação</dt><dd>" . e($c['ano_fabricacao']) . "</dd></div>";
    $h .= "<div><dt>Modelo</dt><dd>" . e($c['ano_modelo']) . "</dd></div>";
    $h .= "<div><dt>Motor</dt><dd>" . e($c['motorizacao']) . "</dd></div>";
    $h .= "<div><dt>Cor</dt><dd>" . e($c['cor']) . "</dd></div>";
    $h .= "</dl>";
    if ($logado) {
        $h .= "<div class='botoes'>";
        $h .= "<a href='alterarCarro.php?registro=" . (int)$c['codigo'] . "'>Alterar</a>";
        $h .= "<a href='#' class='perigo' onclick='excluir(" . (int)$c['codigo'] . "); return false;'>Excluir</a>";
        $h .= "</div>";
    }
    return $h . "</article>";
}

/** Paginação. Com $url mostra links normais; sem $url usa data-pagina (para AJAX) */
function paginacao($pagina, $total, $url = '') {
    if ($total <= 1) return '';
    $h = "<nav class='paginacao'>";
    for ($p = 1; $p <= $total; $p++) {
        $href  = $url !== '' ? e($url . "pagina=$p") : "#";
        $ativo = $p == $pagina ? " class='ativo'" : "";
        $h .= "<a href='$href' data-pagina='$p'$ativo>$p</a>";
    }
    return $h . "</nav>";
}

/* ---------------- USUÁRIOS ---------------- */

/** Foto do usuário; sem foto mostra um círculo com a inicial do nome */
function avatar($foto, $nome, $classe = 'avatar') {
    if ($foto !== '' && $foto !== null) {
        return "<img src='" . e($foto) . "' alt='" . e($nome) . "' class='$classe'>";
    }
    $inicial = mb_strtoupper(mb_substr(trim($nome) ?: '?', 0, 1));
    return "<span class='$classe semfoto'>" . e($inicial) . "</span>";
}
