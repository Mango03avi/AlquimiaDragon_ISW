git  document.addEventListener("DOMContentLoaded", function () {
    cargarUsuarios();

    // Agregar evento de búsqueda
    document.getElementById("searchInput").addEventListener("input", filtrarTabla);
});

// Función para cargar usuarios
function cargarUsuarios() {
    fetch("../base/usuarios.php?action=fetch")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("usuariosTableBody");
            tableBody.innerHTML = "";

            data.forEach(usuario => {
                const row = `
                    <tr>
                        <td>${usuario.ID_usuario}</td>
                        <td>${usuario.Nombre}</td>
                        <td>${usuario.Correo}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${usuario.ID_usuario})">Eliminar</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error al cargar los usuarios:", error));
}

// Función para filtrar la tabla
function filtrarTabla() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#usuariosTableBody tr");

    rows.forEach(row => {
        const cells = row.getElementsByTagName("td");
        const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(input));
        row.style.display = match ? "" : "none";
    });
}

// Función para eliminar un usuario
function eliminarUsuario(idUsuario) {
    if (confirm("¿Estás seguro de eliminar este usuario?")) {
        fetch(`../base/usuarios.php?action=delete&id=${idUsuario}`, { method: "GET" })
            .then(response => response.text())
            .then(responseText => {
                alert(responseText);
                cargarUsuarios(); // Recargar usuarios después de eliminar
            })
            .catch(error => console.error("Error al eliminar el usuario:", error));
    }
}
