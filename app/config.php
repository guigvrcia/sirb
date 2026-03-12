<?php
// Ajuste se seu MySQL tiver senha
<?php
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'sirb_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('BASE_URL', getenv('BASE_URL') ?: ''); // pasta do projeto no htdocs
