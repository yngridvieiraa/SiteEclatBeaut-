/**
 * Gerenciamento de Sacola de Compras e Favoritos via localStorage.
 * Inclui cálculo de cupom de desconto, frete por CEP e atualização de interface.
 */

const CHAVE_CARRINHO = 'eclat_carrinho_v1';
const CHAVE_FAVORITOS = 'eclat_favoritos_v1';
const CHAVE_CUPOM = 'eclat_cupom_v1';

// Tabela de cupons válidos (incluindo o cupom secreto do Easter Egg)
const CUPONS_VALIDOS = {
    'BEMVINDA10': 0.10, // 10% de desconto padrão
    'ECLATVIP30': 0.30  // 30% de desconto do Easter Egg secreto
};

let valorFreteAtual = 0;

/**
 * Retorna os itens salvos no carrinho.
 */
function obterCarrinho() {
    try {
        return JSON.parse(localStorage.getItem(CHAVE_CARRINHO)) || [];
    } catch (e) {
        return [];
    }
}

/**
 * Salva o array do carrinho no localStorage e atualiza o ícone do topo.
 */
function salvarCarrinho(itens) {
    localStorage.setItem(CHAVE_CARRINHO, JSON.stringify(itens));
    atualizarBadgesHeader();
}

/**
 * Adiciona um produto ao carrinho ou incrementa sua quantidade.
 */
function adicionarAoCarrinho(produto, quantidade = 1) {
    const carrinho = obterCarrinho();
    const index = carrinho.findIndex(item => item.id === produto.id);

    if (index > -1) {
        carrinho[index].quantidade += quantidade;
    } else {
        carrinho.push({
            id: produto.id,
            nome: produto.nome,
            categoria: produto.categoria,
            preco: Number(produto.preco),
            cor_fundo: produto.cor_fundo,
            cor_detalhe: produto.cor_detalhe,
            quantidade: quantidade
        });
    }

    salvarCarrinho(carrinho);
    mostrarToast(`✨ "${produto.nome}" adicionado à sua sacola!`);
}

/**
 * Altera a quantidade de um item no carrinho (+1 ou -1).
 */
function alterarQuantidadeCarrinho(idProduto, delta) {
    let carrinho = obterCarrinho();
    const index = carrinho.findIndex(item => item.id === idProduto);

    if (index > -1) {
        carrinho[index].quantidade += delta;
        if (carrinho[index].quantidade <= 0) {
            carrinho.splice(index, 1);
            mostrarToast('Item removido da sacola.');
        }
        salvarCarrinho(carrinho);
        renderizarPaginaCarrinho();
    }
}

/**
 * Remove imediatamente um item do carrinho.
 */
function removerDoCarrinho(idProduto) {
    const carrinho = obterCarrinho().filter(item => item.id !== idProduto);
    salvarCarrinho(carrinho);
    renderizarPaginaCarrinho();
    mostrarToast('Produto removido da sacola.');
}

/**
 * Gerencia a lista de IDs favoritados no localStorage.
 */
function obterFavoritos() {
    try {
        return JSON.parse(localStorage.getItem(CHAVE_FAVORITOS)) || [];
    } catch (e) {
        return [];
    }
}

function alternarFavorito(idProduto, botaoElemento) {
    let favoritos = obterFavoritos();
    const index = favoritos.indexOf(idProduto);

    if (index > -1) {
        favoritos.splice(index, 1);
        if (botaoElemento) botaoElemento.classList.remove('ativo');
        mostrarToast('Removido dos seus favoritos.');
    } else {
        favoritos.push(idProduto);
        if (botaoElemento) botaoElemento.classList.add('ativo');
        mostrarToast('💖 Salvo na sua lista de desejos!');
    }

    localStorage.setItem(CHAVE_FAVORITOS, JSON.stringify(favoritos));
    atualizarBadgesHeader();
}

/**
 * Atualiza os contadores do cabeçalho (sacola e coração) e marca corações ativos.
 */
function atualizarBadgesHeader() {
    const carrinho = obterCarrinho();
    const favoritos = obterFavoritos();

    const totalItens = carrinho.reduce((acc, item) => acc + item.quantidade, 0);
    const badgeCart = document.getElementById('cart-count');
    const badgeFav = document.getElementById('fav-count');

    if (badgeCart) badgeCart.textContent = totalItens;
    if (badgeFav) badgeFav.textContent = favoritos.length;

    // Marca os botões de favorito nos cards da página
    document.querySelectorAll('.card-produto').forEach(card => {
        const id = Number(card.dataset.id);
        const btn = card.querySelector('.btn-favorito');
        if (btn) {
            btn.classList.toggle('ativo', favoritos.includes(id));
        }
    });
}

/**
 * Formata número para padrão R$ brasileiro no JavaScript.
 */
function formatarMoedaJS(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

/**
 * Renderiza a lista de produtos, cupom e totais na página carrinho.php.
 */
function renderizarPaginaCarrinho() {
    const containerLista = document.getElementById('lista-carrinho');
    if (!containerLista) return;

    const carrinho = obterCarrinho();
    const cupomSalvo = localStorage.getItem(CHAVE_CUPOM) || '';

    if (carrinho.length === 0) {
        containerLista.innerHTML = `
            <div style="text-align:center; padding: 2.5rem 1rem;">
                <p style="font-size:1.2rem; margin-bottom:1rem;">Sua sacola Éclat está vazia no momento.</p>
                <a href="produtos.php" class="btn btn-primario">Explorar Catálogo</a>
            </div>
        `;
        atualizarResumoValores(0, 0, 0);
        return;
    }

    let subtotal = 0;
    containerLista.innerHTML = carrinho.map(item => {
        const totalItem = item.preco * item.quantidade;
        subtotal += totalItem;
        return `
            <div class="item-carrinho">
                <div style="width:64px; height:64px; border-radius:10px; background:${item.cor_fundo || '#F6E6E2'}; border:1px solid ${item.cor_detalhe || '#C5A059'}; display:flex; align-items:center; justify-content:center; font-weight:700; color:#2B2625;">
                    ✦
                </div>
                <div>
                    <small style="color:var(--cor-texto-suave);">${item.categoria}</small>
                    <h4 style="font-size:1.1rem;">${item.nome}</h4>
                    <p style="color:var(--cor-primaria); font-weight:600;">${formatarMoedaJS(item.preco)} un.</p>
                </div>
                <div style="text-align:right;">
                    <div class="qtd-controle">
                        <button type="button" onclick="alterarQuantidadeCarrinho(${item.id}, -1)" aria-label="Diminuir quantidade">-</button>
                        <span>${item.quantidade}</span>
                        <button type="button" onclick="alterarQuantidadeCarrinho(${item.id}, 1)" aria-label="Aumentar quantidade">+</button>
                    </div>
                    <div style="margin-top:0.4rem;">
                        <button type="button" onclick="removerDoCarrinho(${item.id})" style="background:none; border:none; color:var(--cor-erro); font-size:0.78rem; cursor:pointer;">Remover</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    const percentualDesconto = CUPONS_VALIDOS[cupomSalvo] || 0;
    const valorDesconto = subtotal * percentualDesconto;
    const freteEfetivo = subtotal >= 249 ? 0 : valorFreteAtual;

    atualizarResumoValores(subtotal, valorDesconto, freteEfetivo);
}

function atualizarResumoValores(subtotal, desconto, frete) {
    const elSub = document.getElementById('resumo-subtotal');
    const elDesc = document.getElementById('resumo-desconto');
    const elFrete = document.getElementById('resumo-frete');
    const elTotal = document.getElementById('resumo-total');

    const totalFinal = Math.max(0, subtotal - desconto + frete);

    if (elSub) elSub.textContent = formatarMoedaJS(subtotal);
    if (elDesc) elDesc.textContent = `- ${formatarMoedaJS(desconto)}`;
    if (elFrete) elFrete.textContent = subtotal >= 249 && subtotal > 0 ? 'Grátis (Acima de R$ 249)' : formatarMoedaJS(frete);
    if (elTotal) elTotal.textContent = formatarMoedaJS(totalFinal);
}

/**
 * Aplica cupom de desconto no carrinho.
 */
function aplicarCupomCarrinho() {
    const input = document.getElementById('input-cupom');
    if (!input) return;
    const codigo = input.value.trim().toUpperCase();

    if (CUPONS_VALIDOS[codigo]) {
        localStorage.setItem(CHAVE_CUPOM, codigo);
        mostrarToast(`🎉 Cupom ${codigo} aplicado (${CUPONS_VALIDOS[codigo] * 100}% OFF)!`);
        renderizarPaginaCarrinho();
    } else {
        localStorage.removeItem(CHAVE_CUPOM);
        mostrarToast('Cupom inválido. Tente BEMVINDA10.', 'erro');
        renderizarPaginaCarrinho();
    }
}

/**
 * Simula o cálculo de frete por CEP na página do carrinho.
 */
function calcularFreteSimulado() {
    const inputCep = document.getElementById('cep-carrinho');
    const infoFrete = document.getElementById('resultado-frete');
    if (!inputCep || !infoFrete) return;

    const cepLimpo = inputCep.value.replace(/\D/g, '');
    if (cepLimpo.length !== 8) {
        infoFrete.textContent = 'Digite um CEP válido com 8 dígitos.';
        infoFrete.style.color = 'var(--cor-erro)';
        return;
    }

    // Simulação baseada no primeiro dígito da região postal
    const regiao = Number(cepLimpo.charAt(0));
    valorFreteAtual = regiao <= 3 ? 14.90 : 24.90;
    const prazo = regiao <= 3 ? '2 a 4 dias úteis' : '4 a 7 dias úteis';

    infoFrete.style.color = 'var(--cor-sucesso)';
    infoFrete.textContent = `Transportadora Éclat Express: ${formatarMoedaJS(valorFreteAtual)} (${prazo})`;
    renderizarPaginaCarrinho();
}

document.addEventListener('DOMContentLoaded', () => {
    atualizarBadgesHeader();
    renderizarPaginaCarrinho();
});