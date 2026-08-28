<?php
namespace Sistema\Pedido;
use Sistema\Produto\Produto;
use Sistema\Traits\Logavel;
class Pedido {
 use Logavel;

 public const STATUS_CRIADO = 'criado';
 public const STATUS_PAGO = 'pago';
 public const STATUS_ENVIADO = 'enviado';
 public const STATUS_ENTREGUE = 'entregue';
 public const STATUS_CANCELADO = 'cancelado';

 private int $id;
 private array $itens;
 private string $status;
 private float $total;
 private static int $contadorPedidos = 0;

public function __construct() {
 $this->id = ++self::$contadorPedidos;
 $this->itens = [];
 $this->status = self::STATUS_CRIADO;
 $this->total = 0;
}

public function adicionarItem(Produto $produto, int $quantidade): void {
$subtotal = $produto->getPreco() * $quantidade;
$this->itens[] = [
'produto' => $produto,
'quantidade' => $quantidade,
'subtotal' => $subtotal
];
$this->total += $subtotal;
}

public function pagar(): void {
if ($this->status === self::STATUS_CRIADO) {
$this->status = self::STATUS_PAGO;
$this->log("Pedido pago - Total: R$ {$this->total}");
} else {
throw new \Exception("Pedido não pode ser pago no status atual: {$this->status}");
}
}

public function enviar(): void {
if ($this->status === self::STATUS_PAGO) {
$this->status = self::STATUS_ENVIADO;
$this->log("Pedido enviado");
} else {
throw new \Exception("Pedido precisa estar pago para ser enviado");
}
}

public function entregar(): void {
if ($this->status === self::STATUS_ENVIADO) {
$this->status = self::STATUS_ENTREGUE;
$this->log("Pedido entregue");
} else {
throw new \Exception("Pedido precisa estar enviado para ser entregue");
}
}

public function cancelar(): void {
    // Impedir recancelamento
    if ($this->status === self::STATUS_CANCELADO) {
        throw new \Exception("Pedido já está cancelado.");
    }

    // Impedir cancelamento após envio/entrega
    if (in_array($this->status, [self::STATUS_ENVIADO, self::STATUS_ENTREGUE], true)) {
        throw new \Exception("Pedido não pode ser cancelado no status atual: {$this->status}");
    }

    // Devolver o estoque apenas para produtos físicos (evita repor digitais ou objetos sem estoque)
    foreach ($this->itens as $item) {
        $produto = $item['produto'];
        $quantidade = (int) $item['quantidade'];

        if ($produto instanceof \Sistema\Produto\ProdutoFisico) {
            $produto->setEstoque($produto->getEstoque() + $quantidade);
        }
    }

    $this->status = self::STATUS_CANCELADO;
    $this->log("Pedido cancelado e estoque devolvido");
}

 public function getId(): int {
 return $this->id;
 }

 public function getStatus(): string {
 return $this->status;
 }

 public function getTotal(): float {
 return $this->total;
 }

 public function __destruct() {
 $this->log("Pedido #{$this->id} destruído - Status final: {$this->status}");
 }
}