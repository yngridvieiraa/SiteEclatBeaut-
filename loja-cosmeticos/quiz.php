<?php
$tituloPagina = 'Quiz Descubra Sua Rotina Ideal';
require_once __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="container">
        <div class="secao-header">
            <span class="subtitulo-topo">Consultoria Digital Gratuita</span>
            <h1 class="secao-titulo">Descubra Sua Rotina Ideal</h1>
            <p>Responda 5 perguntas rápidas sobre sua pele e objetivos para receber uma recomendação personalizada das nossas especialistas.</p>
        </div>

        <div class="quiz-box">
            <div class="progresso-barra" aria-label="Progresso do Quiz">
                <div class="progresso-preenchimento" id="quiz-barra"></div>
            </div>
            <div id="quiz-conteudo">
                <!-- Perguntas e resultados injetados por js/quiz.js -->
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>