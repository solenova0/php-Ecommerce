<?php
require_once("include/initialize.php");

if (isset($_POST['close']) && $_POST['close'] === 'close') {
    unset($_SESSION['PROID']);
    redirect(web_root . 'index.php');
    exit;
}

if (isset($_POST['PROID'])) {
    $_SESSION['PROID'] = $_POST['PROID'];
}

$PROID = $_SESSION['PROID'] ?? null;

if ($PROID) {
    global $pdo;
    $sql = "SELECT * FROM tblpromopro pr
            JOIN tblproduct p ON pr.PROID = p.PROID
            JOIN tblcategory c ON p.CATEGID = c.CATEGID
            WHERE p.PROID = :proid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':proid' => $PROID]);
    $cur = $stmt->fetch(PDO::FETCH_OBJ);
} else {
    $cur = null;
}
?>

<?php if ($cur): ?>
<div class="modal-dialog" style="width:50%">
  <div class="modal-content">
    <button class="close" data-dismiss="modal" type="button">×</button>
    <form method="POST" action="cart/controller.php?action=add">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <img width="230" height="220" src="<?php echo web_root . 'admin/products/' . $cur->IMAGES; ?>" alt="">
          </div>
          <div class="col-md-6">
            <input type="hidden" name="PROPRICE" value="<?php echo $cur->PROPRICE; ?>">
            <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $cur->PROQTY; ?>">
            <input type="hidden" name="PROID" value="<?php echo $cur->PROID; ?>">
            <p><?php echo htmlspecialchars($cur->CATEGORIES); ?></p>
            <ul>
              <li>Type - <?php echo htmlspecialchars($cur->PRODESC); ?></li>
              <li>Price - Br <?php echo number_format($cur->PROPRICE, 2); ?></li>
              <?php if ($cur->PRODISCOUNT > 0): ?>
                <li>Discount - <?php echo $cur->PRODISCOUNT; ?> %</li>
                <li>Discounted Price - Br <?php echo number_format($cur->PRODISPRICE, 2); ?></li>
              <?php endif; ?>
              <li>Available Quantity - <?php echo $cur->PROQTY; ?></li>
            </ul>
            <button class="btn btn-pup" name="btnorder" type="submit">Order Now!</button>
            <button class="btn btn-default" id="btn_close" data-dismiss="modal" type="button">Close</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>