<?php
/*
Plugin Name: Responsive Featured Image Widget
Plugin URI: http://qass.im/my-plugins/
Description: Add featured image in your sidebar easily, responsive and hover animation.
Version: 1.0.0
Author: Qassim Hassan
Author URI: http://qass.im/
License: GPLv2 or later
*/

/*  Copyright 2014  Qassim Hassan  (email : qassim.pay@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Featured Image Widget
class QassimFeaturedImageWidget extends WP_Widget {
	function QassimFeaturedImageWidget() {
		parent::__construct( false, 'Responsive Featured Image', array('description' => 'Display featured image.') );
	}

	function widget( $args, $instance ) {
		$title = apply_filters('widget_title', esc_attr($instance['title']));
		$image_link = $instance['image_link'];
		if( empty($title) ){
			$title = 'Featured Image';
		}
		?>
			<?php echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
                <?php
				if ( !empty($image_link) ) {
					echo '<div class="qassim-fiw-content">';
					echo '<a href="'.$image_link.'">';
    				echo '<img src="'.$image_link.'">';
					echo '</a>';
					echo '</div>';
				}else{
                	echo '<ul><li>Please enter image link.</li></ul>';
				}
				?>
			<?php echo  $args['after_widget']; ?>
        <?php
	}//widget
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image_link'] = strip_tags($new_instance['image_link']);
		return $instance;
	}//update
	
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);
		
		$defaults = array(
			'title' => 'Featured Image',
			'image_link' => ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$image_link = $instance['image_link'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
            
			<p>
				<label for="<?php echo $this->get_field_id('image_link'); ?>">Image Link:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('image_link'); ?>" name="<?php echo $this->get_field_name('image_link'); ?>" type="text" value="<?php echo $image_link; ?>" />
			</p>
        <?php
		
	}//form
	
}
add_action('widgets_init', create_function('', 'return register_widget("QassimFeaturedImageWidget");') );

// Add wp head functions
function QassimFeaturedImageWidget_CSS(){
	?>
    	<style type="text/css">
			.qassim-fiw-content{
				overflow:hidden;
			}
			.qassim-fiw-content a{
				display:block;
				text-decoration:none !important;
				border:none !important;
			}

			.qassim-fiw-content img{
				transition:ease-in-out 1s;
				-moz-transition:ease-in-out 1s;
				-o-transition:ease-in-out 1s;
				-webkit-transition:ease-in-out 1s;
				width:100% !important;
				max-width:100% !important;
				height:auto !important;
			}

			.qassim-fiw-content:hover img{
				opacity:0.7;
				transform:scale(1.3);
				-webkit-transform:scale(1.3);
				-o-transform:scale(1.3);
				-moz-transform:scale(1.3);
				-ms-transform:scale(1.3);
			}
		</style>
    <?php
}
add_action( 'wp_head', 'QassimFeaturedImageWidget_CSS' ); 

?>