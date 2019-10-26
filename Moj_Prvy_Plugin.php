<?php
/*
Plugin Name: Moj Prvy Plugin
Plugin URI: https://www.ki.fpv.ukf.sk/
Description: Toto je moj prvy plugin a nema ziadny popis
Version: 1.0
Author: Dominik
Author URI: https://www.ki.fpv.ukf.sk/zamestnanci-2/mgr-dominik-halvonik/
License: MIT
*/

class Moj_Prvy_Plugin extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'moj_prvy_plugin',
            __('Moj Prvy Widget', 'text_domain'),
            array(
                'customize_selective_refresh' => true,
            )
        );
    }

    public function form($instance)
    {
        // Nastavenie prednastavenych hodnot pre widget
        $defaults = array(
            'title' => '',
            'text' => '',
            'textarea' => '',
            'checkbox' => '',
            'select' => '',
        );

        // Vytiahnutie defaultnych nastaveni WP instancie
        extract(wp_parse_args(( array )$instance, $defaults)); ?>

        <?php // Nazov
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Nazov', 'text_domain'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>

        <?php // Text Field
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                <?php _e('Text:', 'text_domain'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('text')); ?>"
                   type="text"
                   value="<?php echo esc_attr($text); ?>"/>
        </p>

        <?php // Textarea Field
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('textarea')); ?>">
                <?php _e('Textarea:', 'text_domain'); ?>
            </label>
            <textarea class="widefat"
                      id="<?php echo esc_attr($this->get_field_id('textarea')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('textarea')); ?>">
                <?php echo wp_kses_post($textarea); ?>
            </textarea>
        </p>

        <?php // Checkbox
        ?>
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('checkbox')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('checkbox')); ?>"
                   type="checkbox"
                   value="1" <?php checked('1', $checkbox); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('checkbox')); ?>">
                <?php _e('Checkbox', 'text_domain'); ?>
            </label>
        </p>

        <?php // Dropdown
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('select'); ?>">
                <?php _e('Select', 'text_domain'); ?>
            </label>
            <select name="<?php echo $this->get_field_name('select'); ?>"
                    id="<?php echo $this->get_field_id('select'); ?>"
                    class="widefat">
                <?php
                // Your options array
                $options = array(
                    '' => __('Select', 'text_domain'),
                    'option_1' => __('Option 1', 'text_domain'),
                    'option_2' => __('Option 2', 'text_domain'),
                    'option_3' => __('Option 3', 'text_domain'),
                );
                // Loop through options and add each one to the select dropdown
                foreach ($options as $key => $name) {
                    echo '<option value="' . esc_attr($key) . '" 
                                  id="' . esc_attr($key) . '" 
                                  ' . selected($select, $key, false) . '>
                            ' . $name . '
                          </option>';
                } ?>
            </select>
        </p>

        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = isset($new_instance['title']) ? wp_strip_all_tags($new_instance['title']) : '';
        $instance['text'] = isset($new_instance['text']) ? wp_strip_all_tags($new_instance['text']) : '';
        $instance['textarea'] = isset($new_instance['textarea']) ? wp_kses_post($new_instance['textarea']) : '';
        $instance['checkbox'] = isset($new_instance['checkbox']) ? 1 : false;
        $instance['select'] = isset($new_instance['select']) ? wp_strip_all_tags($new_instance['select']) : '';
        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args);

        // Check the widget options
        $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
        $textarea = isset($instance['textarea']) ? $instance['textarea'] : '';
        $select = isset($instance['select']) ? $instance['select'] : '';
        $checkbox = !empty($instance['checkbox']) ? $instance['checkbox'] : false;

        // WordPress core before_widget hook (always include )
        echo $before_widget;

        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Display widget title if defined
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        // Display text field
        if ($text) {
            echo '<p>' . $text . '</p>';
        }

        // Display textarea field
        if ($textarea) {
            echo '<p>' . $textarea . '</p>';
        }

        // Display select field
        if ($select) {
            echo '<p>' . $select . '</p>';
        }

        // Display something if checkbox is true
        if ($checkbox) {
            echo '<p>Nieco</p>';
        }

        echo '</div>';

        // WordPress core after_widget hook (always include )
        echo $after_widget;
    }
}

// Register the widget
function registracia_mojho_widgetu()
{
    register_widget('Moj_Prvy_Plugin');
}

add_action('widgets_init', 'registracia_mojho_widgetu');