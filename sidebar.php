<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        <?php
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM `tblcategory`");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($categories as $result) {
            echo '<div class="categ panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="index.php?q=product&amp;category=' . htmlspecialchars($result->CATEGORIES) . '">' . htmlspecialchars($result->CATEGORIES) . '</a>
                        </h4>
                    </div>
                  </div>';
        }
        ?>
    </div><!--/category-products-->

    <div class="shipping text-center"><!--shipping-->
        <img src="images/home/shipping.jpg" alt="" />
    </div><!--/shipping-->
</div>