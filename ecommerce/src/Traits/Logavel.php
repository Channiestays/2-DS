<?php
namespace Sistema\Traits;
trait Logavel {
 private string $logFile = __DIR__ . '/../../logs/sistema.log';

 public function log(string $mensagem): void {
 $timestamp = date('Y-m-d H:i:s');
 $classe = get_class($this);
 $logEntry = "[{$timestamp}] [{$classe}] {$mensagem}\n";
 file_put_contents($this->logFile, $logEntry, FILE_APPEND);
}

 public function logCriacao(): void {
 $this->log("Objeto criado");
}

 public function logAlteracao(string $campo, $valorAntigo, $valorNovo): void {
 $this->log("Alteração: {$campo} = '{$valorAntigo}' -> '{$valorNovo}'");
}

 public function logExclusao(): void {
 $this->log("Objeto excluído");
 }
}