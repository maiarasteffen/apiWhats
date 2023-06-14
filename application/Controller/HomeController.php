<?php

namespace Mini\Controller;

use WideImage\WideImage;

use Mini\Model\{
    dbCategoria,
    dbProduto,
    dbCaracteristica,
    dbPedido,
    dbCliente,
    dbConfiguracao,
    Webhook
};

class HomeController
{
    public function __construct()
    {
        // die('killed');
    }

    public function index()
    {
        date_default_timezone_set('America/Fortaleza');
        echo 'Integração iniciada às ' . date('H:i:s') . '<br>';

        $type = $_GET['action'];

        switch ($type) {
            case "full":
                registerLog("Tipo: Full");
                $this->enviarREST('5547988179539');
                break;

            case "teste":
                registerLog("Tipo: Teste");
                $this->enviarREST('5547988179539');
                $this->webhook();
                break;

            default:
                registerLog("Tipo '" . $type . "' desconhecido ou não informado");
                echo ("<h2 style='font-size: 30px; color: red;'>Tipo '" . $type . "' desconhecido ou não informado</h2>");
                echo ("<h2 color: red;'>Temos essas opções:</h2>");
                break;
        }

        echo '<br> Integração finalizada às ' . date('H:i:s') . '<br>';
    }

    /* FUNÇÃO GENÉRICA QUE CONECTA NA API E RETORNA OS DADOS */
    function enviarREST($number)
    {
        $curl = curl_init();

        $postFilds = [
            "messaging_product" => "whatsapp",
            "to" => $number,
            "type" => "template", 
            "template" => [
                "name" => "hello_world", 
                "language" => [
                    "code" => "en_US"
                ],
            ],
        ];

        curl_setopt_array($curl, [
          CURLOPT_URL => URL_WHATS,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($postFilds),
          CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . TOKEN_WHATS_TEMP,
            "Content-Type: application/json"
          ],
        ]);

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }
    }

    public function webhook() {
        $webhooks = new Webhook();
        $webhook = $webhooks->getAll();
        echod($webhook);
    }
}