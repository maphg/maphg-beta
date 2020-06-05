function importarStock() {

    var inputFile = document.getElementById("txtFile");
    var tipo = $("#cbTipo").val();

    var file = inputFile.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    //data.append('tipoGasto', tipoGasto);

    $.ajax({
        url: "libs/importar-stock.php", // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        beforeSend: function () {
            $("#loading").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
//            $("#sucesoBody").html(data);
            if (data == 1) {
                alert("Carga exitosa.");
                location.reload();
            } else {
                alert(data);
            }
        }
    });
}