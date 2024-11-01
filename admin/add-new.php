<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function softech_wp_form_page_handler()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'softech_forms';
    $formID = sanitize_key( $_GET['form_id'] );
    $form_from = get_option( 'admin_email' );
    $query = $wpdb->get_results( 
                                "
                                SELECT *
                                FROM $table_name
                                WHERE id = $formID
                                "
                                );

    foreach ( $query as $result ) 
    {
        $form_name = $result->name;
        $form_subject = $result->form_mail_subject;
        $form_to = $result->form_mail_to;
        $form_from_cc = $result->form_mail_cc;
        $form_from = $result->form_mail_from;
    }
?>
<div class="wrap">
    <div class="col-sm-12 sfb_title">
        <h2><?php esc_html_e('Add New Form', 'softech-form-builder'); ?>
        <a class="add-new-h2" href="../wp-admin/admin.php?page=softech-form-builder-list"><?php esc_html_e('Back To List', 'softech-form-builder'); ?></a>
        </h2>
    </div>
            <div class="clearfix"></div>
            <div class="form_builder">
                <form id="sfb" novalidate>
                <div class="row">
                    <div class="col-md-9">
                        <div class="alert hide col-md-12">
                            <h2><?php esc_html_e('Success! Your Form saved.', 'softech-form-builder'); ?></h2>
                        </div>
                        <div class="col-md-12 softech-form-name">
                            <input name="form_name" id="form_name" class="form-control sfb-form-name" placeholder="<?php esc_html_e('Please Enter Your Form Name', 'softech-form-builder'); ?>" value="<?php echo $form_name; ?>" required />
                        </div>
                        <div class="col-md-3">
                            <div class="col-md-12 field-panel">
                                <p><?php esc_html_e('select input type below and drag it on right side. Then set more options', 'softech-form-builder'); ?></p>
                                <nav class="nav-sidebar">
                                    <ul id="add-field">
                                        <a id="add-text" data-type="text" href="#">
                                            <li><?php esc_html_e('Text', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-email" data-type="email" href="#">
                                            <li><?php esc_html_e('Email', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-tel" data-type="tel" href="#">
                                            <li><?php esc_html_e('Tel', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-date" data-type="date" href="#">
                                            <li><?php esc_html_e('Date', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-time" data-type="time" href="#">
                                            <li><?php esc_html_e('Time', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-password" data-type="password" href="#">
                                            <li><?php esc_html_e('Password', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-textarea" data-type="textarea" href="#">
                                            <li><?php esc_html_e('Text Area', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-select" data-type="select" href="#">
                                            <li><?php esc_html_e('Select Box', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-radio" data-type="radio" href="#">
                                            <li><?php esc_html_e('Radio Buttons', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-checkbox" data-type="checkbox" href="#">
                                            <li><?php esc_html_e('Checkbox', 'softech-form-builder'); ?></li>
                                        </a>
                                        <a id="add-agree" data-type="agree" href="#">
                                            <li><?php esc_html_e('Agree Box', 'softech-form-builder'); ?></li>
                                        </a>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-md-9 bal_builder field-panel">
                            <h5><?php esc_html_e('Form Builder Area', 'softech-form-builder'); ?></h5>
                            <div id="form-fields" class="col-md-12">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="col-md-12 sfb-left-mail-panel sfb-left-panel">
                            <div class="form_builder_inside">
                                <h3 class="fancy_title"><?php esc_html_e('Email Settings:-', 'softech-form-builder'); ?></h3>
                                
                                <label><?php echo esc_html( __( "Subject:", 'softech-form-builder' ) ); ?></label>
                                <input type="text" name="form_mail_subject" id="form_mail_subject" class="form-control sfb-form-mail-subject" placeholder="<?php esc_html_e('Email Subject', 'softech-form-builder'); ?>" value="<?php echo $form_subject; ?>" required>
                                
                                <label><?php echo esc_html( __( "To:", 'softech-form-builder' ) ); ?></label>
                                <input type="email" name="form_mail_to" id="form_mail_to" class="form-control sfb-form-mail-to" placeholder="<?php esc_html_e('Email To', 'softech-form-builder'); ?>" value="<?php echo $form_to; ?>" required>
                                
                                <label><?php echo esc_html( __( "Cc", 'softech-form-builder' ) ); ?></label>
                                <input name="form_mail_cc" class="form-control sfb-form-mail-cc" placeholder="<?php esc_html_e('Email To Cc', 'softech-form-builder'); ?>" value="<?php echo $form_from_cc; ?>">
                                
                                <label><?php echo esc_html( __( "From:", 'softech-form-builder' ) ); ?></label>
                                <input name="form_mail_from" class="form-control sfb-form-mail-from" placeholder="<?php esc_html_e('Email From', 'softech-form-builder'); ?>" value="<?php echo $form_from; ?>">
                                <label class="domain-id"><?php echo esc_html( __( "( Please Enter Domain Email Id )", 'softech-form-builder' ) ); ?></label>
                            </div>
                        </div>

                        <div class="col-md-12 sfb-left-panel">
                            <!--<h3><?php echo esc_html( __( "Status", 'softech-form-builder' ) ); ?></h3>-->
                            <div class="form_builder_inside">
                                <img src="../wp-content/plugins/softech-form-builder/images/save.gif" id="sfb-loader" class="sfb-loader" style="display: none; width: 50px;">
                                <button type="submit" id="sfbsave_form" class="submit button button-primary button-block button-xl"><?php esc_html_e('Save Form', 'softech-form-builder'); ?></button>
                            </div>
                        </div>

                        <div class="col-md-12 sfb-left-help">
                            <h3><?php echo esc_html( __( "Do you need help?", 'softech-form-builder' ) ); ?></h3>
                            <div class="form_builder_inside">
                                <p><?php echo esc_html( __( "Here are some available options to help solve your problems.", 'softech-form-builder' ) ); ?></p>
                                <ol>
                                    <li>
                                        <a href="../wp-admin/admin.php?page=softech-form-help"><?php echo esc_html( __( "FAQ", 'softech-form-builder' ) ); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url('https://wordpress.org/support/plugin/softech-form-builder', 'softech-form-builder'); ?>"><?php echo esc_html( __( "Support Forums", 'softech-form-builder' ) ); ?></a>
                                    <li>
                                        <a href="<?php echo esc_url('https://www.softechure.com/contactus.php', 'softech-form-builder'); ?>"><?php echo esc_html( __( "Professional Services", 'softech-form-builder' ) ); ?></a>
                                    </li>
                                    </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 marg-top">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <button type="submit" id="sfbsave_form" class="submit button button-primary button-block button-xl"><?php esc_html_e('Save Form', 'softech-form-builder'); ?></button>
                        </div>
                    </div>
                </div>
         </form>
            </div>
        </div>
<?php
}
?>