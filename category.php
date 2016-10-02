 <?php get_header(); global $mastermind_options; ?>
  <section class="tbeer-search-result-section tbeer-section tbeer-single-post-section">
    <div class="container">
        <div class="row">
        <div class="tbeer-single-post-wrapper">
         <?php
          $category=get_queried_object(); $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
          $total_pages=$wp_query->max_num_pages;
          $posts_per_page=-1;
          $cat_args=array('posts_per_page' => $posts_per_page, 'order'=> 'DESC', 'orderby' => 'date','cat'=>$category->term_id );
			$cat_query= new WP_Query($cat_args);
			if($cat_query->have_posts()):
            echo '<div class="tbeer-main-content col-md-8 col-sm-8 col-xs-12">
                    <h3 class="tbeer-section-title">Category: '.$category->name.'</h3>
                      <div id="latest_post" class="tbeer-search-result-wrapper">';
                    while ($cat_query->have_posts()) :$cat_query->the_post();?>
                       <!-- Latest Article -->
                            <div class="tbeer-search-result">
                            <?php
                                $thumbnail = get_post_thumbnail_id($post->ID);
                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                            if($img_url):
                                $n_img = aq_resize( $img_url[0], $width =315, $height = 315, $crop = true, $single = true, $upscale = true ); ?>
                              <div class="tbeer-image-wrapper">
                                    <img src="<?php echo esc_url($n_img);?>" alt="<?php echo esc_attr($alt);?>">
                                </div>
                            <?php else:
                            $img_url=get_template_directory_uri().'/assets/images/no-image.png';
                            $n_img = aq_resize( $img_url, $width =315, $height = 315, $crop = true, $single = true, $upscale = true );?>
                              <div class="tbeer-image-wrapper">
                                    <img src="<?php echo esc_url($img_url);?>" alt="No image">
                                </div>
                            <?php endif;?>
                                <div class="tbeer-search-result-details">
                                      <div class="tbeer-category-meta"> <?php if (get_the_category()) : ?><?php the_category(' / ');endif; ?></div>
                                    <h3 class="tbeer-news-post-heading">
                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                    </h3>
                                    <p class="tbeer-news-post-excerpt"><?php echo mastermind_the_excerpt_max_charlength(150);?></p>
                                    <div class="tbeer-news-post-meta">
                                        <span class="tbeer-news-post-date"><?php echo date("m.d.y");  ?></span>
                                          <div class="tbeer-news-post-author"><?php the_author_posts_link(); ?></div>
                                    </div>
                                </div>
                                <!-- End -->
                            </div>
                            <!-- End -->
                        <?php 
                        endwhile;
                    echo '</div>';
            echo'</div>';
	    endif;
	    wp_reset_postdata();?>
            <!-- Sidebar -->
            <div class="tbeer-sidebar-wrapper col-md-4 col-sm-4 col-xs-12">
                <div class="tbeer-sidebar">
                  <?php if ( is_active_sidebar( 'mastermind-widgets-sidebar' ) ) : 
			        dynamic_sidebar('mastermind-widgets-sidebar');
			      endif;
			      if ( is_active_sidebar( 'mastermind-trending-sidebar' ) ) : 
			        dynamic_sidebar('mastermind-trending-sidebar');
			      endif;
			     ?>
                </div>
            </div>
            <!-- End -->
            </div>
        </div>
    </div>
</section>       
<?php get_footer(); ?>