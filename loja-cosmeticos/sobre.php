<?php
$tituloPagina = 'Nossa História & Valores';
require_once __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="container">
        <div class="secao-header reveal">
            <span class="subtitulo-topo">Essência & Propósito</span>
            <h1 class="secao-titulo">A História da Éclat Beauté</h1>
            <p>Nascemos da união entre a biotecnologia dermatológica e a delicadeza da perfumaria botânica francesa.</p>
        </div>

        <!-- História da Marca -->
        <div class="painel-box reveal" style="margin-bottom: 3rem; padding: 2.5rem;">
            <div class="layout-duas-colunas" style="align-items: center;">
                <div>
                    <h2 style="font-size: 2rem; margin-bottom: 1rem;">Beleza Limpa, Sensorial e Consciente</h2>
                    <p style="margin-bottom: 1rem; color: var(--cor-texto-suave);">
                        Fundada em 2022, a <strong>Éclat Beauté</strong> surgiu com uma missão clara: provar que o autocuidado de luxo pode ser 100% vegano, ético e clinicamente eficaz. Cada frasco é desenvolvido em nosso laboratório próprio com ingredientes rastreáveis da biodiversidade brasileira e ativos consagrados da cosmetologia mundial.
                    </p>
                    <p style="color: var(--cor-texto-suave);">
                        Acreditamos que cuidar da pele não deve ser uma rotina cansativa de dez passos, mas sim um momento diário de prazer sensorial, respeito à barreira cutânea e celebração da sua beleza real.
                    </p>
                </div>
                <div style="background: var(--cor-superficie-alt); border: 1px solid var(--cor-dourado); border-radius: var(--raio-borda); padding: 2rem; text-align: center;">
                    <span style="font-size: 3rem;">🌿</span>
                    <h3 style="font-size: 1.6rem; margin: 0.6rem 0;">Compromisso Éclat 2030</h3>
                    <p style="font-size: 0.92rem; color: var(--cor-texto-suave);">Embalagens de vidro reciclável, refis inteligentes e neutralização de 100% do carbono das entregas.</p>
                </div>
            </div>
        </div>

        <!-- Pilares e Valores -->
        <div class="secao-header reveal">
            <span class="subtitulo-topo">Nossos Pilares</span>
            <h2 class="secao-titulo">Valores Inegociáveis</h2>
        </div>

        <div class="produtos-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); margin-bottom: 3.5rem;">
            <div class="painel-box reveal" style="text-align: center;">
                <span style="font-size: 2.2rem;">🔬</span>
                <h3 style="font-size: 1.4rem; margin: 0.5rem 0;">Ciência Limpa</h3>
                <p style="color: var(--cor-texto-suave); font-size: 0.92rem;">Livre de parabenos, petrolatos, sulfatos agressivos e corantes sintéticos desnecessários.</p>
            </div>
            <div class="painel-box reveal" style="text-align: center;">
                <span style="font-size: 2.2rem;">🐰</span>
                <h3 style="font-size: 1.4rem; margin: 0.5rem 0;">Respeito à Vida</h3>
                <p style="color: var(--cor-texto-suave); font-size: 0.92rem;">Certificação Cruelty-Free e matérias-primas integralmente vegetais e éticas.</p>
            </div>
            <div class="painel-box reveal" style="text-align: center;">
                <span style="font-size: 2.2rem;">✨</span>
                <h3 style="font-size: 1.4rem; margin: 0.5rem 0;">Alta Performance</h3>
                <p style="color: var(--cor-texto-suave); font-size: 0.92rem;">Concentrações reais de ácido hialurônico, niacinamida e bakuchiol com eficácia comprovada.</p>
            </div>
        </div>

        <!-- Equipe -->
        <div class="secao-header reveal">
            <span class="subtitulo-topo">Mentes Criativas</span>
            <h2 class="secao-titulo">Nossa Equipe</h2>
        </div>

        <div class="produtos-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
            <div class="painel-box reveal" style="text-align: center;">
                <div style="width: 84px; height: 84px; border-radius: 50%; background: var(--cor-secundaria); border: 2px solid var(--cor-dourado); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">👩‍🔬</div>
                <h3>Dra. Clara Valente</h3>
                <small style="color: var(--cor-dourado); font-weight: 700;">Diretora de Pesquisa & Cosmetologia</small>
                <p style="color: var(--cor-texto-suave); font-size: 0.88rem; margin-top: 0.6rem;">Farmacêutica bioquímica especialista em formulações botânicas e dermoestética.</p>
            </div>

            <div class="painel-box reveal" style="text-align: center;">
                <div style="width: 84px; height: 84px; border-radius: 50%; background: var(--cor-secundaria); border: 2px solid var(--cor-dourado); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">🎨</div>
                <h3>Lucas Montclair</h3>
                <small style="color: var(--cor-dourado); font-weight: 700;">Perfumista & Diretor Criativo</small>
                <p style="color: var(--cor-texto-suave); font-size: 0.88rem; margin-top: 0.6rem;">Responsável pela identidade olfativa e pelo design minimalista das embalagens Éclat.</p>
            </div>

            <div class="painel-box reveal" style="text-align: center;">
                <div style="width: 84px; height: 84px; border-radius: 50%; background: var(--cor-secundaria); border: 2px solid var(--cor-dourado); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">💻</div>
                <h3>Sofia Ribeiro</h3>
                <small style="color: var(--cor-dourado); font-weight: 700;">Head de Experiência Digital</small>
                <p style="color: var(--cor-texto-suave); font-size: 0.88rem; margin-top: 0.6rem;">Lidera a consultoria personalizada e o desenvolvimento do Quiz de Rotina Ideal.</p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>