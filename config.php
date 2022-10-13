<?php
include_once('include/Database.php');
//define('SS_DB_NAME', 'tklgxyz_lg');
//define('SS_DB_USER', 'tklgxyz_lg');
//define('SS_DB_PASSWORD', 'D@1037622001');
//define('SS_DB_HOST', 'localhost');
define('SS_DB_NAME', 'lg');
define('SS_DB_USER', 'root');
define('SS_DB_PASSWORD', '');
define('SS_DB_HOST', 'localhost');

$dsn	= 	"mysql:dbname=".SS_DB_NAME.";host=".SS_DB_HOST."";
$pdo	=	"";
try {
	$pdo = new PDO($dsn, SS_DB_USER);
}catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
$db 	=	new Database($pdo);
?>
/* */