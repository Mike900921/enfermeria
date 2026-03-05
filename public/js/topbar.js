function toggleMenu() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("closed");

    // Guardamos el estado en localStorage
    localStorage.setItem("sidebarClosed", sidebar.classList.contains("closed"));
}

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

    // Activamos transición antes de cambiar el estado
    sidebar.classList.add("toggle-transition");

    sidebar.classList.toggle("closed");
    localStorage.setItem("sidebarClosed", sidebar.classList.contains("closed"));

    // Quitamos la transición después de que termine
    setTimeout(() => {
        sidebar.classList.remove("toggle-transition");
    }, 300);
}
