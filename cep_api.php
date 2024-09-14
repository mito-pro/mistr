<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$host = '127.0.0.1';
$db = 'cep_api_db';
$user = 'root';
$pass = ''; // Substitua pela senha do seu banco de dados

// Conecta ao banco de dados
$mysqli = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($mysqli->connect_error) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
}

// Função para consultar o CEP
function consultaCep($cep) {
    $url = "https://viacep.com.br/ws/{$cep}/json/";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Verifica o status da API e a validade do CEP
$query = "SELECT credits, status FROM api_settings WHERE id = 1";
$result = $mysqli->query($query);
$settings = $result->fetch_assoc();

if ($settings['status'] == 'off') {
    echo json_encode(["error" => "A API está desligada."]);
    exit;
}

if (isset($_GET['cep'])) {
    $cep = $_GET['cep'];
    if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $cep)) {
        $cep = str_replace('-', '', $cep);

        if ($settings['credits'] > 0) {
            $data = consultaCep($cep);

            // Atualiza o banco de dados com a consulta
            $mysqli->query("INSERT INTO api_logs (cep) VALUES ('$cep')");

            // Diminui o crédito
            $mysqli->query("UPDATE api_settings SET credits = credits - 1 WHERE id = 1");

            echo $data;
        } else {
            echo json_encode(["error" => "Créditos insuficientes."]);
        }
    } else {
        echo json_encode(["error" => "Formato de CEP inválido."]);
    }
} else {
    echo json_encode(["error" => "CEP não fornecido."]);
}

$mysqli->close();
?>
