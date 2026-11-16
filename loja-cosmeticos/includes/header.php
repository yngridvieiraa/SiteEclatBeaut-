<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../data/produtos.php';

$paginaAtual = basename($_SERVER['PHP_SELF']);
$flash = obterMensagemFlash();
$nomeClienteSessao = $_SESSION['cliente_nome'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($tituloPagina) ? limparTexto($tituloPagina) . ' | Éclat Beauté' : 'Éclat Beauté | A Ciência do Cuidado, a Arte da Beleza'; ?></title>
    <meta name="description" content="Éclat Beauté - Alta cosmética botânica, maquiagem, skincare e perfumaria fina.">
    <!-- Google Fonts: Cormorant Garamond (Títulos Serifados) & Plus Jakarta Sans (Texto) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Barra de Aviso Superior -->
    <div class="topbar">
        <div class="container topbar-content">
            <span>✨ Frete Grátis acima de R$ 249 | Cupom de 1ª compra: <strong>BEMVINDA10</strong></span>
            <?php if ($nomeClienteSessao): ?>
                <span class="topbar-user">Olá, <?php echo limparTexto($nomeClienteSessao); ?>! 💕</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Cabeçalho Principal Fixo -->
    <header class="header-principal" id="header">
        <div class="container header-grid">
            <!-- Botão Menu Mobile -->
            <button type="button" class="menu-toggle" id="menu-toggle" aria-label="Abrir Menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Logotipo (Clique 5x na estrela para ativar o Easter Egg!) -->
            <div class="logo-wrapper">
                <a href="index.php" class="logo" aria-label="Página Inicial Éclat Beauté">
                    ÉCLAT <span class="logo-sub">BEAUTÉ</span>
                </a>
                <button type="button" id="easter-egg-trigger" class="estrela-secreta" title="Brilho Éclat" aria-label="Detalhe decorativo da marca">✦</button>
            </div>

            <!-- Navegação Principal -->
            <nav class="nav-principal" id="nav-principal" aria-label="Menu Principal">
                <ul class="nav-lista">
                    <li><a href="index.php" class="<?php echo $paginaAtual === 'index.php' ? 'ativo' : ''; ?>">Início</a></li>
                    <li><a href="produtos.php" class="<?php echo $paginaAtual === 'produtos.php' ? 'ativo' : ''; ?>">Catálogo</a></li>
                    <li><a href="quiz.php" class="<?php echo $paginaAtual === 'quiz.php' ? 'ativo' : ''; ?>">Quiz da Pele</a></li>
                    <li><a href="sobre.php" class="<?php echo $paginaAtual === 'sobre.php' ? 'ativo' : ''; ?>">Nossa História</a></li>
                    <li><a href="contato.php" class="<?php echo $paginaAtual === 'contato.php' ? 'ativo' : ''; ?>">Contato & FAQ</a></li>
                </ul>
            </nav>

            <!-- Ações do Header (Tema, Favoritos e Sacola) -->
            <div class="header-acoes">
                <button type="button" class="btn-icone" id="theme-toggle" aria-label="Alternar modo claro ou escuro" title="Alternar Tema">
                    <span class="icone-tema" id="theme-icon">🌙</span>
                </button>

                <a href="produtos.php?favoritos=1" class="btn-icone" aria-label="Ver Favoritos" title="Meus Favoritos">
                    <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="1.8" fill="none">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="contador-badge" id="fav-count">0</span>
                </a>

                <a href="carrinho.php" class="btn-icone sacola-link" aria-label="Ver Sacola de Compras" title="Minha Sacola">
                    <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="1.8" fill="none">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span class="contador-badge" id="cart-count">0</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Exibição de Mensagens Flash vindas do PHP (Sessão) -->
    <?php if ($flash): ?>
        <div class="container">
            <div class="alerta-php alerta-<?php echo limparTexto($flash['tipo']); ?>" role="alert">
                <span><?php echo limparTexto($flash['texto']); ?></span>
                <button type="button" onclick="this.parentElement.remove()" aria-label="Fechar aviso">✕</button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Container de Notificações Toast (JS) -->
    <div id="toast-container" class="toast-container" aria-live="polite"></div>

    <!-- Catálogo injetado globalmente para facilitar QuickView, Quiz e Favoritos -->
    <script>
        window.CATALOGO_PRODUTOS = <?php echo json_encode($produtos, JSON_UNESCAPED_UNICODE); ?>;
    </script>