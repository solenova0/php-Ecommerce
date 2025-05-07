<footer id="footer">
    <!-- top footer -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">About Us</h3>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fa fa-map-marker"></i> address</a></li>
                            <li><a href="#"><i class="fa fa-phone"></i> +251900000001</a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i> w8@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 text-center" style="margin-top:80px;">
                    <ul class="footer-payments">
                        <!-- International Payments -->
        
                        <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                        
                        <!-- Local Payment Agents -->
                        <li><a href="#" title="Telebirr"><img src="img\tb.jpg" alt="Telebirr" style="width:32px;height:24px;"></a></li>
                        <li><a href="#" title="CBE Birr"><img src="img\cbe.jpg" alt="CBE Birr" style="width:32px;height:24px;"></a></li>
                        <li><a href="#" title="CBE"><img src="img\cb.jpg" alt="Commercial Bank Of Ethiopia" style="width:32px;height:24px;"></a></li>
                    </ul>
                    
                    <span class="copyright">
                        Developed by W8 team at AASTU for Interent Proggramming 2 Course
                    </span>
                </div>
              </div>
        </div>
    </div>
</footer>

		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/actions.js"></script>
		<script src="js/sweetalert.min"></script>
		<script src="js/jquery.payform.min.js" charset="utf-8"></script>
    <script src="js/script.js"></script>
		<script>var c = 0;
        function menu(){
          if(c % 2 == 0) {
            document.querySelector('.cont_drobpdown_menu').className = "cont_drobpdown_menu active";    
            document.querySelector('.cont_icon_trg').className = "cont_icon_trg active";    
            c++; 
              }else{
            document.querySelector('.cont_drobpdown_menu').className = "cont_drobpdown_menu disable";        
            document.querySelector('.cont_icon_trg').className = "cont_icon_trg disable";        
            c++;
              }
        }
           
		
</script>
    <script type="text/javascript">
		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});
	</script>
	