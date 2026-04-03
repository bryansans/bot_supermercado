<?php
// 1. Configuración del Token
$token = '8644938134:AAFVHV-qXhtYZw7AIYeJ0u_fQ01S6CVxCcI';
$website = "https://api.telegram.org/bot".$token;

// 2. Leer la entrada de Telegram
$input = file_get_contents("php://input");
$update = json_decode($input, TRUE);

// Verificar si recibimos datos, si no, mostrar mensaje de prueba
if (!$update) {
    echo "El archivo bot.php está funcionando. Esperando mensaje de Telegram...";
    exit;
}

$chatId = $update["message"]["chat"]["id"];
$message = strtolower(trim($update["message"]["text"]));

// 3. Lógica de Pasillos (Actividad Semanal)
switch ($message) {
    case "/start":
        $response = "¡Hola! Soy el bot del supermercado. Dime qué producto buscas y te diré el pasillo.";
        break;
    case "carne":
    case "queso":
    case "jamon":
        $response = "Lo encuentras en el Pasillo 1.";
        break;
    case "leche":
    case "yogurth":
    case "cereal":
        $response = "Lo encuentras en el Pasillo 2.";
        break;
    case "bebidas":
    case "jugos":
        $response = "Lo encuentras en el Pasillo 3.";
        break;
    case "pan":
    case "pasteles":
    case "tortas":
        $response = "Lo encuentras en el Pasillo 4.";
        break;
    case "detergente":
    case "lavaloza":
        $response = "Lo encuentras en el Pasillo 5.";
        break;
    default:
        $response = "Lo siento, no entiendo la pregunta.";
        break;
}

// 4. OPCIÓN A: Enviar respuesta ignorando errores de certificado SSL
$url = $website."/sendMessage?chat_id=".$chatId."&text=".urlencode($response);

$options = [
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
];

$context = stream_context_create($options);

// Se añade el $context al final para forzar el envío
file_get_contents($url, false, $context);
?>