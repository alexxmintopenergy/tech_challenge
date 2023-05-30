<?php


/**
 * The core plugin class.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Technical_Challenge
 * @subpackage Technical_Challenge/includes
 * @author     Oleksandr Popov <wsartua@gmail.com>
 */
class Technical_Challenge {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The table name of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $table_name    The table name of the plugin.
	 */
	private string $table_name;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TECHNICAL_CHALLENGE_VERSION' ) ) {
			$this->version = TECHNICAL_CHALLENGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'technical-challenge';

		$this->activate();

		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tcp_custom_table';

		add_action( 'admin_menu', array( $this, 'create_plugin_dashboard_page' ) );

		add_action( 'wp_ajax_tcp_custom_action', array( $this, 'handle_ajax' ) );
		add_action( 'wp_ajax_nopriv_tcp_custom_action', array( $this, 'handle_ajax' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . 'tcp_custom_table';

		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {

			$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name tinytext NOT NULL,
			PRIMARY KEY (id)
			) $charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );

		}

		$dummy_data_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
		if ( $dummy_data_count == 0 ) {
			$wpdb->insert( $table_name, array( 'name' => 'Hello world! - Dummy content' ) );
		}
	}

	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'tcp_custom_table';

		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
	}

    public function enqueue_scripts() {
        wp_enqueue_script( 'handle_ajax', plugin_dir_url( __FILE__ ) . '../admin/js/admin.js', array( 'jquery' ) );

        wp_enqueue_style( 'my_admin_style', plugin_dir_url( __FILE__ ) . '../admin/css/admin.css' );

        wp_localize_script(
            'handle_ajax',
            'tcp_vars',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            )
        );
    }

	public function create_plugin_dashboard_page() {
		$page_title = 'Tech Challenge';
		$menu_title = 'Tech Challenge';
		$capability = 'manage_options';
		$slug       = 'tech-challenge';
		$callback   = array( $this, 'plugin_page' );
		$icon       = 'dashicons-tickets';
		$position   = 6;

		add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
	}

	public function plugin_page() {
		echo '<h1>' . esc_html( 'Welcome!', 'tcp' ) . '</h1>';

		global $wpdb;
		$table_name = $wpdb->prefix . 'tcp_custom_table';
		$results    = $wpdb->get_results( "SELECT * FROM $table_name" );

		foreach ( $results as $result ) {
			echo '<p>' . $result->name . '</p>';
		}

        echo '<button id="tcp_button" class="tcp-get-news-button">' . esc_html( 'Get news!', 'tcp' ) . '</button>';
		echo '<div id="our_clients"></div>';
	}


    public function handle_ajax() {
        $args  = array( 'posts_per_page' => 10 );
        $posts = get_posts( $args );
        $data = array();

        foreach ( $posts as $post ) {
            setup_postdata( $post );
            $item = array(
                'title' => get_the_title( $post->ID ),
                'link' => get_permalink( $post->ID ),
                'thumbnail' => get_the_post_thumbnail_url( $post->ID ),
                'excerpt' => get_the_excerpt( $post->ID )
            );
            array_push($data, $item);
        }

        wp_reset_postdata();

        echo json_encode($data);
        wp_die();
    }

}
