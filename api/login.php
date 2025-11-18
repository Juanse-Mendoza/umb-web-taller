<?php
session_start(); 

// Si el usuario envía credenciales mediante POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Capturar valores enviados
    $usuario = $_POST["usuario"] ?? null;
    $password = $_POST["password"] ?? null;

    // Validación simple (ejemplo de clase)
    if ($usuario && $password) {


        $_SESSION["usuario"] = $usuario;  // Guarda el usuario en la sesión
        $_SESSION["login_time"] = date("Y-m-d H:i:s"); // Guarda hora de inicio

        echo "✔ Sesión iniciada correctamente<br>";
        echo "Bienvenido, <strong>" . $_SESSION["usuario"] . "</strong><br>";
        echo "Hora de inicio: " . $_SESSION["login_time"];

    } else {
        echo "❌ Debe ingresar un usuario y una contraseña.";
    }
}

// ------------------------------------------------------
// Ejemplo de Cerrar sesión (logout)
// ------------------------------------------------------
if (isset($_GET["logout"])) {
    session_destroy();
    echo "🔒 Sesión cerrada correctamente.";
}
?>
