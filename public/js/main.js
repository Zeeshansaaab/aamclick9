
NioApp.coms.docReady.push(function(){ 
    $(document).on('click', '.search-submit', function(){
        searchKeyword(this)
    })

    $(document).on('keyup', '#search-input', function(e){
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode  == 13) {
            searchKeyword('.search-submit');
        }
    })

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        ajax(url, 'GET', function(response){
            $('#table').html(response)
        })
    });
})
