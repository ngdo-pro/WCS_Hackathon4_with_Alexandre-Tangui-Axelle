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
                    var data = [];
                    for(var i=0; i < response.length; i++){
                        data.push(response[i]['tag']);
                        $('ul').append('<li>'+ response[i]['tag'] + '</li>')
                        console.log(response[i]['tag']);
                    }
                    $('input.autocomplete').autocomplete({
                        data: data
                    });

                },
                error: function() {
                    $('#wordautocomp').text('Ajax call error');
                }
            });
        }
    });


});