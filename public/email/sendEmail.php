<?php
// Versión mínima para desarrollo - similar a tu código original pero con limpieza básica

// Verificar método de envío
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?status=error');
    exit;
}

// Obtener datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

// Solo validar que los campos obligatorios no estén vacíos
if (empty($nombre) || empty($email) || empty($mensaje)) {
    header('Location: ../index.php?status=error&msg=' . urlencode('Campos obligatorios vacíos'));
    exit;
}

// Configuración del email (igual que tu código original)
$destinatario = "sistemas.voos@gmail.com";
$asunto = "Nuevo Mensaje de Contacto - JF Products SAS";

// Construir el cuerpo del correo (igual que tu código original)
$cuerpo = "Has recibido un nuevo mensaje de contacto a través de tu sitio web.\n\n";
$cuerpo .= "Nombre: " . $nombre . "\n";
$cuerpo .= "Teléfono: " . $telefono . "\n";
$cuerpo .= "Correo Electrónico: " . $email . "\n\n";
$cuerpo .= "Mensaje:\n" . $mensaje . "\n";

// Cabeceras (ligeramente modificadas para localhost)
$cabeceras = 'From: ' . $email . "\r\n" .
             'Reply-To: ' . $email . "\r\n" .
             'X-Mailer: PHP/' . phpversion();

// Enviar el correo
if (mail($destinatario, $asunto, $cuerpo, $cabeceras)) {
    header('Location: ../index.php?status=success');
    exit;
} else {
    header('Location: ../index.php?status=error');
    exit;
}
?>