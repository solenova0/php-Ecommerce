<?php  
require_once("../include/initialize.php");

if (isset($_POST['updateid'])) {  
    echo '<script>totalprice();</script>';
    $max = count($_SESSION['fixnmix_cart']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['fixnmix_cart'][$i]['productid'];

        // Get updated quantity and price from POST
        $qty = isset($_POST['QTY' . $pid]) ? intval($_POST['QTY' . $pid]) : 0;
        $price = isset($_POST['TOT' . $pid]) ? floatval($_POST['TOT' . $pid]) : 0;

        // Fetch product info using PDO
        $sql = "SELECT * FROM `tblproducts` WHERE `PRODUCTID` = :pid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pid' => $pid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($row['PRICE'] < 500) {
                $fixedqty = round(500 / $row['PRICE']);
                if ($qty >= $fixedqty && $qty <= 999) {
                    $_SESSION['fixnmix_cart'][$i]['qty'] = $qty;
                    $_SESSION['fixnmix_cart'][$i]['price'] = $price;
                }
            } else {
                if ($qty > 0 && $qty <= 999) {
                    $_SESSION['fixnmix_cart'][$i]['qty'] = $qty;
                    $_SESSION['fixnmix_cart'][$i]['price'] = $price;
                }
            }
        }
    }
} else {
    echo '<script>totalprice();</script>';
    require_once('headnav.php'); 
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cart</title>
</head>
<body onload="totalprice()">
<div id="cart"> 
 <form action="" method="post">
  <div class="col-md-9"> 
  <?php check_message(); ?>
      <div class="">
        <div class="panel panel-default">
          <div class="panel-body">  
            <fieldset>  
              <legend><h2 class="text-left">Cart List</h2></legend>
          <div>Every product has a minimum price of Br 500.00 each to be able to order.</div>
      <div class="table-responsive">
       <div class="fixnmix_scroll_carttwo">
          <table class="table fixnmix-table" id="table">
             <thead>
               <tr>
                  <th width="5px">#</th>
                  <th>Product</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Action</th>
               </tr>
             </thead>  
             <tbody> 
               <?php 
              if (!empty($_SESSION['fixnmix_cart'])) { 
                echo '<script>totalprice();</script>';
                $count_cart = count($_SESSION['fixnmix_cart']);
                for ($i = 0; $i < $count_cart; $i++) { 
                    $query = "SELECT * FROM `tblproducts` p, `tblcategory` c 
                      WHERE p.`CATEGORYID` = c.`CATEGORYID` AND PRODUCTID = :pid";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([':pid' => $_SESSION['fixnmix_cart'][$i]['productid']]);
                    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result) { 
            ?>
                      <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><img src="<?php echo web_root . 'admin/modules/product/' . htmlspecialchars($result->IMAGES); ?>" width="50px" height="50px"></td>
                        <td><?php echo htmlspecialchars($result->PRODUCTNAME); ?></td>
                        <td>Br <?php echo number_format($result->PRICE, 2); ?></td>
                        <td>
                          <input type="number" data-id="<?php echo $result->PRODUCTID; ?>" class="cusqty" name="QTY<?php echo $result->PRODUCTID; ?>" id="QTY<?php echo $result->PRODUCTID; ?>" value="<?php echo $_SESSION['fixnmix_cart'][$i]['qty']; ?>"/>
                        </td>
                        <td>Br <output id="Osubtot<?php echo $result->PRODUCTID; ?>"><?php echo $_SESSION['fixnmix_cart'][$i]['price']; ?></output>
                          <!-- hidden textbox -->
                          <input type="hidden" name="TOT<?php echo $result->PRODUCTID; ?>" id="TOT<?php echo $result->PRODUCTID; ?>" value="<?php echo $_SESSION['fixnmix_cart'][$i]['price']; ?>"/>
                          <input type="hidden" name="PRICE<?php echo $result->PRODUCTID; ?>" id="PRICE<?php echo $result->PRODUCTID; ?>" value="<?php echo $_SESSION['fixnmix_cart'][$i]['price']; ?>"/>
                          <input type="hidden" name="originalPRICE<?php echo $result->PRODUCTID; ?>" id="originalPRICE<?php echo $result->PRODUCTID; ?>" value="<?php echo $result->PRICE; ?>"/>
                          <input type="hidden" name="originalqty<?php echo $result->PRODUCTID; ?>" id="originalqty<?php echo $result->PRODUCTID; ?>" value="<?php echo $result->QTY; ?>"/>
                        </td>
                        <td>
                          <a href="cart/controller.php?action=delete&id=<?php echo $result->PRODUCTID; ?>" data-id="<?php echo $result->PRODUCTID; ?>" class="delete btn btn-danger btn-xs">Remove</a>
                        </td>
                      </tr>
            <?php
                    }
                }
              }
            ?>
             </tbody>
          </table>
          </div>
          <table>
            <tfoot>
              <strong><h1 align="right">Total Price : Br <span style="margin-right:3%" id="sum">0.00</span></h1></strong>
            </tfoot>
          </table> 
        </div>
      </fieldset>
    </div>    
  </div>
</div>
<?php    
  echo '<form action="index.php?page=7" method="post">';
  echo '<a href="index.php?page=2" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>Add Another Products</strong></a>';
  $countcart = isset($_SESSION['fixnmix_cart']) ? count($_SESSION['fixnmix_cart']) : 0;
  if ($countcart > 0) {
    if (isset($_SESSION['cus_id'])) {  
      echo '<button type="submit" name="proceed" id="proceed" class="btn btn_fixnmix pull-right"><strong>Proceed And Checkout</strong><span class="glyphicon glyphicon-chevron-right"></span></button>';
    } else {
      echo '<button type="button" class="btn btn_fixnmix pull-right" data-target="#myModal" data-toggle="modal" name="btnorder"><strong>Proceed And Checkout</strong><span class="glyphicon glyphicon-chevron-right"></span></button>';
    } 
  }
  echo '</form>'; 
?>
</form>    

<?php
if (isset($_POST['updateid'])) {
    require_once('sidebar.php');
    echo '<script>totalprice();</script>';
    echo "</div>";
} else {
    echo '<script>totalprice();</script>';
    require_once('sidebar.php');
}
?>
</div>
<div class="modal fade" id="smyModal" tabindex="-1"></div>
<div class="modal fade" id="myModal" tabindex="-1">
  <div class="modal-dialog" style="width:50%">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal" type="button">×</button>
        <h4 class="modal-title" id="myModalLabel">Have already an account?</h4>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab">
          <li class="active"><a href="#home" data-toggle="tab">Login</a></li> 
          <li><a href="#settings" data-toggle="tab">Register</a></li>
        </ul>
        <div class="tab-content"> 
          <div class="tab-pane active" id="home">
            <form action="login.php" onsubmit="return validatepasswords()" method="post">
              <div class="modal-body">
                <div class="col-md-12">
                  <div class="form-group"> 
                    <label for="first_name">Username</label>
                    <input id="user_email" name="user_email" placeholder="Username" type="text" class="form-control input-sm"> 
                  </div>
                  <div class="form-group"> 
                    <label for="first_name">Password</label>
                    <input name="user_pass2" id="user_pass2" placeholder="Password" type="password" class="form-control">
                  </div>
                </div>
                <div class="modal-footer">
                  <p align="left">&copy; Fix N Mix Ordering System</p>
                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>  
                  <button class="btn btn_fixnmix" name="MbtnLogin" type="submit">Sign In</button>
                </div>
              </div>
            </form>
          </div><!--/tab-pane-->
          <div class="tab-pane" id="settings"><br/><br/>
            <form class="form-horizontal span6" action="customer/controller.php?action=add" onsubmit="return validatecustomer()" name="personal" method="POST" enctype="multipart/form-data">
              <?php 
                $autonum = New Autonumber();
                $res = $autonum->single_autonumber(1);
              ?> 
              <!-- Registration fields here (unchanged) -->
              <!-- ... -->
              <div class="modal-footer">
                <p align="left">&copy; Fix N Mix Ordering System</p>
                <button class="btn btn-default" data-dismiss="modal" type="button">Close</button> 
                <button type="submit" name="savecustomer" class="submit btn btn_fixnmix">Sign Up</button> 
              </div> 
            </form>
          </div>
        </div>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script language="javascript" type="text/javascript">
function OpenPopupCenter(pageURL, title, w, h) {
    var left = (screen.width - w) / 2;
    var top = (screen.height - h) / 4;
    var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
} 
</script>
</body>
</html>