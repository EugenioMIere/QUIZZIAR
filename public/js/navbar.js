document.addEventListener("DOMContentLoaded", function() {
    const rol = document.getElementById("rol").value;
    const navUl = document.getElementById("nav-ul");

    if (rol === "editor") {

        const listadoDePreguntasLi = document.createElement("li");
        listadoDePreguntasLi.classList.add("nav-item");
        listadoDePreguntasLi.innerHTML = '<a href="/editor/home" class="nav-link">Listado</a>';
        navUl.appendChild(listadoDePreguntasLi);

        const preguntasSugeridasLi = document.createElement("li");
        preguntasSugeridasLi.classList.add("nav-item");
        preguntasSugeridasLi.innerHTML = '<a href="/editor/verPreguntasSugeridas" class="nav-link">Sugeridas</a>';
        navUl.appendChild(preguntasSugeridasLi);

        const preguntasReportadasLi = document.createElement("li");
        preguntasReportadasLi.classList.add("nav-item");
        preguntasReportadasLi.innerHTML = '<a href="/editor/verPreguntasReportadas" class="nav-link">Reportadas</a>';
        navUl.appendChild(preguntasReportadasLi);

        const crearPreguntaLi = document.createElement("li");
        crearPreguntaLi.classList.add("nav-item");
        crearPreguntaLi.innerHTML = '<a href="/editor/irACrearPregunta" class="nav-link">Crear pregunta</a>';
        navUl.appendChild(crearPreguntaLi);
    } else if (rol === "user") {
        const verPerfilLi = document.createElement("li");
        verPerfilLi.classList.add("nav-item");
        verPerfilLi.innerHTML = '<a href="/user/redirigirDatosUsuario" class="nav-link">Mi perfil</a>';
        navUl.appendChild(verPerfilLi);
    }
});