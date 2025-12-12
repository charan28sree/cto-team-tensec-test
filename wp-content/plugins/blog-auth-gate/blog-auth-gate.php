<?php
/**
 * Plugin Name: Blog Auth Gate
 * Description: Redirects unauthenticated users to OAuth login when accessing blog content.
 * Version: 1.0.0
 * Author: Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Configuration for the OAuth login URL.
// In a real environment, this might be pulled from options or environment variables.
define( 'BLOG_AUTH_OAUTH_LOGIN_URL', '/oauth/login' );

/**
 * Redirect unauthenticated users when they attempt to access blog content.
 */
function bag_redirect_unauthenticated_users() {
	// If the user is logged in, they are allowed to access content.
	if ( is_user_logged_in() ) {
		return;
	}

	// Define the conditions for "blog content".
	// is_home() - The main blog page (if set in Settings > Reading).
	// is_singular('post') - A single blog post.
	// is_post_type_archive('post') - The post type archive for 'post' (if enabled).
	// is_category() || is_tag() - Archives for standard posts.
	$is_blog_content = is_home()
		|| is_singular( 'post' )
		|| is_post_type_archive( 'post' )
		|| is_category()
		|| is_tag()
		|| is_date()
		|| is_author();

	if ( $is_blog_content ) {
		wp_redirect( BLOG_AUTH_OAUTH_LOGIN_URL );
		exit;
	}
}
add_action( 'template_redirect', 'bag_redirect_unauthenticated_users' );

/**
 * Filter menu items based on login state.
 *
 * Use CSS classes 'bag-logged-in' (show only when logged in)
 * and 'bag-logged-out' (show only when logged out) in the menu item configuration.
 *
 * @param array    $items The menu items, sorted by each menu item's menu order.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 * @return array The filtered menu items.
 */
function bag_filter_menu_items( $items, $args ) {
	if ( is_admin() ) {
		return $items;
	}

	foreach ( $items as $key => $item ) {
		// Ensure classes is an array
		$classes = is_array( $item->classes ) ? $item->classes : array();

		// Hide "Logged In" items from guests
		if ( in_array( 'bag-logged-in', $classes ) && ! is_user_logged_in() ) {
			unset( $items[ $key ] );
		}

		// Hide "Logged Out" items from members
		if ( in_array( 'bag-logged-out', $classes ) && is_user_logged_in() ) {
			unset( $items[ $key ] );
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'bag_filter_menu_items', 10, 2 );
