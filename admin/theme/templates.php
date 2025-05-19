<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?= htmlspecialchars($title) ?></title>

<!-- Bootstrap Core CSS -->
<link href="<?= web_root; ?>admin/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= web_root; ?>admin/css/metisMenu.min.css" rel="stylesheet">
<link href="<?= web_root; ?>admin/css/timeline.css" rel="stylesheet">
<link href="<?= web_root; ?>admin/css/sb-admin-2.css" rel="stylesheet">
<link href="<?= web_root; ?>admin/font/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?= web_root; ?>admin/font/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?= web_root; ?>admin/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?= web_root; ?>admin/css/costum.css" rel="stylesheet">
<link href="<?= web_root; ?>admin/css/ekko-lightbox.css" rel="stylesheet">
</head>

<?php
admin_confirm_logged_in();

// PDO query for pending orders
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tblsummary WHERE ORDEREDSTATS = 'Pending'");
$stmt->execute();
$res = $stmt->fetchColumn();
$order = $res > 0 ? '<span style="color:red;">('.$res.')</span>' : '<span> ('.$res.')</span>';
?>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= web_root; ?>admin/index.php">E-Commerce Web Admin Dashboard</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-plus fa-fw"></i> New  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?= web_root; ?>admin/products/index.php?view=add"><i class="fa fa-barcode fa-fw"></i> Product</a></li>
                    <li><a href="<?= web_root; ?>admin/category/index.php?view=add"><i class="fa fa-list-alt  fa-fw"></i> Category</a></li>
                    <?php if ($_SESSION['U_ROLE']=='Administrator') { ?>
                    <li><a href="<?= web_root; ?>admin/user/index.php?view=add"><i class="fa fa-user  fa-fw"></i> User</a></li>
                    <?php }?>
                </ul>
            </li>
<?php
$user = new User();
$singleuser = $user->single_user($_SESSION['USERID']);
?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Hello, <?= htmlspecialchars($_SESSION['U_NAME']) ?>
                    <img title="profile image" width="23" height="17" src="<?= web_root.'admin/user/'.htmlspecialchars($singleuser->USERIMAGE) ?>">
                </a>
                <ul class="dropdown-menu dropdown-acnt">
                    <div class="divpic">
                        <a href="#" data-target="#usermodal" data-toggle="modal">
                            <img title="profile image" width="70" height="80" src="<?= web_root.'admin/user/'.htmlspecialchars($singleuser->USERIMAGE) ?>">
                        </a>
                    </div>
                    <div class="divtxt">
                        <li><a href="<?= web_root; ?>admin/user/index.php?view=edit&id=<?= $_SESSION['USERID']; ?>"> <?= htmlspecialchars($_SESSION['U_NAME']); ?> </a>
                        <li><a title="Edit" href="<?= web_root; ?>admin/user/index.php?view=edit&id=<?= $_SESSION['USERID']; ?>">Edit My Profile</a></li>
                        <li><a href="<?= web_root; ?>admin/logout.php"><i class="fa fa-sign-out fa-fw"></i> Log Out</a></li>
                    </div>
                </ul>
            </li>
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?= web_root; ?>admin/products/index.php"><i class="fa fa-barcode fa-fw"></i>Products </a>
                    </li>
                    <li>
                        <a href="<?= web_root; ?>admin/orders/index.php" ><i class="fa fa-reorder fa-fw"></i>  Orders <?= $order; ?></a>
                    </li>
                    <li>
                        <a href="<?= web_root; ?>admin/category/index.php" ><i class="fa fa-list-alt fa-fw"></i>  Categories </a>
                    </li>
                    <?php if ($_SESSION['U_ROLE']=='Administrator') { ?>
                   
                    <li>
                        <a href="<?= web_root; ?>admin/user/index.php" ><i class="fa fa-user fa-fw"></i> Users </a>
                    </li>
                    <li>
                        <a href="<?= web_root; ?>admin/report/index.php" ><i class="fa  fa-file-text fa-fw"></i> Report </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="usermodal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title" id="myModalLabel">Profile Image.</h4>
                </div>
                <form action="<?= web_root; ?>admin/user/controller.php?action=photos" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="rows">
                                <div class="col-md-12">
                                    <div class="rows">
                                        <img title="profile image" width="500" height="360" src="<?= web_root.'admin/user/'.htmlspecialchars($singleuser->USERIMAGE) ?>">
                                    </div>
                                </div><br/>
                                <div class="col-md-12">
                                    <div class="rows">
                                        <div class="col-md-8">
                                            <input type="hidden" name="MIDNO" id="MIDNO" value="<?= $_SESSION['USERID']; ?>">
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

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php 
                if ($title !== 'Dashboard'){
                    echo '<p class="breadcrumb" style="margin-top: 8px;">
                        <a href="index.php" title="'. htmlspecialchars($title) .'" >'. htmlspecialchars($title) .'</a>
                        '.(isset($header) ? ' / '. htmlspecialchars($header) : '').'  </p>'  ;
                } ?>
                <?php check_message(); ?>
                <?php require_once $content; ?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="<?= web_root; ?>admin/jquery/jquery.min.js"></script>
<script src="<?= web_root; ?>admin/js/bootstrap.min.js"></script>
<script src="<?= web_root; ?>admin/js/metisMenu.min.js"></script>
<script src="<?= web_root; ?>admin/js/jquery.dataTables.min.js"></script>
<script src="<?= web_root; ?>admin/js/dataTables.bootstrap.min.js"></script>
<script src="<?= web_root; ?>admin/js/ekko-lightbox.js"></script>
<script src="<?= web_root; ?>admin/js/sb-admin-2.js"></script>
<script type="text/javascript" language="javascript" src="<?= web_root; ?>admin/js/janobe.js"></script>

<script type="text/javascript">
$(document).on("click", ".PROID", function () {
    var proid = $(this).data('id')
    $(".modal-body #proid").val(proid)
});

$(document).ready(function() {
    var t = $('#example').DataTable({
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[6, 'desc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();

    $('#dash-table').DataTable({
        responsive: true,
        "sort": false
    });
});
</script>

</body>
</html>