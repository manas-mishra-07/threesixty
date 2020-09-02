<?php
/**
 * The template for displaying the footer.
 *
 * @package flatsome
 */

global $flatsome_opt;
?>

</main><!-- #main -->

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer><!-- .footer-wrapper -->

</div><!-- #wrapper -->
 
 <script>
jQuery(function ($) {
    console.log("text");
    $("#abt-txt").text($('#abt-txt').text().replace(/\s/g, ' '));    
});
</script>
 
<?php wp_footer(); ?>

</body>
</html>
