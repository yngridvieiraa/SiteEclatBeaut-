<?php
$tituloPagina = 'Início';
require_once __DIR__ . '/includes/header.php';

// Filtra os 4 produtos mais vendidos (destaque = true)
$maisVendidos = array_filter($produtos, fn($p) => $p['destaque'] === true);
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-conteudo reveal">
                <span class="subtitulo-topo">Nova Coleção Botânica 2026</span>
                <h1>A ciência do cuidado, a arte da sua beleza natural.</h1>
                <p>Fórmulas limpas enriquecidas com ativos clínicos, extratos de rosas orgânicas e micropartículas iluminadoras para revelar o melhor da sua pele.</p>
                <div class="hero-botoes">
                    <a href="produtos.php" class="btn btn-primario">Explorar Coleção</a>
                    <a href="quiz.php" class="btn btn-outline">Descobrir Minha Rotina ✨</a>
                </div>
            </div>
            <div class="hero-arte reveal">
                <div class="hero-card-visual">
                    <?php echo renderizarIlustracaoProduto($produtos[0]); ?>
                    <p style="font-family: var(--fonte-titulo); font-size: 1.25rem; margin-top: 0.8rem;">Sérum Gota de Ouro 24K</p>
                    <small style="color: var(--cor-dourado); font-weight: 600;">Campeão de Vendas Éclat</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Categorias em Destaque -->
    <section class="secao">
        <div class="container">
            <div class="secao-header reveal">
                <span class="subtitulo-topo">Universo Éclat</span>
                <h2 class="secao-titulo">Categorias em Destaque</h2>
            </div>
            <div class="categorias-grid">
                <a href="produtos.php?categoria=Skincare" class="categoria-card reveal">
                    <span class="categoria-icone">💧</span>
                    <h3>Skincare</h3>
                    <small>Séruns & Hidratantes</small>
                </a>
                <a href="produtos.php?categoria=Maquiagem" class="categoria-card reveal">
                    <span class="categoria-icone">💄</span>
                    <h3>Maquiagem</h3>
                    <small>Texturas Aveludadas</small>
                </a>
                <a href="produtos.php?categoria=Perfumes" class="categoria-card reveal">
                    <span class="categoria-icone">✨</span>
                    <h3>Perfumes</h3>
                    <small>Eau de Parfum</small>
                </a>
                <a href="produtos.php?categoria=Cabelo" class="categoria-card reveal">
                    <span class="categoria-icone">🌿</span>
                    <h3>Cabelo</h3>
                    <small>Elixires & Máscaras</small>
                </a>
                <a href="produtos.php?categoria=Corpo" class="categoria-card reveal">
                    <span class="categoria-icone">🌸</span>
                    <h3>Corpo</h3>
                    <small>Toque Acetinado</small>
                </a>
            </div>
        </div>
    </section>

    <!-- Produtos Mais Vendidos -->
    <section class="secao" style="background-color: var(--cor-superficie-alt);">
        <div class="container">
            <div class="secao-header reveal">
                <span class="subtitulo-topo">Escolhidos pelas Clientes</span>
                <h2 class="secao-titulo">Nossos Mais Vendidos</h2>
            </div>
            <div class="produtos-grid">
                <?php foreach ($maisVendidos as $produto): ?>
                    <?php echo renderizarCardProduto($produto); ?>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 2.5rem;">
                <a href="produtos.php" class="btn btn-outline">Ver Catálogo Completo</a>
            </div>
        </div>
    </section>

    <!-- Banner de Promoção com Contagem Regressiva -->
    <section class="secao">
        <div class="container">
            <div class="banner-promo reveal">
                <span class="subtitulo-topo">Oferta Relâmpago Éclat Privilège</span>
                <h2>Semana da Beleza Botânica com até 25% OFF</h2>
                <p>Adicione seus favoritos à sacola e use o cupom <strong>BEMVINDA10</strong> antes que o tempo acabe:</p>
                <div class="countdown-wrapper" id="countdown" aria-label="Tempo restante da promoção">
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-horas">05</span>
                        <span class="countdown-label">Horas</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-min">42</span>
                        <span class="countdown-label">Min</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-seg">19</span>
                        <span class="countdown-label">Seg</span>
                    </div>
                </div>
                <a href="produtos.php" class="btn btn-primario">Aproveitar Ofertas Agora</a>
            </div>
        </div>
    </section>

    <!-- Carrossel de Depoimentos -->
    <section class="secao">
        <div class="container">
            <div class="secao-header reveal">
                <span class="subtitulo-topo">Avaliações Reais</span>
                <h2 class="secao-titulo">O Que Dizem Nossas Clientes</h2>
            </div>
            <div class="carrossel-wrapper reveal">
                <div class="depoimento-slide ativo">
                    <p class="depoimento-texto">“O Sérum Gota de Ouro 24K transformou completamente o viço da minha pele. Uso todos os dias antes do protetor solar e recebo elogios constantes!”</p>
                    <span class="depoimento-autor">— Mariana Vasconcelos, São Paulo (SP) ★★★★★</span>
                </div>
                <div class="depoimento-slide">
                    <p class="depoimento-texto">“O perfume L’Aurore Botanique fixa o dia inteiro na pele e tem cheiro de riqueza! A entrega chegou super perfumada e embalada com todo carinho.”</p>
                    <span class="depoimento-autor">— Camila Fontes, Belo Horizonte (MG) ★★★★★</span>
                </div>
                <div class="depoimento-slide">
                    <p class="depoimento-texto">“Fiz o Quiz da Pele no site e acertei em cheio na Espuma Nuvem de Rosas. Minha pele sensível nunca ficou tão macia e equilibrada.”</p>
                    <span class="depoimento-autor">— Beatriz Alencar, Curitiba (PR) ★★★★★</span>
                </div>
                <div class="carrossel-controles">
                    <button type="button" class="btn-carrossel" id="carrossel-prev" aria-label="Depoimento anterior">←</button>
                    <button type="button" class="btn-carrossel" id="carrossel-next" aria-label="Próximo depoimento">→</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter processada em PHP -->
    <section class="secao" style="background-color: var(--cor-superficie-alt);">
        <div class="container">
            <div class="secao-header reveal" style="margin-bottom: 1.5rem;">
                <span class="subtitulo-topo">Clube Éclat Privilège</span>
                <h2 class="secao-titulo">Receba Dicas de Skincare e Mimos Exclusivos</h2>
                <p>Inscreva-se gratuitamente e ganhe acesso antecipado aos nossos lançamentos.</p>
            </div>
            <form action="processa_contato.php" method="POST" class="reveal" style="max-width: 540px; margin: 0 auto; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <input type="hidden" name="tipo_formulario" value="newsletter">
                <div style="flex: 1; min-width: 240px;">
                    <label for="email-news" class="sr-only" style="display:none;">Seu melhor e-mail</label>
                    <input type="email" id="email-news" name="email" class="input-padrao" placeholder="Digite seu melhor e-mail..." required>
                </div>
                <button type="submit" class="btn btn-primario">Quero Participar</button>
            </form>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>