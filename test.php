<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/tailwind.css">
    </head>

    <body>


        <div class="control antialiased sans-serif w-2/12">
            <input id="sortpicture" name="sortpic"
                class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                type="file" onfocusout="">
            <button onclick="myFunction()">Ok</button>
        </div>
    </body>
    <script src="js/jquery-3.3.1.js"></script>
    <script>
    function myFunction() {
        var file_data = $('#sortpicture').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: 'php/uploadFile.php', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response) {
                console.log(php_script_response, form_data); // display response from the PHP script, if any
            }
        });
    }
    </script>

</html>