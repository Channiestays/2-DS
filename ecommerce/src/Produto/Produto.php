<?php
namespace Sistema\Produto;
abstract class Produto {
 protected string $nome;
 protected float $preco;
 protected int $estoque;
 protected string $categoria;
 protected int $id;

 private static int $totalProdutos = 0;
 private static array $categoriasDisponiveis = ['Eletrônicos', 'Livros', 'Roupas', 'Alimentos'];

 public function __construct(string $nome, float $preco, int $estoque, string $categoria) {
 if (!in_array($categoria, self::$categoriasDisponiveis)) {
 throw new \Exception("Categoria '{$categoria}' não disponível");
}

 $this->nome = $nome;
 $this->preco = $preco;
 $this->estoque = $estoque;
 $this->categoria = $categoria;
 $this->id = ++self::$totalProdutos;
}

 abstract public function calcularFrete(): float;

 public function getNome(): string {
 return $this->nome;
}

 public function getPreco(): float {
 return $this->preco;
}

 public function getEstoque(): int {
 return $this->estoque;
}

 public function setEstoque(int $quantidade): void {
 if ($quantidade < 0) {
 throw new \Exception("Estoque não pode ser negativo");
 }
 $this->estoque = $quantidade;
}

 public function getId(): int {
 return $this->id;
}

 public static function getTotalProdutos(): int {
 return self::$totalProdutos;
}

 public static function adicionarCategoria(string $categoria): void {
 if (!in_array($categoria, self::$categoriasDisponiveis)) {
 self::$categoriasDisponiveis[] = $categoria;
 }
}

 public static function getCategorias(): array {
 return self::$categoriasDisponiveis;
 }
}