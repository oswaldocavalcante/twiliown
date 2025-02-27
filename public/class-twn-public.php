<?php

class TWN_Public 
{
    public function hide_email_field()
    {
        if (current_user_can('manage_options'))
        {
            ?>
            <script>
                jQuery(document).ready(function($) {
                    $('input[name="cwgstock_email"]')
                        .val('dontsend@email.com')
                        .prop('readonly', true)
                        .hide();
                });
            </script>
            <?php
        }
    }
}