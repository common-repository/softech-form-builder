<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function load_softech_form()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'softech_forms';

    $formID = sanitize_key( $_GET['formID'] );
	$query = $wpdb->get_results( 
	"
	SELECT *
	FROM $table_name
	WHERE id = $formID
	"
	);

	foreach ( $query as $result ) 
	{
		echo $result->form_structure;
	}
	die();
}
add_action('wp_ajax_load_softech_form', 'load_softech_form');

?>