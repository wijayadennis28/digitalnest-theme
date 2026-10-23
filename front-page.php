<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$wa = knpo_whatsapp_link( 'Hi DigitalNest, I want a demo.' );
$services = knpo_services();
$works = knpo_works();
?>

<!-- HERO -->
<section class="knpo-hero mx-auto max-w-6xl px-5 pt-14 pb-10 lg:pl-16">
  <p class="knpo-eyebrow knpo-hero-copy">Transaction-to-decision control</p>
  <h1 class="nest-display-lg mt-4 knpo-hero-copy">
    <span class="knpo-jam block w-fit">
      <span class="knpo-jam-text">
        <span class="knpo-mask"><span>Build the system.</span></span>
        <span class="knpo-mask"><span>Close the gaps.</span></span>
      </span>
      <span class="knpo-jam-pixel" aria-hidden="true">
        <span class="knpo-mask"><span>Build the system.</span></span>
        <span class="knpo-mask"><span>Close the gaps.</span></span>
      </span>
    </span>
  </h1>
  <div class="knpo-hero-copy mt-6 flex flex-wrap items-end justify-between gap-6">
    <p class="max-w-md text-nest-muted" data-split>DigitalNest is the plug-and-play crew for SME owners who suspect leakage — we digitize transactions, operations and finance so control comes without chasing staff.</p>
    <a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-arrow">Contact us</a>
  </div>
  <div class="knpo-hero-media mt-10 flex items-center justify-center" role="img" aria-label="Showreel placeholder — stock leakage demo">
    <div class="knpo-hero-media-inner" aria-hidden="true"></div>
    <div class="absolute left-5 top-5 flex items-center gap-2 text-xs uppercase tracking-[0.25em] text-white/60">
      <span class="h-2 w-2 rounded-full bg-red-500"></span> Showreel — 1,000 pencils
    </div>
    <span class="knpo-play" aria-hidden="true">▶</span>
    <div class="absolute bottom-5 right-5 rounded-full border border-white/20 px-4 py-1 text-xs text-white/60">ERP demo · 01:12</div>
  </div>
</section>

<!-- MARQUEE -->
<div class="knpo-marquee border-y border-nest-line py-4 text-sm uppercase tracking-[0.3em] text-nest-muted" aria-hidden="true">
  <div class="knpo-marquee-track">
    <span>Stock trace</span><span>·</span><span>Gateway verified</span><span>·</span><span>Role-based access</span><span>·</span><span>OTP secured</span><span>·</span><span>Auto-logged</span><span>·</span><span>Audit ready</span><span>·</span>
    <span>Stock trace</span><span>·</span><span>Gateway verified</span><span>·</span><span>Role-based access</span><span>·</span><span>OTP secured</span><span>·</span><span>Auto-logged</span><span>·</span><span>Audit ready</span><span>·</span>
  </div>
</div>

<!-- SERVICES / sticky stack -->
<section id="services" class="mx-auto max-w-6xl px-5 py-20 lg:pl-16">
  <div class="knpo-reveal">
    <p class="knpo-eyebrow">Services</p>
    <h2 class="nest-display-md mt-2" data-split>One ecosystem, not tools.</h2>
  </div>
  <div class="knpo-stack mt-10 space-y-6">
    <?php foreach ( $services as $i => $s ) : ?>
    <article class="knpo-stack-card rounded-2xl border border-nest-line bg-nest-card p-6 md:p-10" style="--i: <?php echo $i; ?>">
      <div class="knpo-reveal">
        <div class="flex items-center justify-between gap-4">
          <span class="font-display text-sm knpo-accent"><?php echo esc_html( $s['no'] ); ?></span>
          <a href="<?php echo esc_url( home_url( $s['url'] ) ); ?>" class="nest-link text-sm knpo-accent">Learn more →</a>
        </div>
        <h3 class="nest-display-sm mt-4"><?php echo esc_html( $s['title'] ); ?></h3>
        <div class="knpo-stack-body mt-4 flex flex-col justify-between gap-6">
          <p class="max-w-xl text-nest-muted"><?php echo esc_html( $s['desc'] ); ?></p>
          <div class="flex flex-wrap gap-2">
            <?php foreach ( $s['tags'] as $t ) : ?><span class="rounded-full border border-nest-line px-3 py-1 text-xs text-nest-muted"><?php echo esc_html( $t ); ?></span><?php endforeach; ?>
          </div>
        </div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<!-- WORK -->
<section id="work" class="border-t border-nest-line">
  <div class="mx-auto max-w-6xl px-5 py-20 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">Selected work</p>
      <h2 class="nest-display-md mt-2" data-split>Proof, not promises.</h2>
    </div>
    <div class="mt-10 space-y-14">
      <?php foreach ( $works as $w ) : ?>
      <a href="<?php echo esc_url( home_url( '/work/' ) ); ?>" class="knpo-work-row group block knpo-reveal">
        <div class="knpo-work-thumb aspect-[16/9]">
          <div class="flex h-full w-full flex-col justify-between p-6 md:p-10" style="background: <?php echo esc_attr( $w['gradient'] ); ?>">
            <span class="text-xs uppercase tracking-[0.25em] text-white/60"><?php echo esc_html( $w['industry'] ); ?> · <?php echo esc_html( $w['year'] ); ?></span>
            <span class="font-display text-3xl font-bold text-white md:text-5xl"><?php echo esc_html( $w['client'] ); ?></span>
          </div>
        </div>
        <div class="mt-3 flex items-center justify-between gap-4">
          <p class="text-sm text-nest-muted"><?php echo esc_html( $w['summary'] ); ?></p>
          <span class="nest-link text-sm knpo-accent">View project ↗</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
