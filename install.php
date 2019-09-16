<?php
// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');
// Config

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

try {
$query = $db->query('ALTER TABLE `'.DB_PREFIX.'order` ADD `ttn` VARCHAR(255) NOT NULL AFTER `ip`;');
echo 'Installation complete. You can delete this file :)';
} catch (Exception $e) {
    echo 'Some was wrong: ',  $e->getMessage(), "\n";
}
?>