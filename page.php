<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); global $mastermind_options;?>
     <section class="tbeer-latest-and-trending-article-section tbeer-section">
            <div class="container">
                <div class="row">
                    <?php
                    if(have_posts()): 
                        echo '<div class="tbeer-main-content col-md-8 col-sm-8 col-xs-12">
                                <h3 class="tbeer-section-title">'.get_the_title().'</h3>
                                    <div id="latest_post" class="tbeer-latest-article-wrapper">';
                                        while ( have_posts()) : the_post();?>
                                             <!-- Latest Article -->
                                            <div class="tbeer-latest-article">
                                            <?php the_content();?>
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
        </section>
        <!-- LATEST ARTICLE SECTION END -->
<?php get_footer(); ?>