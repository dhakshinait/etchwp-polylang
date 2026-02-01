<?php 

/**
 * Polylang Language Switcher Shortcode
 * Usage: [pll_languages]
 */
function custom_pll_languages_shortcode( $atts ) {

    // Fail safely if Polylang is not active
    if ( ! function_exists( 'pll_the_languages' ) ) {
        return '';
    }

    // Default attributes
    $atts = shortcode_atts(
        array(
            'dropdown'      => 0,
            'show_flags'    => 1,
            'show_names'    => 1,
            'hide_current'  => 0,
            'raw'           => 0,
        ),
        $atts,
        'pll_languages'
    );

    // Capture output instead of echo
    return pll_the_languages( array(
        'dropdown'     => (int) $atts['dropdown'],
        'show_flags'   => (int) $atts['show_flags'],
        'show_names'   => (int) $atts['show_names'],
        'hide_current' => (int) $atts['hide_current'],
        'echo'         => 0,
        'raw'          => (int) $atts['raw'],
    ) );
}

add_shortcode( 'pll_languages', 'custom_pll_languages_shortcode' );


/*
* Polylang data into post dynamic data
*/
add_filter( 'etch/dynamic_data/post', function( $data, $post_id ) {

    // Safety: Polylang not active
    if ( ! function_exists( 'pll_get_post_language' ) ) {
        return $data;
    }

    // Get language slug of the current post
    $lang_slug = pll_get_post_language( $post_id );

    if ( ! $lang_slug ) {
        return $data;
    }

    // Get full language object
    $lang = function_exists( 'pll_get_language' )
        ? pll_get_language( $lang_slug )
        : array();

    // Register custom post dynamic data
    $data['polylang'] = array(
        'slug'        => $lang_slug,                 // en, de, fr
        'name'        => $lang['name']   ?? '',       // English, Deutsch
        'locale'      => $lang['locale'] ?? '',       // en_US, de_DE
        'is_default'  => ! empty( $lang['slug'] ) && pll_default_language() === $lang['slug'],
    );

    return $data;

}, 10, 2 );

/*
* Polylang data into options
*/

add_filter( 'etch/dynamic_data/option', function( $data ) {

    if ( ! function_exists( 'pll_current_language' ) ) {
        return $data;
    }

    $lang_slug = pll_current_language();
    $lang      = function_exists( 'pll_get_language' )
        ? pll_get_language( $lang_slug )
        : array();

    $data['polylang'] = array(
        'slug'       => $lang_slug,                 // en, de
        'name'       => $lang['name']   ?? '',       // English, Deutsch
        'locale'     => $lang['locale'] ?? '',       // en_US, de_DE
        'is_default' => pll_default_language() === $lang_slug,
    );

    return $data;
});


/*
* Polylang data into terms
*/
add_filter( 'etch/dynamic_data/term', function( $data, $term_id ) {

    if ( function_exists( 'pll_get_term_language' ) ) {
        $lang_slug = pll_current_language();
        $lang      = function_exists( 'pll_get_language' )
            ? pll_get_language( $lang_slug )
            : array();

        $data['polylang'] = array(
            'slug'       => $lang_slug,                 // en, de
            'name'       => $lang['name']   ?? '',       // English, Deutsch
            'locale'     => $lang['locale'] ?? '',       // en_US, de_DE
            'is_default' => pll_default_language() === $lang_slug,
        );
    }

    return $data;

}, 10, 2 );