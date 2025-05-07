<?php
// Initialize message array
$message = [];

if(isset($_POST['add_to_wishlist'])) {
    if($user_id == '') {
        header('location:user_login.php');
        exit();
    } else {
        // Validate and sanitize inputs
        $pid = htmlspecialchars($_POST['pid'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');

        // Validate numeric values
        if(!is_numeric($price) || $price <= 0) {
            $message[] = 'Invalid price value!';
        } else {
            try {
                // Check if already in wishlist
                $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
                $check_wishlist_numbers->execute([$name, $user_id]);

                // Check if already in cart
                $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
                $check_cart_numbers->execute([$name, $user_id]);

                if($check_wishlist_numbers->rowCount() > 0) {
                    $message[] = 'Already added to wishlist!';
                } elseif($check_cart_numbers->rowCount() > 0) {
                    $message[] = 'Already added to cart!';
                } else {
                    // Insert into wishlist
                    $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
                    $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
                    $message[] = 'Added to wishlist!';
                }
            } catch(PDOException $e) {
                $message[] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

if(isset($_POST['add_to_cart'])) {
    if($user_id == '') {
        header('location:user_login.php');
        exit();
    } else {
        // Validate and sanitize inputs
        $pid = htmlspecialchars($_POST['pid'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
        $qty = max(1, (int)filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT));

        // Validate numeric values
        if(!is_numeric($price) || $price <= 0) {
            $message[] = 'Invalid price value!';
        } else {
            try {
                // Check if already in cart
                $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
                $check_cart_numbers->execute([$name, $user_id]);

                if($check_cart_numbers->rowCount() > 0) {
                    $message[] = 'Already added to cart!';
                } else {
                    // Check if in wishlist to remove it
                    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
                    $check_wishlist_numbers->execute([$name, $user_id]);

                    if($check_wishlist_numbers->rowCount() > 0) {
                        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
                        $delete_wishlist->execute([$name, $user_id]);
                    }

                    // Insert into cart
                    $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
                    $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
                    $message[] = 'Added to cart!';
                }
            } catch(PDOException $e) {
                $message[] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}
?>