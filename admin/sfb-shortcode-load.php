<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function front_softech_form()
{
global $wpdb;
$table_name = $wpdb->prefix . 'softech_forms';
$show_formID = sanitize_key( $_GET['show_form_id'] );
$show_query = $wpdb->get_results( 
	"
	SELECT *
	FROM $table_name
	WHERE id = $show_formID
	"
);

foreach ( $show_query as $show_result ) 
{
	echo $show_result->form_structure;
}

	die();
}
add_action('wp_ajax_front_softech_form', 'front_softech_form');
?>