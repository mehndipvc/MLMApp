 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 <!-- Owl Carousel JS -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
 
 <!-- Custom JS -->
 <script>
     $(document).ready(function() {
         $(".owl-carousel").owlCarousel({
             items: 1,
             loop: true,
             margin: 10,
             autoplay: true,
             autoplayTimeout: 3000,
             autoplayHoverPause: true,
             responsive: {
                 0: {
                     items: 1
                 },
                 600: {
                     items: 1
                 },
                 1000: {
                     items: 1
                 }
             }
         });
     });
 </script>
 <script>
     $(window).scroll(function() {
         if ($(this).scrollTop() >= 40) { // Check if the scroll position is 5px or more
             $('#navbar').addClass('sticky');
         } else {
             $('#navbar').removeClass('sticky');
         }
     });
 </script>
 <script>
     document.querySelectorAll(".toogleMenu").forEach(element => {
         element.addEventListener("click", () => {
             document.querySelector(".sidebar-wrap").classList.toggle("opened");
         });
     });
 </script>
 

</body>
</html>