<?php
session_start();

require __DIR__ . '/../config.php';

// impede cache de páginas protegidas
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/login.php");
    exit;
}
