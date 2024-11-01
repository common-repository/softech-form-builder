
//generates the form HTML
function generateForm(show_formID) 
{

    //empty out the preview area
    jQuery("#sfb-fields").empty();
    
    jQuery.ajax({

            type: "GET",
            dataType: 'json',
            url: ajax_form_front_object.ajaxurl,
            data: { 

                'action' : 'front_softech_form', //calls wp_ajax_nopriv_ajaxlogin
                'show_form_id' : show_formID
            },
            success: function (data)
            {
            if (data) 
            {
            //go through each saved field object and render the form HTML
            jQuery.each( data, function( ko, viv ) 
            {

                var fieldType = viv['type'];
                var fieldName = viv['name'];

                //Add the field
                jQuery('#sfb-wrap-'+show_formID+' #sfb-fields').append(addFieldHTML(fieldType,fieldName));
                var $currentField = jQuery('#sfb-fields .sfb-field').last();

                //Add the label
                $currentField.find('label').text(viv['label']);

                //Any choices?
                if (viv['choices']) 
                {

                    var uniqueID = Math.floor(Math.random()*999999)+1;

                    jQuery.each( viv['choices'], function( ko, viv ) 
                    {

                        if (fieldType == 'select') 
                        {
                            var selected = viv['sel'] ? ' selected' : '';
                            var choiceHTML = '<option' + selected + ' value="' + viv['label'] + '">' + viv['label'] + '</option>';
                            $currentField.find(".choices").append(choiceHTML);
                        }

                        else if (fieldType == 'radio') 
                        {
                            var selected = viv['sel'] ? ' checked' : '';
                            var choiceHTML = '<label><input type="radio" name="' + fieldName + '"' + selected + ' value="' + viv['label'] + '">' + viv['label'] + '</label>';
                            $currentField.find(".choices").append(choiceHTML);
                        }

                        else if (fieldType == 'checkbox') 
                        {
                            var selected = viv['sel'] ? ' checked' : '';
                            var choiceHTML = '<label><input type="checkbox" name="' + fieldName + '"' + selected + ' value="' + viv['label'] + '">' + viv['label'] + '</label>';
                            $currentField.find(".choices").append(choiceHTML);
                        }

                    });
                }

                //Is it required?
                if (viv['req']) 
                {
                    if (fieldType == 'text') { $currentField.find("input").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'email') { $currentField.find("email").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'tel') { $currentField.find("tel").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'date') { $currentField.find("date").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'time') { $currentField.find("time").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'password') { $currentField.find("password").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'textarea') { $currentField.find("textarea").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'select') { $currentField.find("select").prop('required',true).addClass('required-choice') }
                    else if (fieldType == 'radio') { $currentField.find("input").prop('required',true).addClass('required-choice') }
                    $currentField.addClass('required-field');
                }

            });
            }

        //HTML templates for rendering frontend form fields
        function addFieldHTML(fieldType,fieldName) 
        {

            switch (fieldType) 
            {

                case 'text':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-text">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<input type="text" id="' + fieldName + '" name="' + fieldName + '" class="form-control">' +
                        '</div>';

                case 'email':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-text">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<input type="email" id="' + fieldName + '" name="' + fieldName + '" class="form-control">' +
                        '</div>';

                case 'tel':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-text">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<input type="tel" id="' + fieldName + '" name="' + fieldName + '" class="form-control">' +
                        '</div>';

                case 'date':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-text">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<input type="date" id="' + fieldName + '" name="' + fieldName + '" class="form-control">' +
                        '</div>';

                case 'time':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-text">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<input type="time" id="' + fieldName + '" name="' + fieldName + '" class="form-control">' +
                        '</div>';

                case 'password':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-text">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<input type="password" id="' + fieldName + '" name="' + fieldName + '" class="form-control">' +
                        '</div>';

                case 'textarea':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-textarea">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<textarea id="' + fieldName + '" name="' + fieldName + '" class="form-control"></textarea>' +
                        '</div>';

                case 'select':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-select">' +
                        '<label for="' + fieldName + '"></label>' +
                        '<select id="' + fieldName + '" name="' + fieldName + '" class="choices choices-select" class="form-control"></select>' +
                        '</div>';

                case 'radio':
                    return '' +
                        '<div id="sfb_' + fieldName + '" class="sfb-field form-group sfb-radio">' +
                        '<label></label>' +
                        '<div class="choices choices-radio" class="form-control"></div>' +
                        '</div>';

                case 'checkbox':
                    return '' +
                        '<div id="sfb_checkbox_' + fieldName + '" class="sfb-field form-group sfb-checkbox">' +
                        '<label class="sfb-label"></label>' +
                        '<div class="choices choices-checkbox" class="form-control"></div>' +
                        '</div>';

                case 'agree':
                    return '' +
                        '<div id="sfb_agree_' + fieldName + '" class="sfb-field form-group sfb-agree required-field">' +
                        '<input type="checkbox" required class="form-control">' +
                        '<label></label>' +
                        '</div>'
            }
        }
    }
    });
}