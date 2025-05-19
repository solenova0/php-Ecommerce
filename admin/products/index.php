<?php
require_once("../../include/initialize.php");

if (!isset($_SESSION['USERID'])) {
    redirect(web_root . "admin/index.php");
}

$view = $_GET['view'] ?? '';

$header = $view;
$title = "Products";

switch ($view) {
    case 'list':
        $content = 'list.php';
        break;
    case 'add':
        $content = 'add.php';
        break;
    case 'edit':
        $content = 'edit.php';
        break;
    case 'view':
        $content = 'view.php';
        break;
    default:
        $title = "Products";
        $content = 'list.php';
        break;
}

require_once("../theme/templates.php");
?>