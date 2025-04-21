<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Pet Place | Online Pet Store</title>
  </head>
  <body>
    <!-- Navigation -->
    <nav>
      <div class="nav__header">
        <div class="nav__logo"><a href="#">Pet Place</a></div>
        <div class="nav__menu__btn" id="menu-btn">
            <i class="ri-menu-line"></i>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#store">Store</a></li>
        <li><a href="#service">Services</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>

    <!-- Header Section -->
    <header id="home">
      <div class="section__container header__container">
        <div class="header__content">
          <h4>Welcome</h4>
          <h1>Pet<br /><span>Doctor</span></h1>
          <h2>We love pets like you do :)</h2>
          <p>From routine check-ups to specialized treatments, we're here to ensure your pets lead happy, healthy lives.</p>
          <div class="header__btn">
            <button>Start Here! <span><i class="ri-arrow-right-line"></i></span></button>
          </div>
        </div>
        <div class="header__image">
          <img
            src="assets/header-bg.png"
            alt="header-bg"
            class="header__image-bg"
          />
          <img src="assets/header.png" alt="header" />
        </div>
      </div>
      <div class="header__bottom"></div>
    </header>

    <section class="section__container intro__container">
      <p class="section__subheader">Intro</p>
      <h2 class="section__header">Get to know us more</h2>
      <div class="intro__grid">
        <div class="intro__card">
          <div class="intro__image">
            <img src="assets/intro-1.png" alt="intro" />
          </div>
          <h4>Pet Experts</h4>
          <p>
            Meet our team of skilled veterinarians, dedicated to your pet's
            well-being.
          </p>
          <a href="#">Read More</a>
        </div>
        <div class="intro__card">
          <div class="intro__image">
            <img src="assets/intro-2.png" alt="intro" />
          </div>
          <h4>Vet Services</h4>
          <p>
            Offering a wide range of veterinary services to keep your pets
            healthy and happy.
          </p>
          <a href="#">Read More</a>
        </div>
        <div class="intro__card">
          <div class="intro__image">
            <img src="assets/intro-3.png" alt="intro" />
          </div>
          <h4>Contact Us</h4>
          <p>
            Reach out to us for any inquiries or schedule an appointment for
            your pet's care.
          </p>
          <a href="#">Read More</a>
        </div>
      </div>
    </section>

    <section class="section__container about__container" id="about">
      <p class="section__subheader">About Us</p>
      <h2 class="section__header">What we can do for you</h2>
      <div class="about__row">
        <div class="about__image">
          <img src="assets/about-1.jpg" alt="about" />
        </div>
        <div class="about__content">
          <span><img src="assets/about-1-icon.png" alt="about-icon" /></span>
          <h4>Let us help you with your pet health</h4>
          <p>
            Our expert veterinarians are here to provide comprehensive care and
            guidance to ensure your pet stays in perfect health.
          </p>
        </div>
      </div>
      <div class="about__row">
        <div class="about__image">
          <img src="assets/about-2.jpg" alt="about" />
        </div>
        <div class="about__content">
          <span><img src="assets/about-2-icon.png" alt="about-icon" /></span>
          <h4>Caring personal will take care of your pet</h4>
          <p>
            Your pet will be in good hands with our compassionate and
            well-trained staff, who treat every pet like family.
          </p>
        </div>
      </div>
      <div class="about__row">
        <div class="about__image">
          <img src="assets/about-3.jpg" alt="about" />
        </div>
        <div class="about__content">
          <span><img src="assets/about-3-icon.png" alt="about-icon" /></span>
          <h4>Let us groom your precious and loved pet</h4>
          <p>
            From bathing to styling, we offer professional grooming services to
            keep your pet looking and feeling their best.
          </p>
        </div>
      </div>
    </section>

    
    <section class="product" id="store">
      <div class="section__container product__container">
        <p class="section__subheader">Products</p>
        <h2 class="section__header">Featured Pet Products</h2>
        <div class="product__grid">
          <?php
          $result = $conn->query("SELECT * FROM products");
          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
          ?>
              <div class="product__card">
                <img src="assets/<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <h4><?php echo $row['name']; ?></h4>
                <p><?php echo $row['description']; ?></p>
                <h3>$<?php echo $row['price']; ?> USD</h3>
                <button onclick="addToCart(<?php echo $row['product_id']; ?>)">Add to Cart</button>
              </div>
          <?php
              }
          } else {
          ?>
              <div class="product__card">
                <img src="assets/product-1.jpg" alt="Dog Trash Bag">
                <h4>Dog Trash Bag</h4>
                <p>Convenient and eco-friendly trash bags for easy pet waste disposal.</p>
                <h3>$29.00 USD</h3>
              </div>
          <?php
          }
          ?>
        </div>
      </div>
    </section>

    <!-- Cart Section -->
    <section class="cart" id="cart">
      <div class="section__container cart__container">
        <p class="section__subheader">Your Cart</p>
        <h2 class="section__header">Items in Cart</h2>
        <div class="cart__items" id="cart-items"></div>
        <div class="cart__summary">
          <p>Total: $<span id="cart-total">0.00</span></p>
          <button onclick="showCheckout()">Proceed to Checkout</button>
        </div>
      </div>
    </section>

    <!-- Checkout Section -->
    <section class="checkout" id="checkout" style="display: none;">
      <div class="section__container checkout__container">
        <p class="section__subheader">Checkout</p>
        <h2 class="section__header">Choose Payment Method</h2>

        <label>
          <input type="radio" name="payment_method" value="cash_on_delivery" checked>
          Cash on Delivery
        </label>
        <label>
          <input type="radio" name="payment_method" value="card_pay">
          Card Payment
        </label>

        <div id="card-details" style="display: none;">
          <input type="text" placeholder="Card Number" name="card_number">
          <input type="text" placeholder="Card Holder Name" name="card_holder">
          <input type="text" placeholder="Expiration Date" name="expiration_date">
          <input type="text" placeholder="CVV" name="cvv">
        </div>

        <button onclick="placeOrder()">Place Order</button>
      </div>
    </section>

    <section class="section__container service__container" id="service">
      <p class="section__subheader">Services</p>
      <h2 class="section__header">What we can do for you</h2>
      <div class="service__flex">
        <div class="service__card">
          <div>
            <img src="assets/service-1.png" alt="service" />
          </div>
          <p>Emergency Care</p>
        </div>
        <div class="service__card">
          <div>
            <img src="assets/service-2.png" alt="service" />
          </div>
          <p>Vaccination Services</p>
        </div>
        <div class="service__card">
          <div>
            <img src="assets/service-3.png" alt="service" />
          </div>
          <p>Nutrition Counseling</p>
        </div>
        <div class="service__card">
          <div>
            <img src="assets/service-4.png" alt="service" />
          </div>
          <p>Behavioral Consultation</p>
        </div>
        <div class="service__card">
          <div>
            <img src="assets/service-5.png" alt="service" />
          </div>
          <p>Pet Boarding Services</p>
        </div>
      </div>
    </section>

    <section class="client">
      <div class="section__container client__container">
        <p class="section__subheader">Testimonials</p>
        <h2 class="section__header">What people say about us</h2>
        <!-- Slider main container -->
        <div class="swiper">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
              <div class="client__card">
                <div class="client__details">
                  <img src="assets/client-1.jpg" alt="client" />
                  <div>
                    <h4>Sarah Johnson</h4>
                    <h5>Graphic Designer</h5>
                  </div>
                </div>
                <p>
                  The care my dog received at Pet Doctor was exceptional. The
                  vets were attentive cared about my dog's well-being.
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="client__card">
                <div class="client__details">
                  <img src="assets/client-2.jpg" alt="client" />
                  <div>
                    <h4>Michael Adams</h4>
                    <h5>Software Engineer</h5>
                  </div>
                </div>
                <p>
                  Pet Doctor saved my cat during an emergency! Their quick
                  response and expertise made all the difference.
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="client__card">
                <div class="client__details">
                  <img src="assets/client-3.jpg" alt="client" />
                  <div>
                    <h4>Emily Martinez</h4>
                    <h5>Teacher</h5>
                  </div>
                </div>
                <p>
                  I trust Pet Doctor with all my pets. Their team is
                  professional, and they always go the extra mile for their
                  patients.
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="client__card">
                <div class="client__details">
                  <img src="assets/client-4.jpg" alt="client" />
                  <div>
                    <h4>Jason Lee</h4>
                    <h5>Marketing Specialist</h5>
                  </div>
                </div>
                <p>
                  The grooming services at Pet Doctor are fantastic! My pup
                  always comes back looking fresh and happy.
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="client__card">
                <div class="client__details">
                  <img src="assets/client-5.jpg" alt="client" />
                  <div>
                    <h4>David Thompson</h4>
                    <h5>Accountant</h5>
                  </div>
                </div>
                <p>
                  I've never seen a team so dedicated to animals. Pet Doctor is
                  my go-to clinic for all pet-related issues.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section__container instagram__container">
      <p>FOLLOW</p>
      <h2 class="section__header">Instagram</h2>
      <div class="instagram__grid">
        <img src="assets/instagram-1.jpg" alt="instagram" />
        <img src="assets/instagram-2.jpg" alt="instagram" />
        <img src="assets/instagram-3.jpg" alt="instagram" />
        <img src="assets/instagram-4.jpg" alt="instagram" />
      </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
      <div class="section__container footer__container">
        <div class="footer__col">
          <div class="footer__logo">
            <a href="#">Pet Place</a>
          </div>
        </div>
        <div class="footer__col">
          <h4>Company</h4>
          <ul class="footer__links">
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Store</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Faq</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Address</h4>
          <ul class="footer__links">
            <li><a href="#">New Delhi, India</a></li>
            <li><a href="#">View on Maps</a></li>
          </ul>
          <br />
          <h4>Inquiries</h4>
          <ul class="footer__links">
            <li><a href="#">+91 0987654321</a></li>
            <li><a href="#">info@website.com</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Newsletter</h4>
          <p>Stay updated with out latest news</p>
          <form action="/">
            <input type="text" placeholder="Your email" />
            <button class="btn">
              <i class="ri-arrow-right-line"></i>
            </button>
          </form>
          <br />
          <h4>Follow Us</h4>
          <ul class="footer__socials">
            <li>
              <a href="#"><i class="ri-facebook-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-twitter-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-youtube-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-pinterest-line"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-instagram-line"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-tiktok-fill"></i></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer__bar">
        Copyright © 2024 Web Design Mastery. All rights reserved.
      </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>
