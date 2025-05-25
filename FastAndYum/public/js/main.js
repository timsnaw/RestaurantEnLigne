(function ($) {
    "use strict";


    // Initialisation de  wowjs
    new WOW().init();


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(window).width() < 992) {
            if ($(this).scrollTop() > 45) {
                $('.fixed-top').addClass('bg-white shadow');
            } else {
                $('.fixed-top').removeClass('bg-white shadow');
            }
        } else {
            if ($(this).scrollTop() > 45) {
                $('.fixed-top').addClass('bg-white shadow').css('top', -45);
            } else {
                $('.fixed-top').removeClass('bg-white shadow').css('top', 0);
            }
        }
    });
    


    // Avis carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        center: true,
        dots: false,
       
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });

    
})(jQuery);


//whatsap footer 
function sendToWhatsApp(event) {
    event.preventDefault();

    const message = document.getElementById("whatsappMessage").value.trim();
    if (!message) {
      alert("Veuillez écrire un message.");
      return;
    }

    const phoneNumber = "+212712635736";

  
    const url = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(message);

 
    window.open(url, "_blank");
  }

    



  // scroll of the navBar 
 
  window.addEventListener('scroll', function () {
    const header = document.querySelector('header');
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
//navbar responsive
  function toggleNavbar() {
    document.getElementById("navbar").classList.toggle("active");
  }

  function toggleDropdown(e) {
    e.stopPropagation();
    const dropdown = e.currentTarget;
    dropdown.classList.toggle("open");
  }

  document.addEventListener("click", () => {
    document.querySelectorAll(".dropdown").forEach(drop => drop.classList.remove("open"));
  });

  
//navbar pizza tacos salade ..
 document.addEventListener("DOMContentLoaded", function () {
    function showTabFromHash() {
        let hash = window.location.hash;
        if (!hash || hash === "#") {
            hash = "#tab-1"; 
        }

        const tabPanes = document.querySelectorAll(".tab-pane");
        const tabButtons = document.querySelectorAll(".btn-orange");

        tabPanes.forEach(pane => {
            if ("#" + pane.id === hash) {
                pane.classList.add("show", "active");
            } else {
                pane.classList.remove("show", "active");
            }
        });

        tabButtons.forEach(btn => {
            if (btn.getAttribute("href") === hash) {
                btn.classList.add("active");
            } else {
                btn.classList.remove("active");
            }
        });
    }


/* Les tableau des produit  */
    // Afficher tab au chargement
    showTabFromHash();

    // Changer tab quand utilisateur clique
    document.querySelectorAll(".btn-orange").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const targetHash = this.getAttribute("href");
            history.pushState(null, null, targetHash);
            showTabFromHash();
        });
    });

    // Écouter le changement du hash
    window.addEventListener("hashchange", showTabFromHash);
});
/**end tableau produit */
//// voila le script quantite li kayn f details product 
function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }

        function increaseQuantity() {
            const qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
        }

        function decreaseQuantity() {
            const qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }


  