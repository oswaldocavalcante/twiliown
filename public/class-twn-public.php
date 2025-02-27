<?php

class TWN_Public 
{
    public function hide_email_field()
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