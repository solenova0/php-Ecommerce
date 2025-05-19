<section id="cart_items">
    <div class="container">
      <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Shopping Cart</li>
        </ol>
      </div>
      <div class="table-responsive cart_info"> 
        <?php  
        check_message();  
        ?>
        <table class="table table-condensed" id="table">
          <thead>
            <tr class="cart_menu">
              <td>Product</td>
              <td>Description</td>
              <td width="15%">Price</td>
              <td width="15%">Quantity</td>
              <td width="15%">Total</td>
            </tr>
          </thead>
          <tbody>
            <?php
            global $pdo;
            if (!empty($_SESSION['gcCart'])) {
                echo '<script>totalprice()</script>';
                $count_cart = count($_SESSION['gcCart']);
                for ($i = 0; $i < $count_cart; $i++) {
                    $productid = $_SESSION['gcCart'][$i]['productid'];
                    $sql = "SELECT * FROM tblpromopro pr
                            JOIN tblproduct p ON pr.PROID = p.PROID
                            JOIN tblcategory c ON p.CATEGID = c.CATEGID
                            WHERE p.PROID = :productid";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':productid' => $productid]);
                    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result) {
            ?>
            <tr>
              <td>
                <img src="<?php echo web_root . 'admin/products/' . htmlspecialchars($result->IMAGES); ?>" onload="totalprice()" width="50" height="50"><br/>
                <?php
                if (isset($_SESSION['CUSID'])) {
                    echo '<a href="' . web_root . 'customer/controller.php?action=addwish&proid=' . htmlspecialchars($result->PROID) . '" title="Add to wishlist">Add to wishlist</a>';
                } else {
                    echo '<a href="#" title="Add to wishlist" class="proid" data-target="#smyModal" data-toggle="modal" data-id="' . htmlspecialchars($result->PROID) . '">Add to wishlist</a>';
                }
                ?>
              </td>
              <td><?php echo htmlspecialchars($result->PRODESC); ?></td>
              <td>
                <input type="hidden" id="PROPRICE<?php echo $result->PROID; ?>" name="PROPRICE<?php echo $result->PROID; ?>" value="<?php echo htmlspecialchars($result->PRODISPRICE); ?>">
                Br <?php echo htmlspecialchars($result->PRODISPRICE); ?>
              </td>
              <td class="input-group custom-search-form">
                <input type="hidden" maxlength="3" class="form-control input-sm" autocomplete="off" id="ORIGQTY<?php echo $result->PROID; ?>" name="ORIGQTY<?php echo $result->PROID; ?>" value="<?php echo htmlspecialchars($result->PROQTY); ?>">
                <input type="number" maxlength="3" data-id="<?php echo $result->PROID; ?>" class="QTY form-control input-sm" autocomplete="off" id="QTY<?php echo $result->PROID; ?>" name="QTY<?php echo $result->PROID; ?>" value="<?php echo htmlspecialchars($_SESSION['gcCart'][$i]['qty']); ?>">
                <span class="input-group-btn">
                  <a title="Remove Item" class="btn btn-danger btn-sm" id="btnsearch" name="btnsearch" href="cart/controller.php?action=delete&id=<?php echo htmlspecialchars($result->PROID); ?>">
                    <i class="fa fa-trash-o"></i>
                  </a>
                </span>
              </td>
              <input type="hidden" id="TOT<?php echo $result->PROID; ?>" name="TOT<?php echo $result->PROID; ?>" value="<?php echo htmlspecialchars($result->PRODISPRICE); ?>">
              <td>Br <output id="Osubtot<?php echo $result->PROID; ?>"><?php echo htmlspecialchars($_SESSION['gcCart'][$i]['price']); ?></output></td>
            </tr>
            <?php
                    }
                }
            } else {
                echo "<tr><td colspan='5'><h1>There is no item in the cart.</h1></td></tr>";
            }
            ?>
          </tbody>
        </table>
        <h3 align="right">Total Br <span id="sum">0</span></h3>
      </div>
    </div>
</section>
<section id="do_action">
    <div class="container">
      <div class="heading">
        <h3>What would you like to do next?</h3>
        <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
      </div>
      <div class="row">
        <form action="index.php?q=orderdetails" method="post">
          <a href="index.php?q=product" class="btn btn-default check_out pull-left">
            <i class="fa fa-arrow-left fa-fw"></i>
            Add New Order
          </a>
          <?php
          $countcart = isset($_SESSION['gcCart']) ? count($_SESSION['gcCart']) : 0;
          if ($countcart > 0) {
              if (isset($_SESSION['CUSID'])) {
                  echo '<button type="submit" name="proceed" id="proceed" class="btn btn-default check_out btn-pup pull-right">
                          Proceed And Checkout
                          <i class="fa fa-arrow-right fa-fw"></i>
                        </button>';
              } else {
                  echo '<a data-target="#smyModal" data-toggle="modal" class="btn btn-default check_out signup pull-right" href="">
                          Proceed And Checkout
                          <i class="fa fa-arrow-right fa-fw"></i>
                        </a>';
              }
          }
          ?>
        </form>
      </div>
    </div>
</section><!--/#do_action-->