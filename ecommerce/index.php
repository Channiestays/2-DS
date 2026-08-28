<?php
require_once 'autoload.php';
use Sistema\Produto\Produto;
use Sistema\Produto\ProdutoFisico;
use Sistema\Produto\ProdutoDigital;
use Sistema\Carrinho\Carrinho;
use Sistema\Pedido\Pedido;
// Configuração inicial
Produto::adicionarCategoria('Games');
// Criando produtos
$notebook = new ProdutoFisico('Notebook Dell XPS', 4500.00, 5, 'Eletrônicos', 2.8);
$ebook = new ProdutoDigital('PHP Avançado', 79.90, 50, 'Livros', 'PDF', 12.5);
$mouse = new ProdutoFisico('Mouse Gamer Razer', 299.90, 15, 'Games', 0.35);
$curso = new ProdutoDigital('Curso de POO', 199.00, 30, 'Livros', 'MP4', 250.0);
echo "=== SISTEMA DE PEDIDOS ===\n";
echo "Produtos cadastrados: " . Produto::getTotalProdutos() . "\n\n";
// Criando carrinho e adicionando itens
$carrinho = new Carrinho();
$carrinho->adicionarItem($notebook, 1);
$carrinho->adicionarItem($ebook, 2);
$carrinho->adicionarItem($mouse, 1);
$carrinho->adicionarItem($curso, 1);
echo "Carrinho #{$carrinho->getId()} - Total: R$ " . $carrinho->getTotal() . "\n\n";
// Iterando sobre o carrinho
echo "=== ITENS DO CARRINHO ===\n";
foreach ($carrinho as $index => $item) {
 $produto = $item['produto'];
 echo ($index + 1) . ". {$produto->getNome()} x{$item['quantidade']} = R$ {$item['subtotal']}\n";
 echo " - Frete: R$ " . $produto->calcularFrete() . "\n";

 if ($produto instanceof \Sistema\Interfaces\Tributavel) {
 echo " - Imposto: R$ " . $produto->calcularImposto() . "\n";
 }
}
// Finalizando pedido
$pedido = $carrinho->finalizarPedido();
$pedido->pagar();
$pedido->enviar();
echo "\n=== RESUMO DO PEDIDO ===\n";
echo "Pedido #{$pedido->getId()}\n";
echo "Status: {$pedido->getStatus()}\n";
echo "Total: R$ {$pedido->getTotal()}\n";
echo "\n=== DESTRUTORES EM AÇÃO ===\n";
// Quando o script termina, os destrutores são chamados automaticamente