'use strict';

// Class definition
var KTCropperDemo = function() {

  // Private functions
  var initCropperDemo = function() {
    var image = document.getElementById('image');

    var options = {
      crop: function(event) {
        // var lg = document.getElementById('cropper-preview-lg');
        // lg.innerHTML = '';
        // lg.appendChild(cropper.getCroppedCanvas({width: 256, height: 160}));
      },
    };

    var cropper = new Cropper(image, options);

    var buttons = document.getElementById('cropper-buttons');
    var methods = buttons.querySelectorAll('[data-method]');
    methods.forEach(function(button) {
      button.addEventListener('click', function(e) {
        var method = button.getAttribute('data-method');
        var option = button.getAttribute('data-option');
        var option2 = button.getAttribute('data-second-option');

        try {
          option = JSON.parse(option);
        }
        catch (e) {
        }

        var result;
        if (!option2) {
          result = cropper[method](option, option2);
        }
        else if (option) {
          result = cropper[method](option);
        }
        else {
          result = cropper[method]();
        }

        if (method === 'getCroppedCanvas') {
            // var modal = document.getElementById('getCroppedCanvasModal');
            // var modalBody = modal.querySelector('.modal-body');
            // modalBody.innerHTML = '';
            // var canvas = document.getElementById('canvas');
            var canvas = result;
            var base64URL = canvas.toDataURL();
            $.ajax({
				url: '/convert_img',
				type: 'post',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				tranditional: true,
				data : {
					image : base64URL,
				},
				success : function (res) {
                    $("#dis_overimg")[0].src = '/upload/'+res;
                    $("#crp_modal").click();
                }
            })
            // modalBody.appendChild(result);
        }

        var input = document.querySelector('#putData');
        try {
          input.value = JSON.stringify(result);
        }
        catch (e) {
          if (!result) {
            input.value = result;
          }
        }
      });
    });

    // set aspect ratio option buttons
    var radioOptions = document.getElementById('setAspectRatio').querySelectorAll('[name="aspectRatio"]');
    radioOptions.forEach(function(button) {
      button.addEventListener('click', function(e) {
        cropper.setAspectRatio(e.target.value);
      });
    });

    // set view mode
    var viewModeOptions = document.getElementById('viewMode').querySelectorAll('[name="viewMode"]');
    viewModeOptions.forEach(function(button) {
      button.addEventListener('click', function(e) {
        cropper.destroy();
        cropper = new Cropper(image, Object.assign({}, options, {viewMode: e.target.value}));
      });
    });

    var toggleoptions = document.getElementById('toggleOptionButtons').querySelectorAll('[type="checkbox"]');
    toggleoptions.forEach(function(checkbox) {
      checkbox.addEventListener('click', function(e) {
        var appendOption = {};
        appendOption[e.target.getAttribute('name')] = e.target.checked;
        options = Object.assign({}, options, appendOption);
        cropper.destroy();
        cropper = new Cropper(image, options);
      })
    })

  };

  return {
    // public functions
    init: function() {
      initCropperDemo();
    },
  };
}();

jQuery(document).ready(function() {
  KTCropperDemo.init();
});
