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
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        },
        success: functionsOnSuccess
    }

    if (typeof functionsOnSuccess === 'undefined') {
        ajaxParams.success = [];
    }

    
    if (isFormData) {
        ajaxParams.processData = false,
        ajaxParams.contentType = false,
        ajaxParams.data = new FormData;
    }

    $.ajax(ajaxParams);
}

function searchKeyword($button){
  let keyword = $('#search-input').val()
  let url = $($button).data('url')
  ajax(url, 'GET', function(response){
      $('#table').html(response)
  }, {
      keyword: keyword
  })
}
  