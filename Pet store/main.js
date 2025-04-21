const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1000,
};

ScrollReveal().reveal(".header__content h4", {
  ...scrollRevealOption,
});
ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".header__content h2", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 1500,
});
ScrollReveal().reveal(".header__btn", {
  ...scrollRevealOption,
  delay: 2000,
});

ScrollReveal().reveal(".intro__card", {
  ...scrollRevealOption,
  interval: 500,
});

ScrollReveal().reveal(
  ".about__row:nth-child(3) .about__image img, .about__row:nth-child(5) .about__image img",
  {
    ...scrollRevealOption,
    origin: "left",
  }
);
ScrollReveal().reveal(".about__row:nth-child(4) .about__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".about__content span", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".about__content h4", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".about__content p", {
  ...scrollRevealOption,
  delay: 1500,
});

ScrollReveal().reveal(".product__card", {
  ...scrollRevealOption,
  interval: 500,
});

ScrollReveal().reveal(".service__card", {
  duration: 1000,
  interval: 500,
});

const swiper = new Swiper(".swiper", {
  slidesPerView: 3,
  spaceBetween: 20,
  loop: true,
});

ScrollReveal().reveal(".instagram__grid img", {
  duration: 1000,
  interval: 500,
});


// Add to Cart Function
function addToCart(productId) {
    fetch('addToCart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadCart();  // Update cart after adding
    });
}

// Load Cart Items
function loadCart() {
    fetch('getCart.php')
        .then(response => response.json())
        .then(cartItems => {
            const cartContainer = document.getElementById('cart-items');
            cartContainer.innerHTML = '';
            let total = 0;
            cartItems.forEach(item => {
                total += parseFloat(item.total);
                cartContainer.innerHTML += `
                    <div class="cart-item">
                        <p>${item.name} - $${item.price} x ${item.quantity}</p>
                        <p>Total: $${item.total}</p>
                    </div>
                `;
            });
            document.getElementById('cart-total').innerText = total.toFixed(2);
        });
}

// Show Checkout
function showCheckout() {
    document.getElementById('checkout').style.display = 'block';
    document.getElementById('cart').style.display = 'none';
    document.getElementById('store').style.display = 'none';
}

// Toggle Card Payment Details
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById("card-details").style.display = 
            this.value === 'card_pay' ? 'block' : 'none';
    });
});

// Place Order
function placeOrder() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    fetch('checkout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ payment_method: paymentMethod })
    })
    .then(response => response.text())
    .then(data => alert(data));
}

