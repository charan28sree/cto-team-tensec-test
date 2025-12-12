<?php
/**
 * B30SC Matrix Theme functions
 *
 * @package B30SC_Matrix
 */

if ( ! function_exists( 'b30sc_matrix_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function b30sc_matrix_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style-editor.css' );

		// Add custom logo support.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 100,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom units.
		add_theme_support( 'units' );
	}
}
add_action( 'after_setup_theme', 'b30sc_matrix_setup' );

if ( ! function_exists( 'b30sc_matrix_enqueue_assets' ) ) {
	/**
	 * Enqueue theme assets.
	 */
	function b30sc_matrix_enqueue_assets() {
		// Enqueue main stylesheet.
		wp_enqueue_style(
			'b30sc-matrix-style',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);

		// Add inline styles for custom CSS variables if needed.
		$custom_css = '
			:root {
				--color-neon-green: #00FF00;
				--color-matrix-green: #00CC00;
				--color-dark-green: #00AA00;
				--color-black: #000000;
				--color-dark-bg: #1A1A1A;
				--color-darker-bg: #0D0D0D;
				--color-white: #FFFFFF;
				--color-light-gray: #CCCCCC;
				--font-mono: "Courier New", "Courier", monospace;
				--font-ocr: "OCR A", "Courier New", monospace;
			}
		';
		wp_add_inline_style( 'b30sc-matrix-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'b30sc_matrix_enqueue_assets' );

if ( ! function_exists( 'b30sc_matrix_register_block_patterns' ) ) {
	/**
	 * Register block patterns for the theme.
	 */
	function b30sc_matrix_register_block_patterns() {
		$pattern_dir = get_template_directory() . '/patterns';

		if ( ! is_dir( $pattern_dir ) ) {
			return;
		}

		$patterns = glob( $pattern_dir . '/*.php' );

		foreach ( $patterns as $pattern ) {
			$pattern_name = basename( $pattern, '.php' );
			register_block_pattern_category(
				$pattern_name,
				array(
					'label' => ucwords( str_replace( '-', ' ', $pattern_name ) ),
				)
			);
		}
	}
}
add_action( 'init', 'b30sc_matrix_register_block_patterns' );

if ( ! function_exists( 'b30sc_matrix_register_template_part_area' ) ) {
	/**
	 * Register template parts area.
	 */
	function b30sc_matrix_register_template_part_area() {
		register_block_pattern_category(
			'header',
			array(
				'label' => __( 'Header', 'b30sc-matrix' ),
			)
		);

		register_block_pattern_category(
			'footer',
			array(
				'label' => __( 'Footer', 'b30sc-matrix' ),
			)
		);
	}
}
add_action( 'init', 'b30sc_matrix_register_template_part_area' );

if ( ! function_exists( 'b30sc_matrix_custom_colors' ) ) {
	/**
	 * Add custom color classes for inline styling.
	 */
	function b30sc_matrix_custom_colors() {
		echo '
		<style>
			.text-neon-green { color: #00FF00; }
			.text-matrix-green { color: #00CC00; }
			.text-dark-green { color: #00AA00; }
			.bg-neon-green { background-color: #00FF00; }
			.bg-matrix-green { background-color: #00CC00; }
			.bg-dark-green { background-color: #00AA00; }
			.bg-black { background-color: #000000; }
			.bg-dark-bg { background-color: #1A1A1A; }
			.bg-darker-bg { background-color: #0D0D0D; }
			.neon-glow {
				text-shadow: 0 0 5px #00FF00, 0 0 10px #00CC00, 0 0 15px #00AA00;
				box-shadow: 0 0 10px #00FF00;
			}
		</style>
		';
	}
}
add_action( 'wp_head', 'b30sc_matrix_custom_colors' );

// Add support for custom font families.
if ( ! function_exists( 'b30sc_matrix_add_font_support' ) ) {
	/**
	 * Add web fonts.
	 */
	function b30sc_matrix_add_font_support() {
		// Import Google Fonts or use system fonts.
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	}
}
add_action( 'wp_head', 'b30sc_matrix_add_font_support' );
