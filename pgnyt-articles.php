<?php
	
/*
Plugin name: Tony UDEMY NY TIMES PLUGINY 
PLUGIN URI: http:www.pl.com
description: Provides Both widgets and shortcuts
Version: 1.0
Author: SG
Author URI: www.sss.com
License: aas3
*/

$plugin_url = WP_PLUGIN_URL . '/pgnyt_articles';
$options = array();

function pgnyt_articles_menu(){
	
	add_options_page( 
	"tonys Plugin", 
	"NYTIME ARTICLE", 
	'manage_options', 
	'pgnyt-articles', 
	'pgnyt_articles_options_page');
	
}

add_action('admin_menu', 'pgnyt_articles_menu');


function pgnyt_articles_options_page(){
	
	
	
	
	if (!current_user_can('manage_options')){
		wp_die('Not Authorized');
	}
	
	global $options;
	global $plugin_url;
	
	if (isset($_POST['pgnyt_form_submitted'])){
		
		$hidden_field = esc_html($_POST['pgnyt_form_submitted']);
		
		if ($hidden_field == "Y"){
			$pgnyt_search = esc_html($_POST['pgnyt_search']);
			$pgnyt_apikey = esc_html($_POST['pgnyt_apikey']);
			
			
		$pgnyt_results = pgnyt_articles_get_results($pgnyt_search, $pgnyt_apikey);
			
			
			$options['pgnyt_search'] = $pgnyt_search;
			$options['pgnyt_apikey'] = $pgnyt_apikey;
			$options['updated_last'] = time();
			
			$options['pgnyt_results'] = $pgnyt_results;
			
			
			update_option('pgnyt_articles',$options);
			
		}

	}
	
	$options = get_option('pgnyt_articles');
	
	if ($options != ''){
		$pgnyt_search = $options['pgnyt_search'];
		$pgnyt_apikey = $options['pgnyt_apikey'];
		$pgnyt_results = $options['pgnyt_results'];
	}

	
	
	require('inc/options-page-wrapper.php');
}


class Pgnyt_Articles_Widget extends WP_Widget {
 
    /**
     * Constructs the new widget.
     *
     * @see WP_Widget::__construct()
     */
    function __construct() {
        // Instantiate the parent object.
        parent::__construct( false, __( 'NY Times Articles Widget', 'textdomain' ) );
    }
 
    /**
     * The widget's HTML output.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Display arguments including before_title, after_title,
     *                        before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget.
     */
    function widget( $args, $instance ) {

    	extract($args);
    	$title = apply_filters('widget_title', $instance['title'] );
    	$num_articles = $instance['num_articles'];
    	$display_image = $instance['display_image'];

    	$options = get_option('pgnyt_articles');
    	$pgnyt_results = $options['pgnyt_results'];

    	require ('inc/front-end.php');
    }
 
    /**
     * The widget update handler.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance The new instance of the widget.
     * @param array $old_instance The old instance of the widget.
     * @return array The updated instance of the widget.
     */
    function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['display_image'] = strip_tags($new_instance['display_image']);
        $instance['num_articles'] = strip_tags($new_instance['num_articles']);

        return $instance;
    }
 
    /**
     * Output the admin widget options form HTML.
     *
     * @param array $instance The current widget settings.
     * @return string The HTML markup for the form.
     */
    function form( $instance ) {

    	$title = esc_attr($instance['title']);
    	$display_image = esc_attr($instance['display_image']);
    	$num_articles = esc_attr($instance['num_articles']);

    	$options = get_option('pgnyt_articles');
    	$pgnyt_results = $options['pgnyt_results'];

    	require ('inc/widget-fields.php');

    }
}
 
add_action( 'widgets_init', 'pgnyt_articles_register_widgets' );
 
/**
 * Register the new widget.
 *
 * @see 'widgets_init'
 */
function pgnyt_articles_register_widgets() {
    register_widget( 'Pgnyt_Articles_Widget' );
}



function pgnyt_articles_shortcode($atts,$content=null){
	
	global $post;
	
	extract(shortcode_atts(array(
	'num_articles' => '2',
	'display_image' => 'on'), $atts));
	
	if ($display_image == 'on') $display_image = 1;
	if ($display_image == 'off') $display_image = 0;
	 
	$options = get_option('pgnyt_articles');
    $pgnyt_results = $options['pgnyt_results'];
    
    ob_start();
     
    require ('inc/front-end.php');
    
    $content = ob_get_clean();
    
    return $content;
}

add_shortcode('pgnyt_articles','pgnyt_articles_shortcode');






function pgnyt_articles_get_results($pgnyt_search, $pgnyt_apikey){
	$json_feed_url = "https://api.nytimes.com/svc/search/v2/articlesearch.json?q=" . $pgnyt_search . "&api-key=" . $pgnyt_apikey;
	
	$json_feed = wp_remote_get($json_feed_url);
	
	$pgnyt_results = json_decode($json_feed['body']);	
	
	return $pgnyt_results;
}



function pgnyt_articles_refresh_results(){
	
	$options = get_option('pgnyt_articles');
	$last_update = $options['updated_last'];
	
	$current_time = time();
	
	$update_difference = $current_time - $last_update;
	
	//linux time() seconds from 1980's
	
	if($update_difference > 86400){
		
		$pgnyt_search = $options['pgnyt_search'];
		$pgnyt_apikey = $options['pgnty_apikey'];
		
		$options['pgnyt_results'] = pgnyt_articles_get_results($pgnyt_search
		, $pgnyt_apikey);
		
		$options['updated_last'] = time();
		
		update_option( 'pgnyt_articles', $options); 
		
	}
	
	die();
	
}



add_action('wp_ajax_pgnyt_articles_refresh_results','pgnyt_articles_refresh_results');




function pgnyt_articles_enable_frontend_ajax(){
	?>
	
<script> var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>'; </script>	

	<?php
}


add_action('wp_head','pgnyt_articles_enable_frontend_ajax'); 




function pgnyt_articles_backend_styles(){
	wp_enqueue_style('pgnyt_articles_backend_css', plugins_url('pgnyt_articles/pgnyt-articles.css'));
}
add_action('admin_head', 'pgnyt_articles_backend_styles');



function pgnyt_articles_frontend_styles(){
		wp_enqueue_style('pgnyt_articles_frontend_css', plugins_url('pgnyt_articles/pgnyt-articles.css'));
		wp_enqueue_script( 'pgnyt_articles_frontend_javascript', plugins_url('pgnyt_articles/pgnyt-articles.js'), array('jquery'),'',true);
		
		
		
}
add_action('wp_enqueue_scripts', 'pgnyt_articles_frontend_styles');


?>