<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

// Dinamic Sidebar
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('mastermind-widgets-aside-right')) :
    _e ('add widgets here', 'mastermind');
endif;
?>