<?php
/**
 * The template part for displaying content
 * @package Automobile Car Dealer
 * @subpackage kindergarten_education
 * @since 1.0
 */
?>
<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="row m-0">
    <div class="col-lg-2 col-md-2 p-0">
      <?php if( get_theme_mod( 'kindergarten_education_metafields_date',true) != '') { ?>
      <div class="datebox">
        <div class="datewrap">
          <span class="date-day"><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date( 'd') ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date( 'd') ); ?></span></a></span>
        </div>
        <div class="month-yearwrap">
          <span class="date-month"><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date( 'M' ) ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date( 'M' ) ); ?></span></a></span>
          <span class="date-year"><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date( 'Y' ) ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span></a></span>
        </div>
      </div>
      <?php }?>
    </div>
    <div class="inner-box <?php if(get_theme_mod( 'kindergarten_education_metafields_date',true) != '') { ?>col-lg-10 col-md-10"<?php } else { ?>col-lg-12 col-md-12"<?php } ?>">
      <div class="row">
        <div class="col-lg-5 col-md-5">
          <div class="box-image">
            <?php 
              if(has_post_thumbnail()) { 
                the_post_thumbnail(); 
              }
            ?>
          </div>
        </div>
        <div class="<?php if(has_post_thumbnail()) { ?>col-lg-7 col-md-7"<?php } else { ?>col-lg-12 col-md-12"<?php } ?>">
          <h2 class="section-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>      
          <div class="new-text">
            <?php $excerpt = get_the_excerpt(); echo esc_html( kindergarten_education_string_limit_words( $excerpt, esc_attr(get_theme_mod('kindergarten_education_post_excerpt_number','30')))); ?> <?php echo esc_html( get_theme_mod('kindergarten_education_post_discription_suffix','[...]') ); ?>
          </div> 
        </div>
      </div>
      <div class="row inner-box-cat-tag">
        <div class="col-lg-6 col-md-6">
          <p class="cats"><span class="cats-1"><?php esc_html_e( 'Category: ','kindergarten-education' ); ?></span><?php foreach((get_the_category()) as $category) { echo esc_html($category->cat_name) . ' '; } ?>
          </p>
          <p class="tag">
            <span class="tags-1"><?php esc_html_e( 'Tags: ','kindergarten-education' ); ?></span><?php
              if( $tags = get_the_tags() ) {
                echo '<span class="meta-sep"></span>';
                foreach( $tags as $post_tag ) {
                  $sep = ( $post_tag === end( $tags ) ) ? '' : ' ';
                  echo '<a href="' . esc_url(get_term_link( $post_tag, $post_tag->taxonomy )) . '">#' . esc_html($post_tag->name) . '</a>' . esc_html($sep);
                }
              }
            ?>
          </p>        
        </div>
        <div class="col-lg-6 col-md-6">
          <?php if( get_theme_mod('kindergarten_education_button_text','View More') != ''){ ?>
            <div class="postbtn">
              <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('kindergarten_education_button_text','View More'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('kindergarten_education_button_text','View More'));?></span></a>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</article>