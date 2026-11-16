<?php
$tituloPagina = 'Minha Sacola de Compras';
require_once __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="container">
        <div class="secao-header">
            <span class="subtitulo-topo">Seu Ritual de Beleza</span>
            <h1 class="secao-titulo">Sacola de Compras</h1>
        </div>

        <div class="layout-duas-colunas">
            <!-- Lista de Itens do Carrinho -->
            <div class="painel-box" id="lista-carrinho">
                <!-- Preenchido via js/carrinho.js -->
            </div>

            <!-- Resumo de Valores, Cupom e Frete -->
            <aside class="painel-box">
                <h3 style="font-size: 1.5rem; margin-bottom: 1.2rem;">Resumo do Pedido</h3>

                <!-- Cupom de Desconto -->
                <div class="campo-grupo" style="margin-bottom: 1.2rem;">
                    <label for="input-cupom">Cupom de Desconto (Ex.: BEMVINDA10)</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" id="input-cupom" class="input-padrao" placeholder="Código do cupom">
                        <button type="button" class="btn btn-outline" onclick="aplicarCupomCarrinho()">Aplicar</button>
                    </div>
                </div>

                <!-- Simulador de Frete por CEP -->
                <div class="campo-grupo" style="margin-bottom: 1.5rem;">
                    <label for="cep-carrinho">Simular Frete e Prazo (CEP)</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" id="cep-carrinho" class="input-padrao" data-mascara="cep" placeholder="00000-000">
                        <button type="button" class="btn btn-outline" onclick="calcularFreteSimulado()">Calcular</button>
                    </div>
                    <small id="resultado-frete" style="display:block; margin-top:0.4rem;"></small>
                </div>

                <div class="resumo-linha">
                    <span>Subtotal:</span>
                    <strong id="resumo-subtotal">R$ 0,00</strong>
                </div>
                <div class="resumo-linha" style="color: var(--cor-sucesso);">
                    <span>Desconto:</span>
                    <strong id="resumo-desconto">- R$ 0,00</strong>
                </div>
                <div class="resumo-linha">
                    <span>Frete:</span>
                    <strong id="resumo-frete">R$ 0,00</strong>
                </div>
                <div class="resumo-linha resumo-total">
                    <span>Total:</span>
                    <span id="resumo-total">R$ 0,00</span>
                </div>

                <a href="checkout.php" class="btn btn-primario btn-bloco" style="margin-top: 1.2rem;">
                    Finalizar Compra Segura →
                </a>
                <a href="produtos.php" class="btn btn-outline btn-bloco" style="margin-top: 0.6rem;">
                    Continuar Comprando
                </a>
            </aside>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>