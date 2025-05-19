<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ecommerce</title>
    <link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo web_root; ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo web_root; ?>css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo web_root; ?>css/price-range.css" rel="stylesheet">
    <link href="<?php echo web_root; ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo web_root; ?>css/main.css" rel="stylesheet">
    <link href="<?php echo web_root; ?>css/responsive.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo web_root; ?>images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo web_root; ?>images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo web_root; ?>images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo web_root; ?>images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo web_root; ?>images/ico/apple-touch-icon-57-precomposed.png">
</head>

<body style="background-color:white" onload="totalprice()">

  <header id="header">
    <div class="header_top" style="background: linear-gradient(to bottom, #993366 0%, #660066 100%);">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="contactinfo">
              <ul class="nav nav-pills">
                <div style="text-align: center; background-color: #f8f8f8; padding: 10px; font-size: 16px; font-weight: bold;">
                🎉 Free Shipping on Orders Over <b>Br 2500</b>! | 
                 <i class="fa fa-phone" style="color:#337ab7;"></i>
                 <a href="tel:+2519000001" style="color:#337ab7; text-decoration:underline; font-weight:bold;">
                 +2519000001
                </a>
              <span style="color:#333;">Call us now for exclusive deals!</span>
             </div>
           </ul>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="social-icons pull-right">
              <ul class="nav navbar-nav">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header-middle">
      <div class="container">
        <div class="row">
          <div class="col-md-4 clearfix">
            <div class="logo pull-left">
              <a href="<?php echo web_root; ?>"><img src="<?php echo web_root; ?>images/home/logos.png" alt="" /></a>
            </div>
          </div>
          <div class="col-md-8 clearfix">
            <div class="shop-menu clearfix pull-right">
              <ul class="nav navbar-nav">
                <li><a href="<?php echo web_root; ?>index.php?q=cart"><i class="text-success fa fa-shopping-cart"></i> Cart</a></li>
                <?php if (isset($_SESSION['CUSID'])) { ?>
                  <li><a href="<?php echo web_root; ?>index.php?q=profile"><i class="fa fa-user"></i> Account</a></li>
                  <li><a href="<?php echo web_root; ?>logout.php"><i class="fa fa-lock"></i> Logout</a></li>
                <?php } else { ?>
                  <li><a data-target="#smyModal" data-toggle="modal" href=""><i class="fa fa-lock"></i> Login</a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-9">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="mainmenu pull-left">
              <ul class="nav navbar-nav collapse navbar-collapse">
                <li><a href="<?php echo web_root; ?>" class="active"><i class="fa fa-home"></i> Home</a></li>
                <li class="dropdown"><a href="#"><i class="fa fa-shopping-cart"></i> Shop<i class="fa fa-angle-down"></i></a>
                  <ul role="menu" class="sub-menu">
                    <?php
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM `tblcategory`");
                    $stmt->execute();
                    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                    foreach ($categories as $result) {
                      echo '<li><a href="index.php?q=product&category=' . htmlspecialchars($result->CATEGORIES) . '">' . htmlspecialchars($result->CATEGORIES) . '</a></li>';
                    }
                    ?>
                  </ul>
                </li>
                <li><a href="<?php echo web_root; ?>index.php?q=product"><i class="fa fa-list-alt"></i> Products</a></li>
                <li><a href="<?php echo web_root; ?>index.php?q=contact"><i class="fa fa-phone"></i> Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-3">
            <form action="<?php echo web_root; ?>index.php?q=product" method="POST">
              <div class="search_box pull-right">
                <input type="text" name="search" placeholder="Search"/>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <?php require_once $content; ?>

  <footer id="footer">
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <p class="pull-left">Developed by <span>W8 TEAM</span></p>
          <p class="pull-right">AASTU, Addis Ababa</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- modalorder -->
  <div class="modal fade" id="myOrdered"></div>
  <?php include "LogSignModal.php"; ?>

  <!-- Scripts -->
  <script src="<?php echo web_root; ?>jquery/jquery.min.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap.min.js"></script>
  <script src="<?php echo web_root; ?>js/jquery.dataTables.min.js"></script>
  <script src="<?php echo web_root; ?>js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo web_root; ?>js/ekko-lightbox.js"></script>
  <script src="<?php echo web_root; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script src="<?php echo web_root; ?>js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
  <script src="<?php echo web_root; ?>js/jquery.scrollUp.min.js"></script>
  <script src="<?php echo web_root; ?>js/price-range.js"></script>
  <script src="<?php echo web_root; ?>js/jquery.prettyPhoto.js"></script>
  <script src="<?php echo web_root; ?>js/main.js"></script>
  <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script src="<?php echo web_root; ?>js/gmaps.js"></script>
  <script src="<?php echo web_root; ?>js/contact.js"></script>
  <script src="<?php echo web_root; ?>js/janobe.js"></script>

  <script type="text/javascript">
    $(document).on("click", ".proid", function () {
      var proid = $(this).data('id');
      $(".modal-body #proid").val(proid);
    });

    $('.tooltip-demo').tooltip({
      selector: "[data-toggle=tooltip]",
      container: "body"
    });

    $("[data-toggle=popover]").popover();

    $('.carousel').carousel({
      interval: 5000
    });

    $('#date_picker').datetimepicker({
      format: 'mm/dd/yyyy',
      language: 'en',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });

    function validatedate() {
      var todaysDate = new Date();
      var txtime = document.getElementById('ftime').value;
      var tprice = document.getElementById('alltot').value;
      var BRGY = document.getElementById('BRGY').value;
      var onum = document.getElementById('ORDERNUMBER').value;
      var mytime = parseInt(txtime);
      var todaytime = todaysDate.getHours();
      if (txtime == "") {
        alert("You must set the time enable to submit the order.");
      } else if (mytime < todaytime) {
        alert("Selected time is invalid. Set another time.");
      } else {
        window.location = "index.php?page=7&price=" + tprice + "&time=" + txtime + "&BRGY=" + BRGY + "&ordernumber=" + onum;
      }
    }

    $('.form_curdate').datetimepicker({
      language: 'en',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('.form_bdatess').datetimepicker({
      language: 'en',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });

    function checkall(selector) {
      var chkelement = document.getElementsByName(selector);
      var checked = document.getElementById('chkall').checked;
      for (var i = 0; i < chkelement.length; i++) {
        chkelement.item(i).checked = checked;
      }
    }

    function checkNumber(textBox) {
      while (textBox.value.length > 0 && isNaN(textBox.value)) {
        textBox.value = textBox.value.substring(0, textBox.value.length - 1)
      }
      textBox.value = textBox.value.trim();
    }

    function checkText(textBox) {
      var alphaExp = /^[a-zA-Z]+$/;
      while (textBox.value.length > 0 && !textBox.value.match(alphaExp)) {
        textBox.value = textBox.value.substring(0, textBox.value.length - 1)
      }
      textBox.value = textBox.value.trim();
    }
  </script>
</body>
</html>