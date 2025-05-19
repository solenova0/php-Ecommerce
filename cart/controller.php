<?php
require_once ("../include/initialize.php");

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        doInsert();
        break;
    case 'edit':
        doEdit();
        break;
    case 'delete':
        doDelete();
        break;
}

function doInsert() {
    global $pdo; // Use the PDO instance directly

    if (isset($_POST['btnorder'])) {
        $pid = $_POST['PROID'];
        $price = $_POST['PROPRICE'];

        // Fetch product using PDO
        $sql = "SELECT * FROM `tblproduct` WHERE `PROID` = :pid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pid' => $pid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $qty = 1;
            $tot = floatval($price) * $qty;

            // Initialize cart if not set
            if (!isset($_SESSION['gcCart']) || !is_array($_SESSION['gcCart'])) {
                $_SESSION['gcCart'] = [];
            }

            // Check if product already in cart
            $found = false;
            foreach ($_SESSION['gcCart'] as &$cartItem) {
                if ($cartItem['productid'] == $pid) {
                    $cartItem['qty'] += $qty;
                    $cartItem['price'] = floatval($price) * $cartItem['qty'];
                    $found = true;
                    break;
                }
            }
            unset($cartItem);

            // If not found, add new item
            if (!$found) {
                $_SESSION['gcCart'][] = [
                    'productid' => $pid,
                    'qty' => $qty,
                    'price' => $tot
                ];
            }

            message("Product added to cart.", "success");
            redirect(web_root . "index.php?q=cart");
        } else {
            message("Product not found.", "error");
            redirect(web_root . "index.php?q=cart");
        }
    }
}

function doEdit() {
    global $pdo;
    if (isset($_POST['UPPROID'])) {
        $max = count($_SESSION['gcCart']);
        for ($i = 0; $i < $max; $i++) {
            $pid = $_SESSION['gcCart'][$i]['productid'];
            $qty = intval($_POST['QTY' . $pid] ?? $_POST['QTY' . $_POST['UPPROID']] ?? "");
            $price = (double)($_POST['TOT' . $pid] ?? $_POST['TOT' . $_POST['UPPROID']] ?? "");

            $sql = "SELECT * FROM `tblproduct` WHERE `PROID` = :pid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':pid' => $pid]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && $qty > 0 && $qty <= 999) {
                $_SESSION['gcCart'][$i]['qty'] = $qty;
                $_SESSION['gcCart'][$i]['price'] = $price;
            }
        }
    }
}

function doDelete() {
    if (isset($_GET['id'])) {
        removetocart($_GET['id']);
        $countcart = isset($_SESSION['gcCart']) ? count($_SESSION['gcCart']) : 0;
        if ($countcart == 0) {
            unset($_SESSION['orderdetails']);
            unset($_SESSION['gcCart']);
        }
        message("1 item has been removed in the cart.", "success");
        redirect(web_root . "index.php?q=cart");
    }
}
?>