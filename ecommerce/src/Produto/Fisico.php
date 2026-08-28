<?php
namespace Sistema\Produto;
use Sistema\Interfaces\Tributavel;
use Sistema\Traits\Logavel;
class ProdutoFisico extends Produto implements Tributavel {
 use Logavel;

private float $peso;
private float $aliquotaImposto;

 public function __construct(string $nome, float $preco, int $estoque, string $categoria, float $peso) {
 parent::__construct($nome, $preco, $estoque, $categoria);
 $this->peso = $peso;
 $this->aliquotaImposto = 0.20;
 $this->logCriacao();
}

 public function calcularFrete(): float {
 return $this->peso * 1.5;
}

 public function calcularImposto(): float {
 return $this->preco * $this->aliquotaImposto;
}

 public function getAliquotaImposto(): float {
 return $this->aliquotaImposto;
}

 public function getPeso(): float {
 return $this->peso;
}
}
