// const { ajax } = require("jquery");
var spinner = '<span style="width: 17px; margin-left:10px;" id="spinner" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>';
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


    $('body').on('submit', '[data-form=ajax-form]', async function(e) {
        e.preventDefault();
        const form = $(this);
        const confirm = $(form).data('confirm'); // data-confimr="yes"
        const backendModal = form.data('backend-modal');
        const redirectURL = form.data('redirect-url');
        const closeModal = form.data('close');
        const submitBtn = form.find('[type=submit]');
        submitBtn.append(spinner);
        submitBtn.attr("disabled", "disabled").button('refresh');
        await ajax(form.attr('action'), form.attr('method'), function(response){
            if(backendModal){
                $('body').append(response);
                const modal = $(`#${backendModal}`);
                modal.modal('show');
                modal.on('hidden.bs.modal', function(){
                    modal.remove()
                })
            }
            if(response.message) NioApp.Toast(response.message, 'success');
            if(closeModal){
                $(`#${closeModal}`).modal('hide');
            }
            form[0].reset()
            $('.custom-file-label').html('');
            $('#spinner').remove()
            submitBtn.removeAttr("disabled").button('refresh');
            if(redirectURL) window.location.href = redirectURL;
        }, form[0], true)
    });

    $('body').on('click', '[data-act=modal-form]', async function(e) {
        const _self = $(this);
        const backendModal = _self.data('backend-modal');
        const action = _self.data('action');
        const method = _self.data('method');
        const tr = _self.data('tr');;
        const btnHtml = _self.html();
        _self.html(spinner);
        await ajax(action, method, function(response){
            if(backendModal){
                $('body').append(response);
                const modal = $(`#${backendModal}`);
                modal.modal('show');
                NioApp.Select2.init()
                modal.on('hidden.bs.modal', function(){
                    modal.remove()
                })
            }
            if(method == "DELETE"){
                $(tr).remove();
            }
            if(response.message) NioApp.Toast(response.message, 'success');
            $('.custom-file-label').html('');
            _self.html(btnHtml);
        })
    });
    
})
