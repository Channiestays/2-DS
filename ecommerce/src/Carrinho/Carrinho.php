<?php
namespace Sistema\Carrinho;
use Sistema\Produto\Produto;
use Sistema\Pedido\Pedido;
use Sistema\Traits\Logavel;
class Carrinho implements \IteratorAggregate {
 use Logavel;

 private int $id;
 private array $itens;
 private float $total;

 private static int $contadorCarrinhos = 0;

 public function __construct() {
 $this->id = ++self::$contadorCarrinhos;
 $this->itens = [];
 $this->total = 0.0;
 $this->logCriacao();
}

public function adicionarItem(Produto $produto, int $quantidade): void {
if ($quantidade <= 0) {
throw new \Exception("Quantidade deve ser maior que zero");
}

if ($produto->getEstoque() < $quantidade) {
throw new \Exception("Estoque insuficiente para {$produto->getNome()}");
}

$subtotal = $produto->getPreco() * $quantidade;
$this->itens[] = [
'produto' => $produto,
'quantidade' => $quantidade,
'subtotal' => $subtotal
];
$this->total += $subtotal;

$this->log("Item adicionado: {$produto->getNome()} x{$quantidade} - R$ {$subtotal}");
}

public function getIterator(): \Traversable {
return new \ArrayIterator($this->itens);
}

public function getTotal(): float {
return $this->total;
}

public function getId(): int {
return $this->id;
}

public function getItens(): array {
return $this->itens;
}

public static function getTotalCarrinhos(): int {return self::$contadorCarrinhos;}

public function finalizarPedido(): Pedido {
$pedido = new Pedido();
foreach ($this->itens as $item) {
$pedido->adicionarItem(
    $item['produto'], $item['quantidade']);
}
$this->log("Pedido finalizado a partir do carrinho #{$this->id}");
return $pedido;
}
}