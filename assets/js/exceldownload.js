
$(document).on('click', '.exceldownload', function() {
    $.ajax({
        url: bases_url + "Projects/exceldownload",
        method: "POST",
        success: function(response) {
           alert(response);
         window.location.replace(response);
        }
    });
});
