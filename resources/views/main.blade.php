<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Envio</title>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <!-- css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .inputBox {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .inputBox h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: gray;
            margin: 0 auto 30px;
        }

        .inputBox form {
            width: 80%;
            max-width: 600px;
        }

        .row .col {
            padding: 0;
        }

        .formSendBtn {
            color: white;
            background-color: green;
            margin: 20px auto 0;
            width: 100%;
            height: 3rem;
            line-height: 3rem;
            text-decoration: none;
            color: #fff;
            background-color: #26a69a;
            text-align: center;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 2px;
            display: inline-block;
            padding: 0 16px;
            text-transform: uppercase;
            cursor: pointer;
        }

        .formSendBtn:hover {
            background-color: #2bbbad;
            transition: all 0.3s ease;
        }

        .formSendBtn:disabled {
            background-color: #6b7c7a;
            cursor: not-allowed;
        }

    </style>
</head>

<body>
    <div class="inputBox">
        <h1>Envie seus arquivos em csv</h1>
        <form method="post" id="fileForm" enctype="multipart/form-data">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Selecione</span>
                    <input class="fileSelect" id="file" type="file" accept=".csv" multiple />
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" />
                    <div class="progress">
                        <div class="determinate" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            <!-- <div class="file-field input-field">
          <div class="btn">
            <span>Selecione</span>
            <input class="fileSelect" id="file2" type="file" accept=".csv" />
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" />
          </div>
        </div> -->
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" />
                    <label for="password">Senha</label>
                    <span class="helper-text">Para finalizar entre com a senha</span>
                </div>
            </div>
            <input id="uploadButton" disabled class="formSendBtn" type="submit" value="Enviar" />
        </form>

    </div>
    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="index.js"></script>
    <!-- js -->
</body>

</html>
<script>
    $(document).ready(function() {
        var pass = "bzdtcXJpejk=";

        $("#file" && "#password").change(function() {
            const passValueCrypto = btoa($("#password").val())
            if (
                $("#file")[0].files.length > 0 &&
                passValueCrypto == pass
            ) {
                $("#uploadButton").prop("disabled", false);
            }
        });

        $("#uploadButton").click(function(event) {
            event.preventDefault();

            var formData = new FormData();

            var file = $("#file")[0];
            for (var i = 0; i < file.files.length; i++) {
                formData.append('file[]', file.files[i]);
            }

            var xhr = new XMLHttpRequest();
            xhr.upload.onloadstart = function() {}
            xhr.upload.onprogress = function(e) {
                var b = (e.loaded / e.total) * 100
                var c = b
                b = b <= 10 ? 0 : b - 10
                var pross = $('.determinate')
                pross.css('width', b + '%')
            }
            xhr.onreadystatechange = function() {
                var pross = $('.determinate')
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        pross.css('width', 100 + '%')
                        M.toast({
                            html: `Sucesso! `
                        })
                        M.toast({
                            html: response.message
                        })

                    } else {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            var errors = response.errors
                            for (var i = 0; i < errors.length; i++) {
                                M.toast({
                                    html: errors[i]
                                })

                            }
                        }
                    }
                    $("#fileForm")[0].reset();
                    $("#uploadButton").prop("disabled", true);
                }
            }
            xhr.open('POST', '/upload');
            xhr.send(formData);

        });
    });
</script>
