$(document).ready(function(){
    $("#searchField1").keyup(function(){
        var keyword = $(this).val();
        if ( keyword.length >= 3 ) {
            console.log('ok');
            $.ajax({
                type: "POST",
                url: "/autocomplete",
                dataType: 'json',
                timeout: 3000,
                success: function(response){
                    //var result = JSON.parse(response.data);
                    //console.log(response)
                    for (var i=0; i<response.length; i++){
                        console.log(response[i]);
                    }
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