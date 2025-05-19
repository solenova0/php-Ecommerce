<?php
require_once("include/initialize.php");
$PROID = $_GET['id']; 

// Fetch main product info with PDO
$sql = "SELECT * FROM tblpromopro pr
        JOIN tblproduct p ON pr.PROID = p.PROID
        JOIN tblcategory c ON p.CATEGID = c.CATEGID
        WHERE p.PROID = :proid";
$stmt = $pdo->prepare($sql);
$stmt->execute([':proid' => $PROID]);
$product = $stmt->fetch(PDO::FETCH_OBJ);

if ($product):
?>
<!-- Portfolio Item Row -->
<form method="POST" action="cart/controller.php?action=add">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-m-12">
                    <div class="col-md-8 responsive">
                        <img width="402" class="img-portfolio" height="300" src="<?php echo web_root . 'admin/products/' . htmlspecialchars($product->IMAGES); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <input type="hidden" name="PROPRICE" value="<?php echo htmlspecialchars($product->PRODISPRICE); ?>">
            <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo htmlspecialchars($product->PROQTY); ?>">
            <input type="hidden" name="PROID" value="<?php echo htmlspecialchars($product->PROID); ?>">
            <p><?php echo htmlspecialchars($product->CATEGORIES); ?></p>
            <ul>
                <li>Type - <?php echo htmlspecialchars($product->PRODESC); ?></li>
                <li>Price - Br <?php echo number_format($product->PROPRICE, 2); ?></li>
                <?php if ($product->PRODISCOUNT > 0): ?>
                    <li>Discount - <?php echo htmlspecialchars($product->PRODISCOUNT); ?> % </li>
                    <li>Discounted Price - Br <?php echo number_format($product->PRODISPRICE, 2); ?> </li>
                <?php endif; ?>
                <li>Available Quantity - <?php echo htmlspecialchars($product->PROQTY); ?></li>
            </ul>
            <button type="submit" class="btn btn-pup btn-sm" name="btnorder">Order Now!</button>
        </div>
    </div>
    <!-- /.row -->
</form>
<?php
// Fetch related products with PDO
$sql_related = "SELECT * FROM tblpromopro pr
                JOIN tblproduct p ON pr.PROID = p.PROID
                JOIN tblcategory c ON p.CATEGID = c.CATEGID
                WHERE c.CATEGORIES = :category AND p.PROID != :proid
                LIMIT 4";
$stmt_related = $pdo->prepare($sql_related);
$stmt_related->execute([
    ':category' => $product->CATEGORIES,
    ':proid' => $product->PROID
]);
$related = $stmt_related->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Related Projects Row -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Related Products</h3>
    </div>
    <?php foreach ($related as $item): ?>
        <div class="col-sm-3 col-xs-6">
            <a href="index.php?q=single-item&id=<?php echo $item->PROID; ?>">
                <img class="img-hover img-related" width="135px" height="90px" src="<?php echo web_root . 'admin/products/' . htmlspecialchars($item->IMAGES); ?>" alt="">
            </a><br/>
            <a href="index.php?q=single-item&id=<?php echo $item->PROID; ?>"><b><?php echo htmlspecialchars($item->PRODESC); ?></b></a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>