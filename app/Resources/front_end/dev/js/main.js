$(document).ready(function(){
    $("#searchField1").keyup(function(){
        var keyword = $(this).val();
        if ( keyword.length >= 3 ) {
            $.ajax({
                type: "POST",
                url: "/autocomplete",
                data: {keyword: keyword},
                dataType: 'json',
                timeout: 3000,
                success: function(response){
                        console.log(response);
                },
                error: function() {
                    $('#wordautocomp').text('Ajax call error');
                }
            });
        }
    });
});



var app = new Vue({
    delimiters: ['${', '}'],
    el: '#searchBar',
    data: {
        message: 'Hello Vue!'
    }
});