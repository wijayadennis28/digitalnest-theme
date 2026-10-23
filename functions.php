<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
} );

add_action( 'wp_enqueue_scripts', function () {
    $font      = knpo_sanitize_font( get_theme_mod( 'knpo_font', 'grotesque' ) );
    $font_urls = [
        'nunito'    => 'https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,400..1000&display=swap',
        'grotesque' => 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Public+Sans:wght@400;500;600;700&display=swap',
        'dm-clash'  => 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100..1000&display=swap',
    ];
    wp_enqueue_style( 'knpo-fonts', $font_urls[ $font ], [], null );
    $phosphor = get_template_directory() . '/assets/vendor/phosphor/regular/style.css';
    if ( file_exists( $phosphor ) ) {
        wp_enqueue_style( 'knpo-phosphor', get_template_directory_uri() . '/assets/vendor/phosphor/regular/style.css', [], '2.1.2' );
    }
    $css = get_template_directory() . '/assets/css/theme.css';
    if ( file_exists( $css ) ) {
        wp_enqueue_style( 'knpo-theme', get_template_directory_uri() . '/assets/css/theme.css', [ 'knpo-fonts' ], filemtime( $css ) );
    }

    // Site-wide motion + Barba page transitions. Everything is vendored locally and deferred.
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    $js  = [
        'gsap'          => [ '/assets/js/vendor/gsap.min.js', '3.15.0', [] ],
        'scrolltrigger' => [ '/assets/js/vendor/ScrollTrigger.min.js', '3.15.0', [ 'knpo-gsap' ] ],
        'splittext'     => [ '/assets/js/vendor/SplitText.min.js', '3.15.0', [ 'knpo-gsap' ] ],
        'lenis'         => [ '/assets/js/vendor/lenis.min.js', '1.3.27', [] ],
        'barba'         => [ '/assets/js/vendor/barba.umd.min.js', '2.10.3', [] ],
    ];
    $args = [ 'in_footer' => true, 'strategy' => 'defer' ];
    foreach ( $js as $name => $script ) {
        if ( file_exists( $dir . $script[0] ) ) {
            wp_enqueue_script( 'knpo-' . $name, $uri . $script[0], $script[2], $script[1], $args );
        }
    }
    $motion = $dir . '/assets/js/motion.js';
    if ( file_exists( $motion ) ) {
        wp_enqueue_script(
            'knpo-motion',
            $uri . '/assets/js/motion.js',
            [ 'knpo-gsap', 'knpo-scrolltrigger', 'knpo-splittext', 'knpo-lenis', 'knpo-barba' ],
            filemtime( $motion ),
            $args
        );
    }

    // Footer "Let's Jam." cursor bloom — every page, small and deferred.
    $jam = get_template_directory() . '/assets/js/jam.js';
    if ( file_exists( $jam ) ) {
        wp_enqueue_script(
            'knpo-jam',
            get_template_directory_uri() . '/assets/js/jam.js',
            [],
            filemtime( $jam ),
            [ 'in_footer' => true, 'strategy' => 'defer' ]
        );
    }
} );

// Preload the bold display face used by the DM Sans + Clash Display option.
add_action( 'wp_head', function () {
    if ( 'dm-clash' !== knpo_sanitize_font( get_theme_mod( 'knpo_font', 'grotesque' ) ) ) return;
    $font = get_theme_file_uri( '/assets/fonts/clash-display/ClashDisplay-Bold.woff2' );
    echo '<link rel="preload" href="' . esc_url( $font ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}, 2 );

// Flag the document before paint. motion.js takes over reveals; the fallback keeps content visible if it never starts.
add_action( 'wp_head', function () {
    ?>
<script>
if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
if ('IntersectionObserver' in window) document.documentElement.classList.add('knpo-js');
if (!(window.CSS && CSS.supports && CSS.supports('animation-timeline: scroll()'))) document.documentElement.classList.add('knpo-no-st');
document.addEventListener('DOMContentLoaded', function () {
  if (!window.knpoRevealsReady) document.documentElement.classList.add('knpo-reveals-fallback');
});
</script>
    <?php
}, 1 );

// Barba prefetches on hover; core speculative loading would fetch the same pages twice.
add_filter( 'wp_speculation_rules_configuration', '__return_null' );

function knpo_page_namespace() {
    if ( is_front_page() ) return 'home';
    if ( is_page() ) {
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        return $slug ? sanitize_html_class( $slug ) : 'page';
    }
    return 'default';
}

function knpo_whatsapp_link( $text = '' ) {
    $msg = rawurlencode( $text ?: 'Hi DigitalNest, I want to digitize my business.' );
    return "https://wa.me/6285121386048?text={$msg}";
}

// Phosphor Regular, self-hosted. Decorative by default; pass a screen-reader label alongside status icons.
function knpo_icon( $name, $class = 'text-xl text-nest-muted' ) {
    return '<span class="ph ph-' . esc_attr( $name ) . ' ' . esc_attr( $class ) . '" aria-hidden="true"></span>';
}

// Light / Dark mode — Customizer → Theme Appearance. Default light.
function knpo_sanitize_mode( $v ) {
    return in_array( $v, [ 'light', 'light-orange', 'dark', 'midnight' ], true ) ? $v : 'light';
}
function knpo_sanitize_font( $v ) {
    return in_array( $v, [ 'grotesque', 'nunito', 'dm-clash' ], true ) ? $v : 'grotesque';
}
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'knpo_appearance', [ 'title' => __( 'Theme Appearance', 'digitalnest-theme' ) ] );
    $wp_customize->add_setting( 'knpo_mode', [ 'default' => 'light', 'sanitize_callback' => 'knpo_sanitize_mode' ] );
    $wp_customize->add_control( 'knpo_mode', [
        'section' => 'knpo_appearance',
        'label'   => __( 'Color mode', 'digitalnest-theme' ),
        'type'    => 'select',
        'choices' => [ 'light' => __( 'Light', 'digitalnest-theme' ), 'light-orange' => __( 'Light Orange', 'digitalnest-theme' ), 'dark' => __( 'Dark', 'digitalnest-theme' ), 'midnight' => __( 'Midnight (Tide)', 'digitalnest-theme' ) ],
    ] );
    $wp_customize->add_setting( 'knpo_font', [ 'default' => 'grotesque', 'sanitize_callback' => 'knpo_sanitize_font' ] );
    $wp_customize->add_control( 'knpo_font', [
        'section' => 'knpo_appearance',
        'label'   => __( 'Typography', 'digitalnest-theme' ),
        'type'    => 'select',
        'choices' => [ 'grotesque' => __( 'Bricolage Grotesque + Public Sans', 'digitalnest-theme' ), 'nunito' => __( 'Nunito Sans', 'digitalnest-theme' ), 'dm-clash' => __( 'DM Sans + Clash Display', 'digitalnest-theme' ) ],
    ] );
} );
add_filter( 'body_class', function ( $classes ) {
    $classes[] = 'knpo-' . knpo_sanitize_mode( get_theme_mod( 'knpo_mode', 'light' ) );
    $font      = knpo_sanitize_font( get_theme_mod( 'knpo_font', 'grotesque' ) );
    if ( 'nunito' === $font ) {
        $classes[] = 'knpo-font-nunito';
    }
    if ( 'dm-clash' === $font ) {
        $classes[] = 'knpo-font-dm-clash';
    }
    return $classes;
} );

// Shared content — one source for the home page and the product pages.
function knpo_services() {
    return [
        [ 'no' => '01', 'title' => 'ERP Control System', 'url' => '/erp-system/', 'desc' => 'Every rupiah traceable — Verify, Authorize, Trace, Identity, Visibility. 8 modules, one dashboard, zero leakage chasing.', 'tags' => [ 'Sales', 'Procurement', 'Inventory', 'Finance', 'Payroll', 'Access' ] ],
        [ 'no' => '02', 'title' => 'Gateway Websites', 'url' => '/websites/', 'desc' => 'Customer → website → gateway → verified → recorded. Human error removed at checkout, OTP + auto-log included.', 'tags' => [ '3-page base', 'Gateway + OTP', 'Auto-log', 'Notifications' ] ],
        [ 'no' => '03', 'title' => 'Leakage Diagnosis', 'url' => '/erp-system/', 'desc' => 'The 1,000-pencils test: we trace your stock, purchasing mark-ups and payroll gaps before you pay for software.', 'tags' => [ 'Stock trace', 'Purchasing', 'Payroll', 'Single-admin risk' ] ],
        [ 'no' => '04', 'title' => 'Visibility Retainers', 'url' => '/pricing/', 'desc' => 'Management sees without chasing. Monthly reconciliation, role-based access, per-employee trails.', 'tags' => [ 'Dashboards', 'Roles', 'Trails', 'Monthly close' ] ],
    ];
}

function knpo_works() {
    return [
        [
            'industry' => 'Manufacturing',
            'client'   => 'PT. Triniti Optima Packindo',
            'summary'  => '2 ERPs consolidated to one dashboard',
            'year'     => '2025',
            'gradient' => 'linear-gradient(135deg,#3f4d0c,#1d1d1d 70%)',
            'scope'    => 'ERP · Inventory · Manufacturing · Reporting',
            'challenge' => 'A bubble-wrap manufacturer with complex operations and two separate ERP systems. Production and stock data never met in one place.',
            'built'    => 'Product formulas, production logs, raw-material consumption, finished-goods records and inventory transactions — with both ERPs consolidated into one dashboard.',
            'result'   => 'Every production run now writes back to stock automatically. Management sees daily transactions as one operational picture.',
        ],
        [
            'industry' => 'Distribution',
            'client'   => 'CV. Maksimalkan Akselerasi Motormu',
            'summary'  => 'Full ERP — stock to finance',
            'year'     => '2025',
            'gradient' => 'linear-gradient(135deg,#0c3a4d,#1d1d1d 70%)',
            'scope'    => 'ERP · Sales · Procurement · Inventory · Finance · Payroll',
            'challenge' => 'Stock, purchasing, payroll and finance lived in separate manual records.',
            'built'    => 'A full ERP covering sales orders, procurement, inventory movements, finance, payroll, reporting and role-based access.',
            'result'   => 'Stock to finance in one system, with every transaction traceable per employee.',
        ],
        [
            'industry' => 'Creative',
            'client'   => 'curatedstudiosus.com',
            'summary'  => '4-page gateway website',
            'year'     => '2024',
            'gradient' => 'linear-gradient(135deg,#4d0c33,#1d1d1d 70%)',
            'scope'    => 'Website · High-resolution media',
            'challenge' => 'A photography studio needed a storefront that could show work at full resolution without losing quality.',
            'built'    => 'A four-page website backed by a large media server for high-resolution photography.',
            'result'   => 'A digital presence that lets the photography demonstrate its true quality.',
        ],
        [
            'industry' => 'Healthcare',
            'client'   => 'indodentalcenter.com',
            'summary'  => '5 pages · 2 modals · 2 langs · floating WA',
            'year'     => '2024',
            'gradient' => 'linear-gradient(135deg,#1a4d0c,#1d1d1d 70%)',
            'scope'    => 'Website · Multilingual · WhatsApp',
            'challenge' => 'A dental clinic needed a clear patient-facing site across two languages, with doctors, articles and fast contact.',
            'built'    => '5 pages (Home, Product Portfolio, Doctors, About Us, Articles), 2 pop-up modals, 2 languages and a floating WhatsApp button.',
            'result'   => 'Patients can find services, doctors and articles — and reach the clinic in one tap.',
        ],
    ];
}

// Create the menu pages once so the site works without manual setup.
add_action( 'admin_init', function () {
    if ( get_option( 'knpo_pages_seeded' ) ) return;
    foreach ( [
        'erp-system' => 'ERP System',
        'websites'   => 'Websites',
        'work'       => 'Work',
        'pricing'    => 'Pricing',
    ] as $slug => $title ) {
        if ( ! get_page_by_path( $slug ) ) {
            wp_insert_post( [ 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $title, 'post_name' => $slug ] );
        }
    }
    update_option( 'knpo_pages_seeded', 1 );
} );
