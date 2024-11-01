<?php
function softech_form_help()
{

/* ======= Register the Softech Wp Clock setting fields =========== */

?>
<div class="wrap">
    <div class="col-sm-12 sfb_title">
        <h1><?php esc_html_e('Softech Form Builder', 'softech-form-builder'); ?></h1>
    </div>


    <div class="col-sm-9">
        <div class="panel-group" id="accordion">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><?php esc_html_e('Introduction', 'softech-form-builder'); ?></a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <ul>
                            <li><?php esc_html_e('Softech Form Builder allow you to create contact forms, Reservation forms and other type of forms for your sites in minutes. Softech Form Builder can manage multiple forms, plus you can customize the form and the mail contents. The form supports Ajax-powered submitting and so on.', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Softech Form Builder make 100% mobile responsive contact form, so your contact forms will always look great on all devices (mobile, tablet, laptop, and desktop).', 'softech-form-builder'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?php esc_html_e('Creating a new Form', 'softech-form-builder'); ?></a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="softech-ul-num">
                            <li><?php esc_html_e('After the installation is finished, you can go ahead and start working on your forms.', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Navigate to Softech Form Builder > Softech Forms page to build your very first form.', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Press Add New Form button from this page, and you will be redirected to Form Editor page. Make sure to write a Title for this form', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('To add a new field to your form, Click on Field button which you want in your form. The field editor toolbox will be opened automatically. Then add a Label for input to your form. you can also make field Required by simply check the Required field.', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('After adding the fields you have to choose a "Subject" & "Email to" field from Email setting Panel on your right side', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('After adding your form fields, you can save your form you have made.', 'softech-form-builder'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><?php esc_html_e('Publishing the Created Form', 'softech-form-builder'); ?></a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="softech-ul-num">
                            <li><?php esc_html_e('After the saving your form, you can go ahead and publish your forms. ', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Navigate to Softech Form Builder > Softech Forms page to publish your very first form.', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Copy the shortcode of the form which you created.', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Now paste this shortcode on a page/post where you want to show', 'softech-form-builder'); ?></li>
                            <li><?php esc_html_e('Now save the page.', 'softech-form-builder'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="col-md-12 sfb-left-help">
            <h3><?php echo esc_html( __( "Do you need help?", 'softech-form-builder' ) ); ?></h3>
            <div class="form_builder_inside">
                <p><?php echo esc_html( __( "Here are some available options to help solve your problems.", 'softech-form-builder' ) ); ?></p>
                <ol>
                    <li><?php esc_html_e('', 'softech-form-builder'); ?>
                        <a href="../wp-admin/admin.php?page=softech-form-help"><?php echo esc_html( __( "FAQ", 'softech-form-builder' ) ); ?></a>
                    </li>
                    <li><?php esc_html_e('', 'softech-form-builder'); ?>
                        <a href="<?php echo esc_url('https://wordpress.org/support/plugin/softech-form-builder', 'softech-form-builder'); ?>"><?php echo esc_html( __( "Support Forums", 'softech-form-builder' ) ); ?></a>
                        <li><?php esc_html_e('', 'softech-form-builder'); ?>
                            <a href="<?php echo esc_url('https://www.softechure.com/contactus.php', 'softech-form-builder'); ?>"><?php echo esc_html( __( "Professional Services", 'softech-form-builder' ) ); ?></a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

</div>
<?php
}
?>