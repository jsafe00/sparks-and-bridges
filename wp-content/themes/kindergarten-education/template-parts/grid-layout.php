<?php
/**
 * The template part for displaying grid post
 * @package Kindergarten Education
 * @subpackage kindergarten_education
 * @since 1.0
 */
?>
<div class="col-lg-4 col-md-4">
  <article id="post-<?php the_ID(); ?>" <?php post_class('inner-box'); ?>>    
    <h2 class="section-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2> 
    <div class="box-image">
      <?php 
        if(has_post_thumbnail()) { 
          the_post_thumbnail(); 
        }
      ?>
    </div>
    <div class="new-text">
      <?php $excerpt = get_the_excerpt(); echo esc_html( kindergarten_education_string_limit_words( $excerpt, esc_attr(get_theme_mod('kindergarten_education_post_excerpt_number','30')))); ?> <?php echo esc_html( get_theme_mod('kindergarten_education_post_discription_suffix','[...]') ); ?>
    </div> 
    <?php if( get_theme_mod('kindergarten_education_button_text','View More') != ''){ ?>
      <div class="postbtn">
        <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('kindergarten_education_button_text','View More'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('kindergarten_education_button_text','View More'));?></span></a>
      </div>
    <?php }?>
  </article>
</div>