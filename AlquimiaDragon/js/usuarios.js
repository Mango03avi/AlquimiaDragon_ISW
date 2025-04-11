document.addEventListener("DOMContentLoaded", function () {
    cargarUsuarios();
    cargarRoles(); // Cargar roles en el select
    // Agregar evento de búsqueda
    document.getElementById("searchInput").addEventListener("input", filtrarTablaUsuarios);
    document.getElementById("btn-update").addEventListener("click", actualizarUsuario);
    document.getElementById("btn-register").addEventListener("click", registrarUsuario);
    
    // Agregar validadores para campos numéricos
    document.querySelectorAll(".numero-positivo").forEach(input => {
        input.addEventListener("input", function() {
            validarNumeroPositivo(this);
        });
    });
});

// Función para validar números positivos
function validarNumeroPositivo(inputElement) {
    // Remover cualquier caracter que no sea número
    inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
    
    // Convertir a número y asegurarse que sea positivo
    const numero = parseInt(inputElement.value);
    if (inputElement.value && numero <= 0) {
        inputElement.value = '';
    }
    
    // Validación visual
    if (inputElement.value && parseInt(inputElement.value) > 0) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
    }
    
    return inputElement.value && parseInt(inputElement.value) > 0;
}

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
            const selectRol1 = document.getElementById("rol1");
            // Limpiar ambos selects
            selectRol.innerHTML = '<option selected disabled>Seleccione el Rol...</option>';
            selectRol1.innerHTML = '<option selected disabled>Seleccione el Rol...</option>';
            data.forEach(rol => {
                const option = `<option value="${rol.ID_rol}">${rol.Nombre}</option>`;
                selectRol.innerHTML += option;
                selectRol1.innerHTML += option;
            });
        })
        .catch(error => console.error("Error al cargar roles:", error));
}

// Llenar formulario al hacer clic en un usuario
function llenarFormulario(id, telefono, correo, rol) {
    document.getElementById("idUsuario").value = id;  // ID
    document.getElementById("telefono").value = telefono;  // Teléfono
    document.getElementById("correo2").value = correo;  // Correo electrónico
    // Seleccionar el rol correcto en el <select>
    const selectRol = document.getElementById("rol");
    selectRol.value = rol; 
}

// Función para actualizar el usuario
function actualizarUsuario(event) {
    event.preventDefault(); // Evita que el formulario recargue la página
    
    // Validar campo de teléfono
    const inputTelefono = document.getElementById("telefono");
    if (inputTelefono && !validarNumeroPositivo(inputTelefono)) {
        alert("Por favor ingrese un número de teléfono válido");
        inputTelefono.focus();
        return;
    }
    
    const id = document.getElementById("idUsuario").value;
    const correo = document.getElementById("correo2").value;
    const telefono = inputTelefono.value;
    const idRol = document.getElementById("rol1").value;
    
    if (!correo || !telefono || !idRol) {
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

// Función para registrar el usuario
function registrarUsuario(event) {
    event.preventDefault(); // Evita que el formulario recargue la página
    
    // Validar campo de teléfono celular
    const inputCelular = document.getElementById("celular");
    if (inputCelular && !validarNumeroPositivo(inputCelular)) {
        alert("Por favor ingrese un número de celular válido");
        inputCelular.focus();
        return;
    }
    
    // Obtener valores de los campos
    const nombre = document.getElementById("name").value.trim();
    const apellidoP = document.getElementById("apellidoP").value.trim();
    const apellidoM = document.getElementById("apellidoM").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const telefono = inputCelular.value;
    const idRol = document.getElementById("rol").value;
    const contra = document.getElementById("contra").value.trim();

    // Validación
    if (!nombre || !apellidoP || !apellidoM || !correo || !telefono || !idRol || !contra) {
        alert("Por favor, complete todos los campos");
        return;
    }

    // Crear objeto con los datos
    const datosUsuario = {
        nombre: nombre,
        apellidoP: apellidoP,
        apellidoM: apellidoM,
        telefono: telefono,
        correo: correo,
        contra: contra,
        id_rol: idRol
    };

    // Enviar como JSON
    fetch("../base/usuarios.php?action=register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(datosUsuario)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.querySelector('form').reset();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error al registrar: " + error.message);
    });
}