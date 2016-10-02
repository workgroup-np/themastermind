<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} $pageid=get_the_ID();global $mastermind_options;  ?>
    <!-- FOOTER -->
        <footer>
            <!-- Footer Top -->
            <div class="tbeer-footer-top">
                <div class="container">
                    <div class="row">
                      <div class="tbeer-fixed-widget col-md-5 col-sm-6 col-xs-12">
                         <?php echo wp_kses_post($mastermind_options['top_articles']);?>
                          
                      </div>
                        <!-- Fixed Widget -->
                        <div class="tbeer-footer-widgets-area col-md-7 col-sm-6 col-xs-12">
                            
                            <div class="tbeer-column">
                                <?php
                                 $top_args=array(
                                    'post_type'=>'post',
                                    'posts_per_page'=>3,
                                    'orderby' => 'date',
                                    'order'   => 'DESC',
                                    'meta_query' => array(
                                        array(
                                            'key'     => '_mastermind_post',
                                            'value'   => 'on',
                                            'compare' => '=',
                                        ),
                                    ),
                                );
                                $top_query= new WP_Query($top_args);
                                if($top_query->have_posts()):$i=1;
                                    while($top_query->have_posts()):
                                    $top_query->the_post(); ?>
                                        <div class="tbeer-footer-post-widget">
                                            <h3>
                                                <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                            </h3>
                                            <p><span class="tbeer-news-post-date"><?php _e('by','mastermind');?>
                                            <span class="tbeer-news-post-author"><?php the_author_posts_link(); ?></span></span></p>
                                        </div>
                                     <?php $i++;
                                    endwhile;
                            endif;
                            wp_reset_postdata();
                                ?>
                            </div>

                            <div class="tbeer-column">
                                <?php
                                 $top_args=array(
                                    'post_type'=>'post',
                                    'posts_per_page'=>3,
                                    'orderby' => 'date',
                                    'offset' =>3,
                                    'order'   => 'DESC',
                                    'meta_query' => array(
                                        array(
                                            'key'     => '_mastermind_post',
                                            'value'   => 'on',
                                            'compare' => '=',
                                        ),
                                    ),
                                );
                                $top_query= new WP_Query($top_args);
                                if($top_query->have_posts()):$i=1;
                                    while($top_query->have_posts()):
                                    $top_query->the_post(); ?>
                                        <div class="tbeer-footer-post-widget">
                                            <h3>
                                                <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                            </h3>
                                            <p><span class="tbeer-news-post-date"><?php _e('by','mastermind');?>
                                            <span class="tbeer-news-post-author"><?php the_author_posts_link(); ?></span></span></p>
                                        </div>
                                     <?php $i++;
                                    endwhile;
                            endif;
                            wp_reset_postdata();
                                ?>
                            </div>
                            <!-- End -->
                        </div>
                        <!-- End -->
                    </div>
                </div>
            </div>
            <!-- Footer Top End -->

            <!-- Footer Bottom -->
            <div class="tbeer-footer-bottom">
                <div class="container">
                    <div class="row">
                     <?php if($mastermind_options['footer_copyright']):?>
                        <div class="tbeer-copyright-info">
                            <p><?php echo wp_kses_post($mastermind_options['footer_copyright']);?></p>
                        </div>
                    <?php endif;?>
                        <div class="tbeer-footer-menu">
                            <?php
                                wp_nav_menu( array(
                                'theme_location'    => 'secondary',
                                'container'         => '',
                                'container_class'   => '',
                                'container_id'      => 'bs-example-navbar-collapse-1',
                                'menu_class'        => '',
                                'fallback_cb'       => 'mastermind_bootstrap_navwalker::fallback',
                                'walker'            => new mastermind_bootstrap_navwalker())
                                );
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->
        </footer>
        <!-- FOOTER END -->
</div>
<?php if(isset($mastermind_options['meta_javascript']) && $mastermind_options['meta_javascript']!='')
echo wp_kses_post($mastermind_options['meta_javascript']); ?>
<?php wp_footer(); ?>
<script type="text/javascript">
jQuery('body').on('click','#loadmore a',function(){
    var paged = jQuery('#paged').val();
    var next_num =parseInt(paged)+1;
    jQuery('#paged').val(next_num);
    var max_paged =jQuery('#max_paged').val();
    console.log(max_paged);
    if(parseInt(paged)>parseInt(max_paged))
    {
      return false;
    }
      jQuery.ajax({
        url: '<?php echo esc_url( get_template_directory_uri() );?>/inc/ajax.php',
        type: 'POST',
        data: 'action_type=loadmore&paged='+paged,
        beforeSend:function(xhr){
          jQuery('#loadmore a').html('Loading..');
        }
      })
      .done(function(result) {
        console.log(result);
        jQuery("#latest_post").append(result);
        if (parseInt(paged) == parseInt(max_paged))
        {
          jQuery("#loadmore a").hide();
          jQuery("#loadmore a").html('Load More');
        }
        else
        {
          jQuery("#loadmore a").show();
          jQuery("#loadmore a").html('Load More');
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
});
jQuery('body').on('click','#loadmore_cat a',function(){
    var paged = jQuery('#paged').val();var cat_id = jQuery('#cat_id').val();
    var next_num =parseInt(paged)+1;
    jQuery('#paged').val(next_num);
    var max_paged =jQuery('#max_paged').val();
    console.log(max_paged);
    if(parseInt(paged)>parseInt(max_paged))
    {
      return false;
    }
      jQuery.ajax({
        url: '<?php echo esc_url( get_template_directory_uri() );?>/inc/ajax.php',
        type: 'POST',
        data: 'action_type=loadmore_cat&cat_id='+cat_id+'&paged='+paged,
        beforeSend:function(xhr){
          jQuery('#loadmore_cat a').html('Loading..');
        }
      })
      .done(function(result) {
        console.log(result);
        jQuery("#latest_post").append(result);
        if (parseInt(paged) == parseInt(max_paged))
        {
          jQuery("#loadmore_cat a").hide();
          jQuery("#loadmore_cat a").html('Load More');
        }
        else
        {
          jQuery("#loadmore_cat a").show();
          jQuery("#loadmore_cat a").html('Load More');
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
});
</script>
    </body>
</html>