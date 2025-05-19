<?php
require_once("../include/initialize.php");
$PROID = $_GET['id'];

global $pdo;
$sql = "SELECT * FROM tblpromopro pr
        JOIN tblproduct p ON pr.PROID = p.PROID
        JOIN tblcategory c ON p.CATEGID = c.CATEGID
        WHERE p.PROID = :proid";
$stmt = $pdo->prepare($sql);
$stmt->execute([':proid' => $PROID]);
$cur = $stmt->fetchAll(PDO::FETCH_OBJ);

foreach ($cur as $result) { 
?>

<!-- Portfolio Item Row -->
<form method="POST" action="cart/controller.php?action=add">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-m-12">
                    <div class="col-md-6 responsive">
                        <img width="250" class="img-portfolio" height="200" src="<?php echo web_root . 'admin/products/' . $result->IMAGES; ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <input type="hidden" name="PROPRICE" value="<?php echo $result->PRODISPRICE; ?>">
            <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $result->PROQTY; ?>">
            <input type="hidden" name="PROID" value="<?php echo $result->PROID; ?>">
            <h3><?php echo $result->PRONAME; ?></h3>
            <p><?php echo $result->CATEGORIES; ?></p>
            <ul>
                <li>Model - <?php echo $result->PROMODEL; ?></li>
                <li>Type - <?php echo $result->PRODESC; ?></li>
                <li>Price - Br <?php echo $result->PROPRICE; ?></li>
                <li>Discount - <?php echo $result->PRODISCOUNT; ?> % </li>
                <li>Discounted Price - Br <?php echo $result->PRODISPRICE; ?> </li>
                <li>Available Quantity - <?php echo $result->PROQTY; ?></li>
            </ul>
            <button type="submit" class="btn btn-primary btn-sm" name="btnorder">Order Now!</button>
        </div>
    </div>
    <!-- /.row -->
</form>

<?php } ?>