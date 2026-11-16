<?php
/**
 * Funções utilitárias globais do sistema Éclat Beauté.
 * Gerencia sessão, formatação de moeda, sanitização, persistência JSON e geração de SVGs.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Formata valores numéricos para o padrão monetário brasileiro (R$).
 */
function formatarMoeda(float $valor): string {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

/**
 * Sanitiza strings recebidas em formulários para prevenir ataques XSS.
 */
function limparTexto(?string $texto): string {
    if ($texto === null) {
        return '';
    }
    return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
}

/**
 * Define uma mensagem flash na sessão PHP para exibir alerta na próxima tela.
 */
function definirMensagemFlash(string $tipo, string $texto): void {
    $_SESSION['flash_message'] = [
        'tipo' => $tipo, // 'sucesso' ou 'erro'
        'texto' => $texto
    ];
}

/**
 * Recupera e limpa a mensagem flash armazenada na sessão.
 */
function obterMensagemFlash(): ?array {
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}

/**
 * Salva um novo registro em um arquivo JSON na pasta /data.
 */
function salvarRegistroJson(string $nomeArquivo, array $novoItem): bool {
    $caminho = __DIR__ . '/../data/' . $nomeArquivo;
    $dadosAtuais = [];

    if (file_exists($caminho)) {
        $conteudo = file_get_contents($caminho);
        $decodificado = json_decode($conteudo, true);
        if (is_array($decodificado)) {
            $dadosAtuais = $decodificado;
        }
    }

    $dadosAtuais[] = $novoItem;
    $jsonFormatado = json_encode($dadosAtuais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($caminho, $jsonFormatado) !== false;
}

/**
 * Gera uma ilustração SVG elegante e exclusiva para cada tipo de produto.
 * Garante que o site nunca fique com imagens quebradas mesmo sem internet.
 * DICA PARA O ALUNO: Se quiser usar fotos reais na pasta /img, basta descomentar o bloco <img> abaixo.
 */
function renderizarIlustracaoProduto(array $produto): string {
    // Caso queira usar imagem real da pasta /img quando ela existir:
    /*
    if (!empty($produto['imagem_real']) && file_exists(__DIR__ . '/../' . $produto['imagem_real'])) {
        return '<img src="' . htmlspecialchars($produto['imagem_real']) . '" alt="' . htmlspecialchars($produto['nome']) . '" class="produto-img-real">';
    }
    */

    $bg = $produto['cor_fundo'] ?? '#F6E6E2';
    $cor = $produto['cor_detalhe'] ?? '#C5A059';
    $icone = $produto['icone'] ?? 'serum';
    $categoria = htmlspecialchars($produto['categoria']);

    $desenhoFrasco = '';
    switch ($icone) {
        case 'serum':
        case 'oleo':
            $desenhoFrasco = '
                <rect x="85" y="42" width="30" height="16" rx="4" fill="#2B2625"/>
                <path d="M93 26 C93 18, 107 18, 107 26 L107 42 L93 42 Z" fill="' . $cor . '"/>
                <rect x="80" y="58" width="40" height="8" rx="2" fill="#D4AF37"/>
                <rect x="70" y="66" width="60" height="96" rx="14" fill="#FFFFFF" stroke="' . $cor . '" stroke-width="2.5"/>
                <rect x="78" y="86" width="44" height="52" rx="4" fill="' . $bg . '" stroke="' . $cor . '" stroke-width="1"/>
                <circle cx="100" cy="112" r="9" fill="' . $cor . '" opacity="0.4"/>';
            break;
        case 'batom':
            $desenhoFrasco = '
                <path d="M86 45 L114 30 L114 78 L86 78 Z" fill="' . $cor . '"/>
                <rect x="82" y="78" width="36" height="18" fill="#D4AF37"/>
                <rect x="78" y="96" width="44" height="68" rx="6" fill="#2B2625"/>
                <line x1="78" y1="120" x2="122" y2="120" stroke="#D4AF37" stroke-width="2"/>';
            break;
        case 'perfume':
            $desenhoFrasco = '
                <rect x="88" y="34" width="24" height="18" rx="3" fill="#D4AF37"/>
                <rect x="94" y="52" width="12" height="10" fill="#2B2625"/>
                <rect x="62" y="62" width="76" height="96" rx="18" fill="#FFFFFF" stroke="' . $cor . '" stroke-width="2.5"/>
                <rect x="74" y="82" width="52" height="56" rx="6" fill="' . $bg . '" stroke="#D4AF37" stroke-width="1.5"/>
                <circle cx="100" cy="110" r="12" fill="none" stroke="' . $cor . '" stroke-width="1.5"/>';
            break;
        case 'paleta':
            $desenhoFrasco = '
                <rect x="52" y="54" width="96" height="96" rx="12" fill="#2B2625" stroke="#D4AF37" stroke-width="2.5"/>
                <circle cx="80" cy="82" r="16" fill="#E8C3B0"/>
                <circle cx="120" cy="82" r="16" fill="#D49B8E"/>
                <circle cx="80" cy="122" r="16" fill="#C5A059"/>
                <circle cx="120" cy="122" r="16" fill="#A67556"/>';
            break;
        default: // creme, corpo, espuma
            $desenhoFrasco = '
                <rect x="64" y="68" width="72" height="20" rx="6" fill="#D4AF37"/>
                <rect x="56" y="88" width="88" height="68" rx="16" fill="#FFFFFF" stroke="' . $cor . '" stroke-width="2.5"/>
                <rect x="70" y="104" width="60" height="34" rx="6" fill="' . $bg . '"/>';
            break;
    }

    return '
    <svg viewBox="0 0 200 200" class="produto-svg" role="img" aria-label="Ilustração do produto ' . htmlspecialchars($produto['nome']) . '">
        <defs>
            <radialGradient id="grad-' . $produto['id'] . '" cx="50%" cy="50%" r="60%">
                <stop offset="0%" stop-color="#FFFFFF" stop-opacity="0.9"/>
                <stop offset="100%" stop-color="' . $bg . '" stop-opacity="1"/>
            </radialGradient>
        </defs>
        <rect width="200" height="200" fill="url(#grad-' . $produto['id'] . ')"/>
        <circle cx="100" cy="100" r="72" fill="#FFFFFF" opacity="0.45"/>
        <path d="M155 42 L158 50 L166 53 L158 56 L155 64 L152 56 L144 53 L152 50 Z" fill="#D4AF37" opacity="0.7"/>
        <path d="M45 140 L47 145 L52 147 L47 149 L45 154 L43 149 L38 147 L43 145 Z" fill="' . $cor . '" opacity="0.6"/>
        ' . $desenhoFrasco . '
        <text x="100" y="184" text-anchor="middle" fill="#6E625F" font-family="sans-serif" font-size="9" letter-spacing="2">' . strtoupper($categoria) . '</text>
    </svg>';
}

/**
 * Renderiza o card HTML completo de um produto para reutilização nas páginas.
 */
function renderizarCardProduto(array $produto): string {
    $precoFormatado = formatarMoeda($produto['preco']);
    $jsonProduto = htmlspecialchars(json_encode($produto, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');

    return '
    <article class="card-produto skeleton-loading reveal" 
             data-id="' . $produto['id'] . '"
             data-nome="' . strtolower(limparTexto($produto['nome'])) . '"
             data-categoria="' . limparTexto($produto['categoria']) . '"
             data-preco="' . $produto['preco'] . '">
        <div class="card-Midia">
            <span class="badge-produto">' . limparTexto($produto['tag']) . '</span>
            <button type="button" class="btn-favorito" onclick="alternarFavorito(' . $produto['id'] . ', this)" aria-label="Favoritar ' . limparTexto($produto['nome']) . '" title="Adicionar aos Favoritos">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="1.8" fill="none">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
            </button>
            <div class="ilustracao-wrapper" onclick="abrirModalProduto(' . $jsonProduto . ')">
                ' . renderizarIlustracaoProduto($produto) . '
            </div>
            <button type="button" class="btn-quickview" onclick="abrirModalProduto(' . $jsonProduto . ')">
                Visualização Rápida
            </button>
        </div>
        <div class="card-corpo">
            <div class="card-meta">
                <span class="card-categoria">' . limparTexto($produto['categoria']) . '</span>
                <span class="card-avaliacao" aria-label="Avaliação ' . $produto['avaliacao'] . ' de 5">★ ' . number_format($produto['avaliacao'], 1, ',', '') . '</span>
            </div>
            <h3 class="card-titulo">' . limparTexto($produto['nome']) . '</h3>
            <p class="card-preco">' . $precoFormatado . '</p>
            <span class="card-parcelamento">ou 3x de ' . formatarMoeda($produto['preco'] / 3) . ' sem juros</span>
            <button type="button" class="btn btn-primario btn-bloco" onclick="adicionarAoCarrinho(' . $jsonProduto . ')">
                Adicionar à Sacola
            </button>
        </div>
    </article>';
}