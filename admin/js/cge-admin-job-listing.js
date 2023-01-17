(function( $ ) {
	$(document).on('click',"button#btn_add_responsable", function () {
        $('#from_ecole_resp_formation').append($('#add_ecole_resp_formation').html());
        $('#from_ecole_resp_formation').find('input').prop('required', true);
    });
    
    $(document).on('click', ".remove_ecole_resp_formation", function () {
        $(this).closest('tr').remove();
    });

    $(document).on('click',"button#btn_add_ecole_associations", function () {
        $('#from_ecole_associations').append($('#add_ecole_associations').html());
        $('#from_ecole_associations').find('input').prop('required', true);
    });
    
    $(document).on('click', ".remove_ecole_associations", function () {
        $(this).closest('tr').remove();
    });

    
    $(document).on('click',"button#btn_add_ecole_accords_internationaux_", function () {
        $('#from_ecole_accords_internationaux_').append($('#add_ecole_accords_internationaux_').html());
        $('#from_ecole_accords_internationaux_').find('input').prop('required', true);
    });
    
    $(document).on('click', ".remove_ecole_accords_internationaux_", function () {
        $(this).closest('tr').remove();
    });
})( jQuery );