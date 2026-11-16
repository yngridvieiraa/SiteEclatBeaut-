/**
 * Script Principal de Interface e Interatividade - Éclat Beauté.
 * Inclui Modo Escuro, Modal QuickView, Toasts, IntersectionObserver,
 * Contagem Regressiva, Carrossel, Filtros, Máscaras, ViaCEP e Easter Egg.
 */

// 1. Notificações Toast
function mostrarToast(mensagem) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = mensagem;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3200);
}

// 2. Modo Claro / Escuro com Persistência no localStorage
function inicializarTema() {
    const temaSalvo = localStorage.getItem('eclat_tema') || 'light';
    document.documentElement.setAttribute('data-theme', temaSalvo);
    atualizarIconeTema(temaSalvo);

    const btnTema = document.getElementById('theme-toggle');
    if (btnTema) {
        btnTema.addEventListener('click', () => {
            const atual = document.documentElement.getAttribute('data-theme');
            const novoTema = atual === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', novoTema);
            localStorage.setItem('eclat_tema', novoTema);
            atualizarIconeTema(novoTema);
            mostrarToast(novoTema === 'dark' ? '🌙 Modo Noturno ativado' : '☀️ Modo Claro ativado');
        });
    }
}

function atualizarIconeTema(tema) {
    const icone = document.getElementById('theme-icon');
    if (icone) icone.textContent = tema === 'dark' ? '☀️' : '🌙';
}

// 3. Menu Hambúrguer Responsivo e Botão Voltar ao Topo
function inicializarNavegacao() {
    const btnMenu = document.getElementById('menu-toggle');
    const nav = document.getElementById('nav-principal');

    if (btnMenu && nav) {
        btnMenu.addEventListener('click', () => {
            const aberto = nav.classList.toggle('aberto');
            btnMenu.setAttribute('aria-expanded', aberto);
        });
    }

    const btnTopo = document.getElementById('btn-topo');
    if (btnTopo) {
        window.addEventListener('scroll', () => {
            btnTopo.classList.toggle('visivel', window.scrollY > 320);
        });
        btnTopo.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
}

// 4. Modal de Visualização Rápida (Quick View)
function abrirModalProduto(produto) {
    const modal = document.getElementById('modal-produto');
    const corpo = document.getElementById('modal-corpo');
    if (!modal || !corpo) return;

    const cardOriginal = document.querySelector(`.card-produto[data-id="${produto.id}"] .ilustracao-wrapper`);
    const svgHtml = cardOriginal ? cardOriginal.innerHTML : '';

    corpo.innerHTML = `
        <div style="border-radius:12px; overflow:hidden;">
            ${svgHtml}
        </div>
        <div>
            <span class="subtitulo-topo">${produto.categoria} • ★ ${produto.avaliacao}</span>
            <h2 id="modal-titulo" style="font-size:2rem; margin-bottom:0.6rem;">${produto.nome}</h2>
            <p style="color:var(--cor-primaria); font-size:1.5rem; font-weight:700; margin-bottom:0.8rem;">
                ${formatarMoedaJS(Number(produto.preco))}
            </p>
            <p style="color:var(--cor-texto-suave); margin-bottom:1.4rem;">${produto.descricao}</p>
            <button type="button" class="btn btn-primario btn-bloco" onclick='adicionarAoCarrinho(${JSON.stringify(produto)}); fecharModalProduto();'>
                Adicionar à Sacola
            </button>
        </div>
    `;

    modal.classList.add('aberto');
    modal.setAttribute('aria-hidden', 'false');
}

function fecharModalProduto() {
    const modal = document.getElementById('modal-produto');
    if (modal) {
        modal.classList.remove('aberto');
        modal.setAttribute('aria-hidden', 'true');
    }
}

// 5. Animações ao Rolar a Página (IntersectionObserver) e Remoção do Skeleton
function inicializarAnimacoesScroll() {
    const elementos = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visivel');
                setTimeout(() => entry.target.classList.remove('skeleton-loading'), 500);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    elementos.forEach(el => observer.observe(el));
}

// 6. Contagem Regressiva da Promoção na Home
function inicializarCountdown() {
    const elHoras = document.getElementById('cd-horas');
    const elMin = document.getElementById('cd-min');
    const elSeg = document.getElementById('cd-seg');
    if (!elHoras || !elMin || !elSeg) return;

    let segundosRestantes = (5 * 3600) + (42 * 60) + 19; // 05h 42m 19s

    setInterval(() => {
        if (segundosRestantes > 0) segundosRestantes--;
        const h = Math.floor(segundosRestantes / 3600);
        const m = Math.floor((segundosRestantes % 3600) / 60);
        const s = segundosRestantes % 60;

        elHoras.textContent = String(h).padStart(2, '0');
        elMin.textContent = String(m).padStart(2, '0');
        elSeg.textContent = String(s).padStart(2, '0');
    }, 1000);
}

// 7. Carrossel de Depoimentos com Autoplay e Botões
function inicializarCarrossel() {
    const slides = document.querySelectorAll('.depoimento-slide');
    const btnPrev = document.getElementById('carrossel-prev');
    const btnNext = document.getElementById('carrossel-next');
    if (slides.length === 0) return;

    let indiceAtual = 0;

    function mostrarSlide(index) {
        slides.forEach((s, i) => s.classList.toggle('ativo', i === index));
    }

    function proximoSlide() {
        indiceAtual = (indiceAtual + 1) % slides.length;
        mostrarSlide(indiceAtual);
    }

    function slideAnterior() {
        indiceAtual = (indiceAtual - 1 + slides.length) % slides.length;
        mostrarSlide(indiceAtual);
    }

    if (btnNext) btnNext.addEventListener('click', proximoSlide);
    if (btnPrev) btnPrev.addEventListener('click', slideAnterior);

    setInterval(proximoSlide, 5500);
}

// 8. Filtros Dinâmicos do Catálogo (produtos.php)
function inicializarFiltrosCatalogo() {
    const inputBusca = document.getElementById('filtro-busca');
    const selectCategoria = document.getElementById('filtro-categoria');
    const rangePreco = document.getElementById('filtro-preco');
    const labelPreco = document.getElementById('valor-preco-label');
    const selectOrdem = document.getElementById('filtro-ordem');
    const checkFavoritos = document.getElementById('filtro-favoritos');
    const grid = document.getElementById('grid-catalogo');
    const contador = document.getElementById('contador-resultados');

    if (!grid || !inputBusca) return;

    function aplicarFiltros() {
        const termo = inputBusca.value.trim().toLowerCase();
        const cat = selectCategoria.value;
        const precoMax = Number(rangePreco.value);
        const ordem = selectOrdem.value;
        const apenasFav = checkFavoritos && checkFavoritos.checked;
        const listaFav = obterFavoritos();

        if (labelPreco) labelPreco.textContent = formatarMoedaJS(precoMax);

        const cards = Array.from(grid.querySelectorAll('.card-produto'));
        let visiveis = [];

        cards.forEach(card => {
            const nome = card.dataset.nome || '';
            const categoriaCard = card.dataset.categoria || '';
            const precoCard = Number(card.dataset.preco);
            const idCard = Number(card.dataset.id);

            const bateNome = nome.includes(termo);
            const bateCat = (cat === 'todas') || (categoriaCard === cat);
            const batePreco = precoCard <= precoMax;
            const bateFav = !apenasFav || listaFav.includes(idCard);

            if (bateNome && bateCat && batePreco && bateFav) {
                card.style.display = 'flex';
                visiveis.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        // Ordenação dos cards visíveis
        visiveis.sort((a, b) => {
            const pA = Number(a.dataset.preco);
            const pB = Number(b.dataset.preco);
            const nA = a.dataset.nome;
            const nB = b.dataset.nome;

            if (ordem === 'menor-preco') return pA - pB;
            if (ordem === 'maior-preco') return pB - pA;
            if (ordem === 'az') return nA.localeCompare(nB);
            return 0;
        });

        visiveis.forEach(card => grid.appendChild(card));
        if (contador) contador.textContent = `${visiveis.length} produto(s) encontrado(s)`;
    }

    [inputBusca, selectCategoria, rangePreco, selectOrdem].forEach(el => {
        if (el) el.addEventListener('input', aplicarFiltros);
    });
    if (checkFavoritos) checkFavoritos.addEventListener('change', aplicarFiltros);

    aplicarFiltros();
}

// 9. Máscaras de Input, API ViaCEP e Validação em Tempo Real
function inicializarFormularios() {
    // Máscaras automáticas
    document.querySelectorAll('[data-mascara]').forEach(input => {
        input.addEventListener('input', (e) => {
            const tipo = e.target.dataset.mascara;
            let v = e.target.value.replace(/\D/g, '');

            if (tipo === 'cpf') {
                v = v.slice(0, 11).replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            } else if (tipo === 'telefone') {
                v = v.slice(0, 11).replace(/^(\d{2})(\d)/g, '($1) $2').replace(/(\d)(\d{4})$/, '$1-$2');
            } else if (tipo === 'cep') {
                v = v.slice(0, 8).replace(/^(\d{5})(\d)/, '$1-$2');
            } else if (tipo === 'cartao') {
                v = v.slice(0, 16).replace(/(\d{4})(?=\d)/g, '$1 ');
            }
            e.target.value = v;
        });
    });

    // Validação em tempo real ao sair do campo (blur)
    document.querySelectorAll('.validar-campo').forEach(campo => {
        campo.addEventListener('blur', () => validarCampoIndividual(campo));
    });

    // Busca de endereço automática com a API ViaCEP no Checkout
    const inputCepCheckout = document.getElementById('cep');
    if (inputCepCheckout) {
        inputCepCheckout.addEventListener('blur', async () => {
            const cep = inputCepCheckout.value.replace(/\D/g, '');
            if (cep.length !== 8) return;

            try {
                mostrarToast('Buscando endereço pelo CEP...');
                const resp = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const dados = await resp.json();
                if (!dados.erro) {
                    document.getElementById('logradouro').value = dados.logradouro || '';
                    document.getElementById('bairro').value = dados.bairro || '';
                    document.getElementById('cidade').value = `${dados.localidade} - ${dados.uf}`;
                    mostrarToast('📍 Endereço preenchido automaticamente!');
                } else {
                    mostrarToast('CEP não encontrado no ViaCEP.');
                }
            } catch (err) {
                mostrarToast('Preencha o endereço manualmente (modo offline).');
            }
        });
    }
}

function validarCampoIndividual(campo) {
    const spanErro = campo.parentElement.querySelector('.erro-msg');
    let mensagem = '';

    if (campo.hasAttribute('required') && !campo.value.trim()) {
        mensagem = 'Este campo é obrigatório.';
    } else if (campo.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campo.value)) {
        mensagem = 'Informe um e-mail válido.';
    } else if (campo.dataset.mascara === 'cpf' && campo.value.replace(/\D/g, '').length !== 11) {
        mensagem = 'O CPF deve conter 11 dígitos.';
    }

    campo.classList.toggle('invalido', mensagem !== '');
    if (spanErro) spanErro.textContent = mensagem;
    return mensagem === '';
}

// 10. Alternância de Campos de Pagamento no Checkout (Pix, Cartão, Boleto)
function selecionarMetodoPagamento(metodo) {
    const inputHidden = document.getElementById('metodo_pagamento');
    if (inputHidden) inputHidden.value = metodo;

    document.querySelectorAll('.aba-pagamento').forEach(aba => {
        aba.classList.toggle('ativa', aba.dataset.metodo === metodo);
    });

    document.getElementById('bloco-pix').style.display = metodo === 'Pix' ? 'block' : 'none';
    document.getElementById('bloco-cartao').style.display = metodo === 'Cartão de Crédito' ? 'block' : 'none';
    document.getElementById('bloco-boleto').style.display = metodo === 'Boleto Bancário' ? 'block' : 'none';
}

// 11. Acordeão do FAQ (contato.php)
function inicializarFaq() {
    document.querySelectorAll('.faq-pergunta').forEach(botao => {
        botao.addEventListener('click', () => {
            const item = botao.parentElement;
            item.classList.toggle('aberto');
        });
    });
}

// 12. Easter Egg Divertido: 5 cliques na estrela da logo liberam cupom VIP de 30% OFF
function inicializarEasterEgg() {
    const estrela = document.getElementById('easter-egg-trigger');
    if (!estrela) return;

    let cliques = 0;
    estrela.addEventListener('click', () => {
        cliques++;
        if (cliques === 5) {
            localStorage.setItem('eclat_cupom_v1', 'ECLATVIP30');
            mostrarToast('💎 EASTER EGG DESBLOQUEADO! Cupom secreto ECLATVIP30 (30% OFF) ativado na sua sacola!');
            cliques = 0;
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    inicializarTema();
    inicializarNavegacao();
    inicializarAnimacoesScroll();
    inicializarCountdown();
    inicializarCarrossel();
    inicializarFiltrosCatalogo();
    inicializarFormularios();
    inicializarFaq();
    inicializarEasterEgg();
});