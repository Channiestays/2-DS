<?php
namespace Sistema\Produto;
use Sistema\Traits\Logavel;
class ProdutoDigital extends Produto {
 use Logavel;

 private string $formatoArquivo;
 private float $tamanhoArquivo;

 public function __construct(string $nome, float $preco, int $estoque, string $categoria, string $formatoArquivo, float $tamanhoArquivo){
 parent::__construct($nome, $preco, $estoque, $categoria);
 $this->formatoArquivo = $formatoArquivo;
 $this->tamanhoArquivo = $tamanhoArquivo;
 $this->logCriacao();
}

 public function calcularFrete(): float {
 return 0.0;
}

 public function getFormatoArquivo(): string {
 return $this->formatoArquivo;
}

 public function getTamanhoArquivo(): float {
 return $this->tamanhoArquivo;
}
}