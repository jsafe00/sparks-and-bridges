<?php
/**
 * The template part for displaying post
 * @package Kindergarten Education
 * @subpackage kindergarten_education
 * @since 1.0
 */
?>
<?php $kindergarten_education_theme_lay = get_theme_mod( 'kindergarten_education_post_layouts','Layout 1');
if($kindergarten_education_theme_lay == 'Layout 1'){ 
  get_template_part('template-parts/Post-layouts/layout1'); 
}else if($kindergarten_education_theme_lay == 'Layout 2'){ 
  get_template_part('template-parts/Post-layouts/layout2'); 
}else if($kindergarten_education_theme_lay == 'Layout 3'){ 
  get_template_part('template-parts/Post-layouts/layout3'); 
}else{ 
  get_template_part('template-parts/Post-layouts/layout1'); 
}