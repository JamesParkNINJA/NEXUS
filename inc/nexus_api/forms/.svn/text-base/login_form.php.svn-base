<?php 
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options
?>

<div class="pure-g">
    <div class="pure-u-5-5">&nbsp;</div>
    <div class="pure-u-5-5 txtC">
        <a href="<?php echo $nexus_DASHBOARDURL; ?>">
            <img src="<?php echo $nexus_SIDEBARLOGO; ?>" width="150" />
        </a>
    </div>
    <div class="pure-u-5-5 txtC">
        <?php wp_login_form(); ?>
        <a href="<?php echo wp_lostpassword_url( $nexus_DASHBOARDURL ); ?>">Forgot your password?</a>
    </div>
    <?php if ( get_option( 'users_can_register' ) ) { ?>
        <div class="pure-u-5-5 txtC">
            <p class="txtC hPad-bottom">-OR-</p>
        </div>
        <div class="pure-u-5-5 txtC">
            <p class="txtC"><a href="#" class="nexus_ajaxFunction" data-query="signup" data-menu="signup">Apply for an account</a>
            <!--
            <p class="txtC"><a href="<?php echo get_bloginfo('url'); ?>/wp-login.php?action=register">Apply for an account</a>
            -->
        </div>
    <?php } ?>
</div>