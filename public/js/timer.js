document.addEventListener("DOMContentLoaded", function() {
    var timer = 10; // 10 segundos
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
    var idPregunta = document.getElementById("idPregunta").value;
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200){ // Códigos de estado 200 = éxito
            // manejar la rta del servidor
            console.log(xhr.responseText);
            window.location.href = "perdisteView.mustache";
        }
    };
    xhr.send("idPregunta=" + idPregunta);
}
