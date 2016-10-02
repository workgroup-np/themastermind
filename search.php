<?php get_header(); ?>
  <section class="tbeer-search-result-section tbeer-section tbeer-single-post-section">
      <div class="container">
        <div class="row">
          <div class="tbeer-single-post-wrapper">
              <?php
               $paged = (get_query_var('page')) ? get_query_var('page') : 1;
              $latest_args = array( 'posts_per_page' => -1, 'order'=> 'DESC',  'orderby' => 'date','s'=>get_search_query() );
               $lateset_posts = query_posts( $latest_args );
               if(have_posts()): 
                        echo '<div class="tbeer-main-content col-md-8 col-sm-8 col-xs-12">
                                <h3 class="tbeer-section-title">Leave a Reply</h3>
                                    <div id="latest_post" class="tbeer-search-result-wrapper">';
                                        while (have_posts()) :the_post();?>
                                             <!-- Latest Article -->
                                            <div class="tbeer-search-result">
                                            <?php
                                                $thumbnail = get_post_thumbnail_id($post->ID);
                                                $img_url = wp_get_attachment_image_src( $thumbnail,'full');
                                                $alt = get_post_meta($thumbnail, '_wp_attachment_image_alt', true);
                                            if($img_url):
                                                $n_img = aq_resize( $img_url[0], $width =320, $height = 320, $crop = true, $single = true, $upscale = true ); ?>
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
                                                <?php if (get_the_category()) : ?>
                                                    <div class="tbeer-category-meta"> <?php the_category(' / '); ?></div>
                                                <?php endif;?>
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
                                if($lateset_posts->found_posts<=$posts_per_page)
                                {
                                  $style="display:none";
                                }
                                $total_post = $lateset_posts->found_posts;
                                $raw_page = $total_post%$posts_per_page;
                                if($raw_page==0){$page_count_raw = $total_post/$posts_per_page; }else{$page_count_raw = $total_post/$posts_per_page+1;}
                                   $page_count = floor($page_count_raw);
                                          ?>
                                <div class="tbeer-load-more-wrapper" id="loadmore" style="<?php echo $style;?>">
                                    <input type="hidden" value="2" id="paged">
                                    <input type="hidden" value="<?php echo $posts_per_page?>" id="post_per_page">
                                    <input type="hidden" value="<?php echo $page_count;?>" id="max_paged">
                                    <a href="javascript:void(0);" class="tbeer-btn tbeer-load-more">Load More</a>
                                </div><?php
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
      </div>
  </section>
  <?php get_footer();?>