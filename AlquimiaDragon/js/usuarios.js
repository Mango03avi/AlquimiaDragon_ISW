git  document.addEventListener("DOMContentLoaded", function () {
    cargarUsuarios();
    cargarRoles(); // Cargar roles en el select
    // Agregar evento de búsqueda
    document.getElementById("searchInput").addEventListener("input", filtrarTablaUsuarios);
    document.getElementById("btn-update").addEventListener("click", actualizarUsuario);
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
                    <tr onclick="llenarFormulario('${usuario.ID_usuario}', '${usuario.Telefono}', '${usuario.Correo}', '${usuario.ID_rol}')">
                        <td>${usuario.ID_usuario}</td>
                        <td>${usuario.Nombre}</td>
                        <td>${usuario.Correo}</td>
                        <td>${usuario.Nombre_Rol}</td>
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
function filtrarTablaUsuarios() {
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

// Cargar roles en el select de forma dinámica
function cargarRoles() {
    fetch("../base/usuarios.php?action=getRoles")
        .then(response => response.json())
        .then(data => {
            const selectRol = document.getElementById("rol");
            selectRol.innerHTML = ""; // Limpiar select

            data.forEach(rol => {
                const option = `<option value="${rol.ID_rol}">${rol.Nombre}</option>`;
                selectRol.innerHTML += option;
            });
        })
        .catch(error => console.error("Error al cargar roles:", error));
}

// Llenar formulario al hacer clic en un usuario
function llenarFormulario(id, telefono, correo, rol) {
    document.getElementById("idUsuario").value = id;  // ID
    document.getElementById("telefono").value = telefono;  // Teléfono
    document.getElementById("correo").value = correo;  // Correo electrónico

    // Seleccionar el rol correcto en el <select>
    const selectRol = document.getElementById("rol");
    selectRol.value = rol; 

    /**  VER ESTA ALTERNATIVA QUE VERIFICA SI EL ROL EXISTE 
    *const optionExists = [...selectRol.options].some(option => option.value == rol);
    *if (!optionExists) {
    *    alert("Seleccione el Rol que desea asignar.");
    *}
    **/
}

// Función para actualizar el usuario
function actualizarUsuario(event) {
    event.preventDefault(); // Evita que el formulario recargue la página

    const id = document.getElementById("idUsuario").value;
    const correo = document.getElementById("correo").value;
    const telefono = document.getElementById("telefono").value;
    const idRol = document.getElementById("rol").value;

    if (!id || !correo || !telefono || !idRol) {
        alert("Por favor, llena todos los campos.");
        return;
    }

    fetch("../base/usuarios.php?action=update", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id: id,
            correo: correo,
            telefono: telefono,
            id_rol: idRol
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            cargarUsuarios(); // Recargar la tabla de usuarios después de actualizar
        }
    })
    .catch(error => console.error("Error al actualizar usuario:", error));
}