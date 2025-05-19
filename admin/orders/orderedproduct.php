<?php

require_once ("../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."index.php");
}

if(isset($_POST['close'])){
    unset($_SESSION['ordernumber']);
}

if (isset($_POST['ordernumber'])){
    $_SESSION['ordernumber'] = $_POST['ordernumber'];
}

$ordernumber = $_SESSION['ordernumber'] ?? 0;

// Fetch summary and customer info
$stmt = $pdo->prepare("SELECT * FROM tblsummary s JOIN tblcustomer c ON s.CUSTOMERID = c.CUSTOMERID WHERE s.ORDEREDNUM = :ordernumber");
$stmt->execute([':ordernumber' => $ordernumber]);
$cur = $stmt->fetch(PDO::FETCH_OBJ);

if (!$cur) {
    echo "<div class='alert alert-danger'>Order not found.</div>";
    exit;
}

// Handle date formatting safely
$orderedDate = $cur->ORDEREDDATE ?? '';
$displayDate = 'N/A';
if ($orderedDate && $orderedDate !== '0000-00-00 00:00:00') {
    $dt = date_create($orderedDate);
    if ($dt) {
        $displayDate = date_format($dt, "M/d/Y h:i:s");
    }
}
?>

<div class="modal-dialog" style="width:70%">
<div class="modal-content">
    <div class="modal-header">
        <button class="close" id="btnclose" data-dismiss="modal" type="button">×</button>
        <h2>Order Number : <?= htmlspecialchars($ordernumber) ?></h2>
    </div>
    <div class="row" style="margin:2%">
        <div class="col-md-6">Name : <?= htmlspecialchars($cur->FNAME . ' ' . $cur->LNAME) ?></div>
        <div class="col-md-6">Address: <?= htmlspecialchars($cur->CUSHOMENUM . ' ' . $cur->STREETADD . ' ' . $cur->BRGYADD . ' ' . $cur->CITYADD . ' ' . $cur->PROVINCE . ' ' . $cur->COUNTRY) ?>
        </div>
    </div>

    <form action="controller.php?action=photos&id=<?= htmlspecialchars($cur->CUSTOMERID) ?>" enctype="multipart/form-data" method="post">
        <div class="modal-body">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>DESCRIPTION</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>TOTAL PRICE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $subtot = 0;
            $stmt = $pdo->prepare(
                "SELECT p.IMAGES, p.PRODESC, p.PROPRICE, o.ORDEREDQTY, o.ORDEREDPRICE, o.ORDEREDSTATS
                 FROM tblproduct p
                 JOIN tblcategory ct ON p.CATEGID = ct.CATEGID
                 JOIN tblorder o ON p.PROID = o.PROID
                 JOIN tblsummary s ON o.ORDEREDNUM = s.ORDEREDNUM
                 JOIN tblcustomer c ON s.CUSTOMERID = c.CUSTOMERID
                 WHERE o.ORDEREDNUM = :ordernumber"
            );
            $stmt->execute([':ordernumber' => $ordernumber]);
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($results as $result) {
                echo '<tr>';
                echo '<td><img src="'.web_root.'admin/products/'.htmlspecialchars($result->IMAGES).'" width="60" height="60" title="'.htmlspecialchars($result->PRODESC).'"/></td>';
                echo '<td>'.htmlspecialchars($result->PRODESC).'</td>';
                echo '<td>&#8369; '.number_format($result->PROPRICE,2).'</td>';
                echo '<td align="center">'.htmlspecialchars($result->ORDEREDQTY).'</td>';
                echo '<td>&#8369; <output>'.number_format($result->ORDEREDPRICE,2).'</output></td>';
                echo '<td id="status">'.htmlspecialchars($result->ORDEREDSTATS).'</td>';
                echo '</tr>';
                $subtot += $result->ORDEREDPRICE;
            }
            ?>
            </tbody>
        </table>
        <hr/>
        <div class="row">
            <div class="col-md-6 pull-left">
                <div>Ordered Date : <?= htmlspecialchars($displayDate) ?></div>
                <div>Payment Method : <?= htmlspecialchars($cur->PAYMENTMETHOD) ?></div>
            </div>
            <div class="col-md-6 pull-right">
                <p align="right">Total Price : &#8369; <?= number_format($subtot,2) ?></p>
                <p align="right">Delivery Fee : &#8369; <?= number_format($cur->DELFEE,2) ?></p>
                <p align="right">Overall Price : &#8369; <?= number_format($cur->PAYMENT,2) ?></p>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn_fixnmix" id="btnclose" data-dismiss="modal" type="button">Close</button>
        </div>
    </form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->