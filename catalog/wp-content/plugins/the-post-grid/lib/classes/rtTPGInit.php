<?php

if (!class_exists('rtTPGInit')):
    class rtTPGInit {

        private $version;

        function __construct() {
            $this->version = defined('WP_DEBUG') && WP_DEBUG ? time() : RT_THE_POST_GRID_VERSION;
            add_action('init', array($this, 'init'), 1);
            add_action('admin_init', array($this, 'the_post_grid_remove_all_meta_box'), 9999);
            add_action('admin_menu', array($this, 'tgp_menu_register'));
            add_action('plugins_loaded', array($this, 'the_post_grid_load_text_domain'));
            register_activation_hook(RT_THE_POST_GRID_PLUGIN_ACTIVE_FILE_NAME, array($this, 'activate'));
            register_deactivation_hook(RT_THE_POST_GRID_PLUGIN_ACTIVE_FILE_NAME, array($this, 'deactivate'));
            add_filter('plugin_action_links_' . RT_THE_POST_GRID_PLUGIN_ACTIVE_FILE_NAME, array(
                $this,
                'rt_post_grid_marketing'
            ));
            add_action('admin_enqueue_scripts', array($this, 'settings_admin_enqueue_scripts'));
            add_action( 'wp_print_styles', [$this, 'tpg_dequeue_unnecessary_styles'], 99 );
        }

        function tpg_dequeue_unnecessary_styles() {
            $settings = get_option(rtTPG()->options['settings']);

            if (isset($settings['tpg_skip_fa'])) {
                wp_dequeue_style( 'rt-fontawsome' );
                wp_deregister_style( 'rt-fontawsome' );
            }
        }

        function the_post_grid_remove_all_meta_box() {
            if (is_admin() && apply_filters('rttpg_remove_all_extra_metabox_from_shordcode', true)) {
                add_filter("get_user_option_meta-box-order_" . rtTPG()->post_type, array(
                    $this,
                    'remove_all_meta_boxes_tgp_sc'
                ));
            }
	        if ( get_option('rttpg_activation_redirect', false) ) {
		        delete_option('rttpg_activation_redirect');
		        wp_redirect( admin_url('edit.php?post_type=rttpg&page=rttpg_get_help') );
	        }
        }

        function remove_all_meta_boxes_tgp_sc() {
            global $wp_meta_boxes;
            if (isset($wp_meta_boxes[rtTPG()->post_type]['normal']['high']['rttpg_meta']) && $wp_meta_boxes[rtTPG()->post_type]['normal']['high']['rttpg_sc_preview_meta'] && $wp_meta_boxes[rtTPG()->post_type]['side']['low']['rt_plugin_sc_pro_information'] ) {
                $publishBox = $wp_meta_boxes[rtTPG()->post_type]['side']['core']['submitdiv'];
                $scBox = $wp_meta_boxes[rtTPG()->post_type]['normal']['high']['rttpg_meta'];
                $scBoxPreview = $wp_meta_boxes[rtTPG()->post_type]['normal']['high']['rttpg_sc_preview_meta'];
                $docBox = $wp_meta_boxes[rtTPG()->post_type]['side']['low']['rt_plugin_sc_pro_information'];

                $wp_meta_boxes[rtTPG()->post_type] = array(
                    'side'   => array(
                        'core' => array('submitdiv' => $publishBox),
                        'default' => [
                            'rt_plugin_sc_pro_information' => $docBox
                        ]
                    ),
                    'normal'   => array('high' => array('submitdiv' => $scBox)),
                    'advanced' => array('high' => array('postexcerpt' => $scBoxPreview))
                );

                return array();
            }
        }

        function init() {

            // Create the post grid post type
            $labels = array(
                'name'               => __('The Post Grid', 'the-post-grid'),
                'singular_name'      => __('The Post Grid', 'the-post-grid'),
                'add_new'            => __('Add New Grid', 'the-post-grid'),
                'all_items'          => __('All Grids', 'the-post-grid'),
                'add_new_item'       => __('Add New Post Grid', 'the-post-grid'),
                'edit_item'          => __('Edit Post Grid', 'the-post-grid'),
                'new_item'           => __('New Post Grid', 'the-post-grid'),
                'view_item'          => __('View Post Grid', 'the-post-grid'),
                'search_items'       => __('Search Post Grids', 'the-post-grid'),
                'not_found'          => __('No Post Grids found', 'the-post-grid'),
                'not_found_in_trash' => __('No Post Grids found in Trash', 'the-post-grid'),
            );

            register_post_type(rtTPG()->post_type, array(
                'labels'          => $labels,
                'public'          => false,
                'show_ui'         => true,
                '_builtin'        => false,
                'capability_type' => 'page',
                'hierarchical'    => true,
                'menu_icon'       => rtTPG()->assetsUrl . 'images/icon-16x16.png',
                'rewrite'         => false,
                'query_var'       => rtTPG()->post_type,
                'supports'        => array(
                    'title',
                ),
                'show_in_menu'    => true,
                'menu_position'   => 20,
            ));

            // register scripts
            $scripts = array();
            $styles = array();
            $scripts[] = array(
                'handle' => 'rt-image-load-js',
                'src'    => rtTPG()->assetsUrl . "vendor/isotope/imagesloaded.pkgd.min.js",
                'deps'   => array('jquery'),
                'footer' => true
            );
            $scripts[] = array(
                'handle' => 'rt-isotope-js',
                'src'    => rtTPG()->assetsUrl . "vendor/isotope/isotope.pkgd.min.js",
                'deps'   => array('jquery'),
                'footer' => true
            );

            $scripts[] = array(
                'handle' => 'rt-tpg',
                'src'    => rtTPG()->assetsUrl . "js/rttpg.js",
                'deps'   => array('jquery'),
                'footer' => true
            );
            // register acf styles
            $styles['rt-fontawsome'] = rtTPG()->assetsUrl . 'vendor/font-awesome/css/font-awesome.min.css';
            $styles['rt-tpg'] = rtTPG()->assetsUrl . 'css/thepostgrid.css';
            $styles['rt-tpg-rtl'] = rtTPG()->assetsUrl . 'css/thepostgrid-rtl.css';

            if (is_admin()) {

                $scripts[] = array(
                    'handle' => 'rt-select2',
                    'src'    => rtTPG()->assetsUrl . "vendor/select2/select2.min.js",
                    'deps'   => array('jquery'),
                    'footer' => false
                );
                $scripts[] = array(
                    'handle' => 'rt-tpg-admin',
                    'src'    => rtTPG()->assetsUrl . "js/admin.js",
                    'deps'   => array('jquery'),
                    'footer' => true
                );
                $scripts[] = array(
                    'handle' => 'rt-tpg-admin-preview',
                    'src'    => rtTPG()->assetsUrl . "js/admin-preview.js",
                    'deps'   => array('jquery'),
                    'footer' => true
                );
                $styles['rt-select2'] = rtTPG()->assetsUrl . 'vendor/select2/select2.min.css';
                $styles['rt-tpg-admin'] = rtTPG()->assetsUrl . 'css/admin.css';
                $styles['rt-tpg-admin-preview'] = rtTPG()->assetsUrl . 'css/admin-preview.css';
            }

            foreach ($scripts as $script) {
                wp_register_script($script['handle'], $script['src'], $script['deps'], isset($script['version']) ? $script['version'] : $this->version, $script['footer']);
            }

            foreach ($styles as $k => $v) {
                wp_register_style($k, $v, false, isset($script['version']) ? $script['version'] : $this->version);
            }
        }

        function tgp_menu_register() {
            add_submenu_page('edit.php?post_type=' . rtTPG()->post_type, __('Settings'), __('Settings', "the-post-grid"), 'administrator', 'rttpg_settings', array(
                $this,
                'rttpg_settings'
            ));
	        add_submenu_page('edit.php?post_type=' . rtTPG()->post_type, __('Get Help'), __('Get Help', "the-post-grid"), 'administrator', 'rttpg_get_help', array(
		        $this,
		        'get_help'
	        ));
        }

        function rttpg_settings() {
            rtTPG()->render_view('settings.settings');
        }

	    function get_help() {
		    rtTPG()->render_view('pages.help');
	    }

        public function the_post_grid_load_text_domain() {
            load_plugin_textdomain('the-post-grid', false, RT_THE_POST_GRID_LANGUAGE_PATH);
        }

        function activate() {
            $this->insertDefaultData();
	        add_option('rttpg_activation_redirect', true);
        }

        function deactivate() {

        }

        private function insertDefaultData() {
            update_option(rtTPG()->options['installed_version'], RT_THE_POST_GRID_VERSION);
            if (!get_option(rtTPG()->options['settings'])) {
                update_option(rtTPG()->options['settings'], rtTPG()->defaultSettings);
            }
        }

        function rt_post_grid_marketing($links) {
            $links[] = '<a target="_blank" href="' . esc_url('https://www.radiustheme.com/demo/plugins/the-post-grid/') . '">Demo</a>';
            $links[] = '<a target="_blank" href="' . esc_url('https://www.radiustheme.com/docs/the-post-grid/') . '">Documentation</a>';
            if (!rtTPG()->hasPro()) {
                $links[] = '<a target="_blank" style="color: #39b54a;font-weight: 700;" href="' . esc_url('https://www.radiustheme.com/downloads/the-post-grid-pro-for-wordpress/') . '">Get Pro</a>';
            }

            return $links;
        }

        function settings_admin_enqueue_scripts() {
            global $pagenow, $typenow;

            // validate page
            if (!in_array($pagenow, array('edit.php'))) {
                return;
            }
            if ($typenow != rtTPG()->post_type) {
                return;
            }

            wp_enqueue_script(array(
                'jquery',
                'rt-tpg-admin'
            ));

            // styles
            wp_enqueue_style(array(
                'rt-tpg-admin'
            ));

            $nonce = wp_create_nonce(rtTPG()->nonceText());
            wp_localize_script('rt-tpg-admin', 'rttpg',
                array(
                    'nonceID' => rtTPG()->nonceId(),
                    'nonce'   => $nonce,
                    'ajaxurl' => admin_url('admin-ajax.php')
                ));
        }
    }
endif;