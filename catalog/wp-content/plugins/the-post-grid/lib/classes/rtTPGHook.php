<?php
if (!class_exists('rtTPGHook')):
    class rtTPGHook {

        function __construct() {
            add_filter('tpg_author_arg', array(__CLASS__, 'filter_author_args'), 10);
            add_action('pre_get_posts', array(__CLASS__, 'category_query'), 10);
            add_filter('plugin_row_meta', array(__CLASS__, 'plugin_row_meta'), 10, 2);
        }

        static function category_query($query) {
            if (!is_admin() && is_category() && $query->is_main_query()) {
                $settings = get_option(rtTPG()->options['settings']);
                $sc_id = isset($settings['template_category']) ? absint($settings['template_category']) : 0;
                if ($sc_id) {
                    $posts_per_page = $sc_id ? absint(get_post_meta($sc_id, 'posts_per_page', true)) : 0;
                    $pagination = $sc_id ? get_post_meta($sc_id, 'pagination', true) : false;
                    $posts_loading_type = $sc_id ? get_post_meta($sc_id, 'posts_loading_type', true) : '';
                    if ($pagination && $posts_loading_type === 'pagination' && $posts_per_page) {
                        $query->set('posts_per_page', $posts_per_page);
                    }
                }
            }
        }

        static function filter_author_args($args) {
            $defaults = array('role__in' => array('administrator', 'editor', 'author'));

            return wp_parse_args($args, $defaults);
        }

        static public function plugin_row_meta($links, $file) {
            if ($file == RT_THE_POST_GRID_PLUGIN_ACTIVE_FILE_NAME) {
                $report_url = 'https://www.radiustheme.com/contact/';
                $row_meta['issues'] = sprintf('%2$s <a target="_blank" href="%1$s">%3$s</a>', esc_url($report_url), esc_html__('Facing issue?', 'the-post-grid'), '<span style="color: red">' . esc_html__('Please open a support ticket.', 'the-post-grid') . '</span>');
                return array_merge($links, $row_meta);
            }
            return (array)$links;
        }

    }

endif;