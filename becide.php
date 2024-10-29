<?php
/*
Plugin Name: Becide
Plugin URI: http://www.becide.com/pages/about/resources/widgetwp
Description: Let you vote decisions created in Becide
Version: 1.0.1
Author: Becide
Author URI: http://www.becide.com
License: GPL2
*/

/*  Copyright 2011 Becide Srl (email : info@becide.com)

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

function wpbecide_jquery() {
  wp_enqueue_script('jquery');
}
add_action('widgets_init','wpbecide_jquery');

class WPBecide extends WP_Widget {

  // constructor...
  function WPBecide() {
    $widget_ops = array( 'classname' => 'wpbecide', 'description' => __('Let you vote decisions created in Becide.') );
    $control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'wpbecide-widget' );
    $this->WP_Widget('wpbecide-widget', 'Becide', $widget_ops, $control_ops);
  }

  // displays/outputs the widgety goodness...
  function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    $becide_username = $instance['becide_username'];
    $becide_bckclr = ltrim($instance['becide_bckclr'], '#');
    $becide_txtclr = ltrim($instance['becide_txtclr'], '#');
    if ($title) echo $before_title.$title.$after_title;

    // let's get into the javascript...
?>
<iframe src="http://www.becide.com/decisions/wpwidget/<?php
  echo $becide_username? $becide_username: 'null';
?>/<?php
  echo $becide_bckclr? $becide_bckclr: 'null';
?>/<?php
  echo $becide_txtclr? $becide_txtclr: 'null';
?>" width="100%" height="360px">
  <p><?php
    _e('Your browser does not support iframes.');
  ?></p>
</iframe>
<?php
  }

  // handles...updating the widget...
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title']);
    $instance['becide_username'] = strip_tags( $new_instance['becide_username']);
    $instance['becide_bckclr'] = strip_tags( $new_instance['becide_bckclr']);
    $instance['becide_txtclr'] = strip_tags( $new_instance['becide_txtclr']);
    return $instance;
  }


  function form($instance) {
?>

<!-- widget title -->
<p>
  <label for="<?php
    echo $this->get_field_id('title');
  ?>"><?php
    _e('Title:');
  ?></label>
  <input class="widefat" id="<?php
    echo $this->get_field_id('title');
  ?>" name="<?php
    echo $this->get_field_name('title');
  ?>" value="<?php
    echo $instance['title'];
  ?>" />
</p>
<p>
  <label for="<?php
    echo $this->get_field_id('becide_username');
  ?>"><?php
    _e('Only decisions from username (optional):');
  ?></label>
  <input class="widefat" id="<?php
    echo $this->get_field_id('becide_username');
  ?>" name="<?php
    echo $this->get_field_name('becide_username');
  ?>" value="<?php
    echo $instance['becide_username'];
  ?>" />
</p>
<p>
  <label for="<?php
    echo $this->get_field_id('becide_bckclr');
  ?>"><?php
    _e('Background color (optional):');
  ?></label>
  <input class="widefat" id="<?php
    echo $this->get_field_id('becide_bckclr');
  ?>" name="<?php
    echo $this->get_field_name('becide_bckclr');
  ?>" value="<?php
    echo $instance['becide_bckclr'];
  ?>" />
</p>
<p>
  <label for="<?php
    echo $this->get_field_id('becide_txtclr');
  ?>"><?php
    _e('Text color (optional):');
  ?></label>
  <input class="widefat" id="<?php
    echo $this->get_field_id('becide_txtclr');
  ?>" name="<?php
    echo $this->get_field_name('becide_txtclr');
  ?>" value="<?php
    echo $instance['becide_txtclr'];
  ?>" />
</p>

<?php
  }
}

add_action('widgets_init','load_wpbecide');

function load_wpbecide() {
  register_widget('WPBecide');
}
?>