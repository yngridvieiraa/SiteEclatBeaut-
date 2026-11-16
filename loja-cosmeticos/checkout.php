<?php
$tituloPagina = 'Finalizar Compra';
require_once __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="container">
        <div class="secao-header">
            <span class="subtitulo-topo">Ambiente 100% Seguro</span>
            <h1 class="secao-titulo">Finalização da Compra</h1>
        </div>

        <form action="processa_pedido.php" method="POST" id="form-checkout" class="layout-duas-colunas" onsubmit="prepararEnvioPedido()">
            <input type="hidden" name="itens_json" id="itens_json" value="[]">
            <input type="hidden" name="metodo_pagamento" id="metodo_pagamento" value="Pix">

            <div class="painel-box">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">1. Dados Pessoais</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                    <div class="campo-grupo">
                        <label for="nome">Nome Completo *</label>
                        <input type="text" id="nome" name="nome" class="input-padrao validar-campo" required placeholder="Ex.: Helena Albuquerque">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" class="input-padrao validar-campo" required placeholder="helena@email.com">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="cpf">CPF *</label>
                        <input type="text" id="cpf" name="cpf" class="input-padrao validar-campo" data-mascara="cpf" required placeholder="000.000.000-00">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="telefone">Telefone / WhatsApp *</label>
                        <input type="text" id="telefone" name="telefone" class="input-padrao validar-campo" data-mascara="telefone" required placeholder="(11) 99999-9999">
                        <span class="erro-msg"></span>
                    </div>
                </div>

                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">2. Endereço de Entrega (Busca ViaCEP)</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                    <div class="campo-grupo">
                        <label for="cep">CEP *</label>
                        <input type="text" id="cep" name="cep" class="input-padrao validar-campo" data-mascara="cep" required placeholder="01310-100">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="logradouro">Rua / Avenida *</label>
                        <input type="text" id="logradouro" name="logradouro" class="input-padrao validar-campo" required placeholder="Av. Paulista">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="numero">Número e Complemento *</label>
                        <input type="text" id="numero" name="numero" class="input-padrao validar-campo" required placeholder="1000, Apto 42">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="bairro">Bairro *</label>
                        <input type="text" id="bairro" name="bairro" class="input-padrao validar-campo" required placeholder="Bela Vista">
                        <span class="erro-msg"></span>
                    </div>
                    <div class="campo-grupo">
                        <label for="cidade">Cidade / UF *</label>
                        <input type="text" id="cidade" name="cidade" class="input-padrao validar-campo" required placeholder="São Paulo - SP">
                        <span class="erro-msg"></span>
                    </div>
                </div>

                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">3. Forma de Pagamento</h3>
                <div class="opcoes-pagamento">
                    <div class="aba-pagamento ativa" data-metodo="Pix" onclick="selecionarMetodoPagamento('Pix')">❖ Pix (Imediato)</div>
                    <div class="aba-pagamento" data-metodo="Cartão de Crédito" onclick="selecionarMetodoPagamento('Cartão de Crédito')">💳 Cartão</div>
                    <div class="aba-pagamento" data-metodo="Boleto Bancário" onclick="selecionarMetodoPagamento('Boleto Bancário')">📄 Boleto</div>
                </div>

                <!-- Campos específicos: PIX -->
                <div id="bloco-pix" style="padding: 1rem; background: var(--cor-fundo); border-radius: 10px; border: 1px dashed var(--cor-dourado);">
                    <p><strong>Pagamento via Pix com aprovação instantânea:</strong> Após confirmar o pedido, o QR Code e o código Pix Copia e Cola serão exibidos na tela seguinte.</p>
                </div>

                <!-- Campos específicos: Cartão -->
                <div id="bloco-cartao" style="display: none; padding: 1rem; background: var(--cor-fundo); border-radius: 10px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="campo-grupo" style="grid-column: 1 / -1;">
                            <label for="num_cartao">Número do Cartão</label>
                            <input type="text" id="num_cartao" name="num_cartao" class="input-padrao" data-mascara="cartao" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="campo-grupo">
                            <label for="validade_cartao">Validade (MM/AA)</label>
                            <input type="text" id="validade_cartao" name="validade_cartao" class="input-padrao" placeholder="08/30" maxlength="5">
                        </div>
                        <div class="campo-grupo">
                            <label for="cvv_cartao">CVV</label>
                            <input type="text" id="cvv_cartao" name="cvv_cartao" class="input-padrao" placeholder="123" maxlength="4">
                        </div>
                    </div>
                </div>

                <!-- Campos específicos: Boleto -->
                <div id="bloco-boleto" style="display: none; padding: 1rem; background: var(--cor-fundo); border-radius: 10px;">
                    <p><strong>Boleto Bancário Registrado:</strong> O código de barras será gerado após a confirmação e tem vencimento em 3 dias úteis.</p>
                </div>
            </div>

            <aside class="painel-box">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Revisão Final</h3>
                <p style="font-size: 0.9rem; color: var(--cor-texto-suave); margin-bottom: 1.2rem;">
                    Ao clicar em confirmar, seu pedido será processado pelo servidor PHP e gravado com protocolo único.
                </p>
                <button type="submit" class="btn btn-primario btn-bloco">
                    Confirmar Pedido Éclat ✓
                </button>
            </aside>
        </form>
    </div>
</main>

<script>
function prepararEnvioPedido() {
    const itens = obterCarrinho();
    document.getElementById('itens_json').value = JSON.stringify(itens);
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>