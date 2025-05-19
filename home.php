<section id="slider"><!--slider-->
    <!-- ...slider code unchanged... -->
</section><!--/slider-->

<section>
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-sm-9 padding-right">
          <div class="features_items"><!--features_items-->
            <h2 class="title text-center">Features Items</h2>
            <?php
            global $pdo;
            $sql = "SELECT * FROM tblpromopro pr
                    JOIN tblproduct p ON pr.PROID = p.PROID
                    JOIN tblcategory c ON p.CATEGID = c.CATEGID
                    WHERE p.PROQTY > 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($results as $result): ?>
                <form method="POST" action="cart/controller.php?action=add">
                    <input type="hidden" name="PROPRICE" value="<?php echo htmlspecialchars($result->PROPRICE); ?>">
                    <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo htmlspecialchars($result->PROQTY); ?>">
                    <input type="hidden" name="PROID" value="<?php echo htmlspecialchars($result->PROID); ?>">
                    <div class="col-sm-4">
                      <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                              <img src="<?php echo web_root . 'admin/products/' . htmlspecialchars($result->IMAGES); ?>" alt="" />
                              <h2>$<?php echo htmlspecialchars($result->PRODISPRICE); ?></h2>
                              <p><?php echo htmlspecialchars($result->PRODESC); ?></p>
                              <button type="submit" name="btnorder" class="btn add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                            <div class="product-overlay">
                              <div class="overlay-content">
                                <h3>$<?php echo htmlspecialchars($result->PRODISPRICE); ?></h3>
                                <p><?php echo htmlspecialchars($result->PRODESC); ?></p>
                                <button type="submit" name="btnorder" class="add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                              </div>
                            </div>
                        </div>
                        <div class="choose">
                          <ul class="nav nav-pills nav-justified">
                            <li>
                              <?php
                              if (isset($_SESSION['CUSID'])) {
                                  echo '<a href="' . web_root . 'customer/controller.php?action=addwish&proid=' . htmlspecialchars($result->PROID) . '" title="Add to wishlist" class="btn btn-danger"><i class="fa fa-plus-square"></i>Add to wishlist</a>';
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
            <?php endforeach; ?>
          </div><!--features_items-->

          <div class="recommended_items"><!--recommended_items-->
            <h2 class="title text-center">Recommended Items</h2>
            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="item active">
                  <?php
                  $sql = "SELECT * FROM tblpromopro pr
                          JOIN tblproduct p ON pr.PROID = p.PROID
                          JOIN tblcategory c ON p.CATEGID = c.CATEGID
                          WHERE p.PROQTY > 0 LIMIT 3";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $results = $stmt->fetchAll(PDO::FETCH_OBJ);

                  foreach ($results as $result): ?>
                    <form method="POST" action="cart/controller.php?action=add">
                        <input type="hidden" name="PROPRICE" value="<?php echo htmlspecialchars($result->PROPRICE); ?>">
                        <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo htmlspecialchars($result->PROQTY); ?>">
                        <input type="hidden" name="PROID" value="<?php echo htmlspecialchars($result->PROID); ?>">
                        <div class="col-sm-4">
                          <div class="product-image-wrapper">
                            <div class="single-products">
                              <div class="productinfo text-center">
                                <img src="<?php echo web_root . 'admin/products/' . htmlspecialchars($result->IMAGES); ?>" alt="" />
                                <h2>$<?php echo htmlspecialchars($result->PRODISPRICE); ?></h2>
                                <p><?php echo htmlspecialchars($result->PRODESC); ?></p>
                                <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                  <?php endforeach; ?>
                </div>
                <div class="item">
                  <?php
                  $sql = "SELECT * FROM tblpromopro pr
                          JOIN tblproduct p ON pr.PROID = p.PROID
                          JOIN tblcategory c ON p.CATEGID = c.CATEGID
                          WHERE p.PROQTY > 0 LIMIT 3,6";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute();
                  $results = $stmt->fetchAll(PDO::FETCH_OBJ);

                  foreach ($results as $result): ?>
                    <form method="POST" action="cart/controller.php?action=add">
                        <input type="hidden" name="PROPRICE" value="<?php echo htmlspecialchars($result->PROPRICE); ?>">
                        <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo htmlspecialchars($result->PROQTY); ?>">
                        <input type="hidden" name="PROID" value="<?php echo htmlspecialchars($result->PROID); ?>">
                        <div class="col-sm-4">
                          <div class="product-image-wrapper">
                            <div class="single-products">
                              <div class="productinfo text-center">
                                <img src="<?php echo web_root . 'admin/products/' . htmlspecialchars($result->IMAGES); ?>" alt="" />
                                <h2>$<?php echo htmlspecialchars($result->PRODISPRICE); ?></h2>
                                <p><?php echo htmlspecialchars($result->PRODESC); ?></p>
                                <button type="submit" name="btnorder" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                  <?php endforeach; ?>
                </div>
              </div>
              <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
              </a>
              <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
              </a>
            </div>
          </div><!--/recommended_items-->
        </div>
      </div>
    </div>
</section>