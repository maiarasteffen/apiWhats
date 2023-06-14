<?php
/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
define('ENVIRONMENT', 'production');
date_default_timezone_set("America/Sao_Paulo");

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
}

ini_set('memory_limit', '300M');  //Quantidade máxima de memória que um script pode alocar (em bytes)
//ini_set('max_execution_time', '300'); //Limita o tempo de execução do script (em segundos)
ini_set('max_execution_time', '900000'); //Limita o tempo de execução do script (em segundos)
// ini_set('max_allowed_packet', '192M');
// ini_set('wait_timeout', '1800');
ini_set('connect_timeout', '60');

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
if (defined('STDIN')) //COMMAND LINE
  define('URL_DOMAIN', ROOT);
else  //SERVER
  define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

define('LOCK_FILE', 'lockTempFile.txt'); //arquivo temporário pra controle de execução do script
define('LOG_FILE', 'log.txt'); //arquivo de log
define('SCRIPT_ID', rand(100, 999)); //identificação aleatorio do script que está sendo executado

define('MAX_TENTATIVAS', 1); //maximo de tentativas de rodar a integração

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'whatsbot');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

/** 
 * Token API Whatsapp
 */
define('TOKEN_WHATS_TEMP', 'EAALKbhuvdZBkBAHJxuioD55ZBEGCZCfqpG3UmwJExy8EXEfrVCSRaZAa7r96B2od828bDxnDEPBM867dfSmRLfxtqh1LjBS61ZBA57JUJu3AL1JzMFZBHvalFXWyUGbp0susBr7PsixawIBc8h2sSh2J9cyK9wdBOIrGXDbqzbpxiXXAbyAoWnTjRt4QaG8HcOfiZAVfZAJb87vrZBUWAiANzCI58HfsnAIoZD');
// define('TOKEN_WHATS', 'EAALKbhuvdZBkBAOLnbbfwZB0HHrzNv3dG859TFBiFN0n7Bh3969D5QZC5n97AhROXMwesZBSTZC0RPp5XVMysi1inmMGnzV4G9DlPEt97Ky5u4kTuuH7hmBrayhoNofvafDlBRC72S0HlbkJUFascrZAAhNA2620AvofP5Ne0SgZAQ5F7VpMmDIo4icHpjmVuRbTJpuD6k3nkHhtbBDA0hltKIvj1itIXbV53Bv1A92awZDZD');
define('URL_WHATS', 'https://graph.facebook.com/v17.0/107648018975982/messages');