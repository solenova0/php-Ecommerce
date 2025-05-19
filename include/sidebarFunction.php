<?php
function get_categories(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM `tblcategory`");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $result) {
        echo '<ul>
                <li><a href="index.php?q=product&amp;category='.htmlspecialchars($result['CATEGORIES']).'" >'.htmlspecialchars($result['CATEGORIES']).'</a></li> 
            </ul>';
    }
}
?>