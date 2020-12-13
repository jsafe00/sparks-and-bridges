<?php
/**
 * The template for displaying all pages.
 * @package Kindergarten Education
 */

get_header(); ?>

<?php do_action( 'kindergarten_education_page_header' ); ?>

<main id="skip_content" class="content_box" role="main">
    <div class="container">
        <div class="main-wrapper">
            <?php while ( have_posts() ) : the_post(); ?>
                <h1><?php the_title();?></h1>
                <?php if(has_post_thumbnail()) { ?>
                    <div class="feature-box">   
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php } ?>
                <div class="new-text"><?php the_content(); ?></div>
            <?php
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'kindergarten-education' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'kindergarten-education' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );            
                ?>
                <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || '0' != get_comments_number() ) {
                        comments_template();
                    }
                ?>
            <?php endwhile; // end of the loop. ?>      
            <div class="clear"></div>    
        </div>
    </div>
</main>

<?php do_action( 'kindergarten_education_page_footer' ); ?>

<?php get_footer(); ?>