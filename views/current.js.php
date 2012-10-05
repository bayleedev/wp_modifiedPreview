<?php
	// Such a gross file...
	header('Content-type: text/javascript');
?>
jQuery(document).ready(function($)) {
	$('#post-preview:contains("<?php echo __( 'Preview Changes' ); ?>")').bind({
		click: function(e) {
			window.open('<?php echo previewChange::previewPostLink(); ?>');
			e.preventDefault();
			e.stopPropagation();
		}
	})
}