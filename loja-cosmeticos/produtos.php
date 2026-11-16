<?php
$tituloPagina = 'Catálogo de Produtos';
require_once __DIR__ . '/includes/header.php';

// Captura filtros vindos pela URL (ex.: clique em categoria na Home ou ícone de favoritos)
$categoriaUrl = isset($_GET['categoria']) ? limparTexto($_GET['categoria']) : 'todas';
$apenasFavoritosUrl = isset($_GET['favoritos']) && $_GET['favoritos'] == '1';
?>

<main class="secao">
    <div class="container">
        <div class="secao-header">
            <span class="subtitulo-topo">Alta Cosmética Botânica</span>
            <h1 class="secao-titulo">Nosso Catálogo Completo</h1>
            <p id="contador-resultados" style="color: var(--cor-texto-suave);"><?php echo count($produtos); ?> produto(s) encontrado(s)</p>
        </div>

        <!-- Barra de Filtros e Ordenação -->
        <section class="barra-filtros" aria-label="Filtros de produtos">
            <div class="campo-grupo">
                <label for="filtro-busca">Buscar por nome</label>
                <input type="search" id="filtro-busca" class="input-padrao" placeholder="Ex.: Sérum, Batom, Rosa...">
            </div>

            <div class="campo-grupo">
                <label for="filtro-categoria">Categoria</label>
                <select id="filtro-categoria" class="select-padrao">
                    <option value="todas" <?php echo $categoriaUrl === 'todas' ? 'selected' : ''; ?>>Todas as Categorias</option>
                    <option value="Skincare" <?php echo $categoriaUrl === 'Skincare' ? 'selected' : ''; ?>>Skincare</option>
                    <option value="Maquiagem" <?php echo $categoriaUrl === 'Maquiagem' ? 'selected' : ''; ?>>Maquiagem</option>
                    <option value="Perfumes" <?php echo $categoriaUrl === 'Perfumes' ? 'selected' : ''; ?>>Perfumes</option>
                    <option value="Cabelo" <?php echo $categoriaUrl === 'Cabelo' ? 'selected' : ''; ?>>Cabelo</option>
                    <option value="Corpo" <?php echo $categoriaUrl === 'Corpo' ? 'selected' : ''; ?>>Corpo</option>
                </select>
            </div>

            <div class="campo-grupo">
                <label for="filtro-preco">Preço máximo: <strong id="valor-preco-label">R$ 350,00</strong></label>
                <input type="range" id="filtro-preco" min="50" max="350" step="10" value="350" style="width: 100%; accent-color: var(--cor-primaria);">
            </div>

            <div class="campo-grupo">
                <label for="filtro-ordem">Ordenar por</label>
                <select id="filtro-ordem" class="select-padrao">
                    <option value="padrao">Destaques Éclat</option>
                    <option value="menor-preco">Menor Preço</option>
                    <option value="maior-preco">Maior Preço</option>
                    <option value="az">Ordem Alfabética (A-Z)</option>
                </select>
            </div>

            <div style="grid-column: 1 / -1; display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="filtro-favoritos" <?php echo $apenasFavoritosUrl ? 'checked' : ''; ?> style="width:18px; height:18px; accent-color: var(--cor-primaria);">
                <label for="filtro-favoritos" style="cursor:pointer; font-size:0.9rem;">Mostrar apenas meus produtos Favoritos 💖</label>
            </div>
        </section>

        <!-- Grade de Produtos Renderizada pelo PHP -->
        <div class="produtos-grid" id="grid-catalogo">
            <?php foreach ($produtos as $produto): ?>
                <?php echo renderizarCardProduto($produto); ?>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>