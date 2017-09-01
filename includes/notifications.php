<?php
function get_notifications_markup( $context ){

	if( $context === 'success' ){
?>
<div class="">
	<?php
	if( key_exists( 'delete', $_GET ) ){
		?>
			<h2>Project Successfuly Deleted</h2>
		<?php
	}
	elseif( key_exists( 'archive-project', $_GET ) ){
		?>
			<h2>Project Successfuly Archived</h2>
		<?php
	}
	else{
	?>
	<h2>Project Successfuly Created</h2>
	<?php } ?>
</div>
<?php
	}

	else {
		if( key_exists( 'delete', $_GET ) ){
			?>
			<div class="">
				<h2>You need to confirm first</h2>
			</div>
			<?php
		}
		elseif( key_exists( 'archive_project', $_GET ) ){
			?>
			<div class="">
				<h2>Archive failed</h2>
			</div>
			<?php
		}
		else{
?>
<div class="">
	<h2>Please fill in project name and project folder</h2>
</div>
<?php
		}
	}
}
