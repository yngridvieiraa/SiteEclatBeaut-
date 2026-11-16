<!-- Modal de Visualização Rápida de Produto (Quick View) -->
    <div class="modal-overlay" id="modal-produto" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-titulo">
        <div class="modal-conteudo">
            <button type="button" class="modal-fechar" onclick="fecharModalProduto()" aria-label="Fechar janela">✕</button>
            <div class="modal-grid" id="modal-corpo">
                <!-- Preenchido dinamicamente via JavaScript -->
            </div>
        </div>
    </div>

    <!-- Botão Voltar ao Topo -->
    <button type="button" id="btn-topo" class="btn-topo" aria-label="Voltar ao topo da página" title="Voltar ao topo">
        ↑
    </button>

    <!-- Rodapé Completo -->
    <footer class="footer-principal">
        <div class="container footer-grid">
            <div class="footer-col">
                <a href="index.php" class="logo footer-logo">ÉCLAT <span class="logo-sub">BEAUTÉ</span></a>
                <p class="footer-slogan">“A ciência do cuidado, a arte da sua beleza natural.”</p>
                <p class="footer-texto">Fórmulas botânicas de alta performance, 100% cruelty-free, veganas e dermatologicamente testadas.</p>
                <div class="selos-sustentabilidade">
                    <span class="selo-item">🐰 Cruelty-Free</span>
                    <span class="selo-item">🌿 100% Vegano</span>
                    <span class="selo-item">♻️ Embalagem Eco</span>
                </div>
            </div>

            <div class="footer-col">
                <h4>Departamentos</h4>
                <ul class="footer-links">
                    <li><a href="produtos.php?categoria=Skincare">Skincare Clínico</a></li>
                    <li><a href="produtos.php?categoria=Maquiagem">Maquiagem Velvet</a></li>
                    <li><a href="produtos.php?categoria=Perfumes">Alta Perfumaria</a></li>
                    <li><a href="produtos.php?categoria=Cabelo">Terapia Capilar</a></li>
                    <li><a href="produtos.php?categoria=Corpo">Cuidado Corporal</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Experiência Éclat</h4>
                <ul class="footer-links">
                    <li><a href="quiz.php">Descubra sua Rotina (Quiz)</a></li>
                    <li><a href="sobre.php">Nossa História & Equipe</a></li>
                    <li><a href="contato.php">Central de Atendimento</a></li>
                    <li><a href="contato.php#faq">Perguntas Frequentes (FAQ)</a></li>
                    <li><a href="carrinho.php">Minha Sacola</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Atendimento & Pagamento</h4>
                <p class="footer-texto">Seg a Sex, das 09h às 18h<br>contato@eclatbeaute.com.br<br>(11) 4002-8922</p>
                <div class="meios-pagamento">
                    <span class="tag-pag">PIX (5% OFF)</span>
                    <span class="tag-pag">Cartão em até 6x</span>
                    <span class="tag-pag">Boleto</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container footer-bottom-flex">
                <p>&copy; <?php echo date('Y'); ?> Éclat Beauté Cosméticos Ltda. Projeto Acadêmico Universitário.</p>
                <p class="dica-easter-egg">Dica secreta: clique 5x na estrela ✦ ao lado da logo no topo.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts JS -->
    <script src="js/carrinho.js"></script>
    <script src="js/main.js"></script>
    <?php if (basename($_SERVER['PHP_SELF']) === 'quiz.php'): ?>
        <script src="js/quiz.js"></script>
    <?php endif; ?>
</body>
</html>