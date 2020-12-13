<?php

	$kindergarten_education_first_color = get_theme_mod('kindergarten_education_first_color');

	$kindergarten_education_custom_css ='';

	/*-------------- Global First Color -----------------*/
	$kindergarten_education_custom_css .='input[type="submit"], .primary-navigation ul ul a, .postbtn a:hover, .blog-section .section-title a:after, .datebox, .woocommerce span.onsale, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, nav.woocommerce-MyAccount-navigation ul li, #comments input[type="submit"].submit, #comments a.comment-reply-link, #comments a.comment-reply-link, #sidebar h3, #sidebar .tagcloud a, .widget_calendar tbody a, .page-content .read-moresec a.button, .copyright-wrapper , .footer-wp h3:after , .footer-wp input[type="submit"], .footer-wp .tagcloud a, .pagination span, .pagination a, .footer-wp input[type="submit"], .footer-wp button, #sidebar button{';
			$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_first_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='a, .page-template-custom-home-page .search-box span i, .page-template-custom-home-page #header .logo a, nav.navigation.post-navigation a , .metabox a:hover, #sidebar ul li a, .footer-wp li a:hover, h2.entry-title, h2.page-title{';
			$kindergarten_education_custom_css .='color: '.esc_attr($kindergarten_education_first_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='.postbtn a:hover, .datebox, .page-content .read-moresec a.button {';
			$kindergarten_education_custom_css .='border-color: '.esc_attr($kindergarten_education_first_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='.copyright-wrapper{';
			$kindergarten_education_custom_css .='border-top-color: '.esc_attr($kindergarten_education_first_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='@media screen and (max-width: 768px){
		#header, #header .logo{';
			$kindergarten_education_custom_css .='background: '.esc_attr($kindergarten_education_first_color).';';
	$kindergarten_education_custom_css .='} }';

	/*------------------ Global Second Color ---------------------*/
	$kindergarten_education_second_color = get_theme_mod('kindergarten_education_second_color');

	$kindergarten_education_custom_css .='.more-btn a, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, #comments input[type="submit"].submit:hover, .page-content .read-moresec a.button:hover, .footer-wp .tagcloud a:hover , .pagination a:hover, .pagination .current, input[type="submit"]:hover, .more-btn a, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, #comments input[type="submit"].submit:hover, .page-content .read-moresec a.button:hover, .footer-wp .tagcloud a:hover, .pagination a:hover, .pagination .current, input[type="submit"]:hover , #sidebar .tagcloud a:hover{';
			$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_second_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='.more-btn a:hover, nav.navigation.post-navigation a:hover, .footer-wp .textwidget p a:hover, .testbutton a:hover, .more-btn a:hover, nav.navigation.post-navigation a:hover, .footer-wp .textwidget p a:hover, .testbutton a:hover{';
			$kindergarten_education_custom_css .='color: '.esc_attr($kindergarten_education_second_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='.more-btn a, .page-content .read-moresec a.button:hover, .more-btn a, .page-content .read-moresec a.button:hover{';
			$kindergarten_education_custom_css .='border-color: '.esc_attr($kindergarten_education_second_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='{';
			$kindergarten_education_custom_css .='border-top-color: '.esc_attr($kindergarten_education_second_color).';';
	$kindergarten_education_custom_css .='}';

	/*------------------------------ Global Third Color ---------------------*/
	$kindergarten_education_third_color = get_theme_mod('kindergarten_education_third_color');

	$kindergarten_education_custom_css .='.primary-navigation ul ul a:hover, .primary-navigation ul ul a:focus, .inner-box-cat-tag{';
			$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_third_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='.primary-navigation ul ul a, #sidebar ul, #sidebar .widget_shopping_cart_content, #sidebar .tagcloud, #sidebar .textwidget,#sidebar form, #sidebar #calendar_wrap, .inner-box{';
			$kindergarten_education_custom_css .='border-color: '.esc_attr($kindergarten_education_third_color).';';
	$kindergarten_education_custom_css .='}';

	/*---------- Global Fourth Color ----------------*/
	$kindergarten_education_fourth_color = get_theme_mod('kindergarten_education_fourth_color');

	$kindergarten_education_custom_css .='.inner-box{';
		$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_fourth_color).';';
	$kindergarten_education_custom_css .='}';

	/*---------------------------Width Layout -------------------*/

	$kindergarten_education_theme_lay = get_theme_mod( 'kindergarten_education_width_layout_options','Default');
    if($kindergarten_education_theme_lay == 'Default'){
		$kindergarten_education_custom_css .='body{';
			$kindergarten_education_custom_css .='max-width: 100%;';
		$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == 'Container Layout'){
		$kindergarten_education_custom_css .='body{';
			$kindergarten_education_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$kindergarten_education_custom_css .='}';
		$kindergarten_education_custom_css .='
		@media screen and (max-width: 768px){
		.page-template-custom-home-page #header{';
		$kindergarten_education_custom_css .='width:100%;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_theme_lay == 'Box Layout'){
		$kindergarten_education_custom_css .='body{';
			$kindergarten_education_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$kindergarten_education_custom_css .='}';
		$kindergarten_education_custom_css .='.page-template-custom-home-page header{';
			$kindergarten_education_custom_css .='position: relative';
		$kindergarten_education_custom_css .='}';
	}

	/*-----------------Slider Content Layout -------------------*/
	$kindergarten_education_theme_lay = get_theme_mod( 'kindergarten_education_slider_content_layout','Left');
    if($kindergarten_education_theme_lay == 'Left'){
		$kindergarten_education_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, .slide-button {';
			$kindergarten_education_custom_css .='text-align:left; left:15%; right:40%;';
		$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == 'Center'){
		$kindergarten_education_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, .slide-button {';
			$kindergarten_education_custom_css .='text-align:center; left:30%; right:30%;';
		$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == 'Right'){
		$kindergarten_education_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, .slide-button {';
			$kindergarten_education_custom_css .='text-align:right; left:40%; right:15%;';
		$kindergarten_education_custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/
	$kindergarten_education_theme_lay = get_theme_mod( 'kindergarten_education_slider_opacity','0.7');
	if($kindergarten_education_theme_lay == '0'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.1'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.1';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.2'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.2';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.3'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.3';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.4'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.4';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.5'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.5';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.6'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.6';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.7'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.7';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.8'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.8';
	$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == '0.9'){
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='opacity:0.9';
	$kindergarten_education_custom_css .='}';
	}

	/*-------------- Woocommerce Button  -------------*/
	$kindergarten_education_woocommerce_button_padding_top = get_theme_mod('kindergarten_education_woocommerce_button_padding_top',15);
	$kindergarten_education_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{';
		$kindergarten_education_custom_css .='padding-top: '.esc_attr($kindergarten_education_woocommerce_button_padding_top).'px; padding-bottom: '.esc_attr($kindergarten_education_woocommerce_button_padding_top).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woocommerce_button_padding_right = get_theme_mod('kindergarten_education_woocommerce_button_padding_right',15);
	$kindergarten_education_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{';
		$kindergarten_education_custom_css .='padding-left: '.esc_attr($kindergarten_education_woocommerce_button_padding_right).'px; padding-right: '.esc_attr($kindergarten_education_woocommerce_button_padding_right).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woocommerce_button_border_radius = get_theme_mod('kindergarten_education_woocommerce_button_border_radius',30);
	$kindergarten_education_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{';
		$kindergarten_education_custom_css .='border-radius: '.esc_attr($kindergarten_education_woocommerce_button_border_radius).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_related_product_enable = get_theme_mod('kindergarten_education_related_product_enable',true);
	if($kindergarten_education_related_product_enable == false){
		$kindergarten_education_custom_css .='.related.products{';
			$kindergarten_education_custom_css .='display: none;';
		$kindergarten_education_custom_css .='}';
	}

	$kindergarten_education_woocommerce_product_border_enable = get_theme_mod('kindergarten_education_woocommerce_product_border_enable',true);
	if($kindergarten_education_woocommerce_product_border_enable == false){
		$kindergarten_education_custom_css .='.products li{';
			$kindergarten_education_custom_css .='border: none;';
		$kindergarten_education_custom_css .='}';
	}

	$kindergarten_education_woocommerce_product_padding_top = get_theme_mod('kindergarten_education_woocommerce_product_padding_top',10);
	$kindergarten_education_custom_css .='.products li{';
		$kindergarten_education_custom_css .='padding-top: '.esc_attr($kindergarten_education_woocommerce_product_padding_top).'px !important; padding-bottom: '.esc_attr($kindergarten_education_woocommerce_product_padding_top).'px !important;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woocommerce_product_padding_right = get_theme_mod('kindergarten_education_woocommerce_product_padding_right',10);
	$kindergarten_education_custom_css .='.products li{';
		$kindergarten_education_custom_css .='padding-left: '.esc_attr($kindergarten_education_woocommerce_product_padding_right).'px !important; padding-right: '.esc_attr($kindergarten_education_woocommerce_product_padding_right).'px !important;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woocommerce_product_border_radius = get_theme_mod('kindergarten_education_woocommerce_product_border_radius');
	$kindergarten_education_custom_css .='.products li{';
		$kindergarten_education_custom_css .='border-radius: '.esc_attr($kindergarten_education_woocommerce_product_border_radius).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woocommerce_product_box_shadow = get_theme_mod('kindergarten_education_woocommerce_product_box_shadow');
	$kindergarten_education_custom_css .='.products li{';
		$kindergarten_education_custom_css .='box-shadow: '.esc_attr($kindergarten_education_woocommerce_product_box_shadow).'px '.esc_attr($kindergarten_education_woocommerce_product_box_shadow).'px '.esc_attr($kindergarten_education_woocommerce_product_box_shadow).'px #eee;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woo_product_sale_top_bottom_padding = get_theme_mod('kindergarten_education_woo_product_sale_top_bottom_padding', 0);
	$kindergarten_education_woo_product_sale_left_right_padding = get_theme_mod('kindergarten_education_woo_product_sale_left_right_padding', 0);
	$kindergarten_education_custom_css .='.woocommerce span.onsale{';
		$kindergarten_education_custom_css .='padding-top: '.esc_attr($kindergarten_education_woo_product_sale_top_bottom_padding).'px; padding-bottom: '.esc_attr($kindergarten_education_woo_product_sale_top_bottom_padding).'px; padding-left: '.esc_attr($kindergarten_education_woo_product_sale_left_right_padding).'px; padding-right: '.esc_attr($kindergarten_education_woo_product_sale_left_right_padding).'px; display:inline-block;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woo_product_sale_border_radius = get_theme_mod('kindergarten_education_woo_product_sale_border_radius',100);
	$kindergarten_education_custom_css .='.woocommerce span.onsale {';
		$kindergarten_education_custom_css .='border-radius: '.esc_attr($kindergarten_education_woo_product_sale_border_radius).'%;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_woo_product_sale_position = get_theme_mod('kindergarten_education_woo_product_sale_position', 'Right');
	if($kindergarten_education_woo_product_sale_position == 'Right' ){
		$kindergarten_education_custom_css .='.woocommerce ul.products li.product .onsale{';
			$kindergarten_education_custom_css .=' left:auto; right:0;';
		$kindergarten_education_custom_css .='}';
	}elseif($kindergarten_education_woo_product_sale_position == 'Left' ){
		$kindergarten_education_custom_css .='.woocommerce ul.products li.product .onsale{';
			$kindergarten_education_custom_css .=' left:-6px; right:auto;';
		$kindergarten_education_custom_css .='}';
	}

	// footer setting
	$kindergarten_education_footer_bg_color = get_theme_mod('kindergarten_education_footer_bg_color');
	$kindergarten_education_custom_css .='.footer-wp{';
		$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_footer_bg_color).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_footer_bg_image = get_theme_mod('kindergarten_education_footer_bg_image');
	if($kindergarten_education_footer_bg_image != false){
		$kindergarten_education_custom_css .='.footer-wp{';
			$kindergarten_education_custom_css .='background: url('.esc_attr($kindergarten_education_footer_bg_image).');';
		$kindergarten_education_custom_css .='}';
	}

	/*------------- Back to Top  -------------------*/
	$kindergarten_education_back_to_top_border_radius = get_theme_mod('kindergarten_education_back_to_top_border_radius');
	$kindergarten_education_custom_css .='#scrollbutton i{';
		$kindergarten_education_custom_css .='border-radius: '.esc_attr($kindergarten_education_back_to_top_border_radius).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_scroll_icon_font_size = get_theme_mod('kindergarten_education_scroll_icon_font_size', 22);
	$kindergarten_education_custom_css .='#scrollbutton i{';
		$kindergarten_education_custom_css .='font-size: '.esc_attr($kindergarten_education_scroll_icon_font_size).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_top_bottom_scroll_padding = get_theme_mod('kindergarten_education_top_bottom_scroll_padding', 12);
	$kindergarten_education_custom_css .='#scrollbutton i{';
		$kindergarten_education_custom_css .='padding-top: '.esc_attr($kindergarten_education_top_bottom_scroll_padding).'px; padding-bottom: '.esc_attr($kindergarten_education_top_bottom_scroll_padding).'px;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_left_right_scroll_padding = get_theme_mod('kindergarten_education_left_right_scroll_padding', 17);
	$kindergarten_education_custom_css .='#scrollbutton i{';
		$kindergarten_education_custom_css .='padding-left: '.esc_attr($kindergarten_education_left_right_scroll_padding).'px; padding-right: '.esc_attr($kindergarten_education_left_right_scroll_padding).'px;';
	$kindergarten_education_custom_css .='}';

	/*------ Slider show/hide ------*/
	$kindergarten_education_slider = get_theme_mod('kindergarten_education_slider_hide');
	if($kindergarten_education_slider == false){
		$kindergarten_education_custom_css .='.page-template-custom-home-page #header{';
			$kindergarten_education_custom_css .=' position: static;';
		$kindergarten_education_custom_css .='}';
	}

	/*----------- Preloader Color Option  ----------------*/
	$kindergarten_education_preloader_bg_color_option = get_theme_mod('kindergarten_education_preloader_bg_color_option');
	$kindergarten_education_preloader_icon_color_option = get_theme_mod('kindergarten_education_preloader_icon_color_option');
	$kindergarten_education_custom_css .='.frame{';
		$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_preloader_bg_color_option).';';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_custom_css .='.dot-1,.dot-2,.dot-3{';
		$kindergarten_education_custom_css .='background-color: '.esc_attr($kindergarten_education_preloader_icon_color_option).';';
	$kindergarten_education_custom_css .='}';

	// preloader type
	$kindergarten_education_theme_lay = get_theme_mod( 'kindergarten_education_preloader_type','First Preloader Type');
    if($kindergarten_education_theme_lay == 'First Preloader Type'){
		$kindergarten_education_custom_css .='.dot-1, .dot-2, .dot-3{';
			$kindergarten_education_custom_css .='';
		$kindergarten_education_custom_css .='}';
	}else if($kindergarten_education_theme_lay == 'Second Preloader Type'){
		$kindergarten_education_custom_css .='.dot-1, .dot-2, .dot-3{';
			$kindergarten_education_custom_css .='border-radius:0;';
		$kindergarten_education_custom_css .='}';
	}

	// menu settings
	$kindergarten_education_menu_font_size_option = get_theme_mod('kindergarten_education_menu_font_size_option', 14);
	$kindergarten_education_custom_css .='.primary-navigation a{';
		$kindergarten_education_custom_css .='font-size: '.esc_attr($kindergarten_education_menu_font_size_option).'px;';
	$kindergarten_education_custom_css .='}';

	// Responsive Media
	$kindergarten_education_slider = get_theme_mod( 'kindergarten_education_display_slider',false);
	if($kindergarten_education_slider == true && get_theme_mod( 'kindergarten_education_slider_hide', false) == false){
    	$kindergarten_education_custom_css .='#slider{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} ';
	}
    if($kindergarten_education_slider == true){
    	$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='#slider{';
			$kindergarten_education_custom_css .='display:block;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_slider == false){
		$kindergarten_education_custom_css .='@media screen and (max-width:575px){';
		$kindergarten_education_custom_css .='#slider{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} }';
	}

	$kindergarten_education_sliderbutton = get_theme_mod( 'kindergarten_education_display_slider_button',true);
	if($kindergarten_education_sliderbutton == true && get_theme_mod( 'kindergarten_education_show_slider_button',true) != true){
    	$kindergarten_education_custom_css .='.more-btn{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} ';
	}
    if($kindergarten_education_sliderbutton == true){
    	$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='.more-btn{';
			$kindergarten_education_custom_css .='display:block;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_sliderbutton == false){
		$kindergarten_education_custom_css .='@media screen and (max-width:575px){';
		$kindergarten_education_custom_css .='.more-btn{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} }';
	}

	$kindergarten_education_sidebar = get_theme_mod( 'kindergarten_education_display_sidebar',true);
    if($kindergarten_education_sidebar == true){
    	$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='#sidebar{';
			$kindergarten_education_custom_css .='display:block;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_sidebar == false){
		$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='#sidebar{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} }';
	}

	$kindergarten_education_scroll = get_theme_mod( 'kindergarten_education_display_scrolltop', true);
	if($kindergarten_education_scroll == true && get_theme_mod( 'kindergarten_education_hide_show_scroll',true) != true){
    	$kindergarten_education_custom_css .='#scrollbutton i{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} ';
	}
    if($kindergarten_education_scroll == true){
    	$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='#scrollbutton i{';
			$kindergarten_education_custom_css .='display:block;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_scroll == false){
		$kindergarten_education_custom_css .='@media screen and (max-width:575px){';
		$kindergarten_education_custom_css .='#scrollbutton i{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} }';
	}

	$kindergarten_education_preloader = get_theme_mod( 'kindergarten_education_display_preloader',true);
	if($kindergarten_education_preloader == true && get_theme_mod( 'kindergarten_education_preloader',true) != true){
    	$kindergarten_education_custom_css .='.frame{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} ';
	}
    if($kindergarten_education_preloader == true){
    	$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='.frame{';
			$kindergarten_education_custom_css .='display:block;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_preloader == false){
		$kindergarten_education_custom_css .='@media screen and (max-width:575px){';
		$kindergarten_education_custom_css .='.frame{';
			$kindergarten_education_custom_css .='display:none;';
		$kindergarten_education_custom_css .='} }';
	}

	$kindergarten_education_fixed_header = get_theme_mod( 'kindergarten_education_display_fixed_header',false);
	if($kindergarten_education_fixed_header == true && get_theme_mod( 'kindergarten_education_sticky_header',false) != true){
    	$kindergarten_education_custom_css .='.fixed-header{';
			$kindergarten_education_custom_css .='position:static;';
		$kindergarten_education_custom_css .='} ';
	}
    if($kindergarten_education_fixed_header == true){
    	$kindergarten_education_custom_css .='@media screen and (max-width:575px) {';
		$kindergarten_education_custom_css .='.fixed-header{';
			$kindergarten_education_custom_css .='position:fixed;';
		$kindergarten_education_custom_css .='} }';
	}else if($kindergarten_education_fixed_header == false){
		$kindergarten_education_custom_css .='@media screen and (max-width:575px){';
		$kindergarten_education_custom_css .='.fixed-header{';
			$kindergarten_education_custom_css .='position:static;';
		$kindergarten_education_custom_css .='} }';
	}

	//  comment form width
	$kindergarten_education_comment_form_width = get_theme_mod( 'kindergarten_education_comment_form_width');
	$kindergarten_education_custom_css .='#comments textarea{';
		$kindergarten_education_custom_css .='width: '.esc_attr($kindergarten_education_comment_form_width).'%;';
	$kindergarten_education_custom_css .='}';

	$kindergarten_education_title_comment_form = get_theme_mod('kindergarten_education_title_comment_form', 'Leave a Reply');
	if($kindergarten_education_title_comment_form == ''){
		$kindergarten_education_custom_css .='#comments h2#reply-title {';
			$kindergarten_education_custom_css .='display: none;';
		$kindergarten_education_custom_css .='}';
	}

	$kindergarten_education_comment_form_button_content = get_theme_mod('kindergarten_education_comment_form_button_content', 'Post Comment');
	if($kindergarten_education_comment_form_button_content == ''){
		$kindergarten_education_custom_css .='#comments p.form-submit {';
			$kindergarten_education_custom_css .='display: none;';
		$kindergarten_education_custom_css .='}';
	}

	// slider height
	$kindergarten_education_option_slider_height = get_theme_mod('kindergarten_education_option_slider_height');
	$kindergarten_education_custom_css .='#slider img{';
		$kindergarten_education_custom_css .='height: '.esc_attr($kindergarten_education_option_slider_height).'px;';
	$kindergarten_education_custom_css .='}';

	// site title font size
	$kindergarten_education_site_title_font_size = get_theme_mod('kindergarten_education_site_title_font_size', 30);
	$kindergarten_education_custom_css .='#header .logo a{';
	$kindergarten_education_custom_css .='font-size: '.esc_attr($kindergarten_education_site_title_font_size).'px;';
	$kindergarten_education_custom_css .='}';

