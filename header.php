<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lshlss' ); ?></a>

    <header id="masthead" class="header">
        <div class="container">
            <div class="mobile-container">
                <div class="site-branding">
                    <h1><a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
                </div><!-- .site-branding -->
                
                <button class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button><!-- #primary-mobile-menu -->
            </div>
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'twentytwentyone' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'menu_class'      => 'menu-wrapper',
                            'container_class' => 'primary-menu-container',
                            'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                            'fallback_cb'     => false,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            <?php endif; ?>
        </div>
    </header><!-- #masthead -->

    <main id="main" class="content">
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="page-hero">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php } ?>
        <div class="container">
            <div class="page-title<?php if ( has_post_thumbnail() ) { echo ' has-thumb'; } ?>">
                <?php leashless_page_title(); ?>
            </div>
           