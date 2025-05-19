<?php
if (!isset($_SESSION['USERID'])){
    redirect(web_root."index.php");
}

$PROID = $_GET['id'];
$product = new Product();
$singleproduct = $product->single_product($PROID);

// Ensure $singleproduct is an object
if (is_array($singleproduct)) {
    $singleproduct = (object)$singleproduct;
}

$category = new Category();
$singlecategory = $category->single_category($singleproduct->CATEGID ?? null);

// Ensure $singlecategory is an object
if (is_array($singlecategory)) {
    $singlecategory = (object)$singlecategory;
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Update Product</h1>
    </div>
</div>
<form class="form-horizontal span6" action="controller.php?action=edit" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="OWNERNAME">Owner:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" id="OWNERNAME" name="OWNERNAME" placeholder="Owner Name" type="text" value="<?= isset($singleproduct->OWNERNAME) ? htmlspecialchars($singleproduct->OWNERNAME) : '' ?>">
                </div>
            </div>
        </div>  

        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="OWNERPHONE">Phone:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" id="OWNERPHONE" name="OWNERPHONE" placeholder="+25190000000" type="number" value="<?= isset($singleproduct->OWNERPHONE) ? htmlspecialchars($singleproduct->OWNERPHONE) : '' ?>">
                </div>
            </div>
        </div> 

        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="PRODESC">Description:</label>
                <div class="col-md-8"> 
                    <input id="PROID" name="PROID" type="hidden" value="<?= isset($singleproduct->PROID) ? htmlspecialchars($singleproduct->PROID) : '' ?>">
                    <textarea class="form-control input-sm" id="PRODESC" name="PRODESC" cols="1" rows="3"><?= isset($singleproduct->PRODESC) ? htmlspecialchars($singleproduct->PRODESC) : '' ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="CATEGORY">Category:</label>
                <div class="col-md-8">
                    <select class="form-control input-sm" name="CATEGORY" id="CATEGORY">
                        <option value="None">Select Category</option>
                        <?php
                        // PDO for category list
                        $stmt = $pdo->prepare("SELECT * FROM tblcategory");
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                        foreach ($categories as $cat) {
                            $selected = (isset($singlecategory->CATEGID) && $cat->CATEGID == $singlecategory->CATEGID) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($cat->CATEGID) . '" ' . $selected . '>' . htmlspecialchars($cat->CATEGORIES) . '</option>';
                        }
                        ?>
                    </select> 
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="ORIGINALPRICE">Original Price:</label>
                <div class="col-md-3">
                    <input class="form-control input-sm" id="ORIGINALPRICE" name="ORIGINALPRICE" placeholder="Original Price (Birr)" type="number" step="any" value="<?= isset($singleproduct->ORIGINALPRICE) ? htmlspecialchars($singleproduct->ORIGINALPRICE) : '' ?>">
                </div>
                <label class="col-md-2 control-label" for="PROPRICE">Price:</label>
                <div class="col-md-3">
                    <input class="form-control input-sm" id="PROPRICE" name="PROPRICE" placeholder="Birr" type="number" step="any" value="<?= isset($singleproduct->PROPRICE) ? htmlspecialchars($singleproduct->PROPRICE) : '' ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="PROQTY">Quantity:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" id="PROQTY" name="PROQTY" placeholder="Quantity" type="number" value="<?= isset($singleproduct->PROQTY) ? htmlspecialchars($singleproduct->PROQTY) : '' ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8">
                <label class="col-md-4 control-label" for="idno"></label>
                <div class="col-md-8">
                    <button class="btn btn-primary btn-sm" name="save" type="submit"><span class="fa fa-save fw-fa"></span> Save</button>
                </div>
            </div>
        </div> 
    </div>
</form>