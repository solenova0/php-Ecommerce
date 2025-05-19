<?php
require_once("include/initialize.php");

$view = $_GET['q'] ?? '';
$title = "Home";
$content = 'home.php';

switch ($view) {
    case 'product':
        $title = "Products";
        $content = 'menu.php';
        break;
    case 'cart':
        $title = "Cart List";
        $content = 'cart.php';
        break;
    case 'profile':
        $title = "Profile";
        $content = 'customer/profile.php';
        break;
    case 'trackorder':
        $title = "Track Order";
        $content = 'customer/trackorder.php';
        break;
    case 'orderdetails':
        if (!isset($_SESSION['orderdetails'])) {
            $_SESSION['orderdetails'] = "Order Details";
        }
        $content = 'customer/orderdetails.php';
        if (!empty($_SESSION['orderdetails'])) {
            $title = 'Cart List | <a href="">Order Details</a>';
        }
        break;
    case 'billing':
        if (!isset($_SESSION['billingdetails'])) {
            $_SESSION['billingdetails'] = "Order Details";
        }
        $content = 'customer/customerbilling.php';
        if (!empty($_SESSION['billingdetails'])) {
            $title = 'Cart List | <a href="">Billing Details</a>';
        }
        break;
    case 'contact':
        $title = "Contact Us";
        $content = 'contact.php';
        break;
    case 'single-item':
        $title = "Product";
        $content = 'single-item.php';
        break;
    case 'recoverpassword':
        $title = "Recover Password";
        $content = 'passwordrecover.php';
        break;
    default:
        // $title and $content already set to Home
        break;
}

require_once("theme/templates.php");
?>