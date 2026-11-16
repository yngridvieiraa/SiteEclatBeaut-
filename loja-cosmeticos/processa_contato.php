<?php
/**
 * Processamento Back-end de Formulários de Contato e Newsletter.
 * Valida, sanitiza, grava os registros em data/contatos.json e cria mensagem Flash na sessão.
 */

require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$tipoFormulario = limparTexto(filter_input(INPUT_POST, 'tipo_formulario', FILTER_DEFAULT));
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if ($tipoFormulario === 'newsletter') {
    if (!$email) {
        definirMensagemFlash('erro', 'Informe um endereço de e-mail válido para assinar a newsletter.');
        header('Location: index.php');
        exit;
    }

    $registro = [
        'tipo' => 'newsletter',
        'email' => $email,
        'data_inscricao' => date('d/m/Y H:i:s')
    ];

    salvarRegistroJson('contatos.json', $registro);
    definirMensagemFlash('sucesso', '✨ Inscrição confirmada! Bem-vinda ao Clube Éclat Privilège.');
    header('Location: index.php');
    exit;
}

// Processamento do formulário de Contato completo
$nome = limparTexto(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT));
$assunto = limparTexto(filter_input(INPUT_POST, 'assunto', FILTER_DEFAULT));
$mensagem = limparTexto(filter_input(INPUT_POST, 'mensagem', FILTER_DEFAULT));

if (empty($nome) || !$email || empty($mensagem)) {
    definirMensagemFlash('erro', 'Por favor, preencha todos os campos do formulário de contato.');
    header('Location: contato.php');
    exit;
}

$novoContato = [
    'tipo' => 'contato',
    'nome' => $nome,
    'email' => $email,
    'assunto' => $assunto,
    'mensagem' => $mensagem,
    'data_envio' => date('d/m/Y H:i:s')
];

salvarRegistroJson('contatos.json', $novoContato);
$_SESSION['cliente_nome'] = explode(' ', $nome)[0];

definirMensagemFlash('sucesso', "Recebemos sua mensagem, $nome! Nosso Concierge responderá em breve no e-mail informado.");
header('Location: contato.php');
exit;