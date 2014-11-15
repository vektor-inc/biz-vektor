<div class="wrap biz_vektor_options">

	<h2><?php echo get_biz_vektor_name(); ?> <?php _e('Advanced Options', 'biz-vektor') ?></h2>

	<?php echo $data['mess'] ?>
	<div class="fileedit-sub"></div>
<!--
	<div class="message_intro">
		<p>
			<?php _e('Here you can edit the advanced options.');?>
		</p>
	</div>
-->
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
		<?php wp_nonce_field( 'submit-sitemap', 'nonce-sitemap' ); ?>

		<!-- [SITEMAP] -->
		<div class="sectionBox" id="post-type">

			<h3><?php _e('Sitemap settings', 'biz-vektor') ?></h3>

			<table class="form-table">
				<tbody>
					<tr>
						<th>
							<label for="types">
								<?php _e('Post types to add', 'biz-vektor') ?>
							</label>
						</th>
						<td>
							<p>
								<input type="text" id="types" name="types" placeholder="service,product" value="<?php echo $data['types'] ?>" />
								&nbsp;<?php _e( '*In case you have created custom post types you can add them here, comma separated if you have several.', 'biz-vektor' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th>
							<label for="pages"><?php _e('Pages to hide') ?></label>
						</th>
						<td>
							<p>
								<input type="text" id="pages" name="pages" placeholder="35,1654" value="<?php echo $data['pages'] ?>" />
								&nbsp;<?php _e( 'Enter the IDs of the pages you want to hide from the sitemap. Comma separated.', 'biz-vektor' );?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</div><!-- /.sectionBox -->
		<!-- [/SITEMAP] -->

	</form><!-- end from-->



</div><!-- /.biz-vektor-options -->