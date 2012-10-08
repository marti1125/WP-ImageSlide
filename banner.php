<?php  
/* 
	Plugin Name: Banner Plugin 
	Description: Banner!! 
	Author: Willy Aguirre 
	Version: 1.0 
*/
class np_Widget extends WP_Widget {  
    public function __construct() {  
        parent::__construct('np_Widget', 'Banner Images', array('description' => __('A Banner Images Widget', 'text_domain')));  
    }
    
	public function form($instance) {  
	if (isset($instance['title'])) {  
		$title = $instance['title'];  
	}  
	else {  
		$title = __('Widget Banner', 'text_domain');  
	}  
	?>  
		<p>  
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>  
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />  
		</p>  
	<?php  
    }
    
    public function update($new_instance, $old_instance) {  
		$instance = array();  
		$instance['title'] = strip_tags($new_instance['title']);  
		return $instance;  
	}
	
	public function widget($args, $instance) {  
		extract($args);  
		// the title  
		$title = apply_filters('widget_title', $instance['title']);  
		echo $before_widget;  
		if (!empty($title))  
        echo $before_title . $title . $after_title;  
		echo np_function('np_widget');  
		echo $after_widget;  
	}   
     
} 


function np_widgets_init() {  
	register_widget('np_Widget');  
}  
add_action('widgets_init', 'np_widgets_init');  

function np_function($type='np_function') {  
	$args = array(  
		'post_type' => 'np_images',  
		'posts_per_page' => 5  
	);  
	$result = '<div id="border">';  
	$result .= '<div class="accordion">';  
	$result .= '<div class="holder">';
	//the loop  
	$loop = new WP_Query($args);  
	while ($loop->have_posts()) {  
		$loop->the_post();  
		$the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);		
		$result .= '<div class="block">';		
		$the_url[0] = str_replace('-180x100',"", $the_url[0]);		
		$result .= '<div class="content_holder" src="' . $the_url[0] . '">';
		$result .= '<div class="image"></div>';
		$result .= '<div class="content" transitionType="bottom" transitionTime="0.5" distance="30" delay="0" x="0" y="0" alignV="bottom">';
		$result .= '<div class="box"><p class="title">'.get_the_title().'</p><p class="text">'.get_the_content().'</p></div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';		 
	}  
	$result .= '</div>';  
	$result .='</div>';  
	$result .='<div class="previous accordion_button" normal="wp-content/plugins/banner/images/ui/previous_button.png" over="wp-content/plugins/banner/images/ui/previous_button_over.png">';  
	$result .='</div>';  
	$result .='<div class="next accordion_button" normal="wp-content/plugins/banner/images/ui/next_button.png" over="wp-content/plugins/banner/images/ui/next_button_over.png">'; 
    $result .='</div>';
	return $result;  
}  


function np_register_scripts() {  
	if (!is_admin()) {  
		// register
		wp_register_script('jquery-script', plugins_url('jquery-1.6.2.min.js', __FILE__), array( 'jquery' ));  
		wp_register_script('accordion-script', plugins_url('accordion.js', __FILE__), array( 'jquery' ));
		wp_register_script('accordion_minified-script', plugins_url('accordion_minified.js', __FILE__), array( 'jquery' ));
		wp_register_script('buttons-script', plugins_url('buttons.js', __FILE__), array( 'jquery' ));
		wp_register_script('pngFixer-script', plugins_url('pngFixer.js', __FILE__), array( 'jquery' ));  
		wp_register_script('np_script', plugins_url('script.js', __FILE__));  
		// enqueue
		wp_enqueue_script('jquery-script');  
		wp_enqueue_script('accordion-script');
		wp_enqueue_script('accordion_minified-script'); 
		wp_enqueue_script('buttons-script'); 
		wp_enqueue_script('pngFixer-script'); 
		wp_enqueue_script('np_script');  
	}  
} 
 
function np_register_styles() {  
	// register  
	wp_register_style('accordion_styles', plugins_url('accordion.css', __FILE__));  	
	// enqueue  
	wp_enqueue_style('accordion_styles'); 
}  

function np_init() {
	add_shortcode('np-shortcode', 'np_function');  
	
	add_theme_support( 'post-thumbnails' ); 
	
	add_image_size('np_widget', 900, 400, true);  
    add_image_size('np_function', 600, 280, true);  
	
	$args = array(  
		'public' => true,  
		'label' => 'Banner Images',  
		'supports' => array(  
			'title',
			'editor', 
			'thumbnail'  
		)  
	);  
	register_post_type('np_images', $args);  
}  
// config
add_action('init', 'np_init');
add_action('wp_print_scripts', 'np_register_scripts');  
add_action('wp_print_styles', 'np_register_styles');  

?>
