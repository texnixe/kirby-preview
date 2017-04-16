(function($) {
  $.fn.preview = function() {
    return this.each(function() {
      var fieldname = 'preview';
      console.log(fieldname);
      var field = $(this);
      var select = $('.selectbox-preview');
      console.log(field);


      select.on('change', function() {
        var container = $('.preview').remove();
          val = $(this).val();
          console.log(val);
          if(val == '') {
            return;
          } else {
            $.fn.ajaxPreview(fieldname, val);
          }
      });

    });

  };

  // Ajax function
  $.fn.ajaxPreview = function(fieldname, val) {
    console.log(val);
    var blueprintFieldname = $('.selectbox-preview').attr('name');
    var baseURL = window.location.href.replace(/(\/edit.*)/g, '/field') + '/' + blueprintFieldname + '/' + fieldname;
    var data = {page: val};
    $.ajax({
      url: baseURL + '/previewer',
      type: 'POST',
      data: data,
      dataType: "json",
      success: function(response) {
        var container = $('.field-name-' + blueprintFieldname);
        container.append('<div class="preview"> <iframe id="preview-frame" width="100%" height="500px" frameborder="0"></iframe></div>');
        $('.preview iframe')[0].contentDocument.write(response.html);

      }
    });
  };

})(jQuery);
