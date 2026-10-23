<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post(); ?>
<article class="mx-auto max-w-6xl px-5 py-16">
  <h1 class="nest-display-md"><span class="knpo-mask"><span><?php the_title(); ?></span></span></h1>
  <div class="mt-4"><?php the_content(); ?></div>
</article>
<?php endwhile;
get_footer();
