<!doctype html>
<html <?php language_attributes(); ?> data-theme="digitalnest">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-nest-black text-base-content font-body' ); ?> data-barba="wrapper">
<?php wp_body_open(); ?>
<div class="nest-progress" aria-hidden="true"></div>
<div class="knpo-rail flex-col items-center justify-between py-24" aria-hidden="true">
  <span class="text-[0.65rem] uppercase tracking-[0.3em] text-nest-muted" style="writing-mode: vertical-rl;">Est. Jakarta</span>
  <span class="h-2 w-2 rounded-full bg-nest-lime"></span>
  <span class="text-[0.65rem] uppercase tracking-[0.3em] text-nest-muted" style="writing-mode: vertical-rl;">Scroll</span>
</div>
<header class="knpo-header fixed inset-x-0 top-0 z-50 border-b border-nest-line bg-nest-black/85 backdrop-blur">
  <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3 lg:pl-16">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="font-display text-lg font-bold tracking-tight">
      Digital<span class="knpo-accent">Nest</span>
    </a>
    <p class="hidden text-xs uppercase tracking-[0.25em] text-nest-muted md:block">Close the gaps. Control the business.</p>
    <div class="flex items-center gap-3">
      <nav class="hidden items-center gap-5 text-sm text-nest-muted lg:flex" aria-label="Primary">
        <a class="nest-link hover:text-base-content" href="<?php echo esc_url( home_url( '/erp-system/' ) ); ?>">ERP System</a>
        <a class="nest-link hover:text-base-content" href="<?php echo esc_url( home_url( '/websites/' ) ); ?>">Websites</a>
        <a class="nest-link hover:text-base-content" href="<?php echo esc_url( home_url( '/work/' ) ); ?>">Work</a>
        <a class="nest-link hover:text-base-content" href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">Pricing</a>
      </nav>
      <a href="<?php echo esc_url( knpo_whatsapp_link( 'Hi DigitalNest, I want a demo.' ) ); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-sm btn-arrow">Contact us</a>
      <details class="relative lg:hidden">
        <summary class="btn btn-ghost btn-sm list-none" aria-label="Open menu">Menu</summary>
        <nav class="absolute right-0 z-50 mt-2 flex w-48 flex-col rounded-xl border border-nest-line bg-nest-card p-2 text-sm shadow-xl" aria-label="Mobile">
          <a class="rounded-lg px-3 py-2 hover:bg-nest-line/50" href="<?php echo esc_url( home_url( '/erp-system/' ) ); ?>">ERP System</a>
          <a class="rounded-lg px-3 py-2 hover:bg-nest-line/50" href="<?php echo esc_url( home_url( '/websites/' ) ); ?>">Websites</a>
          <a class="rounded-lg px-3 py-2 hover:bg-nest-line/50" href="<?php echo esc_url( home_url( '/work/' ) ); ?>">Work</a>
          <a class="rounded-lg px-3 py-2 hover:bg-nest-line/50" href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">Pricing</a>
        </nav>
      </details>
    </div>
  </div>
</header>
<main id="content" class="pt-14" data-barba="container" data-barba-namespace="<?php echo esc_attr( knpo_page_namespace() ); ?>">
