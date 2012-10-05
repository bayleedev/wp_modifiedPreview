<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Preview Settings</h2>
	<form action="options-general.php?page=<?php echo $url; ?>" method="post">
		<h3>Address</h3>
		<p>Specify a base URL for preview button. For example, <code><?php bloginfo('url'); ?>/preview/%post_type%/%ID%/</code>.</p>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th>
						<label for="<?php echo $key; ?>">Address</label>
					</th>
					<td>
						<input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo get_option($key, get_bloginfo('url') . '/preview/%post_type%/%ID%/'); ?>" size="45" />
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>