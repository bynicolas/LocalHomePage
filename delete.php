<?php require_once('includes/config.php'); ?>

<?php get_header_markup(); ?>

	    <div class="canvas">

		    <header>

			    <h1>Are you sure you want to delete </h1>

			    <?php get_navigation(); ?>

					<?php get_notifications(); ?>

					<?php isset( $_GET['project'] ) ? $root = PROJECTS_ROOT . $_GET['project'] : $root = ''; ?>



		    </header>

		    <content class="cf">
					<form method="post">

						<ul class="delete-project">
							<li>
								<label for="project-name">This will delete the project located at: <?php echo $root; ?></label>
								<input type="hidden" name="project-root" value="<?php echo isset( $_GET['project'] ) ? $_GET['project'] : ''; ?>">
							</li>
							<li>
								<label for="project-folder">You could also archive the project for later use</label>
							</li>
							<li>
								<label for="is-delete-confirmed">Confirm to delete project?</label>
								<input type="checkbox" name="is-delete-confirmed" value=1>
							</li>
							<li>
								<input type="hidden" name="delete-project">
								<input type="submit" value="Delete Project">
							</li>
						</ul>
					</form>
				</content>

<?php get_footer(); ?>
