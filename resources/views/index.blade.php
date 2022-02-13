<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpLoad</title>
</head>

<body>

    <input type="text">
    <input type="file" name="file" id="file" multiple>
    <button id="btn">Upload</button>

    <script>
        var btn = document.getElementById('btn');
        var file = document.getElementById('file');
        btn.addEventListener('click', function() {
            var formData = new FormData();

            for (var i = 0; i < file.files.length; i++) {

                formData.append('file[]', file.files[i]);
            }
            var xhr = new XMLHttpRequest();
            xhr.upload.onloadstart = function() {
                console.log('start');
            }
            xhr.upload.onprogress = function(e) {
                console.log((e.loaded / e.total) * 100);
            }
            xhr.upload.onloadend = function() {
                console.log('end');
            }
            xhr.open('POST', '/upload');
            xhr.send(formData);
        });
    </script>
</body>

</html>
