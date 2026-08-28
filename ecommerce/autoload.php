<?php
spl_autoload_register(function ($class) {
 // Converte o namespace para caminho de arquivo
 $prefix = 'Sistema\\';
 $base_dir = __DIR__ . 
 // Verifica se a classe usa o prefixo
 $len = strlen($prefix);
 if (strncmp($prefix, $class, $len) !== 0) {
 return;
 }

 // Obtém o nome relativo da classe
 $relative_class = substr($class, $len);

 // Substitui namespace separators por DIRECTORY_SEPARATOR
 $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

 if (file_exists($file)) {
 require $file;
 }
});
// Carrega interfaces
spl_autoload_register(function ($class) {
 $prefix = 'Sistema\\Interfaces\\';
 $base_dir = __DIR__ . '/Interfaces/';

 $len = strlen($prefix);
 if (strncmp($prefix, $class, $len) !== 0) {
return;
}

$relative_class = substr($class, $len);
$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

if (file_exists($file)) {
require $file;
}
});
// Carrega traits
spl_autoload_register(function ($class) {
$prefix = 'Sistema\\Traits\\';
$base_dir = __DIR__ . '/src/Traits/';
$len = strlen($prefix);
 if (strncmp($prefix, $class, $len) !== 0) {
 return;
 }

 $relative_class = substr($class, $len);
 $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

 if (file_exists($file)) {
 require $file;
 }
});
echo "Autoload carregado com sucesso!\n";