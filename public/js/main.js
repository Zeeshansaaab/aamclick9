// const { ajax } = require("jquery");

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


    $('body').on('submit', '[data-form=ajax-form]', function(e) {
        e.preventDefault();
        const form = $(this);
        const confirm = $(form).data('confirm'); // data-confimr="yes"
        const backendModal = form.data('backend-modal');
        const closeModal = form.data('close');
        ajax(form.attr('action'), form.attr('method'), function(response){
            if(backendModal){
                $('body').append(response);
                const modal = $(`#${backendModal}`);
                modal.modal('show');
                modal.on('hidden.bs.modal', function(){
                    modal.remove()
                })
            }
            NioApp.Toast(response.message, 'success');
            if(closeModal){
                $(`#${closeModal}`).modal('hide');
            }
        }, form[0], true)
        
        return;
        
        if (confirm=='yes') {
            window.swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to submit this form?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, do it!"
            }).then((result) => {
                if (result.value) 
                    console.log("a")
            });
        } else {
            sendAjaxForm(form);
        }
    });
    
})
