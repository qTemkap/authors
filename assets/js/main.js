$( document ).ready(function() {
    $.ajax({
        method: "POST",
        url: "cookie.php",
    })
        .done(function( response ) {
            console.log(response);
        });
});