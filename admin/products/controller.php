<?php
require_once ("../../include/initialize.php");

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
    case 'photos':
        doupdateimage();
        break;
    case 'banner':
        setBanner();
        break;
    case 'discount':
        setDiscount();
        break;
    default:
        // No action, redirect to product list
        redirect("index.php");
        break;
}

function doInsert() {
    if (isset($_POST['save'])) {
        $errofile = $_FILES['image']['error'];
        $type = $_FILES['image']['type'];
        $temp = $_FILES['image']['tmp_name'];
        $myfile = $_FILES['image']['name'];

        // Only allow image files
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $image_size = getimagesize($temp);

        if ($errofile > 0) {
            message("No Image Selected!", "error");
            redirect("index.php?view=add");
        } elseif ($image_size === false || !in_array($type, $allowed_types)) {
            message("Uploaded file is not a valid image!", "error");
            redirect("index.php?view=add");
        } else {
            // Rename file to avoid conflicts
            $ext = pathinfo($myfile, PATHINFO_EXTENSION);
            $newFileName = uniqid('img_', true) . '.' . $ext;
            $location = "uploaded_photos/" . $newFileName;

            if (!move_uploaded_file($temp, $location)) {
                message("Failed to upload image!", "error");
                redirect("index.php?view=add");
            }

            if (empty($_POST['PRODESC']) || empty($_POST['PROPRICE'])) {
                message("All fields are required!", "error");
                redirect('index.php?view=add');
            } else {
                $autonumber = new Autonumber();
                $res = $autonumber->set_autonumber('PROID');

                $product = new Product();
                $product->PROID           = $res->AUTO;
                $product->OWNERNAME       = $_POST['OWNERNAME'];
                $product->OWNERPHONE      = $_POST['OWNERPHONE'];
                $product->IMAGES          = $location;
                $product->PRODESC         = $_POST['PRODESC'];
                $product->CATEGID         = $_POST['CATEGORY'];
                $product->PROQTY          = $_POST['PROQTY'];
                $product->ORIGINALPRICE   = $_POST['ORIGINALPRICE'];
                $product->PROPRICE        = $_POST['PROPRICE'];
                $product->PROSTATS        = 'Available';
                $product->create();

                $promo = new Promo();
                $promo->PROID        = $res->AUTO;
                $promo->PRODISPRICE  = $_POST['PROPRICE'];
                $promo->create();

                $autonumber->auto_update('PROID');

                message("New Product created successfully!", "success");
                redirect("index.php");
            }
        }
    }
}

function doEdit() {
    if (@$_GET['stats'] == 'NotAvailable') {
        $product = new Product();
        $product->PROSTATS = 'Available';
        $product->update(@$_GET['id']);
    } elseif (@$_GET['stats'] == 'Available') {
        $product = new Product();
        $product->PROSTATS = 'NotAvailable';
        $product->update(@$_GET['id']);
    } else {
        if (isset($_GET['front'])) {
            $product = new Product();
            $product->FRONTPAGE = true;
            $product->update(@$_GET['id']);
        }
    }

    if (isset($_POST['save'])) {
        $product = new Product();
        $product->OWNERNAME      = $_POST['OWNERNAME'];
        $product->OWNERPHONE     = $_POST['OWNERPHONE'];
        $product->PRODESC        = $_POST['PRODESC'];
        $product->CATEGID        = $_POST['CATEGORY'];
        $product->PROQTY         = $_POST['PROQTY'];
        $product->ORIGINALPRICE  = $_POST['ORIGINALPRICE'];
        $product->PROPRICE       = $_POST['PROPRICE'];
        $product->update($_POST['PROID']);

        message("Product has been updated!", "success");
        redirect("index.php");
    }
    redirect("index.php");
}

function doDelete() {
    if (empty($_POST['selector'])) {
        message("Select the records first before you delete!", "error");
        redirect('index.php');
    } else {
        $id = $_POST['selector'];
        foreach ($id as $prodId) {
            $product = new Product();
            $product->delete($prodId);

            $stockin = new StockIn();
            $stockin->delete($prodId);

            $promo = new Promo();
            $promo->delete($prodId);
        }
        message("Product(s) have been deleted!", "info");
        redirect('index.php');
    }
}

function doupdateimage() {
    $errofile = $_FILES['photo']['error'];
    $type = $_FILES['photo']['type'];
    $temp = $_FILES['photo']['tmp_name'];
    $myfile = $_FILES['photo']['name'];

    // Only allow image files
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $image_size = getimagesize($temp);

    if ($errofile > 0) {
        message("No Image Selected!", "error");
        redirect("index.php?view=view&id=" . $_POST['proid']);
    } elseif ($image_size === false || !in_array($type, $allowed_types)) {
        message("Uploaded file is not a valid image!", "error");
        redirect("index.php?view=view&id=" . $_POST['proid']);
    } else {
        // Rename file to avoid conflicts
        $ext = pathinfo($myfile, PATHINFO_EXTENSION);
        $newFileName = uniqid('img_', true) . '.' . $ext;
        $location = "uploaded_photos/" . $newFileName;

        if (!move_uploaded_file($temp, $location)) {
            message("Failed to upload image!", "error");
            redirect("index.php?view=view&id=" . $_POST['proid']);
        }

        $product = new Product();
        $product->IMAGES = $location;
        $product->update($_POST['proid']);

        message("Image updated successfully!", "success");
        redirect("index.php?view=view&id=" . $_POST['proid']);
    }
}

function setBanner() {
    $promo = new Promo();
    $promo->PROBANNER = 1;
    $promo->update($_POST['PROID']);
}

function setDiscount() {
    if (isset($_POST['submit'])) {
        $promo = new Promo();
        $promo->PRODISCOUNT = $_POST['PRODISCOUNT'];
        $promo->PRODISPRICE = $_POST['PRODISPRICE'];
        $promo->PROBANNER = 1;
        $promo->update($_POST['PROID']);

        msgBox("Discount has been set.");
        redirect("index.php");
    }
}

function removeDiscount() {
    if (isset($_POST['submit'])) {
        $promo = new Promo();
        $promo->PRODISCOUNT = $_POST['PRODISCOUNT'];
        $promo->PRODISPRICE = $_POST['PRODISPRICE'];
        $promo->PROBANNER = 1;
        $promo->update($_POST['PROID']);

        msgBox("Discount has been set.");
        redirect("index.php");
    }
}
?>