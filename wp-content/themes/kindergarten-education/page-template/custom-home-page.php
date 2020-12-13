<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="skip_content" role="main">
  <?php do_action( 'kindergarten_education_before_slider' ); ?>

  <?php if( get_theme_mod('kindergarten_education_slider_hide', false) != '' || get_theme_mod( 'kindergarten_education_display_slider',false) != ''){ ?>
    <section id="slider">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
        <?php $kindergarten_education_slider_page = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'kindergarten_education_slider_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $kindergarten_education_slider_page[] = $mod;
          }
        }
        if( !empty($kindergarten_education_slider_page) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $kindergarten_education_slider_page,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
        ?>     
        <div class="carousel-inner" role="listbox">
          <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php the_post_thumbnail(); ?>
              <div class="carousel-caption">
                <div class="inner_carousel">
                  <h1><?php the_title(); ?></h1>
                  <p><?php $excerpt = get_the_excerpt(); echo esc_html( kindergarten_education_string_limit_words( $excerpt, esc_attr(get_theme_mod('kindergarten_education_slider_excerpt_number','30')))); ?></p>
                  <?php if (get_theme_mod( 'kindergarten_education_show_slider_button',true) != '' || get_theme_mod( 'kindergarten_education_display_slider_button',true) != ''){ ?>
                    <?php if( get_theme_mod('kindergarten_education_slider_button_text','READ MORE') != ''){ ?>
                      <div class="more-btn">              
                        <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_theme_mod('kindergarten_education_slider_button_text',__('READ MORE','kindergarten-education'))); ?><span class="screen-reader-text"><?php echo esc_html( get_theme_mod('kindergarten_education_slider_button_text',__('READ MORE','kindergarten-education'))); ?></span></a>
                      </div>
                    <?php }?>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
          <div class="no-postfound"></div>
          <?php endif;
        endif;?>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"><i class="<?php echo esc_attr(get_theme_mod('kindergarten_education_slider_previous_icon','fas fa-chevron-left')); ?>"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Previous','kindergarten-education' );?></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"><i class="<?php echo esc_attr(get_theme_mod('kindergarten_education_slider_next_icon','fas fa-chevron-right')); ?>"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Next','kindergarten-education' );?></span>
        </a>
      </div>  
      <div class="clearfix"></div>
    </section> 
  <?php }?>

  <?php do_action( 'kindergarten_education_after_slider' ); ?>

  <?php if( get_theme_mod('kindergarten_education_single_post') != '' || get_theme_mod('kindergarten_education_blogcategory_setting') != ''){ ?>
    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 service-section">
            <?php
            $kindergarten_education_postData1=  get_theme_mod('kindergarten_education_single_post');
            if($kindergarten_education_postData1){
              $args = array( 'name' => esc_html($kindergarten_education_postData1 ,'kindergarten-education'));
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="serv-text-box">
                  <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2><span class="screen-reader-text"><?php the_title(); ?></span></a>
                  <hr class="line">
                  <p><?php $excerpt = get_the_excerpt(); echo esc_html( kindergarten_education_string_limit_words( $excerpt, esc_attr(get_theme_mod('kindergarten_education_service_excerpt_number','20')))); ?></p>
                </div>
                <div class="service-img-box"><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></div>  
              <?php endwhile; 
              wp_reset_postdata();?>
              <?php else : ?>
                <div class="no-postfound"></div>
            <?php endif; } ?>
          </div>
          <div class="col-lg-8 col-md-8 category-section">
            <div class="row">
              <?php 
              $kindergarten_education_catData=  get_theme_mod('kindergarten_education_blogcategory_setting');
              if($kindergarten_education_catData){
                $page_query = new WP_Query(array( 'category_name' => esc_html( $kindergarten_education_catData ,'kindergarten-education')));?>
                <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?> 
                  <div class="col-lg-4 col-md-4 category-text">
                    <div class="trainerbox">
                      <div class="service-img-box1"><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></div>
                    </div>
                    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3><span class="screen-reader-text"><?php the_title(); ?></span></a>
                    <p><?php $excerpt = get_the_excerpt(); echo esc_html( kindergarten_education_string_limit_words( $excerpt, esc_attr(get_theme_mod('kindergarten_education_category_excerpt_number','10')))); ?></p>
                    <div class ="testbutton">
                      <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_theme_mod('kindergarten_education_category_button_text',__('VIEW MORE','kindergarten-education'))); ?><i class="<?php echo esc_attr(get_theme_mod('kindergarten_education_services_button_icon','fas fa-arrow-right')); ?>"></i><span class="screen-reader-text"><?php echo esc_html( get_theme_mod('kindergarten_education_category_button_text',__('VIEW MORE','kindergarten-education'))); ?></span></a>
                    </div>
                  </div>
                <?php endwhile;
                  wp_reset_postdata();
                }
              ?>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php }?>

  <?php do_action( 'kindergarten_education_after_service' ); ?>

  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <div class="new-text"><?php the_content(); ?></div>
    <?php endwhile; // end of the loop. ?>
  </div>
</main>

<?php get_footer(); ?>