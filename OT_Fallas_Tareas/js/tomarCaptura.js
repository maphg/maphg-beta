const $boton = document.querySelector("#btnCapturar"), // El botón que desencadena
    $objetivo = document.body;
$boton.addEventListener("click", () => {
    html2canvas($objetivo) // Llamar a html2canvas y pasarle el elemento
        .then(canvas => {
            // Cuando se resuelva la promesa traerá el canvas
            // Crear un elemento <a>
            let enlace = document.createElement('a');
            enlace.download = "CapturaDePAntalla.png";
            // Convertir la imagen a Base64
            enlace.href = canvas.toDataURL();
            // Hacer click en él
            enlace.click();
        });
});