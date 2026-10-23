<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$wa = knpo_whatsapp_link( 'Hi DigitalNest, I want to discuss your ERP system.' );
$gaps = [
  [ 'icon' => 'receipt', 'title' => 'Marked-up purchasing', 'desc' => 'Suppliers and prices manipulated before you ever see them.' ],
  [ 'icon' => 'package', 'title' => 'Stock for personal use', 'desc' => 'Goods leave the warehouse with no record.' ],
  [ 'icon' => 'money', 'title' => 'Payroll and transaction manipulation', 'desc' => 'Ghost entries and edited amounts slip through.' ],
  [ 'icon' => 'user-circle', 'title' => 'Single-employee knowledge', 'desc' => 'Critical data lives in one person’s head.' ],
  [ 'icon' => 'keyboard', 'title' => 'Price and quantity mis-entry', 'desc' => 'Small typos, repeated daily, become big losses.' ],
  [ 'icon' => 'database', 'title' => 'No inventory and sales data', 'desc' => 'You cannot reconcile what was never recorded.' ],
];
$checkpoints = [
  [ 'icon' => 'identification-badge', 'name' => 'Identity', 'question' => 'Who made this transaction?', 'desc' => 'Every employee has their own account and access.' ],
  [ 'icon' => 'seal-check', 'name' => 'Verification', 'question' => 'Is this transaction valid?', 'desc' => 'Important activity can require a verification mechanism.' ],
  [ 'icon' => 'user-check', 'name' => 'Authorization', 'question' => 'Who is allowed to approve?', 'desc' => 'Not everyone has the same authority.' ],
  [ 'icon' => 'path', 'name' => 'Traceability', 'question' => 'What actually happened?', 'desc' => 'Every transaction leaves a digital trail.' ],
  [ 'icon' => 'eye', 'name' => 'Visibility', 'question' => 'Can management see it?', 'desc' => 'Operations are monitored without asking staff one by one.' ],
];
$datasheet = [
  'Core' => [
    [ 'icon' => 'shopping-cart', 'name' => 'Sales', 'desc' => 'Sales orders, delivery orders, price books', 'top' => true, 'mam' => true ],
    [ 'icon' => 'truck', 'name' => 'Procurement', 'desc' => 'Purchase orders, suppliers, monitoring', 'top' => true, 'mam' => true ],
    [ 'icon' => 'warehouse', 'name' => 'Inventory', 'desc' => 'Movements, transfers, returns', 'top' => true, 'mam' => true ],
  ],
  'Manufacturing' => [
    [ 'icon' => 'factory', 'name' => 'Manufacturing', 'desc' => 'Formulas, production logs, material use', 'top' => true, 'mam' => false ],
    [ 'icon' => 'flask', 'name' => 'Product Formula', 'desc' => 'Recipes and raw-material composition', 'top' => true, 'mam' => false ],
    [ 'icon' => 'notebook', 'name' => 'Production Log', 'desc' => 'Production runs and material consumption', 'top' => true, 'mam' => false ],
  ],
  'Finance' => [
    [ 'icon' => 'bank', 'name' => 'Finance', 'desc' => 'Petty cash, payments, transactions', 'top' => true, 'mam' => true ],
    [ 'icon' => 'users-three', 'name' => 'Payroll', 'desc' => 'Salaries, supervision', 'top' => true, 'mam' => true ],
    [ 'icon' => 'wallet', 'name' => 'Petty Cash', 'desc' => 'Cash advances and expenses', 'top' => true, 'mam' => true ],
  ],
  'Control' => [
    [ 'icon' => 'chart-line-up', 'name' => 'Reporting', 'desc' => 'Dashboards, reports, reconciliation', 'top' => true, 'mam' => true ],
    [ 'icon' => 'lock-key', 'name' => 'Account and Access', 'desc' => 'Users, roles, audit trail', 'top' => true, 'mam' => true ],
  ],
];
?>

<section class="mx-auto max-w-6xl px-5 pb-10 pt-14 lg:pl-16">
  <p class="knpo-eyebrow">ERP System</p>
  <h1 class="nest-display-md mt-4 max-w-4xl">
    <span class="knpo-jam knpo-jam-title block w-fit">
      <span class="knpo-jam-text">
        <span class="knpo-mask"><span>Every movement recorded.</span></span>
        <span class="knpo-mask"><span>Every rupiah traceable.</span></span>
      </span>
      <span class="knpo-jam-pixel" aria-hidden="true">
        <span class="knpo-mask"><span>Every movement recorded.</span></span>
        <span class="knpo-mask"><span>Every rupiah traceable.</span></span>
      </span>
    </span>
  </h1>
  <div class="mt-6 flex flex-wrap items-end justify-between gap-6">
    <p class="max-w-xl text-nest-muted" data-split>How DigitalNest ERP closes operational gaps — from purchase order to management dashboard. One ecosystem that connects transactions, operations, finance and management.</p>
    <a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-arrow">Contact us</a>
  </div>
</section>

<section class="border-t border-nest-line">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">The problem</p>
      <h2 class="nest-display-sm mt-2 max-w-2xl" data-split>Everyday gaps quietly drain your business.</h2>
    </div>
    <div class="knpo-ledger knpo-reveal mt-8">
      <?php foreach ( $gaps as $g ) : ?>
      <div class="knpo-ledger-row">
        <?php echo knpo_icon( $g['icon'], 'knpo-ledger-icon' ); ?>
        <div>
          <h3 class="font-display text-lg font-bold"><?php echo esc_html( $g['title'] ); ?></h3>
          <p class="mt-1 max-w-2xl text-sm text-nest-muted"><?php echo esc_html( $g['desc'] ); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="knpo-quote knpo-reveal mt-10">
      <p class="knpo-quote-text" data-scrub><strong>Where does your money go</strong> when you cannot see every transaction? The issue is rarely dishonest staff — it is a system <strong class="knpo-scrub-key knpo-accent">without checkpoints</strong>.</p>
    </div>
  </div>
</section>

<section class="border-y border-nest-line bg-nest-surface">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">Example: stock leakage</p>
      <h2 class="nest-display-sm mt-2" data-split>1,000 pencils in. How many can you trace?</h2>
    </div>
    <div class="knpo-stagger mt-8 grid gap-4 md:grid-cols-2">
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <p class="font-display text-lg font-bold text-red-400">Without a system</p>
        <ol class="mt-3 list-decimal space-y-1 pl-5 text-sm text-nest-muted">
          <li>Goods received, partially recorded</li>
          <li>Used and sold, some slips missing</li>
          <li>Stock leaves with no trail</li>
        </ol>
        <p class="mt-3 text-sm">Small leaks, repeated, become <strong>large losses</strong>.</p>
      </div>
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <p class="font-display text-lg font-bold knpo-accent">With DigitalNest ERP</p>
        <ol class="mt-3 list-decimal space-y-1 pl-5 text-sm text-nest-muted">
          <li>Purchase order creates stock automatically</li>
          <li>Payment and stock logged together</li>
          <li>Sale reduces stock, fully traceable</li>
        </ol>
        <p class="mt-3 text-sm text-nest-muted">Every movement leaves a trail — with a timestamp, an owner and a document.</p>
      </div>
    </div>
  </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
  <div class="knpo-spine-layout">
    <div class="knpo-spine-intro">
      <div class="knpo-reveal">
        <p class="knpo-eyebrow">Five checkpoints</p>
        <h2 class="nest-display-sm mt-2 max-w-3xl" data-split>A good system makes your business smarter.</h2>
      </div>
    </div>
    <ol class="knpo-spine">
      <?php foreach ( $checkpoints as $i => $c ) : ?>
      <li class="knpo-spine-item">
        <?php if ( $i < count( $checkpoints ) - 1 ) : ?>
        <span class="knpo-spine-fill knpo-accent" aria-hidden="true"></span>
        <?php endif; ?>
        <div class="knpo-spine-node knpo-accent" aria-hidden="true">
          <?php echo knpo_icon( $c['icon'], 'knpo-spine-icon' ); ?>
        </div>
        <div class="knpo-spine-copy">
          <p class="knpo-spine-meta"><?php echo esc_html( $c['name'] ); ?></p>
          <h3 class="font-display mt-1 text-xl font-bold"><?php echo esc_html( $c['question'] ); ?></h3>
          <p class="mt-1 max-w-xl text-sm text-nest-muted"><?php echo esc_html( $c['desc'] ); ?></p>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="border-y border-nest-line bg-nest-surface">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">From process to digital control system</p>
      <h2 class="nest-display-sm mt-2" data-split>One ecosystem, transaction to decision.</h2>
    </div>
    <div class="knpo-stagger mt-8 grid gap-4 md:grid-cols-3">
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <h3 class="font-display text-lg font-bold knpo-accent">Control transactions</h3>
        <ul class="mt-3 space-y-1 text-sm text-nest-muted">
          <li>Payment gateway + OTP verification</li>
          <li>Customer data and automatic transaction log</li>
          <li>Automatic notifications</li>
        </ul>
      </div>
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <h3 class="font-display text-lg font-bold knpo-accent">Control operations</h3>
        <ul class="mt-3 space-y-1 text-sm text-nest-muted">
          <li>Sales, procurement, inventory</li>
          <li>Manufacturing, finance, payroll</li>
          <li>User access, every log recorded</li>
        </ul>
      </div>
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <h3 class="font-display text-lg font-bold knpo-accent">Control the business</h3>
        <ul class="mt-3 space-y-1 text-sm text-nest-muted">
          <li>Dashboards and reports</li>
          <li>Supervision and reconciliation</li>
          <li>Full visibility for decisions</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
  <div class="knpo-reveal">
    <p class="knpo-eyebrow">Modules</p>
    <h2 class="nest-display-sm mt-2" data-split>ERP modules, fitted to your business.</h2>
    <p class="mt-4 max-w-2xl text-sm text-nest-muted">Delivered for PT. Triniti Optima Packindo and CV. Maksimalkan Akselerasi Motormu.</p>
  </div>
  <div class="knpo-datasheet knpo-reveal mt-10">
    <table class="knpo-table">
      <caption class="sr-only">Modules delivered to PT. Triniti Optima Packindo and CV. Maksimalkan Akselerasi Motormu</caption>
      <thead>
        <tr>
          <th scope="col">Module</th>
          <th scope="col" class="hidden md:table-cell">What’s inside</th>
          <th scope="col" class="knpo-datasheet-status">PT. TOP</th>
          <th scope="col" class="knpo-datasheet-status">CV. MAM</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ( $datasheet as $group => $rows ) : ?>
        <tr class="knpo-datasheet-group">
          <th scope="colgroup" colspan="4" class="knpo-accent"><?php echo esc_html( $group ); ?></th>
        </tr>
        <?php foreach ( $rows as $r ) : ?>
        <tr>
          <th scope="row">
            <span class="inline-flex items-center gap-2">
              <?php echo knpo_icon( $r['icon'], 'text-base text-nest-muted' ); ?>
              <span class="font-medium"><?php echo esc_html( $r['name'] ); ?></span>
            </span>
            <span class="mt-1 block text-xs font-normal text-nest-muted md:hidden"><?php echo esc_html( $r['desc'] ); ?></span>
          </th>
          <td class="hidden text-nest-muted md:table-cell"><?php echo esc_html( $r['desc'] ); ?></td>
          <td class="knpo-datasheet-status">
            <?php if ( $r['top'] ) : ?>
              <span class="knpo-status-yes"><?php echo knpo_icon( 'check', 'knpo-status-icon knpo-accent' ); ?><span class="sr-only">Included</span></span>
            <?php else : ?>
              <span class="knpo-status-no"><span aria-hidden="true">—</span><span class="sr-only">Not included</span></span>
            <?php endif; ?>
          </td>
          <td class="knpo-datasheet-status">
            <?php if ( $r['mam'] ) : ?>
              <span class="knpo-status-yes"><?php echo knpo_icon( 'check', 'knpo-status-icon knpo-accent' ); ?><span class="sr-only">Included</span></span>
            <?php else : ?>
              <span class="knpo-status-no"><span aria-hidden="true">—</span><span class="sr-only">Not included</span></span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="mt-4 text-sm text-nest-muted">We build the system around your needs — one foundation, adapted to your business.</p>
</section>

<section class="border-y border-nest-line bg-nest-surface">
  <div class="mx-auto max-w-6xl px-5 py-16 lg:pl-16">
    <div class="knpo-reveal">
      <p class="knpo-eyebrow">Case study · Manufacturing · 2025</p>
      <h2 class="nest-display-sm mt-2 max-w-3xl" data-split>PT. TOP: from production formula to inventory movement.</h2>
    </div>
    <p class="knpo-reveal mt-4 max-w-2xl text-nest-muted" data-scrub>PT. Triniti Optima Packindo is a bubble-wrap manufacturer with complex operations. DigitalNest integrated the full production chain — product formulas, production records, raw-material consumption, finished-goods records and inventory transactions.</p>
    <div class="knpo-stagger mt-8 grid gap-4 md:grid-cols-3">
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <p class="font-display font-bold">Production writes back to stock</p>
        <p class="mt-1 text-sm text-nest-muted">When a production run happens, raw-material consumption and finished-goods additions are recorded in the system.</p>
      </div>
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <p class="font-display font-bold">Two ERPs, one dashboard</p>
        <p class="mt-1 text-sm text-nest-muted">Two existing ERP systems were consolidated into a single management dashboard.</p>
      </div>
      <div class="rounded-2xl border border-nest-line bg-nest-card p-6">
        <p class="font-display font-bold">Daily transactions, full visibility</p>
        <p class="mt-1 text-sm text-nest-muted">Management sees the operational picture without chasing reports.</p>
      </div>
    </div>
    <a href="<?php echo esc_url( home_url( '/work/' ) ); ?>" class="nest-link mt-8 inline-block text-sm knpo-accent">See all work ↗</a>
  </div>
</section>

<?php get_footer(); ?>
