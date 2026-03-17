// Al cargar la página, revisamos el estado
window.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const isClosed = localStorage.getItem("sidebarClosed") === "true";

    if (isClosed) {
        sidebar.classList.add("closed");
    } else {
        sidebar.classList.remove("closed");
    }
});


// Para que el transition no pege saltyo al abrir/cerrar el menú, añadimos una clase temporal que activa la transición solo durante el toggle
function toggleMenu() {
    const sidebar = document.getElementById("sidebar");

    sidebar.classList.add("toggle-transition");
    sidebar.classList.toggle("closed");

    const isClosed = sidebar.classList.contains("closed");

    document.documentElement.classList.toggle("sidebar-closed", isClosed);

    localStorage.setItem("sidebarClosed", isClosed);

    setTimeout(() => {
        sidebar.classList.remove("toggle-transition");
    }, 300);
}
