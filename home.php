<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/smart.jpg" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Latest Smartphones</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/jeans.jpg" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Latest Jeans</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/watches.jpg" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Smartwatches</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">Types of Clothes & Electronics</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <!-- Clothing Categories -->
   <a href="category.php?category=t-shirts" class="swiper-slide slide">
      <img src="images/c-1.jpg" alt="T-Shirts">
      <h3>T-Shirts</h3>
   </a>

   <a href="category.php?category=hodies" class="swiper-slide slide">
      <img src="images/c-2.jpg" alt="Hoodies">
      <h3>Hoodies</h3>
   </a>

   <a href="category.php?category=jeans" class="swiper-slide slide">
      <img src="images/c-3.jpg" alt="Jeans">
      <h3>Jeans</h3>
   </a>

   <a href="category.php?category=dresses" class="swiper-slide slide">
      <img src="images/c-4.jpg" alt="Dresses">
      <h3>Dresses</h3>
   </a>

   <a href="category.php?category=jackets" class="swiper-slide slide">
      <img src="images/c-5.jpg" alt="Jackets">
      <h3>Jackets</h3>
   </a>

   <!-- Electronics Categories -->
   <a href="category.php?category=smartphones" class="swiper-slide slide">
      <img src="images/e-1.jpg" alt="Smartphones">
      <h3>Smartphones</h3>
   </a>

   <a href="category.php?category=laptops" class="swiper-slide slide">
      <img src="images/e-2.jpg" alt="Laptops">
      <h3>Laptops</h3>
   </a>

   <a href="category.php?category=headphones" class="swiper-slide slide">
      <img src="images/e-3.jpg" alt="Headphones">
      <h3>Headphones</h3>
   </a>

   <a href="category.php?category=smartwatches" class="swiper-slide slide">
      <img src="images/e-4.jpg" alt="Smartwatches">
      <h3>Smartwatches</h3>
   </a>

   <a href="category.php?category=tablets" class="swiper-slide slide">
      <img src="images/e-5.jpg" alt="Tablets">
      <h3>Tablets</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>