<div class="wrap biz_vektor_options">

	<h1><?php _e('高度な設定', 'biz-vektor') ?></h1>
	<div class="message_intro">
		高度な設定の説明
	</div>

	<?php //echo $data['mess'] ?>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">

		<div class="sectionBox">
			
			<h3><?php _e('サイトマップに追加する投稿タイプ', 'biz-vektor') ?></h3>
			<table class="form-table">
				<tbody>
					<tr>
						<th><?php _e('投稿タイプ', 'biz-vektor') ?></th>
						<td>
							<p>
								<?php 
									//var_dump(get_pages()); 
								?>
								<?php wp_list_pages('title_li=') ?>
								<input type="checkbox" id="" name="" />
								<label for=""></label>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('変更を保存', 'biz-vektor') ?>" />
			</p>
		</div><!-- /.sectionBox -->

		<div class="sectionBox">
			<h3><?php _e('サイトマップから除外する固定ページ', 'biz-vektor') ?></h3>
					<table class="form-table">
				<tbody>
					<tr>
						<th><?php _e('Pages') ?></th>
						<td>
							<p>
								<input type="checkbox" id="" name="" />
								<label for=""></label>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('変更を保存', 'biz-vektor') ?>" />
			</p>
		</div><!-- /.sectionBox -->
	</form><!-- end from-->



</div><!-- /.biz-vektor-options -->