 $(document).ready(function () {
     $("#sidebar").mCustomScrollbar({
         theme: "minimal"
     });

     /* Font Awesome close button is clicked */
     $('#dismiss, .overlay').on('click', function () {
         $('#sidebar').removeClass('active');
         $('.overlay').fadeOut();
     });
     
     $('#sidebarCollapse').on('click', function () {
         $('#sidebar').addClass('active');
         $('.overlay').fadeIn();
         $('.collapse.in').toggleClass('in');
         $('a[aria-expanded=true]').attr('aria-expanded', 'false');
     });
     /* Fades the sidebar if subreddit is clicked */
     $('.subreddit').on('click', function () {
         $('#sidebar').removeClass('active');
         $('.overlay').fadeOut();
     });
 }); // End document.ready
