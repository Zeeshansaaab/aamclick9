
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
  
$("body").on("click", "[data-act=ajax-page]", function () {
  const _self = $(this);
  const contentId = _self.data('content')
  const swalContent = _self.data('swal-content')
  const content = $(contentId);
  Swal.fire({
    title: "",
    text: "Please wait...",
    showConfirmButton: false,
    backdrop: true,
  });
  // const spinner = $("#ajax_model_spinner");

  // content.hide();
  // spinner.show();

  // var attr = _self.attr("data-modal-size");

  // if (typeof attr !== "undefined" && attr !== false) {
  //     $("#ajax_model").addClass("bd-example-modal-xl");
  //     $(".modal-dialog").addClass("modal-xl");
  // }

  // $("#ajax_model").modal({ backdrop: "static" });
  // $("#ajax_model_title").html(_self.attr("data-title"));
  var metaData = {};
  $(this).each(function () {
      $.each(this.attributes, function () {
          if (this.specified && this.name.match("^data-post-")) {
              var dataName = this.name.replace("data-post-", "");
              metaData[dataName] = this.value;
          }
      });
  });
  axios({
      method: _self.attr("data-method"),
      url: _self.attr("data-action-url"),
      data: metaData,
  }).then((response) => {
      Swal.close();
      if(content)
        var conetentData =  _.isString(response.data) ? response.data : response.data.data;
        content.html(conetentData);
      if(swalContent){
        Swal.fire(response.data.message)
      }else {
        NioApp.Toast('success', response.data.message);
      }
        
    }).catch((error) => {
      Swal.close();
      NioApp.Toast('error', error.response.data.message);
  });
});