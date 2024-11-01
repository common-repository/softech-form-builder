<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/* ======= Register The Plugin Shortcode =========== */

function softech_form_builder_shortcode($atts) 
{
    $atts = shortcode_atts(array(
        'id' => '',
        'name' => null,
    ), $atts);


    global $wpdb;
    $table_name = $wpdb->prefix . 'softech_forms';
    $formID = $atts['id'];
    $query = $wpdb->get_results( 
                                "
                                SELECT *
                                FROM $table_name
                                WHERE id = $formID
                                "
                                );

    foreach ( $query as $result ) 
    {
        $form_subject = $result->form_mail_subject;
        $form_to = $result->form_mail_to;
        $formCc = $result->form_mail_cc;
        $form_from = $result->form_mail_from;
    }
//add_action( 'wp_footer', 'softech_load_html')
//function softech_load_html() { ?>

<script type="text/javascript">
//On document ready
jQuery(function()
{
    //load saved form by ID
    var show_formID = <?php echo $atts['id']; ?>;
    generateForm(show_formID);
});
</script>

<?php //} ?>
<div id="sfb-wrap-<?php echo $atts['id']; ?>">
    <div class="alert hide col-md-12">
        <h2><?php esc_html_e('Your Message Has Been Send!.', 'softech-form-builder'); ?></h2>
        <p></p>
    </div>
    <form id="sfb-sample-<?php echo $atts['id']; ?>" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <div id="sfb-fields">
           
        </div>
        <input type="submit" name="mail_to_post_<?php echo $atts['id']; ?>" class="submit btn btn-primary btn-block" value="Send">
    </form>
</div>

<?php
if(isset($_POST['mail_to_post_'.$atts['id']]))
{
        $postdata = file_get_contents("php://input");
        $postdata = substr($postdata, 0,strrpos($postdata, '&' ));
        $convert = explode("&", $postdata);
        $string = str_replace("+"," ",$convert);
        //$string = str_replace("%","@",$string);
        $string = str_replace("_"," ",$string);
        $string = str_replace('%40', '@', $string);
        $string = str_replace('%3A', ':', $string);//change the word from certain word
        //$string = preg_replace('/[0-9]+/', '', $string);
        $msg='';
        for ($i=0;$i<count($string);$i++)  
        {
            $user = strstr($string[$i], '=', true); //get the before word from certain word
            $user = preg_replace('/[0-9]+/', '', $user);
            $msg .= $user." = ".ltrim(strstr($string[$i], '='), '=')."<br>"; //get the after word from certain word
        }
        // If email has been process for sending, display a success message

        $to = $form_to;
        $subject = $form_subject;

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= "From: " . $form_from . "\r\n";
        //Multiple CC can be added, if we need (comma separated);
        $headers .= 'Cc:'. $formCc . "\r\n";
        //Multiple BCC, same as CC above;
        //$headers .= 'Bcc: myboss3@example.com, myboss4@example.com' . "\r\n";

        $message = $msg;

        if ( wp_mail($to, $subject, $message, $headers) ) 
        {
            echo esc_html_e('Thanks for contact us expect a response soon.', 'softech-form-builder');
        } 
        else 
        {
            echo esc_html_e('An unexpected error occurred', 'softech-form-builder');
        }
}
    return ob_get_clean();
    
}
add_shortcode( 'softech-form-builder', 'softech_form_builder_shortcode' );
?>
