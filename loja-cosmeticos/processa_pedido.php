<?php
/**
 * Processamento Back-end do Checkout em PHP.
 * Sanitiza os campos, gera protocolo único de pedido, salva em data/pedidos.json,
 * armazena o nome do cliente na sessão PHP e exibe a tela de confirmação.
 */

require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: checkout.php');
    exit;
}

// Sanitização e validação dos dados no servidor com filter_input e htmlspecialchars
$nome = limparTexto(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT));
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$cpf = limparTexto(filter_input(INPUT_POST, 'cpf', FILTER_DEFAULT));
$telefone = limparTexto(filter_input(INPUT_POST, 'telefone', FILTER_DEFAULT));
$cep = limparTexto(filter_input(INPUT_POST, 'cep', FILTER_DEFAULT));
$logradouro = limparTexto(filter_input(INPUT_POST, 'logradouro', FILTER_DEFAULT));
$numero = limparTexto(filter_input(INPUT_POST, 'numero', FILTER_DEFAULT));
$bairro = limparTexto(filter_input(INPUT_POST, 'bairro', FILTER_DEFAULT));
$cidade = limparTexto(filter_input(INPUT_POST, 'cidade', FILTER_DEFAULT));
$metodoPagamento = limparTexto(filter_input(INPUT_POST, 'metodo_pagamento', FILTER_DEFAULT));
$itensJson = $_POST['itens_json'] ?? '[]';
$itensPedido = json_decode($itensJson, true) ?: [];

if (empty($nome) || !$email || empty($cpf) || empty($logradouro)) {
    definirMensagemFlash('erro', 'Por favor, preencha todos os dados obrigatórios corretamente.');
    header('Location: checkout.php');
    exit;
}

// Calcula valor total no servidor
$valorTotal = 0;
foreach ($itensPedido as $item) {
    $valorTotal += (float)($item['preco'] ?? 0) * (int)($item['quantidade'] ?? 1);
}

// Gera número de pedido único em PHP
$numeroPedido = 'ECL-' . date('Y') . '-' . strtoupper(substr(md5(uniqid((string)mt_rand(), true)), 0, 6));

$novoPedido = [
    'numero_pedido' => $numeroPedido,
    'data_hora' => date('d/m/Y H:i:s'),
    'cliente' => [
        'nome' => $nome,
        'email' => $email,
        'cpf' => $cpf,
        'telefone' => $telefone
    ],
    'endereco' => "$logradouro, $numero - $bairro, $cidade (CEP: $cep)",
    'metodo_pagamento' => $metodoPagamento,
    'itens' => $itensPedido,
    'valor_total' => $valorTotal
];

// Salva em /data/pedidos.json
salvarRegistroJson('pedidos.json', $novoPedido);

// Salva o primeiro nome do cliente na sessão PHP para saudação personalizada no topo
$partesNome = explode(' ', $nome);
$_SESSION['cliente_nome'] = $partesNome[0];

$tituloPagina = 'Pedido Confirmado';
require_once __DIR__ . '/includes/header.php';
?>

<main class="secao">
    <div class="container">
        <div class="painel-box" style="max-width: 680px; margin: 0 auto; text-align: center; padding: 3rem 2rem; border-color: var(--cor-dourado);">
            <span style="font-size: 3rem;">🎉</span>
            <span class="subtitulo-topo" style="display:block; margin-top: 0.5rem;">Compra Realizada com Sucesso</span>
            <h1 class="secao-titulo">Obrigada pelo seu pedido, <?php echo limparTexto($partesNome[0]); ?>!</h1>
            <p style="color: var(--cor-texto-suave); margin-bottom: 1.5rem;">
                Seu ritual de beleza Éclat Beauté já está sendo separado em nosso ateliê.
            </p>

            <div style="background: var(--cor-superficie-alt); padding: 1.5rem; border-radius: 12px; margin-bottom: 1.8rem; text-align: left;">
                <p><strong>Número do Pedido:</strong> <span style="color: var(--cor-primaria); font-weight:700;"><?php echo $numeroPedido; ?></span></p>
                <p><strong>Data:</strong> <?php echo $novoPedido['data_hora']; ?></p>
                <p><strong>Forma de Pagamento:</strong> <?php echo $metodoPagamento; ?></p>
                <p><strong>Endereço de Entrega:</strong> <?php echo limparTexto($novoPedido['endereco']); ?></p>
                <p><strong>Total dos Produtos:</strong> <?php echo formatarMoeda($valorTotal); ?></p>
            </div>

            <a href="index.php" class="btn btn-primario">Voltar à Página Inicial</a>
        </div>
    </div>
</main>

<script>
    // Limpa o carrinho após confirmação do pedido no PHP
    localStorage.removeItem('eclat_carrinho_v1');
    localStorage.removeItem('eclat_cupom_v1');
    if (typeof atualizarBadgesHeader === 'function') atualizarBadgesHeader();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>