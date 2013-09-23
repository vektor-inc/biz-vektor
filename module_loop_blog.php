<ul class="entryList">
<?php while(have_posts()): the_post(); ?>
<li>
<span class="infoDate"><?php echo esc_html( get_the_date() ); ?></span>
<span class="infoCate"><?php the_category(' ') ?></span>
<?php if ( is_user_logged_in() == TRUE ) : edit_post_link(__('Edit', 'biz-vektor'), '<span class="edit-link　edit-item">[ ', ' ]</span>');endif ?>
<span class="infoTxt"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
</li>
<?php endwhile; ?>
</ul>