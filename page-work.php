<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$works = knpo_works();
?>

<section class="mx-auto max-w-6xl px-5 pb-10 pt-14 lg:pl-16">
  <p class="knpo-eyebrow">Selected work</p>
  <h1 class="nest-display-md mt-4 max-w-4xl">
    <span class="knpo-jam knpo-jam-title block w-fit">
      <span class="knpo-jam-text">
        <span class="knpo-mask"><span>Proof, not promises.</span></span>
      </span>
      <span class="knpo-jam-pixel" aria-hidden="true">
        <span class="knpo-mask"><span>Proof, not promises.</span></span>
      </span>
    </span>
  </h1>
  <p class="mt-6 max-w-xl text-nest-muted" data-split>ERP ecosystems and websites — from factory floors to photo-grade storefronts.</p>
</section>

<section class="border-t border-nest-line">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <?php foreach ( $works as $w ) : ?>
    <article class="border-t border-nest-line py-14 first:border-t-0 first:pt-0">
      <div class="knpo-reveal">
        <div class="flex flex-wrap items-center justify-between gap-2">
          <p class="knpo-eyebrow"><?php echo esc_html( $w['industry'] ); ?> · <?php echo esc_html( $w['year'] ); ?></p>
          <p class="text-xs uppercase tracking-[0.2em] text-nest-muted"><?php echo esc_html( $w['scope'] ); ?></p>
        </div>
        <h2 class="nest-display-sm mt-3" data-split><?php echo esc_html( $w['client'] ); ?></h2>
      </div>
      <div class="knpo-work-row">
        <div class="knpo-reveal knpo-work-thumb mt-6 aspect-[16/9]">
          <div class="flex h-full w-full flex-col justify-between p-6 md:p-10" style="background: <?php echo esc_attr( $w['gradient'] ); ?>">
            <span class="text-xs uppercase tracking-[0.25em] text-white/60"><?php echo esc_html( $w['summary'] ); ?></span>
            <span class="font-display text-3xl font-bold text-white md:text-5xl"><?php echo esc_html( $w['client'] ); ?></span>
          </div>
        </div>
      </div>
      <div class="knpo-stagger mt-6 grid gap-5 md:grid-cols-3">
        <div>
          <h3 class="knpo-eyebrow">Challenge</h3>
          <p class="mt-2 text-sm text-nest-muted"><?php echo esc_html( $w['challenge'] ); ?></p>
        </div>
        <div>
          <h3 class="knpo-eyebrow">What we built</h3>
          <p class="mt-2 text-sm text-nest-muted"><?php echo esc_html( $w['built'] ); ?></p>
        </div>
        <div>
          <h3 class="knpo-eyebrow">Result</h3>
          <p class="mt-2 text-sm text-nest-muted"><?php echo esc_html( $w['result'] ); ?></p>
        </div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<?php get_footer(); ?>
