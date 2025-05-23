<?php

check_message();
?> 
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">List of Products  
            <a href="index.php?view=add" class="btn btn-primary btn-xs">
                <i class="fa fa-plus-circle fw-fa"></i> New
            </a>
        </h1>
    </div>
</div>
<form action="controller.php?action=delete" method="POST">  	
    <div class="table-responsive">				
        <table id="dash-table" class="table table-striped table-bordered table-hover" style="font-size:12px" cellspacing="0">
            <thead>
                <tr> 
                    <th width="1%">#</th>
                    <th width="50">Image</th>
                    <th>Product</th> 
                    <th>Description</th>
                    <th>Price</th>
                    <th>Discount%</th>  
                    <th>Discounted Price</th>  
                    <th>Quantity</th>  
                </tr>	
            </thead> 	
            <tbody>
                <?php 
                // Use PDO for product list
                $stmt = $pdo->prepare("SELECT * FROM tblpromopro pr 
                    JOIN tblproduct p ON pr.PROID = p.PROID 
                    JOIN tblcategory c ON p.CATEGID = c.CATEGID");
                $stmt->execute();
                $cur = $stmt->fetchAll(PDO::FETCH_OBJ);

                foreach ($cur as $result) { 
                    echo '<tr>';
                    echo '<td width="1%" align="center"><input type="checkbox" name="selector[]" id="selector[]" value="' . htmlspecialchars($result->PROID) . '"/></td>';
                    echo '<td style="padding:0px;">
                        <a class="PROID" href="" data-target="#productmodal" data-toggle="modal" data-id="' . htmlspecialchars($result->PROID) . '"> 
                        <img title="' . htmlspecialchars($result->CATEGORIES) . '" style="width:100px;height:50px;padding:0;" src="' . web_root . 'admin/products/' . htmlspecialchars($result->IMAGES) . '">
                        </a></td>'; 	
                    echo '<td><a title="edit" href="' . web_root . 'admin/products/index.php?view=edit&id=' . htmlspecialchars($result->PROID) . '"><i class="fa fa-pencil "></i>' . htmlspecialchars($result->CATEGORIES) . '</a></td>';
                    echo '<td>' . htmlspecialchars($result->PRODESC) . '</td>'; 
                    echo '<td> Br ' . number_format($result->PROPRICE, 2) . '</td>';
                    echo '<td> ' . number_format($result->PRODISCOUNT, 0) . '%</td>';
                    echo '<td> Br ' . number_format($result->PRODISPRICE, 2) . '</td>';
                    echo '<td width="4%">' . htmlspecialchars($result->PROQTY) . '</td>';
                    echo '</tr>';
                } 
                ?>
            </tbody>
        </table>
        <div class="btn-group">
            <button type="submit" class="btn btn-default" name="delete"><i class="fa fa-trash fw-fa"></i> Delete Selected</button>
        </div>
    </div>
</form>

<div class="modal fade" id="productmodal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">Image.</h4>
            </div>
            <form action="<?php echo web_root; ?>admin/products/controller.php?action=photos" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="rows">
                            <div class="col-md-12">
                                <div class="rows">
                                    <div class="col-md-8">
                                        <input class="proid" type="hidden" name="proid" id="proid" value="">
                                        <input name="MAX_FILE_SIZE" type="hidden" value="1000000">
                                        <input id="photo" name="photo" type="file">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-primary" name="savephoto" type="submit">Upload Photo</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->