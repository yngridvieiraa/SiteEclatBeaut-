<?php
$tituloPagina = 'Contato & Perguntas Frequentes';
require_once __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="container">
        <div class="secao-header">
            <span class="subtitulo-topo">Concierge Éclat Beauté</span>
            <h1 class="secao-titulo">Fale Conosco & FAQ</h1>
            <p>Dúvidas sobre ativos cosméticos, pedidos ou parcerias? Nossa equipe responde rapidamente.</p>
        </div>

        <div class="layout-duas-colunas">
            <!-- Formulário de Contato Processado em PHP -->
            <div class="painel-box">
                <h2 style="font-size: 1.7rem; margin-bottom: 1rem;">Envie sua Mensagem</h2>
                <form action="processa_contato.php" method="POST">
                    <input type="hidden" name="tipo_formulario" value="contato">

                    <div class="campo-grupo" style="margin-bottom: 1rem;">
                        <label for="nome-contato">Seu Nome *</label>
                        <input type="text" id="nome-contato" name="nome" class="input-padrao validar-campo" required placeholder="Digite seu nome">
                        <span class="erro-msg"></span>
                    </div>

                    <div class="campo-grupo" style="margin-bottom: 1rem;">
                        <label for="email-contato">Seu E-mail *</label>
                        <input type="email" id="email-contato" name="email" class="input-padrao validar-campo" required placeholder="seu@email.com">
                        <span class="erro-msg"></span>
                    </div>

                    <div class="campo-grupo" style="margin-bottom: 1rem;">
                        <label for="assunto-contato">Assunto *</label>
                        <select id="assunto-contato" name="assunto" class="select-padrao" required>
                            <option value="Dúvida sobre Produto">Dúvida sobre Produto / Skincare</option>
                            <option value="Status de Pedido">Acompanhamento de Pedido</option>
                            <option value="Trocas e Devoluções">Trocas e Devoluções</option>
                            <option value="Elogios ou Sugestões">Elogios ou Sugestões</option>
                        </select>
                    </div>

                    <div class="campo-grupo" style="margin-bottom: 1.2rem;">
                        <label for="mensagem-contato">Mensagem *</label>
                        <textarea id="mensagem-contato" name="mensagem" rows="4" class="input-padrao validar-campo" required placeholder="Como podemos ajudar você hoje?"></textarea>
                        <span class="erro-msg"></span>
                    </div>

                    <button type="submit" class="btn btn-primario btn-bloco">Enviar Mensagem</button>
                </form>
            </div>

            <!-- Perguntas Frequentes (FAQ em Acordeão) -->
            <div class="painel-box" id="faq">
                <h2 style="font-size: 1.7rem; margin-bottom: 1rem;">Perguntas Frequentes (FAQ)</h2>

                <div class="faq-item aberto">
                    <button type="button" class="faq-pergunta">
                        <span>Os produtos da Éclat Beauté são veganos e cruelty-free?</span>
                        <span>+</span>
                    </button>
                    <div class="faq-resposta">
                        <p>Sim! 100% do nosso portfólio é livre de ingredientes de origem animal e jamais testamos em animais em nenhuma etapa de produção.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-pergunta">
                        <span>Gestantes e peles sensíveis podem usar a linha Skincare?</span>
                        <span>+</span>
                    </button>
                    <div class="faq-resposta">
                        <p>Nossas fórmulas utilizam Bakuchiol (retinol botânico suave) e extratos calmantes. Ainda assim, recomendamos sempre apresentar a composição ao seu dermatologista.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-pergunta">
                        <span>Qual é o prazo de envio e como funciona o frete grátis?</span>
                        <span>+</span>
                    </button>
                    <div class="faq-resposta">
                        <p>Os pedidos são despachados em até 24h úteis. Compras acima de R$ 249,00 ganham Frete Grátis automático para todo o Brasil.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-pergunta">
                        <span>Como utilizar o cupom de primeira compra?</span>
                        <span>+</span>
                    </button>
                    <div class="faq-resposta">
                        <p>Na página da Sacola, digite o código <strong>BEMVINDA10</strong> no campo de cupom e clique em Aplicar para receber 10% de desconto imediato.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>