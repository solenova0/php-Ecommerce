<?php

require_once("../../include/initialize.php");

if (!isset($_SESSION['USERID'])) {
    redirect(web_root . "admin/index.php");
}

$title = 'Report';
$view = $_GET['view'] ?? '';
switch ($view) {
    case 'list':
        $content = 'list.php';
        break;
    default:
        $content = 'list.php';
        break;
}

require_once '../theme/templates.php';
?>