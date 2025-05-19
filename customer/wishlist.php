
<h3>Wish List</h3>  
<form method="POST" action="<?php echo web_root ; ?>cart/controller.php?action=add">           
    <table id="example" class="table" style="font-size:12px" cellspacing="0"> 
        <tbody>
            <?php 
                // Use PDO directly
                global $pdo;
                $sql = "SELECT * FROM `tblproduct` P 
                        JOIN `tblwishlist` W ON P.`PROID`=W.`PROID`
                        JOIN `tblcustomer` C ON W.`CUSID`=C.`CUSTOMERID`
                        JOIN `tblpromopro` PR ON P.`PROID`=PR.`PROID`
                        JOIN `tblcategory` CT ON P.`CATEGID`=CT.`CATEGID`
                        WHERE WISHSTATS=0 AND C.`CUSTOMERID`=:cusid
                        ORDER BY `WISHDATE` DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':cusid' => $_SESSION['CUSID']]);
                $cur = $stmt->fetchAll(PDO::FETCH_OBJ);

                foreach ($cur as $result) { 
            ?>
            <tr>
                <td>
                    <img alt="" style="width:300px; height:200px;" title="" class="img-reponsive img-thumbnail isTooltip" src="<?php echo web_root.'admin/products/'. htmlspecialchars($result->IMAGES); ?>" data-original-title="Usuario"> 
                </td>
                <td>
                    <p><h4>Date added: <?php echo date_format(date_create($result->WISHDATE),"M/d/Y h:i:s"); ?></h4></p>
                    <p><h2><?php echo htmlspecialchars($result->CATEGORIES); ?></h2></p> 
                    <p><h4>Product Description</h4></p>
                    <ul> 
                        <li><?php echo htmlspecialchars($result->PRODESC); ?></li> 
                    </ul>
                    <p><h5>Price : Br <?php echo htmlspecialchars($result->PROPRICE); ?></h5></p>
                    <?php if ($result->PRODISCOUNT > 0) { ?>
                        <p><h5>Discount : <?php echo htmlspecialchars($result->PRODISCOUNT); ?>%</h5></p>
                        <p><h5>Discounted Price : Br <?php echo htmlspecialchars($result->PRODISPRICE); ?></h5></p> 
                    <?php } ?>
                    <input type="hidden" name="PROPRICE" value="<?php echo htmlspecialchars($result->PRODISPRICE); ?>">
                    <input type="hidden" name="PROID" value="<?php echo htmlspecialchars($result->PROID); ?>">
                    <button type="submit" class="btn btn-primary btn-sm" name="btnorder">Order Now!</button>
                    <a href="<?php echo web_root ; ?>customer/controller.php?action=wishlist&wishid=<?php echo $result->WISHID; ?>" class="btn btn-info btn-sm" data-toggle="lightbox">
                        <i class="fa fa-trash-o fa-fw" data-toggle="tooltip" data-placement="left" title="Remove"></i>  
                    </a>
                </td>
            </tr>
            <?php 
                }
            ?>
        </tbody>
    </table>
</form>