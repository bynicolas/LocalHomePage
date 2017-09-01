<?php
function get_nav_markup(){
    ?>
<nav>
    <ul>
<?php
    $devtools = get_devtools();
    foreach ( $devtools as $tool ) {
        $target = isset( $tool[ 'same_window' ] ) &&  $tool[ 'same_window' ] == true ? '' : ' target="_blank"';
        printf( '<li><a href="%1$s"%2$s>%3$s</a></li>', $tool['url'], $target, $tool['name'] );
    }
?>
    </ul>
</nav>
    <?php
}
