<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$wa = knpo_whatsapp_link( 'Hi DigitalNest, I want to discuss a website for my business.' );
$sites = [
  [
    'name' => 'curatedstudiosus.com',
    'url'  => 'https://www.curatedstudiosus.com/',
    'summary' => '4-page website',
    'detail'  => 'A large media server for high-resolution photography, built to demonstrate print-grade image quality.',
    'gradient' => 'linear-gradient(135deg,#4d0c33,#1d1d1d 70%)',
    'tags' => [ '4 pages', 'High-res media', 'Creative studio' ],
  ],
  [
    'name' => 'indodentalcenter.com',
    'url'  => 'https://www.indodentalcenter.com/',
    'summary' => '5-page clinic website',
    'detail'  => 'Home, Product Portfolio, Doctors, About Us and Articles — with 2 pop-up modals, 2 languages and a floating WhatsApp button.',
    'gradient' => 'linear-gradient(135deg,#1a4d0c,#1d1d1d 70%)',
    'tags' => [ '5 pages', '2 modals', '2 languages', 'Floating WA' ],
  ],
];
$stages = [
  [ 'icon' => 'credit-card', 'stage' => 'Payment', 'manual' => 'Information can be manipulated', 'digital' => 'Gateway-verified' ],
  [ 'icon' => 'bell-ringing', 'stage' => 'Confirmation', 'manual' => 'Depends on a person', 'digital' => 'Automatic' ],
  [ 'icon' => 'database', 'stage' => 'Records', 'manual' => 'Scattered across chats and slips', 'digital' => 'Logged and integrated' ],
  [ 'icon' => 'scales', 'stage' => 'Reconciliation', 'manual' => 'Manual and slow', 'digital' => 'Traceable by transaction' ],
  [ 'icon' => 'storefront', 'stage' => 'Customer experience', 'manual' => 'Inconsistent', 'digital' => 'Professional and predictable' ],
];
?>

<section class="mx-auto max-w-6xl px-5 pb-10 pt-14 lg:pl-16">
  <p class="knpo-eyebrow">Websites</p>
  <h1 class="nest-display-md mt-4 max-w-4xl">
    <span class="knpo-jam knpo-jam-title block w-fit">
      <span class="knpo-jam-text">
        <span class="knpo-mask"><span>Websites that remove human error.</span></span>
      </span>
      <span class="knpo-jam-pixel" aria-hidden="true">
        <span class="knpo-mask"><span>Websites that remove human error.</span></span>
      </span>
    </span>
  </h1>
  <div class="mt-6 flex flex-wrap items-end justify-between gap-6">
    <p class="max-w-xl text-nest-muted" data-split>Gateway-verified checkout flows, integrated records and a professional customer experience — without adding manual steps.</p>
    <a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-arrow">Contact us</a>
  </div>
</section>

<section class="border-t border-nest-line">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">Manual vs digital</p>
      <h2 class="nest-display-sm mt-2" data-split>Digitalization removes human-error points.</h2>
      <div class="mt-5 flex flex-col gap-2 text-xs text-nest-muted md:flex-row md:gap-8">
        <p><span class="font-semibold">Manual</span> · customer → employee → payment method → manual confirmation</p>
        <p><span class="font-semibold knpo-accent">With DigitalNest</span> · customer → website → payment gateway → verification → recorded → integrated</p>
      </div>
    </div>
    <div class="knpo-compare knpo-reveal mt-8">
      <table class="knpo-table">
        <caption class="sr-only">Manual process compared with DigitalNest</caption>
        <thead>
          <tr>
            <th scope="col">Stage</th>
            <th scope="col">
              <span class="inline-flex items-center gap-2">
                <?php echo knpo_icon( 'x', 'text-sm text-red-400' ); ?>
                <span>Manual process</span>
              </span>
            </th>
            <th scope="col">
              <span class="inline-flex items-center gap-2">
                <?php echo knpo_icon( 'check', 'text-sm knpo-accent' ); ?>
                <span class="knpo-accent">With DigitalNest</span>
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ( $stages as $s ) : ?>
          <tr>
            <th scope="row">
              <span class="inline-flex items-center gap-2">
                <?php echo knpo_icon( $s['icon'], 'knpo-compare-icon' ); ?>
                <span class="font-medium"><?php echo esc_html( $s['stage'] ); ?></span>
              </span>
            </th>
            <td class="knpo-compare-manual" data-label="Manual"><?php echo esc_html( $s['manual'] ); ?></td>
            <td class="knpo-compare-digital" data-label="DigitalNest"><?php echo esc_html( $s['digital'] ); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="border-y border-nest-line bg-nest-surface">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">Selected websites</p>
      <h2 class="nest-display-sm mt-2" data-split>Digital presence that works.</h2>
    </div>
    <div class="mt-10 space-y-14">
      <?php foreach ( $sites as $s ) : ?>
      <a href="<?php echo esc_url( $s['url'] ); ?>" target="_blank" rel="noopener" class="knpo-work-row group block knpo-reveal">
        <div class="knpo-work-thumb aspect-[16/9]">
          <div class="flex h-full w-full flex-col justify-between p-6 md:p-10" style="background: <?php echo esc_attr( $s['gradient'] ); ?>">
            <span class="text-xs uppercase tracking-[0.25em] text-white/60">Website · <?php echo esc_html( $s['summary'] ); ?></span>
            <span class="font-display text-3xl font-bold text-white md:text-5xl"><?php echo esc_html( $s['name'] ); ?></span>
          </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center justify-between gap-4">
          <p class="max-w-xl text-sm text-nest-muted"><?php echo esc_html( $s['detail'] ); ?></p>
          <span class="nest-link text-sm knpo-accent">Visit site ↗</span>
        </div>
        <div class="mt-3 flex flex-wrap gap-2">
          <?php foreach ( $s['tags'] as $t ) : ?><span class="rounded-full border border-nest-line px-3 py-1 text-xs text-nest-muted"><?php echo esc_html( $t ); ?></span><?php endforeach; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section>
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal rounded-2xl border border-nest-line bg-nest-card p-6 md:p-10">
      <p class="knpo-eyebrow">Website only — from Rp 10.000.000</p>
      <h2 class="nest-display-sm mt-2" data-split>Three pages, built to convert.</h2>
      <p class="mt-3 max-w-2xl text-sm text-nest-muted">3 pages (Home, Product Portfolio, About Us) · responsive on phone and desktop · additional page Rp 3.500.000. Excludes domain and API integrations. Terms apply.</p>
    </div>
  </div>
</section>

<?php get_footer(); ?>
