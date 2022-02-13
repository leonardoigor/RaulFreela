$(document).ready(function () {
  var pass = "bzdtcXJpejk=";
  var pass = "0";

  $("#file" && "#password").change(function () {
    const passValueCrypto = $("#password").val()
    if (
      $("#file")[0].files.length > 0 &&
      passValueCrypto == pass
    ) {
      $("#uploadButton").prop("disabled", false);
    }
  });

  $("#uploadButton").click(function (event) {
    event.preventDefault();

    var formData = new FormData();

    var file = $("#file")[0];
    for (var i = 0; i < file.files.length; i++) {
      formData.append('file[]', file.files[i]);
    }

    var xhr = new XMLHttpRequest();
    xhr.upload.onloadstart = function () {
    }
    xhr.upload.onprogress = function (e) {
      var b = (e.loaded / e.total) * 100
      var c = b
      b = b <= 10 ? 0 : b - 10
      var pross = $('.determinate')
      pross.css('width', b + '%')
    }
    xhr.onreadystatechange = function () {
      var pross = $('.determinate')
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          var response = JSON.parse(xhr.responseText);
          pross.css('width', 100 + '%')
          M.toast({ html: `Sucesso! ` })
          M.toast({ html: response.message })

        }
        else {
          var response = JSON.parse(xhr.responseText);
          if (response.errors) {
            var errors = response.errors
            for (var i = 0; i < errors.length; i++) {
              M.toast({ html: errors[i] })

            }
          }
        }
        $("#fileForm")[0].reset();
        $("#uploadButton").prop("disabled", true);
      }
    }
    xhr.open('POST', 'http://127.0.0.1:8003/upload');
    xhr.send(formData);

  });
});
