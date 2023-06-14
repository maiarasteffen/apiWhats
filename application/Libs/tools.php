<?php

/**
 * Última função a rodar, e sempre será executada
 * Registrada em index.php
 */
function veryLastScript()
{
    //se o arquivo de controle de execução de script existir, apaga ele
    if (defined("LOCK_FOPEN")) {
        fclose(LOCK_FOPEN);
        unlink(ROOT . LOCK_FILE);
    }

    //confere se houve erros (fatal errors), como mto tempo de execução ou mta memória 
    //limites estes definidos em Config/config.php
    $error = error_get_last();
    if ($error) {
        $msgErro = "Erro: " . $error['message'] . ", ";
        $msgErro .= "Arquivo: " . $error['file'] . ", ";
        $msgErro .= "Linha: " . $error['line'];
        registerLog($msgErro, true);

        $tentativa = TENTATIVA; //definido em index, de acordo com $_GET
        $tentativa++;
        if ($tentativa <= MAX_TENTATIVAS)
            header('location: http://localhost/integracaoSaoRafael/index.php?action=import&tentativa=' . $tentativa);
        exit();
    }

    registerLog("Script finalizado");
}

function registerLog($text, $sendEmail = false)
{
    $mensagem = "(" . date("d/m/Y H:i:s") . ") [" . SCRIPT_ID . "] " . $text . PHP_EOL;
    echo $mensagem;

    $fp = fopen(ROOT . LOG_FILE, "a") or die("Unable to open file!");
    fwrite($fp, $mensagem);
    fclose($fp);

    if ($sendEmail) {
        require ROOT . '\application\Libs\email.php';
        // (new \Mini\Libs\Email())->sendEmail($mensagem);
    }
}

function echod($text, $die = true)
{
    echo "<pre>";
    print_r($text);
    echo "</pre>";

    if ($die) {
        die();
    }
}

function debug($value, $msg = false, $die = false)
{
    if ($msg) {
        echo "<br><h2>$msg</h2>";
    }
    echo "<pre>";
    print_r($value);
    echo "</pre>";
    if ($msg) {
        echo "<br><h2>FIM</h2>";
    }
    if ($die) {
        die();
    }
}

/**
 * @param $string string que será formatada
 * @return string retorno de string formatada como slugify
 */
function slugify($string)
{
    $string = html_entity_decode($string);
    //função removendo espaços para -
    $string = mb_strtolower(strip_tags(preg_replace(array('/[`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/'), array(null, '-', '-'), $string)), 'UTF-8');

    $string = str_replace(",", "", $string);
    $string = str_replace(".", "", $string);
    $string = str_replace(";", "", $string);
    $string = str_replace(":", "", $string);
    $string = str_replace(">", "", $string);
    $string = str_replace("<", "", $string);
    $string = str_replace("/", "", $string);
    $string = str_replace("|", "", $string);
    $string = str_replace("!", "", $string);
    $string = str_replace("@", "", $string);
    $string = str_replace("#", "", $string);
    $string = str_replace("$", "", $string);
    $string = str_replace("%", "", $string);
    $string = str_replace("¨", "", $string);
    $string = str_replace("'", "", $string);
    $string = str_replace("´", "", $string);
    $string = str_replace("&", "", $string);
    $string = str_replace("*", "", $string);
    $string = str_replace("(", "", $string);
    $string = str_replace(")", "", $string);
    $string = str_replace("+", "", $string);
    $string = str_replace("=", "", $string);
    $string = str_replace("º", "", $string);
    $string = str_replace("°", "", $string);
    $string = str_replace("ª", "", $string);
    $string = str_replace("\\", "", $string);
    return tirarAcentos($string);
}

function cleanString($string)
{
    // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9]/', '', $string); // Just numbers and letters
}

function tirarAcentos($string)
{
    $string = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);

    return strtolower($string);
}

function searchArray($value, $key, $array)
{
    foreach ($array as $k => $val) {
        $val = (array) $val;
        if ($val[$key] === $value) {
            return $k;
        }
    }
    return null;
}
