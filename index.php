<?php
// set a constant that holds the project's folder path, like "/var/www/".
// DIRECTORY_SEPARATOR adds a slash to the end of the path
define('ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
// set a constant that holds the project's "application" folder, like "/var/www/application".
define('APP', ROOT.'application'.DIRECTORY_SEPARATOR);

// This is the auto-loader for Composer-dependencies (to load tools into your project).
require ROOT.'vendor/autoload.php';

// load application config (error reporting etc.)
require APP.'Config/config.php';

// TOOLS
require APP.'Libs/tools.php';
register_shutdown_function('veryLastScript'); //sempre executa no final (em Libs/tools.php)

// load application class
use \Mini\Core\Application;

// Define qual tentativa é, se houve problema na execução anterior, então script foi chamado de novo
$tentativa = (isset($_GET['tentativa'])) ? $_GET['tentativa'] : 1;
define('TENTATIVA', $tentativa);

registerLog("Script inicializado, tentativa ".TENTATIVA);

/**
 * Controle de execução de script
 * Cria um arquivo temporário e o apaga no final (em tools\veryLastScript)
 * Ou seja, existindo este arquivo, sabe-se que um script está sendo executado
 */
if (file_exists(ROOT.LOCK_FILE)) {
    registerLog("[".SCRIPT_ID."] Erro: Outro script em execução", true);	
}
else {
	define('LOCK_FOPEN', fopen(ROOT.LOCK_FILE, 'w'));
    $app = new Application(); // start the application
}
    