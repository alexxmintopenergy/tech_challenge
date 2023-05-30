<?php
/**
 * The header for our theme
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<div class="site" id="page">

	<nav class="navbar navbar-expand-md navbar-light bg-light" role="navigation">
		<div class="container">
            <a class="navbar-brand" href="#"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.svg' ?>"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-1" aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'your-theme-slug' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'header-menu',
					'depth'           => 2,
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'navbar-collapse-1',
					'menu_class'      => 'nav navbar-nav',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(),
				)
			);
			?>
		</div>
	</nav>
