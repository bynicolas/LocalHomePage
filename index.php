<?php require_once('includes/config.php'); ?>

<?php get_header(); ?>

	    <div class="canvas">

		    <header>

			    <h1>My Local Sites</h1>

					<?php get_navigation(); ?>

					<?php get_notifications(); ?>

		    </header>

		    <content class="cf">
<?php

		    foreach ( $dir as $d ) {
			    $dirsplit = explode('/', $d);
			    $dirname = $dirsplit[count($dirsplit)-2];

				printf( '<ul class="sites %1$s">', $dirname );

		        foreach( glob( $d ) as $project_dir )  {

		        	$project_dirname = basename($project_dir);
							// error_log( PROJECTS_ROOT . ' $project_dirname: ' . print_r( $project_dirname, true ) );


		        	if ( in_array( $project_dirname, $hiddensites ) ) continue;

		            echo '<li>';

		            $siteroot = sprintf( 'http://%1$s.%2$s', $project_dirname, $Projects[ 'tld' ] );

		            // Display an icon for the site
		            $icon_output = '<span class="no-img"></span>';
		            foreach( $icons as $icon ) {

		            	if ( file_exists( $project_dir . '/' . $icon ) ) {
		            		$icon_output = sprintf( '<img src="%1$s/%2$s">', $siteroot, $icon );
		            		break;
		            	} // if ( file_exists( $project_dir . '/' . $icon ) )

		            } // foreach( $icons as $icon )
		            echo $icon_output;

		            // Display a link to the site
		            $displayname = $project_dirname;
		            if ( array_key_exists( $project_dirname, $siteoptions ) ) {
		            	if ( is_array( $siteoptions[$project_dirname] ) )
		            		$displayname = array_key_exists( 'displayname', $siteoptions[$project_dirname] ) ? $siteoptions[$project_dirname]['displayname'] : $project_dirname;
		            	else
		            		$displayname = $siteoptions[$project_dirname];
		            }
		            printf( '<a class="site" href="%1$s">%2$s</a>', $siteroot, $displayname );


								//Display Delete project link
								$delete_project = ' - <span class="delete-project"><a title="Delete project" href="/delete.php?project=' . $project_dirname . '"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>';

								//Display archive project link
								$archive_project = '<span class="archive-project"><a title="Archive project" href="/?archive=' . $project_dirname . '"><i class="fa fa-archive" aria-hidden="true"></i></a></span>';


					// Display an icon with a link to the admin area
					$adminurl = '';
					// We'll start by checking if the site looks like it's a WordPress site
					if ( is_dir( $project_dir . '/wp-admin' ) )
						$adminurl = sprintf( '%1$s/wp-login.php', $siteroot );

					// If the user has defined an adminurl for the project we'll use that instead
		            if (isset($siteoptions[$project_dirname]) &&  is_array( $siteoptions[$project_dirname] ) && array_key_exists( 'adminurl', $siteoptions[$project_dirname] ) )
		            	$adminurl = $siteoptions[$project_dirname]['adminurl'];

		            // If there's an admin url then we'll show it - the icon will depend on whether it looks like WP or not
		            if ( ! empty( $adminurl ) )
			            printf( '<a class="%2$s icon" href="%1$s">Admin</a>', $adminurl, is_dir( $project_dir . '/wp-admin' ) ? 'wp' : 'admin' );

								echo $delete_project;
								echo $archive_project;
		            echo '</li>';

				} // foreach( glob( $d ) as $project_dir )

		        echo '</ul>';

		   	} // foreach ( $dir as $d )
?>
			</content>


<?php get_footer(); ?>
