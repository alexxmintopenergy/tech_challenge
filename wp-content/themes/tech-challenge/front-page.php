<?php

get_header();

$slider       = get_field( 'slider' );
$product_info = get_field( 'product_info' );
$contact_form = get_field( 'contact_form_shortcode' );

?>

<?php if ( $slider ) : ?>
	<section id="hero_slider">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="product-slider swiper-container">
						<div class="swiper-wrapper">
							<?php foreach ( $slider as $slide ) : ?>
								<div class="product-slide swiper-slide">
									<div class="slide-content col-md-6 col-sm-12">
										<h1><?php echo esc_html( $slide['slide_title'] ); ?></h1>
										<p><?php echo esc_html( $slide['description'] ); ?></p>
										<a href="<?php echo esc_url( $slide['button']['url'] ); ?>"><?php echo esc_html( $slide['button']['title'] ); ?></a>
									</div>
									<div class="slide-image col-md-6 col-sm-12">
										<img src="<?php echo esc_url( $slide['slide_image']['url'] ); ?>" alt="<?php echo esc_attr( $slide['image']['alt'] ); ?>">
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( $product_info ) : ?>
	<section id="product_info" class="our-product">
		<div class="container d-flex">
			<ul id="tabs" class="nav nav-tabs col-md-3 col-sm-12" role="tablist">
				<?php
				$count = 0;
				foreach ( $product_info as $product ) :
					$product_tab = str_replace( ' ', '', $product['tab_title'] );
					$product_tab = strtolower( $product_tab )
					?>
					<li class="nav-item flex-column nav-pills nav-pills-custom">
						<a id="tab-<?php echo esc_html( $product_tab ); ?>" href="#pane-<?php echo esc_html( $product_tab ); ?>" class="nav-link <?php echo ( $count == 0 ? 'active' : '' ); ?>" data-toggle="tab" role="tab">
							<?php echo esc_html( $product['tab_title'] ); ?>
						</a>
					</li>
					<?php $count++; ?>
				<?php endforeach; ?>
			</ul>


			<div id="content" class="tab-content" role="tablist">
				<?php
				$count = 0;
				foreach ( $product_info as $product ) :
					$product_tab = str_replace( ' ', '', $product['tab_title'] );
					$product_tab = strtolower( $product_tab )
					?>
					<div id="pane-<?php echo esc_html( $product_tab ); ?>"
						 class="card tab-pane fade show  <?php echo ( $count == 0 ? 'active' : '' ); ?>"
						 role="tabpanel"
						 aria-labelledby="tab-<?php echo esc_html( $product_tab ); ?>">
						<div class="card-header" role="tab" id="heading-<?php echo esc_html( $product_tab ); ?>">
							<h5 class="mb-0">
								<a data-toggle="collapse" href="#collapse-<?php echo esc_html( $product_tab ); ?>" aria-expanded="true" aria-controls="collapse-<?php echo esc_html( $product_tab ); ?>">
									<?php echo esc_html( $product['tab_title'] ); ?>
                                    <div class="accordion-toogle"></div>
                                </a>
							</h5>
						</div>

						<div id="collapse-<?php echo esc_html( $product_tab ); ?>" class="collapse <?php echo ( $count == 0 ? 'show' : '' ); ?>" data-parent="#content" role="tabpanel" aria-labelledby="heading-<?php echo esc_html( $product_tab ); ?>">
							<div class="card-body new-card-body">
								<div class="row">
									<div class="col-md-12">
										<p><?php echo wp_kses_post( $product['tab_content'] ); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $count++; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( $contact_form ) : ?>
	<section id="contact_form">
		<div class="container">
			<div class="contact-us">
				<h2>Contact Us</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php echo do_shortcode( $contact_form ); ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>


<?php

get_footer();

