<?php if ( is_active_sidebar( 'blog-first-widget-area' ) ) : ?>
<div class="localSection sideWidget">
<?php dynamic_sidebar( 'blog-first-widget-area' ); ?>
</div>
<?php else : ?>
<div class="localSection sideWidget">
<div class="localNaviBox">
<h3 class="localHead">カテゴリー</h3>
<ul class="localNavi">
<?php wp_list_categories('title_li=&orderby=order'); ?> 
</ul>
</div>
</div>
<?php endif; ?>