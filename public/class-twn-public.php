<?php

class TWN_Public
{
    public function hide_email_field()
    {
        if (current_user_can('edit_posts'))
        {
            ?>
            <script>
                jQuery(document).ready(function($) 
                {
                    jQuery(document).off('click', '.cwgstock_button', instock_notifier.submit_form);
                    instock_notifier.submit_form = {};
                    
                    $('.cwgstock_name').val('');
                    $('.cwgstock_email').val('');

                    var twn_submit_form = function(e)
                    {
                        e.preventDefault();
                        var submit_button_obj = jQuery(this);
                        var subscriber_name = jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_name').val();
                        var email_id = jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_email').val();
                        var quantity = jQuery(this).closest('.cwginstock-subscribe-form').find('.add_quantity_field').val();
                        var product_id = jQuery(this).closest('.cwginstock-subscribe-form').find('.cwg-product-id').val();
                        var var_id = jQuery(this).closest('.cwginstock-subscribe-form').find('.cwg-variation-id').val();
                        var security = jQuery(this).closest('.cwginstock-subscribe-form').find('.cwg-security').val();
                        
                        if (quantity === '' || quantity <= 0) 
                        {
                            if (is_quantity_field_optional == '2') 
                            {
                                jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').fadeIn();
                                jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').html("<div class='cwginstockerror' style='color:red;'>" + emptyquantity + "</div>");
                                return false;
                            }
                        }
                        // Customised for Phone Field
                        if (phone_field == '1')
                        {
                            var subscriber_phone = iti.getNumber(); // jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_phone').val();
                            phone_meta_data = iti.getSelectedCountryData();
                            if (!iti.isValidNumber()) 
                            {
                                var errorCode = iti.getValidationError();
                                console.log(errorCode);
                                var errorMsg = phone_error[errorCode];
                                if (errorCode == -99) {
                                    errorMsg = phone_error[0];
                                }
                                if ((errorCode != -99 && is_phone_field_optional == '1') || is_phone_field_optional == '2') {
                                    jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').fadeIn();
                                    jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').html("<div class='cwginstockerror' style='color:red;'>" + errorMsg + "</div>");
                                    return false;
                                }
                            }
                        }

                        if (!subscriber_name || subscriber_name == '') 
                        {
                            subscriber_name = '---';
                        }

                        if (email_id == '')
                        {
                            var email_id = subscriber_phone + '@' + window.location.host;
                        }
                        else
                        {
                            if (!instock_notifier.is_email(email_id)) // check is valid email
                            {
                                jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').fadeIn();
                                jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').html("<div class='cwginstockerror' style='color:red;'>" + invalidemail + "</div>");
                                return false;
                            }
                        } 

                        if (is_iagree == '1') 
                        {
                            if (!jQuery(this).closest('.cwginstock-subscribe-form').find('.cwg_iagree_checkbox_input').is(':checked'))
                            {
                                jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').fadeIn();
                                jQuery(this).closest('.cwginstock-subscribe-form').find('.cwgstock_output').html("<div class='cwginstockerror' style='color:red;'>" + iagree_error + "</div>");
                                return false;
                            }
                        }

                        var data = 
                        {
                            action: 'cwginstock_product_subscribe',
                            product_id: product_id,
                            variation_id: var_id,
                            subscriber_name: subscriber_name,
                            subscriber_phone: subscriber_phone,
                            subscriber_phone_meta: phone_meta_data,
                            user_email: email_id,
                            user_id: cwginstock.user_id,
                            security: security,
                            dataobj: cwginstock,
                            custom_quantity: quantity
                        };

                        if (jQuery.fn.block)
                        {
                            submit_button_obj.closest('.cwginstock-subscribe-form').block
                            ({
                                message: null
                            });
                        } 
                        else 
                        {
                            var overlay = jQuery('<div id="cwg-bis-overlay"> </div>');
                            overlay.appendTo(submit_button_obj.closest('.cwginstock-subscribe-form'));
                        }
                        
                        instock_notifier.perform_ajax(data, submit_button_obj);
                        
                    };

                    jQuery(document).on('click', '.cwgstock_button', twn_submit_form);
                    instock_notifier.init();
                });
            </script>
            <?php
        }
    }
}
