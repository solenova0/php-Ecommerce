<?php
require_once("include/initialize.php");
$PROID = $_GET['id'];

global $pdo;
$sql = "SELECT * FROM tblpromopro pr
        JOIN tblproduct p ON pr.PROID = p.PROID
        JOIN tblcategory c ON p.CATEGID = c.CATEGID
        WHERE p.PROID = :proid";
$stmt = $pdo->prepare($sql);
$stmt->execute([':proid' => $PROID]);
$results = $stmt->fetchAll(PDO::FETCH_OBJ);

foreach ($results as $result): 
?>
<form method="POST" action="cart/controller.php?action=add">
    <div class="row">
        <div class="col-md-6">
            <img width="250" height="200" class="img-portfolio" src="<?php echo web_root . 'admin/products/' . $result->IMAGES; ?>" alt="">
        </div>
        <div class="col-md-6">
            <input type="hidden" name="PROPRICE" value="<?php echo $result->PRODISPRICE; ?>">
            <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $result->PROQTY; ?>">
            <input type="hidden" name="PROID" value="<?php echo $result->PROID; ?>">
            <p><?php echo htmlspecialchars($result->CATEGORIES); ?></p>
            <ul>
                <li>Type - <?php echo htmlspecialchars($result->PRODESC); ?></li>
                <li>Price - $<?php echo $result->PROPRICE; ?></li>
                <li>Discount - <?php echo $result->PRODISCOUNT; ?> %</li>
                <li>Discounted Price - $<?php echo $result->PRODISPRICE; ?></li>
                <li>Available Quantity - <?php echo $result->PROQTY; ?></li>
            </ul>
            <button type="submit" class="btn btn-pup btn-sm" name="btnorder">Order Now!</button>
        </div>
    </div>
</form>
<?php endforeach; ?>