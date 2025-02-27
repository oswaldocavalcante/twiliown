jQuery(document).ready(function ($)
{
    $(document).on('cwg_instock_after_email_field', function () {
        $('.cwgstock_email')
            .val('naoresponda@ryanne.com.br')
            .prop('readonly', true)
            .closest('.form-group')
    });
});