function screenShot(){
    document.getElementById("boton").classList.add("hidden")
    document.getElementsByTagName("body")[0].classList.remove("items-center")
    document.getElementsByTagName("body")[0].classList.add("items-start")
    html2canvas(document.getElementById('33')).then(function(canvas){
        document.body.appendChild(canvas)
        document.getElementById("33").classList.add("hidden")


 
        //let enlace = document.createElement('a');
          // El título
         // enlace.download = "Descargar.png";
          // Convertir la imagen a Base64 y ponerlo en el enlace
         // enlace.href = canvas.toDataURL();
          // Hacer click en él
          //enlace.click();
         
    });
    setTimeout(print,3000);
}
