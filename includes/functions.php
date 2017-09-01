<?php

function get_header(){
  get_header_markup();
}

function get_navigation(){
  get_nav_markup();
}

function get_footer(){
  get_footer_markup();
}

function get_notifications(){

  if( isset( $_GET['new-project'] ) ){
    get_notifications_markup( $_GET['new-project'] );
  }

  if( isset( $_GET['delete'] ) ){
    get_notifications_markup( $_GET['delete'] );
  }

  if( isset( $_GET['archive-project'] ) ){
    get_notifications_markup( $_GET['archive-project'] );
  }


}

if( isset( $_POST['new-project'] ) ){

  if( empty( $_POST[ 'project-name' ] ) || empty( $_POST[ 'project-folder' ] ) ){
    header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?new-project=error" );
    die();
  }

  if ( ! file_exists( PROJECTS_ROOT . $_POST[ 'project-folder' ] ) ) {

    mkdir( PROJECTS_ROOT . $_POST[ 'project-folder' ], 0777, true );

  }

  if( isset( $_POST[ 'is-wordpress' ] ) ){
    recurse_copy( WWW_ROOT . 'WP-Quick-Install/wp-quick-install', PROJECTS_ROOT . $_POST[ 'project-folder' ] . '/wpqi' );
  }

  header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?new-project=success" );
  die();


}


function recurse_copy( $src, $dst ) {
    $dir = opendir( $src );
    @mkdir( $dst );
    while( false !== ( $file = readdir( $dir ) ) ) {
        if( ( $file != '.' ) && ( $file != '..' ) ) {
            if( is_dir( $src . '/' . $file ) ) {
                recurse_copy( $src . '/' . $file, $dst . '/' . $file );
            }
            else {
                copy( $src . '/' . $file, $dst . '/' . $file );
            }
        }
    }
    closedir( $dir );
}

//---------
//--------- Put this into a delete class or a project class containing a delete Method
//---------

define( 'DELETE_SCRIPT_FAIL_UNSAFE', -2 );
define( 'DELETE_SCRIPT_FAIL_CANT_DELETE', -1 );
define( 'DELETE_SCRIPT_SUCCESS', 0 );

function delete_project( $project_path )
{
	if ( ! defined( 'PROJECTS_ROOT' ) ) return DELETE_SCRIPT_FAIL_UNSAFE;

  delTree( $project_path ) ? $return = DELETE_SCRIPT_SUCCESS : $return = DELETE_SCRIPT_FAIL_CANT_DELETE;

  return $return;

}

function delTree( $dir ) {
   $files = array_diff( scandir( $dir ), array( '.', '..' ) );
    foreach ( $files as $file ) {
      ( is_dir( "$dir/$file" ) ) ? delTree( "$dir/$file" ) : unlink( "$dir/$file" );
    }
    return rmdir( $dir );
  }


//Listen to archive project
if( isset( $_GET[ 'archive' ] ) && ! empty( $_GET[ 'archive' ] ) )
{

  rename( PROJECTS_ROOT . $_GET[ 'archive' ], PROJECTS_ARCHIVES_ROOT .$_GET[ 'archive' ]);

  header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?archive-project=success" );
  die();
}




  // Listen for the delete POST
  if( isset( $_POST[ 'delete-project' ] ) )
  {

    if ( ! defined( 'PROJECTS_ROOT' ) ) {
      header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?project=" . $_GET[ 'project' ] . "&".  "delete=error" );
      die();
     return; // Exit if PROJECT_ROOT is not set for security measure
    }

    // return if not confirmed
    if( 1 != $_POST[ 'is-delete-confirmed' ] ){
      header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?project=" . $_GET[ 'project' ] . "&".  "delete=error" );
      die();
    }

    // return if root of projects
    if( PROJECTS_ROOT == PROJECTS_ROOT . $_POST[ 'project-root' ] || '' == $_POST[ 'project-root' ]){
      header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?delete=error" );
      die();
    }

    else {

      //reset confirmation
      unset( $_POST[ 'is-delete-confirmed' ] );

      echo $_POST[ 'project-root' ] . ' --> ' . delete_project( PROJECTS_ROOT . $_POST[ 'project-root' ] );

      header("Location: " . $_SERVER['HOST'] . $_SERVER['SCRIPT_NAME'] . "?delete=success" );
      die();

    }

  }
