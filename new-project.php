<?php require_once('includes/config.php'); ?>

<?php get_header_markup(); ?>

	    <div class="canvas">

		    <header>

			    <h1>Add New Project</h1>

			    <?php get_navigation(); ?>

					<?php get_notifications(); ?>


		    </header>

		    <content class="cf">
					<form method="post">

						<ul class="new-project">
							<li>
								<label for="project-name">Project Name</label>
								<input type="text" name="project-name" value="<?php isset( $_POST['project-name'] ) ? $_POST['project-name'] : ''; ?>">
							</li>
							<li>
								<label for="project-folder">Project Folder</label>
								<input type="text" name="project-folder" value="<?php isset( $_POST['project-folder'] ) ? $_POST['project-folder'] : ''; ?>">
							</li>
							<li>
								<label for="is-wordpress">Is this a WordPress project?</label>
								<input type="checkbox" name="is-wordpress" value=1>
							</li>
							<li>
								<input type="hidden" name="new-project">
								<input type="submit" value="Create Project">
							</li>
						</ul>
					</form>
				</content>

<?php get_footer(); ?>
