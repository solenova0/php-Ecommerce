<?php
if (!isset($_SESSION['U_ROLE']) || $_SESSION['U_ROLE'] !== 'Administrator') {
    redirect(web_root . "admin/index.php");
} 

require_once("../../include/initialize.php");

// Initialize totals
$totAmount = 0;
$Capital = 0;
$totQty = 0;
$markupPrice = 0;
?>

<div class="row" style="margin:0;text-align:center;">
<form action="index.php" method="post">  
    <div class="col-lg-6"></div>
    <div class="col-lg-4"> 
        <div class="col-md-12"> 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-group"> 
                        <label>From:</label> 
                        <input type="date" name="date_pickerfrom" id="date_pickerfrom"
                               value="<?= htmlspecialchars($_POST['date_pickerfrom'] ?? '') ?>"
                               class="form-control input-sm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-group"> 
                        <label>To:</label> 
                        <input type="date" name="date_pickerto" id="date_pickerto"
                               value="<?= htmlspecialchars($_POST['date_pickerto'] ?? '') ?>"
                               class="form-control input-sm">
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-2">  
        <div class="row">
            <div class="col-md-12">
                <div class="form-group input-group" style="margin-top:25px;">  
                    <button class="btn btn-primary btn-sm" name="submit" type="submit">
                        Search <i class="fa fa-search"></i>
                    </button> 
                </div>
            </div>  
        </div> 
    </div>
</form>
</div>

<div class="row">
<span id="printout">
    <div class="col-md-12">
        <div class="page-header" style="text-align:center;">
            <h1>List of Ordered Products</h1>
            <div>
                Inclusive Dates: From : <?= htmlspecialchars($_POST['date_pickerfrom'] ?? '') ?> - To : <?= htmlspecialchars($_POST['date_pickerto'] ?? '') ?>
            </div>
        </div>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <table class="table table-bordered table-hover" align="center" cellspacing="10px">
                <thead>
                    <tr bgcolor="skyblue" style="font-weight: bold;"> 
                        <td>Date Ordered</td>  
                        <td>Product</td>
                        <td>Original Price</td>
                        <td>Price</td>
                        <td>Quantity</td> 
                        <td>Sub-total</td>
                    </tr>
                </thead>
                <tbody>
<?php
if (isset($_POST['submit']) && !empty($_POST['date_pickerfrom']) && !empty($_POST['date_pickerto'])) {
    $from = $_POST['date_pickerfrom'];
    $to = $_POST['date_pickerto'];

    // Use PDO for secure queries
    $query = "SELECT *, SUM(ORDEREDQTY) as QTY
              FROM tblproduct P
              JOIN tblpromopro PR ON P.PROID = PR.PROID
              JOIN tblorder O ON PR.PROID = O.PROID
              JOIN tblsummary S ON O.ORDEREDNUM = S.ORDEREDNUM
              JOIN tblcustomer C ON S.CUSTOMERID = C.CUSTOMERID
              WHERE DATE(ORDEREDDATE) >= :fromdate
                AND DATE(ORDEREDDATE) <= :todate
              GROUP BY PRODESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':fromdate' => $from,
        ':todate' => $to
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    if ($results) {
        foreach ($results as $result) {
            $AMOUNT = $result->PROPRICE * $result->QTY;
            echo '<tr>
                    <td>' . htmlspecialchars(date('M/d/Y h:i:s', strtotime($result->ORDEREDDATE))) . '</td>
                    <td>' . htmlspecialchars($result->PRODESC) . '</td>
                    <td>' . htmlspecialchars($result->ORIGINALPRICE) . '</td>
                    <td>' . htmlspecialchars($result->PROPRICE) . '</td>
                    <td>' . htmlspecialchars($result->QTY) . '</td>
                    <td>' . htmlspecialchars($AMOUNT) . '</td>
                  </tr>';
            $Capital += $result->ORIGINALPRICE;    
            $markupPrice += $result->PROPRICE;
            $totQty += $result->QTY;                 
            $totAmount += $AMOUNT;
        }
    } else {
        echo '<tr><td colspan="7" align="center"><h2>No records found for selected dates.</h2></td></tr>';
    }
} else {
    echo '<tr><td colspan="7" align="center"><h2>Please select both dates and click Search.</h2></td></tr>';
}
?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?= htmlspecialchars($Capital) ?></td>
                        <td><?= htmlspecialchars($markupPrice) ?></td>
                        <td><?= htmlspecialchars($totQty) ?></td>
                        <td><?= htmlspecialchars($totAmount) ?></td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</span>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">     
                <button onclick="tablePrint();" class="btn btn-primary"><i class="fa fa-print"></i> Print Report</button>
            </div>
        </div>
    </div>
</div>
   
<script>
function tablePrint(){  
    var display_setting="toolbar=no,location=no,directories=no,menubar=no,";  
    display_setting+="scrollbars=no,width=500, height=500, left=100, top=25";  
    var content_innerhtml = document.getElementById("printout").innerHTML;  
    var document_print=window.open("","",display_setting);  
    document_print.document.open();  
    document_print.document.write('<body style="font-family:Calibri(body);  font-size:8px;" onLoad="self.print();self.close();" >');  
    document_print.document.write(content_innerhtml);  
    document_print.document.write('</body></html>');  
    document_print.print();  
    document_print.document.close();  
    return false;  
}
$(document).ready(function() {
    $('#list').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
});
</script>