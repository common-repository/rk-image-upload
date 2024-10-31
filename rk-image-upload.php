<?php
/*
Plugin Name: RK Image Upload
Plugin URI: http://www.rkc-zira.com/
Description: A simple plugin that Adds a widget to upload a single image.
Version: 2.1.1
Author: Raman Kumar
Author URI: http://www.rkc-zira.com/
*/
?>
<?php
class Rk_Image_Upload_Widget extends WP_Widget
{
	
	/**
	* Widget construction
	*/
	function __construct()
	{
		$widget_ops = array('classname' => 'widget_image image-upload-widget', 'description' => __('Text, Image, CSS-Class'));
        $control_ops = array('width' => 450);
        parent::__construct('Rk_Image_Upload_Widget', __('Image Upload', 'imageupload'), $widget_ops, $control_ops);
	}
	
	public function widget( $args, $instance )
	{
		if (!isset($args['widget_id'])) {
          $args['widget_id'] = null;
        }
		
		extract($args);
		
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance);
        $cssClass = empty($instance['css_class']) ? '' : $instance['css_class'];
        $height = empty($instance['height']) ? '150px' : $instance['height'];
        $width = empty($instance['width']) ? '150px' : $instance['width'];
		$imageUri = empty($instance['image_uri']) ? '' : $instance['image_uri'];
        $responsive = !empty($instance['responsive']) ? true : false;
		
		// basic output just for this example
		$addClass="";
		if($responsive==true){
			$addClass="img-responsive ";
		}
		echo '<h2>'.$title.'</h2>
			<a href="#">
				<img class="'.$addClass.$cssClass.'" style="height:'.$height.';width:'.$width.';" src="'.$imageUri.'" />
			</a>';
	}
	
	
	    /**
     * Run on widget update
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['css_class']= strip_tags($new_instance['css_class']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['width'] = strip_tags($new_instance['width']);
		$instance['image_uri'] = strip_tags($new_instance['image_uri']);
        $instance['responsive'] = strip_tags($new_instance['responsive']);
        return $instance;
    }
  
    /**
     * Setup the widget admin form
     */
	public function form( $instance )
	{
		$instance = wp_parse_args( (array) $instance, array(
            'title' => '',
            'css_class' => '',
            'height' => '',
            'width' => '',
			'image_uri' => '',
        ));
        $title = $instance['title'];
        $cssClass = $instance['css_class'];
		$height = $instance['height'];
        $width = $instance['width'];
        $imageUri = $instance['image_uri'];
		$responsive=$instance['responsive'];
		?>
		<p>
		  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'imageupload'); ?>:</label><br />
		  <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $title ?>" class="widefat" />
		</p>
		<p>
		  <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Image*', 'imageupload'); ?>:</label><br />
		  <input type="text" class="img rk_image_upload_input" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $imageUri; ?>" />
		  <input type="button" id="rk_image_upload_button" class="select-img" value="Select Image" />
		</p>
		 <p>
		  <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height(eg. 200px or 20%)', 'imageupload'); ?>:</label><br />
		  <input type="text" name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" value="<?php echo $height; ?>" class="widefat" />
		</p>
		 <p>
		  <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width(eg. 200px or 20%)', 'imageupload'); ?>:</label><br />
		  <input type="text" name="<?php echo $this->get_field_name('width'); ?>" id="<?php echo $this->get_field_id('width'); ?>" value="<?php echo $width; ?>" class="widefat" />
		</p>
		<p>
		  <label for="<?php echo $this->get_field_id('Class for Custom Style'); ?>"><?php _e('Class for Custom Style(optional)', 'imageupload'); ?>:</label><br />
		  <input type="text" name="<?php echo $this->get_field_name('css_class'); ?>" id="<?php echo $this->get_field_id('css_class'); ?>" value="<?php echo $cssClass; ?>" class="widefat" />
		</p>
		
		<p>
		  <label for="<?php echo $this->get_field_id('responsive'); ?>"><?php _e('Responsive(Bootstrap css only)(optional)', 'imageupload'); ?>:</label><br />
		  <input type="checkbox" name="<?php echo $this->get_field_name('responsive'); ?>" id="<?php echo $this->get_field_id('responsive'); ?>" <?php if(!empty($responsive)) { echo "checked"; } ?> class="widefat" />
		</p>
		<?php
	  }
} 

// queue up the necessary js
function imgupl_enqueue()
{
  wp_enqueue_style('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_script('hrw', plugin_dir_url( __FILE__ ).'/js/script.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'imgupl_enqueue');

/**
 * Register the widget
 */
function rk_image_upload_widget_init() {
    register_widget('Rk_Image_Upload_Widget');
}
add_action('widgets_init', 'rk_image_upload_widget_init');

