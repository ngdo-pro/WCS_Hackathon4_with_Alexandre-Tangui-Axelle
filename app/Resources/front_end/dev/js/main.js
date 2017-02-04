$("#searchField1").keyup(function(){
    var keyword = $(this).val();
    if ( keyword.length >= 3 ) {
        $.ajax({
            type: "POST",
            url: "/autocomplete",
            dataType: 'json',
            timeout: 3000,
            success: function(response){
                var result = JSON.parse(response.data);
                console.log(result)},
            error: function() {
                $('#wordautocomp').text('Ajax call error');
            }
        });
    }
});

var app = new Vue({
    delimiters: ['${', '}'],
    el: '#searchBar',
    data: {
        message: 'Hello Vue!'
    }
});