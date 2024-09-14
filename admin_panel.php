<?php
header("Content-Type: text/html; charset=UTF-8");

$host = '127.0.0.1';
$db = 'cep_api_db';
$user = 'root';
$pass = ''; // Substitua pela senha do seu banco de dados

// Conecta ao banco de dados
$mysqli = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($mysqli->connect_error) {
    die("Falha na conexão com o banco de dados.");
}

// Atualizar os créditos e status se o formulário for enviado
if (isset($_POST['credits']) && isset($_POST['status'])) {
    $credits = intval($_POST['credits']);
    $status = $_POST['status'];
    $stmt = $mysqli->prepare("UPDATE api_settings SET credits = ?, status = ? WHERE id = 1");
    $stmt->bind_param("is", $credits, $status);
    $stmt->execute();
}

// Buscar os dados da API
$result = $mysqli->query("SELECT api_name, credits, status FROM api_settings WHERE id = 1");
$settings = $result->fetch_assoc();

echo '<h1>Painel Administrativo</h1>';
echo '<p>Nome da API: ' . htmlspecialchars($settings['api_name']) . '</p>';
echo '<p>Créditos disponíveis: ' . htmlspecialchars($settings['credits']) . '</p>';
echo '<p>Status da API: ' . htmlspecialchars($settings['status']) . '</p>';

echo '
<form method="post">
    <label>Créditos: <input type="number" name="credits" value="' . htmlspecialchars($settings['credits']) . '"></label><br>
    <label>Status: 
        <select name="status">
            <option value="on"' . ($settings['status'] == 'on' ? ' selected' : '') . '>On</option>
            <option value="off"' . ($settings['status'] == 'off' ? ' selected' : '') . '>Off</option>
        </select>
    </label><br>
    <input type="submit" value="Atualizar">
</form>';

$mysqli->close();
?>
