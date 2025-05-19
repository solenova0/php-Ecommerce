<?php
if (!isset($_SESSION['TYPE']) || $_SESSION['TYPE'] !== 'Administrator') {
    redirect(web_root . "index.php");
}

if (isset($_GET['fname'])) {
    $_SESSION['FIRSTNAME'] = $_GET['fname'];
    $_SESSION['LASTNAME'] = $_GET['lname'];
    $_SESSION['ADDRESS'] = $_GET['address'];
    $_SESSION['CONTACTNUMBER'] = $_GET['contact'];
    $_SESSION['CUSTOMERID'] = $_GET['CUSTOMERID'];
    $_SESSION['paymethod'] = 'Cash on Pickup';
    $_SESSION['ORDERNUMBER'] = $_GET['ORDERNUMBER'];
    $_SESSION['alltot'] = $_GET['alltot'];
    redirect('controller.php?action=processorder');
}
?>
<div class="container">
    <div class="">
        <div class="panel panel-default">
            <div class="panel-body">
                <fieldset>
                    <legend><h2 class="text-left">Order Details</h2></legend>
                    <table class="fixnmix-table">
                        <tbody>
                            <tr>
                                <td width="100px">First Name </td>
                                <td width="350px">
                                    <input id="FIRSTNAME" name="FIRSTNAME" class="form-control input-sm" type="text" value="<?= htmlspecialchars($_SESSION['FIRSTNAME'] ?? "") ?>">
                                </td>
                                <td width="100px">Last Name</td>
                                <td>
                                    <input id="LASTNAME" name="LASTNAME" class="form-control input-sm" type="text" value="<?= htmlspecialchars($_SESSION['LASTNAME'] ?? "") ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Address </td>
                                <td>
                                    <input id="ADDRESS" name="ADDRESS" class="form-control input-sm" type="text" value="<?= htmlspecialchars($_SESSION['ADDRESS'] ?? "") ?>">
                                </td>
                                <td width="100px">Contact Number</td>
                                <td width="350px">
                                    <input id="CONTACTNUMBER" name="CONTACTNUMBER" class="form-control input-sm" type="number" value="<?= htmlspecialchars($_SESSION['CONTACTNUMBER'] ?? "") ?>">
                                </td>
                            </tr>
                        </tbody>
                        <tfoot><tr><td></td></tr></tfoot>
                    </table>

                    <table class="fixnmix-table" id="table">
                        <thead>
                            <tr>
                                <th width="10">#</th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th style="width:100px">Price</th>
                                <th style="width:120px">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($_SESSION['fixnmix_cart'])) {
                            $count_cart = count($_SESSION['fixnmix_cart']);
                            for ($i = 0; $i < $count_cart; $i++) {
                                $productid = $_SESSION['fixnmix_cart'][$i]['productid'];
                                $stmt = $pdo->prepare("SELECT * FROM tblproducts p JOIN tblcategory c ON p.CATEGORYID = c.CATEGORYID WHERE p.PRODUCTID = :productid");
                                $stmt->execute([':productid' => $productid]);
                                $cur = $stmt->fetchAll(PDO::FETCH_OBJ);
                                foreach ($cur as $result) {
                                    ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td>
                                            <img src="<?= web_root . 'admin/modules/product/' . htmlspecialchars($result->IMAGES) ?>" onload="totalprice()" width="50px" height="50px">
                                        </td>
                                        <td><?= htmlspecialchars($result->PRODUCTNAME) ?></td>
                                        <td><?= htmlspecialchars($_SESSION['fixnmix_cart'][$i]['qty']) ?></td>
                                        <td>&#8369; <?= number_format($result->PRICE, 2) ?></td>
                                        <td>&#8369; <output><?= number_format($_SESSION['fixnmix_cart'][$i]['price'], 2) ?></output></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                    <div class="container">
                        <div class="row">
                            <h3 align="right" style="margin-right:20%">Total Price : &#8369; <span id="sum">0.00</span></h3>
                        </div>
                    </div>

                    <?php
                    $autonum = new Autonumber();
                    $res = $autonum->single_autonumber(1);
                    ?>
                    <input id="CUSTOMERID" name="CUSTOMERID" type="hidden" value="<?= htmlspecialchars($res->AUTO) ?>">
                    <?php
                    $autonum = new Autonumber();
                    $res = $autonum->single_autonumber(3);
                    ?>
                    <input id="ORDERNUMBER" name="ORDERNUMBER" type="hidden" value="<?= htmlspecialchars($res->AUTO) ?>">
                    <a href="index.php?view=addtocart" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>View Cart</strong>
                    </a>
                    <button name="submitorder" id="submitorder" class="btn btn_fixnmix pull-right" onclick="validatedate()">
                        <strong>Save Order</strong> <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                </fieldset>
            </div>
        </div>
    </div>
</div>