<?php
session_start();
require_once __DIR__ . '/app/config.php';
session_destroy();
header("Location: " . BASE_URL . "/index.php");
exit;