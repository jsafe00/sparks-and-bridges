<?php
/**
 * Kindergarten Education Theme Customizer
 * @package Kindergarten Education
 */

load_template( trailingslashit( get_template_directory() ) . '/inc/logo-sizer.php' );
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kindergarten_education_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . 'inc/custom-control.php' );
	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-changer.php' );

	$wp_customize->add_setting( 'kindergarten_education_logo_sizer',array(
		'default' => 50,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_logo_sizer',array(
		'label' => esc_html__( 'Logo Sizer','kindergarten-education' ),
		'section' => 'title_tagline',
		'priority'    => 9,
		'input_attrs' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting('kindergarten_education_site_title_enable',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_site_title_enable',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Site Title','kindergarten-education'),
       'section' => 'title_tagline'
    ));

    $wp_customize->add_setting('kindergarten_education_site_title_font_size',array(
		'default'=> 30,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control(new kindergarten_education_Custom_Control( $wp_customize, 'kindergarten_education_site_title_font_size',array(
		'label' => esc_html__( 'Site Title Font Size (px)','kindergarten-education' ),
		'section'=> 'title_tagline',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	)));

    $wp_customize->add_setting('kindergarten_education_site_tagline_enable',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_site_tagline_enable',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Site Tagline','kindergarten-education'),
       'section' => 'title_tagline'
    ));	

	//add home page setting pannel
	$wp_customize->add_panel( 'kindergarten_education_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'kindergarten-education' ),
	    'description' => __( 'Description of what this panel does.', 'kindergarten-education' ),
	) );

	$kindergarten_education_font_array = array(
		''                       => 'No Fonts',
		'Abril Fatface'          => 'Abril Fatface',
		'Acme'                   => 'Acme',
		'Anton'                  => 'Anton',
		'Architects Daughter'    => 'Architects Daughter',
		'Arimo'                  => 'Arimo',
		'Arsenal'                => 'Arsenal',
		'Arvo'                   => 'Arvo',
		'Alegreya'               => 'Alegreya',
		'Alfa Slab One'          => 'Alfa Slab One',
		'Averia Serif Libre'     => 'Averia Serif Libre',
		'Bangers'                => 'Bangers',
		'Boogaloo'               => 'Boogaloo',
		'Bad Script'             => 'Bad Script',
		'Bitter'                 => 'Bitter',
		'Bree Serif'             => 'Bree Serif',
		'BenchNine'              => 'BenchNine',
		'Cabin'                  => 'Cabin',
		'Cardo'                  => 'Cardo',
		'Courgette'              => 'Courgette',
		'Cherry Swash'           => 'Cherry Swash',
		'Cormorant Garamond'     => 'Cormorant Garamond',
		'Crimson Text'           => 'Crimson Text',
		'Cuprum'                 => 'Cuprum',
		'Cookie'                 => 'Cookie',
		'Chewy'                  => 'Chewy',
		'Days One'               => 'Days One',
		'Dosis'                  => 'Dosis',
		'Droid Sans'             => 'Droid Sans',
		'Economica'              => 'Economica',
		'Fredoka One'            => 'Fredoka One',
		'Fjalla One'             => 'Fjalla One', 
		'Francois One'           => 'Francois One',
		'Frank Ruhl Libre'       => 'Frank Ruhl Libre',
		'Gloria Hallelujah'      => 'Gloria Hallelujah',
		'Great Vibes'            => 'Great Vibes',
		'Handlee'                => 'Handlee',
		'Hammersmith One'        => 'Hammersmith One',
		'Inconsolata'            => 'Inconsolata',
		'Indie Flower'           => 'Indie Flower', 
		'IM Fell English SC'     => 'IM Fell English SC',
		'Julius Sans One'        => 'Julius Sans One',
		'Josefin Slab'           => 'Josefin Slab',
		'Josefin Sans'           => 'Josefin Sans',
		'Kanit'                  => 'Kanit', 
		'Lobster'                => 'Lobster',
		'Lato'                   => 'Lato',
		'Lora'                   => 'Lora',
		'Libre Baskerville'      => 'Libre Baskerville',
		'Lobster Two'            => 'Lobster Two', 
		'Merriweather'           => 'Merriweather',
		'Monda'                  => 'Monda', 
		'Montserrat'             => 'Montserrat',
		'Muli'                   => 'Muli', 
		'Marck Script'           => 'Marck Script', 
		'Noto Serif'             => 'Noto Serif', 
		'Open Sans'              => 'Open Sans', 
		'Overpass'               => 'Overpass',
		'Overpass Mono'          => 'Overpass Mono',
		'Oxygen'                 => 'Oxygen', 
		'Orbitron'               => 'Orbitron',
		'Patua One'              => 'Patua One',
		'Pacifico'               => 'Pacifico',
		'Padauk'                 => 'Padauk',
		'Playball'               => 'Playball',
		'Playfair Display'       => 'Playfair Display', 
		'PT Sans'                => 'PT Sans',
		'Philosopher'            => 'Philosopher',
		'Permanent Marker'       => 'Permanent Marker',
		'Poiret One'             => 'Poiret One',
		'Quicksand'              => 'Quicksand',
		'Quattrocento Sans'      => 'Quattrocento Sans',
		'Raleway'                => 'Raleway',
		'Rubik'                  => 'Rubik', 
		'Rokkitt'                => 'Rokkitt',
		'Russo One'              => 'Russo One',
		'Righteous'              => 'Righteous',
		'Slabo'                  => 'Slabo', 
		'Source Sans Pro'        => 'Source Sans Pro',
		'Shadows Into Light Two' => 'Shadows Into Light Two', 
		'Shadows Into Light'     => 'Shadows Into Light',
		'Sacramento'             => 'Sacramento',
		'Shrikhand'              => 'Shrikhand',
		'Tangerine'              => 'Tangerine',
		'Ubuntu'                 => 'Ubuntu',
		'VT323'                  => 'VT323',
		'Varela Round'           => 'Varela Round',
		'Vampiro One'            => 'Vampiro One',
		'Vollkorn'               => 'Vollkorn', 
		'Volkhov'                => 'Volkhov',
		'Yanone Kaffeesatz'      => 'Yanone Kaffeesatz'
	);

	//Typography
	$wp_customize->add_section('kindergarten_education_typography', array(
		'title'    => __('Typography', 'kindergarten-education'),
		'panel'    => 'kindergarten_education_panel_id',
	));

	// This is Paragraph Color picker setting
	$wp_customize->add_setting('kindergarten_education_paragraph_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_paragraph_color', array(
		'label'    => __('Paragraph Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_paragraph_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control(	'kindergarten_education_paragraph_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('Paragraph Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	$wp_customize->add_setting('kindergarten_education_paragraph_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_paragraph_font_size', array(
		'label'   => __('Paragraph Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_paragraph_font_size',
		'type'    => 'text',
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting('kindergarten_education_atag_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_atag_color', array(
		'label'    => __('"a" Tag Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_atag_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control(	'kindergarten_education_atag_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('"a" Tag Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting('kindergarten_education_li_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_li_color', array(
		'label'    => __('"li" Tag Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_li_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control(	'kindergarten_education_li_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('"li" Tag Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting('kindergarten_education_h1_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_h1_color', array(
		'label'    => __('H1 Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_h1_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control('kindergarten_education_h1_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('H1 Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('kindergarten_education_h1_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_h1_font_size', array(
		'label'   => __('H1 Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_h1_font_size',
		'type'    => 'text',
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting('kindergarten_education_h2_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_h2_color', array(
		'label'    => __('h2 Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_h2_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control(
	'kindergarten_education_h2_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('h2 Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('kindergarten_education_h2_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_h2_font_size', array(
		'label'   => __('H2 Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_h2_font_size',
		'type'    => 'text',
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting('kindergarten_education_h3_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_h3_color', array(
		'label'    => __('H3 Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_h3_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control(
	'kindergarten_education_h3_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('H3 Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('kindergarten_education_h3_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_h3_font_size', array(
		'label'   => __('H3 Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_h3_font_size',
		'type'    => 'text',
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting('kindergarten_education_h4_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_h4_color', array(
		'label'    => __('H4 Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_h4_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control('kindergarten_education_h4_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('H4 Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('kindergarten_education_h4_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_h4_font_size', array(
		'label'   => __('H4 Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_h4_font_size',
		'type'    => 'text',
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting('kindergarten_education_h5_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_h5_color', array(
		'label'    => __('H5 Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_h5_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control('kindergarten_education_h5_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('H5 Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('kindergarten_education_h5_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_h5_font_size', array(
		'label'   => __('H5 Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_h5_font_size',
		'type'    => 'text',
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting('kindergarten_education_h6_color', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_h6_color', array(
		'label'    => __('H6 Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_typography',
		'settings' => 'kindergarten_education_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('kindergarten_education_h6_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control('kindergarten_education_h6_font_family', array(
		'section' => 'kindergarten_education_typography',
		'label'   => __('H6 Fonts', 'kindergarten-education'),
		'type'    => 'select',
		'choices' => $kindergarten_education_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('kindergarten_education_h6_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('kindergarten_education_h6_font_size', array(
		'label'   => __('H6 Font Size', 'kindergarten-education'),
		'section' => 'kindergarten_education_typography',
		'setting' => 'kindergarten_education_h6_font_size',
		'type'    => 'text',
	));

	//layout setting
	$wp_customize->add_section( 'kindergarten_education_option', array(
    	'title'      => __( 'Layout Settings', 'kindergarten-education' ),
		'panel' => 'kindergarten_education_panel_id'
	) );

	$wp_customize->add_setting('kindergarten_education_preloader',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_preloader',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Preloader','kindergarten-education'),
       'section' => 'kindergarten_education_option'
    ));

    $wp_customize->add_setting('kindergarten_education_preloader_type',array(
        'default' => 'First Preloader Type',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control('kindergarten_education_preloader_type',array(
        'type' => 'radio',
        'label' => __('Preloader Types','kindergarten-education'),
        'section' => 'kindergarten_education_option',
        'choices' => array(
            'First Preloader Type' => __('First Preloader Type','kindergarten-education'),
            'Second Preloader Type' => __('Second Preloader Type','kindergarten-education'),
        ),
	) );

	$wp_customize->add_setting('kindergarten_education_preloader_bg_color_option', array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_preloader_bg_color_option', array(
		'label'    => __('Preloader Background Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_option',
	)));

	$wp_customize->add_setting('kindergarten_education_preloader_icon_color_option', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_preloader_icon_color_option', array(
		'label'    => __('Preloader Icon Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_option',
	)));

    //Sticky Header
	$wp_customize->add_setting( 'kindergarten_education_sticky_header',array(
		'default'	=> false,
      	'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ) );
    $wp_customize->add_control('kindergarten_education_sticky_header',array(
    	'type' => 'checkbox',
        'label' => __( 'Enable / Disable Sticky Header','kindergarten-education' ),
        'section' => 'kindergarten_education_option'
    ));

    $wp_customize->add_setting('kindergarten_education_menu_font_size_option',array(
		'default'=> 14,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Kindergarten_Education_Custom_Control( $wp_customize,'kindergarten_education_menu_font_size_option',array(
		'label'	=> __('Menu Font Size ','kindergarten-education'),
		'section'=> 'kindergarten_education_option',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	)));

    $wp_customize->add_setting('kindergarten_education_search_icon',array(
		'default'	=> 'fa fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_search_icon',array(
		'label'	=> __('Search Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_option',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('kindergarten_education_width_layout_options',array(
        'default' => 'Default',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control('kindergarten_education_width_layout_options',array(
        'type' => 'radio',
        'label' => __('Container Box','kindergarten-education'),
        'description' => __('Here you can change the Width layout. ','kindergarten-education'),
        'section' => 'kindergarten_education_option',
        'choices' => array(
            'Default' => __('Default','kindergarten-education'),
            'Container Layout' => __('Container Layout','kindergarten-education'),
            'Box Layout' => __('Box Layout','kindergarten-education'),
        ),
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('kindergarten_education_layout_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'	        
	) );
	$wp_customize->add_control('kindergarten_education_layout_options', array(
        'type' => 'radio',
        'label' => __('Do you want this section','kindergarten-education'),
        'section' => 'kindergarten_education_option',
        'choices' => array(
            'One Column' => __('One Column','kindergarten-education'),
            'Three Columns' => __('Three Columns','kindergarten-education'),
            'Four Columns' => __('Four Columns','kindergarten-education'),
            'Grid Layout' => __('Grid Layout','kindergarten-education'),
            'Left Sidebar' => __('Left Sidebar','kindergarten-education'),
            'Right Sidebar' => __('Right Sidebar','kindergarten-education')
        ),
	)   );

	$wp_customize->add_setting('kindergarten_education_responsive_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_responsive_menu_open_icon',array(
		'label'	=> __('Responsive Open Menu Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_option',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('kindergarten_education_responsive_menu_close_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_responsive_menu_close_icon',array(
		'label'	=> __('Responsive Close Menu Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_option',
		'type'		=> 'icon'
	)));

	//Global Color
	$wp_customize->add_section('kindergarten_education_global_color', array(
		'title'    => __('Theme Color Option', 'kindergarten-education'),
		'panel'    => 'kindergarten_education_panel_id',
	));

	$wp_customize->add_setting('kindergarten_education_first_color', array(
		'default'           => '#07809a',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_first_color', array(
		'label'    => __('First Highlight Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_global_color',
		'settings' => 'kindergarten_education_first_color',
	)));

	$wp_customize->add_setting('kindergarten_education_second_color', array(
		'default'           => '#f8cf14',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_second_color', array(
		'label'    => __('Second Highlight Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_global_color',
		'settings' => 'kindergarten_education_second_color',
	)));

	$wp_customize->add_setting('kindergarten_education_third_color', array(
		'default'           => '#fcfe74',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_third_color', array(
		'label'    => __('Third Highlight Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_global_color',
		'settings' => 'kindergarten_education_third_color',
	)));

	$wp_customize->add_setting('kindergarten_education_fourth_color', array(
		'default'           => '#feffb5',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_fourth_color', array(
		'label'    => __('Fourth Highlight Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_global_color',
		'settings' => 'kindergarten_education_fourth_color',
	)));
	
	//Blog Post Settings
	$wp_customize->add_section('kindergarten_education_post_settings', array(
		'title'    => __('Post General Settings', 'kindergarten-education'),
		'panel'    => 'kindergarten_education_panel_id',
	));

	$wp_customize->add_setting('kindergarten_education_post_layouts',array(
        'default' => 'Layout 1',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control(new Kindergarten_Education_Image_Radio_Control($wp_customize, 'kindergarten_education_post_layouts', array(
        'type' => 'select',
        'label' => __('Post Layouts','kindergarten-education'),
        'description' => __('Here you can change the 3 different layouts of post.','kindergarten-education'),
        'section' => 'kindergarten_education_post_settings',
        'choices' => array(
            'Layout 1' => get_template_directory_uri().'/images/layout1.png',
            'Layout 2' => get_template_directory_uri().'/images/layout2.png',
            'Layout 3' => get_template_directory_uri().'/images/layout3.png',
    ))));

	$wp_customize->add_setting('kindergarten_education_metafields_date',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_metafields_date',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Date ','kindergarten-education'),
       'section' => 'kindergarten_education_post_settings'
    ));

    $wp_customize->add_setting('kindergarten_education_date_icon',array(
		'default'	=> 'far fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_date_icon',array(
		'label'	=> __('Post Date Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_post_settings',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('kindergarten_education_metafields_author',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_metafields_author',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Author','kindergarten-education'),
       'section' => 'kindergarten_education_post_settings'
    ));

    $wp_customize->add_setting('kindergarten_education_post_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_post_author_icon',array(
		'label'	=> __('Post Author Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_post_settings',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('kindergarten_education_metafields_comment',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_metafields_comment',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Comments','kindergarten-education'),
       'section' => 'kindergarten_education_post_settings'
    ));

    $wp_customize->add_setting('kindergarten_education_post_comment_icon',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_post_comment_icon',array(
		'label'	=> __('Post Comment Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_post_settings',
		'type'		=> 'icon'
	)));

    //Post excerpt
	$wp_customize->add_setting( 'kindergarten_education_post_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'kindergarten_education_post_excerpt_number', array(
		'label'       => esc_html__( 'Blog Post Content Limit','kindergarten-education' ),
		'section'     => 'kindergarten_education_post_settings',
		'type'        => 'number',
		'settings'    => 'kindergarten_education_post_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'kindergarten_education_post_discription_suffix', array(
		'default'   => __('[...]','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'kindergarten_education_post_discription_suffix', array(
		'label'       => esc_html__( 'Post Excerpt Suffix','kindergarten-education' ),
		'section'     => 'kindergarten_education_post_settings',
		'type'        => 'text',
		'settings'    => 'kindergarten_education_post_discription_suffix',
	) );

	$wp_customize->add_setting('kindergarten_education_button_text',array(
		'default'=> __('View More','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_button_text',array(
		'label'	=> __('Add Button Text','kindergarten-education'),
		'section'=> 'kindergarten_education_post_settings',
		'type'=> 'text'
	));

	//Single Post Settings
	$wp_customize->add_section('kindergarten_education_single_post_settings', array(
		'title'    => __('Single Post Settings', 'kindergarten-education'),
		'panel'    => 'kindergarten_education_panel_id',
	));

    $wp_customize->add_setting('kindergarten_education_single_post_featured_image',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_single_post_featured_image',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Featured image','kindergarten-education'),
       'section' => 'kindergarten_education_single_post_settings',
    ));

	$wp_customize->add_setting('kindergarten_education_single_post_tags',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_single_post_tags',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Tags','kindergarten-education'),
       'section' => 'kindergarten_education_single_post_settings'
    ));

    $wp_customize->add_setting( 'kindergarten_education_single_post_meta_seperator', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'kindergarten_education_single_post_meta_seperator', array(
		'label'       => esc_html__( 'Single Post Meta Box Seperator','kindergarten-education' ),
		'section'     => 'kindergarten_education_single_post_settings',
		'description' => __('Here you can add the seperator for meta box. e.g. "|",  ",", "/", etc. ','kindergarten-education'),
		'type'        => 'text',
		'settings'    => 'kindergarten_education_single_post_meta_seperator',
	) );

	$wp_customize->add_setting( 'kindergarten_education_comment_form_width',array(
		'default' => 100,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new kindergarten_education_Custom_Control( $wp_customize, 'kindergarten_education_comment_form_width',	array(
		'label' => esc_html__( 'Comment Form Width','kindergarten-education' ),
		'section' => 'kindergarten_education_single_post_settings',
		'input_attrs' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting('kindergarten_education_title_comment_form',array(
       'default' => __('Leave a Reply','kindergarten-education'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('kindergarten_education_title_comment_form',array(
       'type' => 'text',
       'label' => __('Comment Form Heading Text','kindergarten-education'),
       'section' => 'kindergarten_education_single_post_settings'
    ));

    $wp_customize->add_setting('kindergarten_education_comment_form_button_content',array(
       'default' => __('Post Comment','kindergarten-education'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('kindergarten_education_comment_form_button_content',array(
       'type' => 'text',
       'label' => __('Comment Form Button Text','kindergarten-education'),
       'section' => 'kindergarten_education_single_post_settings'
    ));

	$wp_customize->add_setting('kindergarten_education_enable_single_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_enable_single_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Single Post Pagination','kindergarten-education'),
       'section' => 'kindergarten_education_single_post_settings'
    ));

	//home page slider
	$wp_customize->add_section( 'kindergarten_education_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'kindergarten-education' ),
		'priority'   => null,
		'panel' => 'kindergarten_education_panel_id'
	) );

	$wp_customize->add_setting('kindergarten_education_slider_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_slider_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide slider','kindergarten-education'),
       'section' => 'kindergarten_education_slidersettings',
    ));

    $wp_customize->add_setting('kindergarten_education_show_slider_button',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_show_slider_button',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Button','kindergarten-education'),
       'section' => 'kindergarten_education_slidersettings'
    ));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'kindergarten_education_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'kindergarten_education_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'kindergarten_education_slider_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'kindergarten-education' ),
			'section'  => 'kindergarten_education_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('kindergarten_education_slider_button_text',array(
		'default'=> __('READ MORE','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_slider_button_text',array(
		'label'	=> __('Add Button Text','kindergarten-education'),
		'section'=> 'kindergarten_education_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('kindergarten_education_slider_previous_icon',array(
		'default'	=> 'fas fa-chevron-left',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_slider_previous_icon',array(
		'label'	=> __('Slider Previous Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_slidersettings',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('kindergarten_education_slider_next_icon',array(
		'default'	=> 'fas fa-chevron-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_slider_next_icon',array(
		'label'	=> __('Slider Next Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_slidersettings',
		'type'		=> 'icon'
	)));

	//content layout
    $wp_customize->add_setting('kindergarten_education_slider_content_layout',array(
    'default' => 'Left',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control('kindergarten_education_slider_content_layout',array(
        'type' => 'radio',
        'label' => __('Slider Content Layout','kindergarten-education'),
        'section' => 'kindergarten_education_slidersettings',
        'choices' => array(
            'Center' => __('Center','kindergarten-education'),
            'Left' => __('Left','kindergarten-education'),
            'Right' => __('Right','kindergarten-education'),
        ),
	) );

	$wp_customize->add_setting('kindergarten_education_option_slider_height',array(
		'default'=> __('550','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_option_slider_height',array(
		'label'	=> __('Slider Height','kindergarten-education'),
		'section'=> 'kindergarten_education_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'kindergarten_education_slider_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'kindergarten_education_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Content Limit','kindergarten-education' ),
		'section'     => 'kindergarten_education_slidersettings',
		'type'        => 'number',
		'settings'    => 'kindergarten_education_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('kindergarten_education_slider_opacity',array(
      'default'              => 0.7,
      'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control( 'kindergarten_education_slider_opacity', array(
	'label'       => esc_html__( 'Slider Image Opacity','kindergarten-education' ),
	'section'     => 'kindergarten_education_slidersettings',
	'type'        => 'select',
	'settings'    => 'kindergarten_education_slider_opacity',
	'choices' => array(
		'0' =>  esc_attr('0','kindergarten-education'),
		'0.1' =>  esc_attr('0.1','kindergarten-education'),
		'0.2' =>  esc_attr('0.2','kindergarten-education'),
		'0.3' =>  esc_attr('0.3','kindergarten-education'),
		'0.4' =>  esc_attr('0.4','kindergarten-education'),
		'0.5' =>  esc_attr('0.5','kindergarten-education'),
		'0.6' =>  esc_attr('0.6','kindergarten-education'),
		'0.7' =>  esc_attr('0.7','kindergarten-education'),
		'0.8' =>  esc_attr('0.8','kindergarten-education'),
		'0.9' =>  esc_attr('0.9','kindergarten-education')
	),
	));

	//Service
	$wp_customize->add_section('kindergarten_education_services',array(
		'title'	=> __('Service','kindergarten-education'),
		'description'	=> __('Add Service Section below.','kindergarten-education'),
		'panel' => 'kindergarten_education_panel_id',
	));

	$args = array('numberposts' => -1);
	$post_list = get_posts($args);
	$i = 0;
	$pst[]='Select';  
	foreach($post_list as $post){
	$pst[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('kindergarten_education_single_post',array(
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control('kindergarten_education_single_post',array(
		'type'    => 'select',
		'choices' => $pst,
		'label' => __('Select post','kindergarten-education'),
		'section' => 'kindergarten_education_services',
	));

	$wp_customize->add_setting( 'kindergarten_education_service_excerpt_number', array(
		'default'              => 20,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'kindergarten_education_service_excerpt_number', array(
		'label'       => esc_html__( 'Services Content Limit','kindergarten-education' ),
		'section'     => 'kindergarten_education_services',
		'type'        => 'number',
		'settings'    => 'kindergarten_education_service_excerpt_number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Category1
	$wp_customize->add_section('kindergarten_education_categoryservices',array(
		'title'	=> __('Service Category','kindergarten-education'),
		'description'	=> __('Add Service Section below.','kindergarten-education'),
		'panel' => 'kindergarten_education_panel_id',
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($categories as $category){
	if($i==0){
	$default = $category->slug;
	$i++;
	}
	$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('kindergarten_education_blogcategory_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	));
	$wp_customize->add_control('kindergarten_education_blogcategory_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display Latest Post','kindergarten-education'),
		'section' => 'kindergarten_education_categoryservices',
	));

	$wp_customize->add_setting( 'kindergarten_education_category_excerpt_number', array(
		'default'              => 10,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'kindergarten_education_category_excerpt_number', array(
		'label'       => esc_html__( 'Category Content Limit','kindergarten-education' ),
		'section'     => 'kindergarten_education_categoryservices',
		'type'        => 'number',
		'settings'    => 'kindergarten_education_category_excerpt_number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('kindergarten_education_category_button_text',array(
		'default'=> __('VIEW MORE','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_category_button_text',array(
		'label'	=> __('Add Button Text','kindergarten-education'),
		'section'=> 'kindergarten_education_categoryservices',
		'type'=> 'text'
	));

	$wp_customize->add_setting('kindergarten_education_services_button_icon',array(
		'default'	=> 'fas fa-arrow-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_services_button_icon',array(
		'label'	=> __('Services Button Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_categoryservices',
		'type'		=> 'icon'
	)));

	//footer text
	$wp_customize->add_section('kindergarten_education_footer_section',array(
		'title'	=> __('Footer Text','kindergarten-education'),
		'panel' => 'kindergarten_education_panel_id'
	));

	$wp_customize->add_setting('kindergarten_education_footer_bg_color', array(
		'default'           => '#191919',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kindergarten_education_footer_bg_color', array(
		'label'    => __('Footer Background Color', 'kindergarten-education'),
		'section'  => 'kindergarten_education_footer_section',
	)));

	$wp_customize->add_setting('kindergarten_education_footer_bg_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'kindergarten_education_footer_bg_image',array(
        'label' => __('Footer Background Image','kindergarten-education'),
        'section' => 'kindergarten_education_footer_section'
	)));

	$wp_customize->add_setting('footer_widget_areas',array(
        'default'           => 4,
        'sanitize_callback' => 'kindergarten_education_sanitize_choices',
    ));
    $wp_customize->add_control('footer_widget_areas',array(
        'type'        => 'radio',
        'label'       => __('Footer Widget Area', 'kindergarten-education'),
        'section'     => 'kindergarten_education_footer_section',
        'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'kindergarten-education'),
        'choices' => array(
            '1'     => __('One', 'kindergarten-education'),
            '2'     => __('Two', 'kindergarten-education'),
            '3'     => __('Three', 'kindergarten-education'),
            '4'     => __('Four', 'kindergarten-education')
        ),
    ));

    $wp_customize->add_setting('kindergarten_education_hide_show_scroll',array(
        'default' => true,
        'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
	));
	$wp_customize->add_control('kindergarten_education_hide_show_scroll',array(
     	'type' => 'checkbox',
      	'label' => __('Enable / Disable Back To Top','kindergarten-education'),
      	'section' => 'kindergarten_education_footer_section',
	));

	$wp_customize->add_setting('kindergarten_education_back_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Kindergarten_Education_Icon_Changer(
        $wp_customize,'kindergarten_education_back_to_top_icon',array(
		'label'	=> __('Back to Top Icon','kindergarten-education'),
		'transport' => 'refresh',
		'section'	=> 'kindergarten_education_footer_section',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('kindergarten_education_scroll_icon_font_size',array(
		'default'=> 22,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control(new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_scroll_icon_font_size',array(
		'label'	=> __('Back To Top Icon Font Size','kindergarten-education'),
		'section'=> 'kindergarten_education_footer_section',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	)));

	$wp_customize->add_setting('kindergarten_education_footer_options',array(
        'default' => 'Right align',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control('kindergarten_education_footer_options',array(
        'type' => 'radio',
        'label' => __('Back To Top','kindergarten-education'),
        'section' => 'kindergarten_education_footer_section',
        'choices' => array(
            'Left align' => __('Left align','kindergarten-education'),
            'Right align' => __('Right align','kindergarten-education'),
            'Center align' => __('Center align','kindergarten-education'),
        ),
	) );
	
	$wp_customize->add_setting( 'kindergarten_education_top_bottom_scroll_padding',array(
		'default' => 12,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_top_bottom_scroll_padding',	array(
		'label' => esc_html__( 'Top Bottom Scroll Padding (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_footer_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_left_right_scroll_padding',array(
		'default' => 17,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_left_right_scroll_padding',	array(
		'label' => esc_html__( 'Left Right Scroll Padding (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_footer_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_back_to_top_border_radius',array(
		'default' => 50,
		'transport' => 'postMessage',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_back_to_top_border_radius', array(
		'label' => esc_html__( 'Back to Top Border Radius (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_footer_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting('kindergarten_education_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('kindergarten_education_footer_copy',array(
		'label'	=> __('Copyright Text','kindergarten-education'),
		'section'	=> 'kindergarten_education_footer_section',
		'description'	=> __('Add some text for footer like copyright etc.','kindergarten-education'),
		'type'		=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('kindergarten_education_responsive_media',array(
		'title'	=> __('Responsive Media','kindergarten-education'),
		'panel' => 'kindergarten_education_panel_id',
	));

    $wp_customize->add_setting('kindergarten_education_display_slider',array(
       'default' => false,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_display_slider',array(
       'type' => 'checkbox',
       'label' => __('Display Slider','kindergarten-education'),
       'section' => 'kindergarten_education_responsive_media'
    ));

    $wp_customize->add_setting('kindergarten_education_display_slider_button',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_display_slider_button',array(
       'type' => 'checkbox',
       'label' => __('Display Slider Button','kindergarten-education'),
       'section' => 'kindergarten_education_responsive_media'
    ));

	$wp_customize->add_setting('kindergarten_education_display_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_display_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Display Sidebar','kindergarten-education'),
       'section' => 'kindergarten_education_responsive_media'
    ));

    $wp_customize->add_setting('kindergarten_education_display_scrolltop',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_display_scrolltop',array(
       'type' => 'checkbox',
       'label' => __('Display Back To Top','kindergarten-education'),
       'section' => 'kindergarten_education_responsive_media'
    ));

    $wp_customize->add_setting('kindergarten_education_display_fixed_header',array(
       'default' => false,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_display_fixed_header',array(
       'type' => 'checkbox',
       'label' => __('Display Sticky Header','kindergarten-education'),
       'section' => 'kindergarten_education_responsive_media'
    ));

    $wp_customize->add_setting('kindergarten_education_display_preloader',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_display_preloader',array(
       'type' => 'checkbox',
       'label' => __('Display Preloader','kindergarten-education'),
       'section' => 'kindergarten_education_responsive_media'
    ));

	//404 Page Setting
	$wp_customize->add_section('kindergarten_education_page_not_found',array(
		'title'	=> __('404 Page Not Found / No Result','kindergarten-education'),
		'panel' => 'kindergarten_education_panel_id',
	));	

	$wp_customize->add_setting('kindergarten_education_page_not_found_heading',array(
		'default'=> __('404 Not Found','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_page_not_found_heading',array(
		'label'	=> __('404 Heading','kindergarten-education'),
		'section'=> 'kindergarten_education_page_not_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('kindergarten_education_page_not_found_text',array(
		'default'=> __('Looks like you have taken a wrong turn. Dont worry it happens to the best of us.','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_page_not_found_text',array(
		'label'	=> __('404 Content','kindergarten-education'),
		'section'=> 'kindergarten_education_page_not_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('kindergarten_education_page_not_found_button',array(
		'default'=>  __('Back to Home Page','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_page_not_found_button',array(
		'label'	=> __('404 Button','kindergarten-education'),
		'section'=> 'kindergarten_education_page_not_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('kindergarten_education_no_search_result_heading',array(
		'default'=> __('Nothing Found','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_no_search_result_heading',array(
		'label'	=> __('No Search Results Heading','kindergarten-education'),
		'description'=>__('The search page heading display when no results are found.','kindergarten-education'),
		'section'=> 'kindergarten_education_page_not_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('kindergarten_education_no_search_result_text',array(
		'default'=> __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','kindergarten-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('kindergarten_education_no_search_result_text',array(
		'label'	=> __('No Search Results Text','kindergarten-education'),
		'description'=>__('The search page text display when no results are found.','kindergarten-education'),
		'section'=> 'kindergarten_education_page_not_found',
		'type'=> 'text'
	));

	//Woocommerce Section
	$wp_customize->add_section( 'kindergarten_education_woocommerce_section' , array(
    	'title'      => __( 'Woocommerce Settings', 'kindergarten-education' ),
    	'description'=>__('The below settings are apply on woocommerce pages.','kindergarten-education'),
		'priority'   => null,
		'panel' => 'kindergarten_education_panel_id'
	) );

	/**
	 * Product Columns
	 */
	$wp_customize->add_setting( 'kindergarten_education_per_columns' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_choices',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'kindergarten_education_per_columns', array(
		'label'    => __( 'Product per columns', 'kindergarten-education' ),
		'section'  => 'kindergarten_education_woocommerce_section',
		'type'     => 'select',
		'choices'  => array(
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
	) ) );

	$wp_customize->add_setting('kindergarten_education_product_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('kindergarten_education_product_per_page',array(
		'label'	=> __('Product per page','kindergarten-education'),
		'section'	=> 'kindergarten_education_woocommerce_section',
		'type'		=> 'number'
	));

	$wp_customize->add_setting('kindergarten_education_shop_sidebar_enable',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_shop_sidebar_enable',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable shop page sidebar','kindergarten-education'),
       'section' => 'kindergarten_education_woocommerce_section',
    ));

    $wp_customize->add_setting('kindergarten_education_product_page_sidebar_enable',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_product_page_sidebar_enable',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable product page sidebar','kindergarten-education'),
       'section' => 'kindergarten_education_woocommerce_section',
    ));

    $wp_customize->add_setting('kindergarten_education_related_product_enable',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_related_product_enable',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Related product','kindergarten-education'),
       'section' => 'kindergarten_education_woocommerce_section',
    ));

    $wp_customize->add_setting( 'kindergarten_education_woo_product_sale_border_radius',array(
		'default' => 100,
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control(new kindergarten_education_Custom_Control( $wp_customize, 'kindergarten_education_woo_product_sale_border_radius', array(
        'label'  => __('Woocommerce Product Sale Border Radius','kindergarten-education'),
        'section'  => 'kindergarten_education_woocommerce_section',
        'type'        => 'number',
        'input_attrs' => array(
        	'step'=> 1,
            'min' => 0,
            'max' => 50,
        )
    )));

    $wp_customize->add_setting('kindergarten_education_woo_product_sale_top_bottom_padding',array(
		'default'=> 0,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new kindergarten_education_Custom_Control( $wp_customize, 'kindergarten_education_woo_product_sale_top_bottom_padding',array(
		'label'	=> __('Woocommerce Product Sale Top Bottom Padding ','kindergarten-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'kindergarten_education_woocommerce_section',
		'type'=> 'number'
	)));

	$wp_customize->add_setting('kindergarten_education_woo_product_sale_left_right_padding',array(
		'default'=> 0,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new kindergarten_education_Custom_Control( $wp_customize, 'kindergarten_education_woo_product_sale_left_right_padding',array(
		'label'	=> __('Woocommerce Product Sale Left Right Padding','kindergarten-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'kindergarten_education_woocommerce_section',
		'type'=> 'number'
	)));

	$wp_customize->add_setting('kindergarten_education_woo_product_sale_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'kindergarten_education_sanitize_choices'
	));
	$wp_customize->add_control('kindergarten_education_woo_product_sale_position',array(
        'type' => 'select',
        'label' => __('Woocommerce Product Sale Position','kindergarten-education'),
        'section' => 'kindergarten_education_woocommerce_section',
        'choices' => array(
            'Right' => __('Right','kindergarten-education'),
            'Left' => __('Left','kindergarten-education'),
        ),
	));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_button_padding_top',array(
		'default' => 15,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_button_padding_top',	array(
		'label' => esc_html__( 'Button Top Bottom Padding (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_button_padding_right',array(
		'default' => 15,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_button_padding_right',	array(
		'label' => esc_html__( 'Button Right Left Padding (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_button_border_radius',array(
		'default' => 30,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_button_border_radius',array(
		'label' => esc_html__( 'Button Border Radius (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

    $wp_customize->add_setting('kindergarten_education_woocommerce_product_border_enable',array(
       'default' => true,
       'sanitize_callback'	=> 'kindergarten_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('kindergarten_education_woocommerce_product_border_enable',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable product border','kindergarten-education'),
       'section' => 'kindergarten_education_woocommerce_section',
    ));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_product_padding_top',array(
		'default' => 10,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_product_padding_top',	array(
		'label' => esc_html__( 'Product Top Bottom Padding (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_product_padding_right',array(
		'default' => 10,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_product_padding_right',	array(
		'label' => esc_html__( 'Product Right Left Padding (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_product_border_radius',array(
		'default' => 3,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_product_border_radius',array(
		'label' => esc_html__( 'Product Border Radius (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));

	$wp_customize->add_setting( 'kindergarten_education_woocommerce_product_box_shadow',array(
		'default' => 5,
		'transport' => 'refresh',
		'sanitize_callback' => 'kindergarten_education_sanitize_integer'
	));
	$wp_customize->add_control( new Kindergarten_Education_Custom_Control( $wp_customize, 'kindergarten_education_woocommerce_product_box_shadow',array(
		'label' => esc_html__( 'Product Box Shadow (px)','kindergarten-education' ),
		'section' => 'kindergarten_education_woocommerce_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	)));
}

add_action( 'customize_register', 'kindergarten_education_customize_register' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Kindergarten_Education_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Kindergarten_Education_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new Kindergarten_Education_Customize_Section_Pro($manager,
			'kindergarten_education_example_1',
			array(
			'title'   =>  esc_html__( 'Kindergarten Edu Pro', 'kindergarten-education' ),
			'pro_text' => esc_html__( 'Go Pro', 'kindergarten-education' ),
			'pro_url'  => esc_url('https://www.buywptemplates.com/themes/kindergarten-education-wordpress-theme/'),
			'priority'   => 9
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'kindergarten-education-customize-controls', trailingslashit( get_template_directory_uri() ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'kindergarten-education-customize-controls', trailingslashit( get_template_directory_uri() ) . '/css/customize-controls.css' );
	}

	//Footer widget areas
	function kindergarten_education_sanitize_choices( $input ) {
	    $valid = array(
	        '1'     => __('One', 'kindergarten-education'),
	        '2'     => __('Two', 'kindergarten-education'),
	        '3'     => __('Three', 'kindergarten-education'),
	        '4'     => __('Four', 'kindergarten-education')
	    );
	    if ( array_key_exists( $input, $valid ) ) {
	        return $input;
	    } else {
	        return '';
	    }
	}
}

// Doing this customizer thang!
Kindergarten_Education_Customize::get_instance();