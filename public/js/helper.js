var loading = false;
function ajaxForm(formItems) {
    var form = new FormData();
    formItems.forEach(formItem => {
      form.append(formItem[0], formItem[1]);
    });
    return form;
}

/**
 * 
 * @param {*} url route
 * @param {*} method POST or GET 
 * @param {*} functionsOnSuccess Array of functions that should be called after ajax
 * @param {*} form for POST request
 */
function ajax(url, method, functionsOnSuccess, form = {}, isFormData=false) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
  
    let ajaxParams = {
        url: url,
        type: method,
        async: true,
        data: form,
        error: function(xhr, textStatus, error) {
          try{
            error = JSON.parse(xhr.responseText)
            const messages = error.message.split('.');
          } catch(e){
            console.log(e)
          }
          NioApp.Toast(messages[0], 'error');
        },
        success: functionsOnSuccess
    }

    if (typeof functionsOnSuccess === 'undefined') {
        ajaxParams.success = [];
    }

    
    if (isFormData) {
        ajaxParams.processData = false,
        ajaxParams.contentType = false,
        ajaxParams.data = new FormData(form);
    }
    $.ajax(ajaxParams);
}

function searchKeyword(button){
  let keyword = $('#search-input').val()
  let url = $(button).data('url')
  $(button).html('<div class="spinner-border text-gray" style="width: 20px; height: 20px" role="status">'
    +'<span class="sr-only">Loading...</span>'
    +'</div>'
  )

  loading = !loading;
  if(loading){
    ajax(url, 'GET', function(response){
      loading = false;
      $(button).html('<em class="icon ni ni-search"></em>')
        $('#table').html(response)
    }, {
        keyword: keyword
    })
  }
 
}
  