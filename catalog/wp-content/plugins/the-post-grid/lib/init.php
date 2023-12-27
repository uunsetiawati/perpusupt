<?php

if ( ! class_exists( 'rtTPG' ) ) {

	class rtTPG {
		public $options;
		public $post_type;
		public $assetsUrl;
		public $defaultSettings;

		protected static $_instance;

		function __construct() {

			$this->options         = array(
				'settings'          => 'rt_the_post_grid_settings',
				'version'           => RT_THE_POST_GRID_VERSION,
				'installed_version' => 'rt_the_post_grid_current_version',
				'slug'              => RT_THE_POST_GRID_PLUGIN_SLUG
			);
			$this->defaultSettings = array(
				'custom_css' => null
			);

			$this->post_type    = "rttpg";
			$this->libPath      = dirname( __FILE__ );
			$this->modelsPath   = $this->libPath . '/models/';
			$this->classesPath  = $this->libPath . '/classes/';
			$this->widgetsPath  = $this->libPath . '/widgets/';
			$this->viewsPath    = $this->libPath . '/views/';
			$this->templatePath = $this->libPath . '/templates/';
			$this->assetsUrl    = RT_THE_POST_GRID_PLUGIN_URL . '/assets/';

			$this->rtLoadModel( $this->modelsPath );
			$this->rtLoadClass( $this->classesPath );
			$this->defaultSettings = array(
				'popup_fields'       => array(
					'title',
					'feature_img',
					'content',
					'post_date',
					'author',
					'categories',
					'tags',
					'social_share',
				),
				'social_share_items' => array(
					'facebook',
					'twitter',
					'linkedin'
				),
				'custom_css'         => null
			);
			add_filter( 'wp_calculate_image_srcset', '__return_false' );
            add_action('admin_footer', array($this, 'pro_alert_html'));

		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function rtLoadModel( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
				}
			}
		}

		function rtLoadClass( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			$classes = array();
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$className = str_replace( ".php", "", $item );
					$classes[] = new $className;
				}
			}
			if ( $classes ) {
				foreach ( $classes as $class ) {
					$this->objects[] = $class;
				}
			}
		}

		function loadWidget( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$class = str_replace( ".php", "", $item );
					if ( method_exists( $class, 'register_widget' ) ) {
						$caller = new $class;
						$caller->register_widget();
					} else {
						register_widget( $class );
					}
				}
			}
		}

        /**
         * Get the plugin path.
         *
         * @return string
         */
        public function plugin_path() {
            return untrailingslashit(plugin_dir_path(__FILE__));
        }

        public function plugin_template_path() {
            $plugin_template = $this->plugin_path() . '/templates/';

            return apply_filters('tlp_tpg_template_path', $plugin_template);
        }

		/**
		 * @param       $viewName
		 * @param array $args
		 * @param bool  $return
		 *
		 * @return string|void
		 */
		function render_view( $viewName, $args = array(), $return = false ) {
			$path     = str_replace( ".", "/", $viewName );
			$viewPath = $this->viewsPath . $path . '.php';
			if ( ! file_exists( $viewPath ) ) {
				return;
			}
			if ( $args ) {
				extract( $args );
			}
			if ( $return ) {
				ob_start();
				include $viewPath;

				return ob_get_clean();
			}
			include $viewPath;
		}

		/**
		 * @param       $viewName
		 * @param array $args
		 * @param bool  $return
		 *
		 * @return string|void
		 */
		function render( $viewName, $args = array(), $return = false ) {

			$path = str_replace( ".", "/", $viewName );
			if ( $args ) {
				extract( $args );
			}
			$template = array(
				"the-post-grid-pro/{$path}.php",
				"the-post-grid/{$path}.php"
			);

			if ( ! $template_file = locate_template( $template ) ) {
				$template_file = $this->plugin_template_path() . $path . '.php';
			}
			if ( ! file_exists( $template_file ) ) {
				return;
			}
			if ( $return ) {

				ob_start();
				include $template_file;

				return ob_get_clean();
			} else {

				include $template_file;
			}
		}

		/**
		 * Dynamically call any  method from models class
		 * by pluginFramework instance
		 */
		function __call( $name, $args ) {
			if ( ! is_array( $this->objects ) ) {
				return;
			}
			foreach ( $this->objects as $object ) {
				if ( method_exists( $object, $name ) ) {
					$count = count( $args );
					if ( $count == 0 ) {
						return $object->$name();
					} elseif ( $count == 1 ) {
						return $object->$name( $args[0] );
					} elseif ( $count == 2 ) {
						return $object->$name( $args[0], $args[1] );
					} elseif ( $count == 3 ) {
						return $object->$name( $args[0], $args[1], $args[2] );
					} elseif ( $count == 4 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3] );
					} elseif ( $count == 5 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4] );
					} elseif ( $count == 6 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4], $args[5] );
					}
				}
			}
		}

        public function hasPro() {
            return class_exists('rtTPGP') ? true : false;
        }

        public function pro_alert_html() {
            global $typenow;

            if ($this->hasPro()) return;

            if ( ( isset( $_GET['page'] ) && $_GET['page'] != 'rttpg_settings' ) || $typenow != $this->post_type ) {
                return;
            }

            $html = '';
            $html .= '<div class="rt-document-box rt-alert rt-pro-alert">
                <div class="rt-box-icon"><i class="dashicons dashicons-lock"></i></div>
                <div class="rt-box-content">
                    <h3 class="rt-box-title">' . esc_html__( 'Pro field alert!', 'the-post-grid' ) . '</h3>
                    <p><span></span>' . esc_html__( 'Sorry! this is a pro field. To use this field, you need to use pro plugin.', 'the-post-grid' ) . '</p>
                    <a href="https://www.radiustheme.com/downloads/the-post-grid-pro-for-wordpress/" target="_blank" class="rt-admin-btn">' . esc_html__("Upgrade to pro", "the-post-grid") . '</a>
                    <a href="#" target="_blank" class="rt-alert-close rt-pro-alert-close">x</a>
                </div>
            </div>';
            echo $html;
        }

	}

	function rtTPG() {
		return rtTPG::instance();
	}

	rtTPG();

}
