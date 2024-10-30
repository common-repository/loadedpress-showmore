<?php
/*
Plugin Name: LWP Show More
Plugin URI: http://loadedpress.com
Description: Convert [showmore], [more] shortcodes into an easy to use hidden / expanding content area. Useful for hiding images, long quotes, etc. Also part of the Loaded Wordpress system, <a href="http://loadedpress.com" target="_blank">Click here to take a tour</a>.
Version: 0.2
Author: LoadedPress
Author URI: http://loadedpress.com/
*/

function lwp_showmore( $atts, $content = null ) {
   extract( shortcode_atts( array(
      
      ), $atts ) );
	STATIC $i = 0; 
	STATIC $j = 0;
	$i++;
	
	if ($j == 0){
		$j++;
	}else if ($j == 1){
		$j=0;
	}
	
	$content = str_replace('[more]', '<div class="lwpshowmore" id="showmore_-'.$i.'">', $content);
	$content = str_replace('[/more]', '</div>', $content);
	
	return '<div class="showmore showmore-'.$j.'" id="showmore_ID-'.$i.'" name="showmore_ID-'.$i.'">' . $content . '</div>';
	
}

add_shortcode('showmore', 'lwp_showmore');


function lwp_showmore_scripts(){
		wp_enqueue_script('jquery');  
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.showmore').each(function(){
		var showmoreid = ($(this).attr('id')).replace('showmore_ID-', '');
			$(this).find('a').each(function(){
					$(this).attr('href', '#showmore_-'+showmoreid);				
				$(this).click(function(e){
					e.preventDefault();

					$(this).fadeOut('fast',function(){
						$('#showmore_-'+showmoreid).fadeIn();
					});
				});
			});
	});
});
</script>

<style type="text/css">
.lwpshowmore{display:none;}
</style>

<?php

}




add_action('wp_head', 'lwp_showmore_scripts');

?>
