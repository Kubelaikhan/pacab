<a href="javascript:" id="return-to-top" class="btn btn-primary"><i class="fas fa-arrow-up"></i></a>

<script>
    // ===== Scroll to Top ==== 
    $('#konten').scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
        $('#konten ,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });
 
</script>
</body>

</html>