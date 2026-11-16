/**
 * Lógica do Quiz Interativo "Descubra sua Rotina Ideal" (quiz.php).
 * Faz 5 perguntas e cruza as respostas com os atributos do catálogo de produtos.
 */

const PERGUNTAS_QUIZ = [
    {
        titulo: '1. Como você descreveria o comportamento da sua pele ao longo do dia?',
        campo: 'pele',
        opcoes: [
            { texto: '✨ Equilibrada, nem muito seca nem brilhante (Normal)', valor: 'normal' },
            { texto: '💧 Repuxa com facilidade e pede hidratação intensa (Seca)', valor: 'seca' },
            { texto: '🌿 Brilho na zona T (testa e nariz) e bochechas normais (Mista)', valor: 'mista' },
            { texto: '☀️ Produz brilho excessivo e poros visíveis (Oleosa)', valor: 'oleosa' },
            { texto: '🌸 Fica avermelhada ou irritada com facilidade (Sensível)', valor: 'sensivel' }
        ]
    },
    {
        titulo: '2. Qual é o seu principal objetivo de beleza hoje?',
        campo: 'objetivo',
        opcoes: [
            { texto: '🌟 Conquistar um viço radiante e efeito Glow imediato', valor: 'glow' },
            { texto: '⏳ Prevenir linhas finas e melhorar a firmeza (Anti-idade)', valor: 'anti-idade' },
            { texto: '💦 Hidratação profunda e reparação da barreira cutânea', valor: 'hidratacao' },
            { texto: '🍃 Controlar a oleosidade e suavizar poros', valor: 'controle-oleosidade' }
        ]
    },
    {
        titulo: '3. Qual textura sensorial você mais gosta de aplicar?',
        campo: 'textura',
        opcoes: [
            { texto: '💧 Séruns fluidos e gotas iluminadoras leves', valor: 'serum' },
            { texto: '☁️ Espumas suaves e géis refrescantes oil-free', valor: 'gel' },
            { texto: '🧴 Cremes aveludados e manteigas nutritivas', valor: 'creme' }
        ]
    },
    {
        titulo: '4. Quanto tempo você costuma dedicar ao seu ritual diário?',
        campo: 'tempo',
        opcoes: [
            { texto: '⚡ Prático e expresso (até 3 minutos)', valor: 'rapido' },
            { texto: '🧘‍♀️ Ritual completo de autocuidado (5 a 10 minutos)', valor: 'completo' }
        ]
    },
    {
        titulo: '5. Qual toque final não pode faltar para você se sentir incrível?',
        campo: 'extra',
        opcoes: [
            { texto: '💄 Lábios marcantes ou maquiagem iluminada', valor: 'maquiagem' },
            { texto: '💐 Uma fragrância sofisticada e inesquecível', valor: 'perfumacao' },
            { texto: '💇‍♀️ Fios alinhados, brilhantes e sem frizz', valor: 'cabelo' }
        ]
    }
];

let passoAtualQuiz = 0;
let respostasUsuario = {};

function renderizarPerguntaQuiz() {
    const container = document.getElementById('quiz-conteudo');
    const barra = document.getElementById('quiz-barra');
    if (!container) return;

    const progresso = ((passoAtualQuiz + 1) / PERGUNTAS_QUIZ.length) * 100;
    if (barra) barra.style.width = `${progresso}%`;

    const pergunta = PERGUNTAS_QUIZ[passoAtualQuiz];

    container.innerHTML = `
        <span class="subtitulo-topo">Pergunta ${passoAtualQuiz + 1} de ${PERGUNTAS_QUIZ.length}</span>
        <h2 style="font-size:1.8rem; margin-bottom:1rem;">${pergunta.titulo}</h2>
        <div class="quiz-opcoes">
            ${pergunta.opcoes.map(op => `
                <button type="button" class="quiz-opcao-btn" onclick="responderQuiz('${pergunta.campo}', '${op.valor}')">
                    ${op.texto}
                </button>
            `).join('')}
        </div>
    `;
}

function responderQuiz(campo, valor) {
    respostasUsuario[campo] = valor;
    passoAtualQuiz++;

    if (passoAtualQuiz < PERGUNTAS_QUIZ.length) {
        renderizarPerguntaQuiz();
    } else {
        exibirResultadoQuiz();
    }
}

function exibirResultadoQuiz() {
    const container = document.getElementById('quiz-conteudo');
    const catalogo = window.CATALOGO_PRODUTOS || [];

    // Filtra produtos compatíveis com o tipo de pele, objetivo principal e toque final
    let recomendados = catalogo.filter(p => {
        const batePele = p.pele.includes(respostasUsuario.pele) || p.pele.includes('todas');
        const bateObjetivo = p.objetivo.includes(respostasUsuario.objetivo) || p.objetivo.includes(respostasUsuario.extra);
        return batePele && bateObjetivo;
    });

    if (recomendados.length < 3) {
        recomendados = catalogo.slice(0, 3);
    } else {
        recomendados = recomendados.slice(0, 3);
    }

    container.innerHTML = `
        <div style="text-align:center;">
            <span class="subtitulo-topo">Diagnóstico Concluído ✨</span>
            <h2 style="font-size:2.1rem; margin-bottom:0.5rem;">Sua Rotina Personalizada Éclat</h2>
            <p style="color:var(--cor-texto-suave); margin-bottom:2rem;">
                Selecionamos as fórmulas botânicas ideais para pele <strong>${respostasUsuario.pele.toUpperCase()}</strong> com foco em <strong>${respostasUsuario.objetivo.toUpperCase()}</strong>:
            </p>
        </div>
        <div style="display:grid; gap:1.2rem; margin-bottom:2rem;">
            ${recomendados.map(prod => `
                <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1.2rem; border:1px solid var(--cor-dourado); border-radius:12px; background:var(--cor-fundo); flex-wrap:wrap;">
                    <div>
                        <small style="color:var(--cor-dourado); font-weight:700;">${prod.categoria}</small>
                        <h3 style="font-size:1.3rem;">${prod.nome}</h3>
                        <p style="font-size:0.88rem; color:var(--cor-texto-suave); max-width:420px;">${prod.descricao}</p>
                        <strong style="color:var(--cor-primaria);">${formatarMoedaJS(Number(prod.preco))}</strong>
                    </div>
                    <button type="button" class="btn btn-primario" onclick='adicionarAoCarrinho(${JSON.stringify(prod)})'>
                        Adicionar à Sacola
                    </button>
                </div>
            `).join('')}
        </div>
        <div style="text-align:center;">
            <button type="button" class="btn btn-outline" onclick="reiniciarQuiz()">Refazer Diagnóstico</button>
        </div>
    `;
}

function reiniciarQuiz() {
    passoAtualQuiz = 0;
    respostasUsuario = {};
    renderizarPerguntaQuiz();
}

document.addEventListener('DOMContentLoaded', renderizarPerguntaQuiz);