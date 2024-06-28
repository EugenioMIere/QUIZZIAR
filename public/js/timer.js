document.addEventListener("DOMContentLoaded", function() {
    var timer = 20; // 20 segundos
    var interval = setInterval(function() {
        if (timer <= 0) {
            clearInterval(interval);
            enviarRespuesta();
        } else {
            document.getElementById("timer").innerHTML = timer;
            timer--;
        }
    }, 1000);
});

function enviarRespuesta() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/pregunta/validarPregunta", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var idPregunta = document.getElementById("idPregunta").value();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200){
            // manejar la rta del servidor
            console.log(xhr.responseText);
            // redirigir a otra página si es necesario
        }
    };
    xhr.send("idPregunta=" + idPregunta);
}