<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$tiers = [
  [
    'name' => 'Basic',
    'setup' => 'Rp 10.000.000',
    'sub' => '+ Rp 5.000.000/mo subscription',
    'features' => [ 'Sales, Procurement, Inventory', 'Finance, Management', '1-week after-purchase service' ],
    'popular' => false,
  ],
  [
    'name' => 'Business',
    'setup' => 'Rp 15.000.000',
    'sub' => '+ Rp 8.000.000/mo subscription',
    'features' => [ 'Everything in Basic', 'Manufacturing module', 'Customization and training', '3-page website included' ],
    'popular' => true,
  ],
  [
    'name' => 'Enterprise',
    'setup' => 'Rp 30.000.000',
    'sub' => '+ Rp 10.000.000/mo subscription',
    'features' => [ 'Everything in Business', '24/7 support', 'Fully tailored build' ],
    'popular' => false,
  ],
];
?>

<section class="mx-auto max-w-6xl px-5 pb-10 pt-14 lg:pl-16">
  <p class="knpo-eyebrow">Investment</p>
  <h1 class="nest-display-md mt-4 max-w-4xl">
    <span class="knpo-jam knpo-jam-title block w-fit">
      <span class="knpo-jam-text">
        <span class="knpo-mask"><span>How far do you want to digitize?</span></span>
      </span>
      <span class="knpo-jam-pixel" aria-hidden="true">
        <span class="knpo-mask"><span>How far do you want to digitize?</span></span>
      </span>
    </span>
  </h1>
  <p class="mt-6 max-w-xl text-nest-muted" data-split>Starting prices. Final quote depends on modules. Excludes domain and API integrations.</p>
</section>

<section class="border-t border-nest-line">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-stagger grid items-start gap-4 md:grid-cols-3">
      <?php foreach ( $tiers as $t ) : ?>
      <div class="relative rounded-2xl border <?php echo $t['popular'] ? 'border-nest-lime' : 'border-nest-line'; ?> bg-nest-card p-6 md:p-8">
        <?php if ( $t['popular'] ) : ?><p class="absolute -top-3 left-6 rounded-full bg-nest-lime px-3 py-1 text-xs font-semibold text-nest-black">Most popular</p><?php endif; ?>
        <h2 class="font-display text-lg font-bold"><?php echo esc_html( $t['name'] ); ?></h2>
        <p class="mt-2 font-display text-3xl font-bold"><?php echo esc_html( $t['setup'] ); ?> <span class="whitespace-nowrap text-sm font-normal text-nest-muted">one-time setup</span></p>
        <p class="text-sm text-nest-muted"><?php echo esc_html( $t['sub'] ); ?></p>
        <ul class="mt-4 space-y-1 text-sm text-nest-muted">
          <?php foreach ( $t['features'] as $feature ) : ?><li>✓ <?php echo esc_html( $feature ); ?></li><?php endforeach; ?>
        </ul>
        <a href="<?php echo esc_url( knpo_whatsapp_link( 'Hi DigitalNest, I want to discuss the ' . $t['name'] . ' plan.' ) ); ?>" target="_blank" rel="noopener" class="btn <?php echo $t['popular'] ? 'btn-primary' : 'btn-outline'; ?> mt-6 w-full">Discuss <?php echo esc_html( $t['name'] ); ?></a>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="knpo-reveal mt-4 rounded-2xl border border-nest-line bg-nest-card p-6 md:p-8">
      <p class="knpo-eyebrow">Website only — from Rp 10.000.000</p>
      <p class="mt-3 max-w-2xl text-sm text-nest-muted">3 pages (Home, Product Portfolio, About Us) · responsive on phone and desktop · additional page Rp 3.500.000. Excludes domain and API integrations. Terms apply.</p>
    </div>

    <p class="mt-8 text-center text-xs text-nest-muted">Starting prices — final quote depends on modules. Terms and conditions apply.</p>
  </div>
</section>

<?php get_footer(); ?>
