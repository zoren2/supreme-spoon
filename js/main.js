$(document).ready(function () {

    // Waits for click on Sidebar links and serves content
    $(document).on("click", ".subreddit", function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: {subreddit: $(this).attr('href') },
            datatype: "html",
            contentType: "text/plain",
            success: function (ajaxHtml) {
                $('.sections').html(ajaxHtml);
            },
            error: function (error) {
                console.log("Cannot retrieve data from the API and/or database!");
            }
        }); // End ajax call
    }); // End on click
}); // End document ready
