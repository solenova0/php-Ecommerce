<section id="advertisement">
    <div class="container">
      <img src="images/shop/advertisement.jpg" alt="" />
    </div>
</section>

<section>
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
         <?php include 'sidebar.php'; ?>
        </div><!--/category-productsr-->  

        <div class="col-sm-9 padding-right">
          <div class="features_items"><!--features_items-->
            <h2 class="title text-center">Products</h2>
            <?php
            global $pdo;

            if (isset($_POST['search'])) {
                $search = '%' . $_POST['search'] . '%';
                $sql = "SELECT * FROM tblpromopro pr
                        JOIN tblproduct p ON pr.PROID = p.PROID
                        JOIN tblcategory c ON p.CATEGID = c.CATEGID
                        WHERE p.PROQTY > 0 AND (
                            c.CATEGORIES LIKE :search OR
                            p.PRODESC LIKE :search OR
                            p.PROQTY LIKE :search OR
                            p.PROPRICE LIKE :search
                        )";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':search' => $search]);
            } elseif (isset($_GET['category'])) {
                $sql = "SELECT * FROM tblpromopro pr
                        JOIN tblproduct p ON pr.PROID = p.PROID
                        JOIN tblcategory c ON p.CATEGID = c.CATEGID
                        WHERE p.PROQTY > 0 AND c.CATEGORIES = :category";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':category' => $_GET['category']]);
            } else {
                $sql = "SELECT * FROM tblpromopro pr
                        JOIN tblproduct p ON pr.PROID = p.PROID
                        JOIN tblcategory c ON p.CATEGID = c.CATEGID
                        WHERE p.PROQTY > 0";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }

            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            if ($results) {
                foreach ($results as $result) {
            ?>
            <form method="POST" action="cart/controller.php?action=add">
                <input type="hidden" name="PROPRICE" value="<?php echo htmlspecialchars($result->PROPRICE); ?>">
                <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo htmlspecialchars($result->PROQTY); ?>">
                <input type="hidden" name="PROID" value="<?php echo htmlspecialchars($result->PROID); ?>">
                <div class="col-sm-4">
                  <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                          <img src="<?php echo web_root . 'admin/products/' . htmlspecialchars($result->IMAGES); ?>" alt="" />
                          <h2>Br <?php echo htmlspecialchars($result->PRODISPRICE); ?></h2>
                          <p><?php echo htmlspecialchars($result->PRODESC); ?></p>
                          <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                        </div>
                        <div class="product-overlay">
                          <div class="overlay-content">
                            <h2>Br <?php echo htmlspecialchars($result->PRODISPRICE); ?></h2>
                            <p><?php echo htmlspecialchars($result->PRODESC); ?></p>
                            <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                          </div>
                        </div>
                    </div>
                    <div class="choose">
                      <ul class="nav nav-pills nav-justified">
                        <li>
                        <?php
                        if (isset($_SESSION['CUSID'])) {
                            echo '<a href="' . web_root . 'customer/controller.php?action=addwish&proid=' . htmlspecialchars($result->PROID) . '" title="Add to wishlist"><i class="fa fa-plus-square"></i>Add to wishlist</a>';
                        } else {
                            echo '<a href="#" title="Add to wishlist" class="proid" data-target="#smyModal" data-toggle="modal" data-id="' . htmlspecialchars($result->PROID) . '"><i class="fa fa-plus-square"></i>Add to wishlist</a>';
                        }
                        ?>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </form>
            <?php
                }
            } else {
                echo '<h1>No Products Available</h1>';
            }
            ?>
          </div><!--features_items-->
        </div>
      </div>
    </div>
</section>