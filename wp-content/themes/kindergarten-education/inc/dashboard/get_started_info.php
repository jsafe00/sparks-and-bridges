<?php

add_action( 'admin_menu', 'kindergarten_education_gettingstarted' );
function kindergarten_education_gettingstarted() {    	
	add_theme_page( esc_html__('About Theme', 'kindergarten-education'), esc_html__('About Theme', 'kindergarten-education'), 'edit_theme_options', 'kindergarten-education-guide-page', 'kindergarten_education_guide');   
}

function kindergarten_education_admin_theme_style() {
   wp_enqueue_style('kindergarten-education-custom-admin-style', get_template_directory_uri() . '/inc/dashboard/get_started_info.css');
}
add_action('admin_enqueue_scripts', 'kindergarten_education_admin_theme_style');

function kindergarten_education_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {?>
    <div class="notice notice-success is-dismissible getting_started">
		<div class="notice-content">
			<h2><?php esc_html_e( 'Thanks for installing Kindergarten Education Lite, you rock!', 'kindergarten-education' ) ?> </h2>
			<p><?php esc_html_e( 'Take benefit of a variety of features, functionalities, elements, and an exclusive set of customization options to build your own professional Kindergarten Education website. Please Click on the link below to know the theme setup information.', 'kindergarten-education' ) ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=kindergarten-education-guide-page' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Getting Started', 'kindergarten-education' ); ?></a></p>
		</div>
	</div>
	<?php }
}
add_action('admin_notices', 'kindergarten_education_notice');

/**
 * Theme Info Page
 */
function kindergarten_education_guide() {

	// Theme info
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'kindergarten-education' ); ?>

	<div class="wrap getting-started">
		<div class="getting-started__header">
			<div class="row">
				<div class="col-md-5 intro">
					<div class="pad-box">
						<h2><?php esc_html_e( 'Welcome to Kindergarten Education', 'kindergarten-education' ); ?></h2>
						<p>Version: <?php echo esc_html($theme['Version']);?></p>
						<span class="intro__version"><?php esc_html_e( 'Congratulations! You are about to use the most easy to use and flexible WordPress theme.', 'kindergarten-education' ); ?>	
						</span>
						<div class="powered-by">
							<p><strong><?php esc_html_e( 'Theme created by Buy WP Templates', 'kindergarten-education' ); ?></strong></p>
							<p>
								<img class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/theme-logo.png'); ?>"/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="pro-links">
				    	<a href="<?php echo esc_url( KINDERGARTEN_EDUCATION_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'kindergarten-education'); ?></a>
						<a href="<?php echo esc_url( KINDERGARTEN_EDUCATION_BUY_PRO ); ?>"><?php esc_html_e('Buy Pro', 'kindergarten-education'); ?></a>
						<a href="<?php echo esc_url( KINDERGARTEN_EDUCATION_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'kindergarten-education'); ?></a>
					</div>
					<div class="install-plugins">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/responsive1.png'); ?>" alt="" />
					</div>
				</div>
			</div>
			<h2 class="tg-docs-section intruction-title" id="section-4"><?php esc_html_e( '1). Setup Kindergarten Education Theme', 'kindergarten-education' ); ?></h2>
			<div class="row">
				<div class="theme-instruction-block col-md-7">
					<div class="pad-box">
	                    <p><?php esc_html_e( 'The Kindergarten Education is a beautiful and minimal kids school theme . It is a kids school theme with plenty of features, user-friendly customization and personalization options. It includes features such as quick page speed, mobile friendly design, cross browser compatibility, SEO friendly, translation ready, etc. It shows a large slider with a banner that has a Call to Action Button (CTA) to attract the visitors. It is compatible with WooCommerce and features layouts for products, posts, and pages. It has secure and clean codes that do not allow you to write even a single line of code. It offers a bunch of shortcodes that helps in incorporating functional features. This kindergarten theme is based on Bootstrap framework which enhances the speed of development. Also, it has an interactive demo for easy understanding.', 'kindergarten-education' ); ?><p><br>
						<ol>
							<li><?php esc_html_e( 'Start','kindergarten-education'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizing','kindergarten-education'); ?></a> <?php esc_html_e( 'your website.','kindergarten-education'); ?> </li>
							<li><?php esc_html_e( 'Kindergarten Education','kindergarten-education'); ?> <a target="_blank" href="<?php echo esc_url( KINDERGARTEN_EDUCATION_FREE_DOC ); ?>"><?php esc_html_e( 'Documentation','kindergarten-education'); ?></a> </li>
						</ol>
                    </div>
              	</div>
				<div class="col-md-5">
					<div class="pad-box">
              			<img class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/screenshot.png'); ?>"/>
              		 </div> 
              	</div>
            </div>
			<div class="col-md-12 text-block">
					<h2 class="dashboard-install-title"><?php esc_html_e( '2.) Premium Theme Information.','kindergarten-education'); ?></h2>
					<div class="row">
						<div class="col-md-7">
							<img src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/responsive.png'); ?>" alt="">
							<div class="pad-box">
								<h3><?php esc_html_e( 'Pro Theme Description','kindergarten-education'); ?></h3>
	                    		<p class="pad-box-p"><?php esc_html_e( 'This premium education WordPress theme is vibrant, colourful, fresh and lively. It imparts happy and positive vibes to the visitors. The jovial approach it carries is sure to attract visitors into taking your services. The theme is best fit for kindergartens, child care centres, preschools, nurseries, primary schools and other kids websites. With great scope of customizations, the theme can be used for high schools, colleges, universities, training institutes, coaching centres, LMS and for any learning academy. This education WordPress theme is well built on Bootstrap framework to ease its usage for WordPress newbie as well as webmasters. The user-friendly interface of front-end and back-end enhances its usability to both website admin and visitor equally. The themes clean design leads to hassle-free navigation. Users will instantly find what they are looking for within moments of landing on the site without wandering here and there. Your site will stand strong against any security breach thanks to its clean and secure code. The whole design of the premium education theme maintains a flow that binds visitors to explore everything about you and convert mere site visitors into potential customers.', 'kindergarten-education' ); ?><p>
	                    	</div>
						</div>
						<div class="col-md-5 install-plugin-right">
							<div class="pad-box">								
								<h3><?php esc_html_e( 'Pro Theme Features','kindergarten-education'); ?></h3>
								<div class="dashboard-install-benefit">
									<ul>
										<li><?php esc_html_e( 'Theme options using customizer API','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Responsive design','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Favicon, Logo, title and tagline customization','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Advanced Color options and color pallets','kindergarten-education'); ?></li>
										<li><?php esc_html_e( '100+ Font Family Options','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Pagination option','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Fade Slider With different Tabs','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Unlimited Slides','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'About the Company section','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Services Listing','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Form to get a Free quote using Contact Form 7','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Pricing Plans section','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Seperate section to defind the flow of work','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Testimonial Section with shortcode','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'FAQ Section on Home with its shortcode','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Brand/Partner Listing Section','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Social Icon Widget, tagline, logo.','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Social Sharing On post','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Well sanitized as per WordPress standards.','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Responsive layout for all devices','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Fully integrated with Font Awesome Icon','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Background Image Option','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Custom page templates','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Allow to set site title, tagline, logo','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Left and Right Sidebar','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Sticky post & Comment threads','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Customizable Home Page','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Multiple inner page templates','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Contact Page Template','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Blog Full width and right and left sidebar','kindergarten-education'); ?></li>
										<li><?php esc_html_e( 'Recent post widget with images, Related post','kindergarten-education'); ?></li>
									</ul>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="dashboard__blocks">
			<div class="row">
				<div class="col-md-3">
					<h3><?php esc_html_e( 'Get Support','kindergarten-education'); ?></h3>
					<ol>
						<li><a target="_blank" href="<?php echo esc_url( KINDERGARTEN_EDUCATION_FREE_SUPPORT ); ?>"><?php esc_html_e( 'Free Theme Support','kindergarten-education'); ?></a></li>
						<li><a target="_blank" href="<?php echo esc_url( KINDERGARTEN_EDUCATION_PRO_SUPPORT ); ?>"><?php esc_html_e( 'Premium Theme Support','kindergarten-education'); ?></a></li>
					</ol>
				</div>

				<div class="col-md-3">
					<h3><?php esc_html_e( 'Getting Started','kindergarten-education'); ?></h3>
					<ol>
						<li><?php esc_html_e( 'Start','kindergarten-education'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizing','kindergarten-education'); ?></a> <?php esc_html_e( 'your website.','kindergarten-education'); ?> </li>
					</ol>
				</div>
				<div class="col-md-3">
					<h3><?php esc_html_e( 'Help Docs','kindergarten-education'); ?></h3>
					<ol>
						<li><a target="_blank" href="<?php echo esc_url( KINDERGARTEN_EDUCATION_FREE_DOC ); ?>"><?php esc_html_e( 'Free Theme Documentation','kindergarten-education'); ?></a></li>
						<li><a target="_blank" href="<?php echo esc_url( KINDERGARTEN_EDUCATION_PRO_DOC ); ?>"><?php esc_html_e( 'Premium Theme Documentation','kindergarten-education'); ?></a></li>
					</ol>
				</div>
				<div class="col-md-3">
					<h3><?php esc_html_e( 'Buy Premium','kindergarten-education'); ?></h3>
					<ol>
						<a href="<?php echo esc_url( KINDERGARTEN_EDUCATION_BUY_PRO ); ?>"><?php esc_html_e('Buy Pro', 'kindergarten-education'); ?></a>
					</ol>
				</div>
			</div>
		</div>
	</div>

<?php }?>