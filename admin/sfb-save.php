<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
function save_softech_form()
{

//if( current_user_can('editor') || current_user_can('administrator') ) 
//{  
    check_ajax_referer( 'check_softech_form', 'security' );

    global $wpdb;
    $table_name = $wpdb->prefix . 'softech_forms';

    //get the submitted data and decode it
    $formID = sanitize_key( $_POST['formId'] );
    $formName = sanitize_text_field( $_POST['formName'] );
    $formSubject = sanitize_text_field( $_POST['formSubject'] );
    $formTo = sanitize_email( $_POST['formTo'] );
    $formCc = sanitize_email( $_POST['formCc'] );
    $formFrom = sanitize_email( $_POST['formFrom'] );


    $formFields1 = sanitize_text_field( $_POST['formFields'] );
    $formFields = str_replace('\"','"',$formFields1);

    $data = array(
        'name' => $formName,
        'shortcode' => '',
        'form_structure' => $formFields,
        'form_mail_subject' => $formSubject,
        'form_mail_to' => $formTo,
        'form_mail_cc' => $formCc,
        'form_mail_from' => $formFrom
        );

    $data_update = array(
        'name' => $formName,
        'shortcode' => '[softech-form-builder id="'.$formID.'" name="'.$formName.'"]',
        'form_structure' => $formFields,
        'form_mail_subject' => $formSubject,
        'form_mail_to' => $formTo,
        'form_mail_cc' => $formCc,
        'form_mail_From' => $formFrom
        );
    if($formID == "false")
    {
	   $wpdb->insert($table_name, $data);
	   $last_id = $wpdb->insert_id;

	   $updateshortcode=array( 
                        'shortcode' => '[softech-form-builder id="'.$last_id.'" name="'.$formName.'"]'
                    );
	   $wpdb->update( $table_name, $updateshortcode, array('id' => $last_id));
    }
    else
    {
	   $wpdb->update($table_name, $data_update, array('id' => $formID));             
    }

    echo json_encode('your form would have saved successfully!');
//}
die();
}
add_action('wp_ajax_save_softech_form', 'save_softech_form');
?>
