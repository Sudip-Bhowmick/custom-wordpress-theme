jQuery(document).ready(function($) {
    $('#searchform').submit(function() {
        var formData = $(this).serialize();
        $.ajax({
            type: 'GET',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: formData + '&action=custom_search',
            success: function(response) {
                // Handle the response (e.g., update search results container)
            }
        });
        return false;
    });
});
