document.addEventListener("DOMContentLoaded", function () {
    cargarUsuarios();
    cargarRoles(); // Cargar roles en el select
    // Agregar evento de búsqueda
    document.getElementById("searchInput").addEventListener("input", filtrarTablaUsuarios);
    document.getElementById("btn-update").addEventListener("click", actualizarUsuario);
     // eliminamos listener al botón y cambiamos al formulario:
    const frm = document.getElementById("registerForm");
    frm.addEventListener("submit", registrarUsuario);
    document.getElementById("btn-register").addEventListener("click", registrarUsuario); //Agregue doble captura de formulario 

    // Agregar validadores para campos numéricos
    document.querySelectorAll(".numero-positivo").forEach(input => {
        input.addEventListener("input", function() {
            validarSoloNumeros(this);
        });
    });
});

// Función para validar números positivos
function validarSoloTexto(inputElement) {
    // Guardar el valor original antes de limpiar
    const valorOriginal = inputElement.value;
    
    // Eliminar todo lo que no sea letra (incluye acentos, espacios y Ñ)
    inputElement.value = inputElement.value.replace(/[^A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]/g, '');
    
    // Verificar si el valor original tenía caracteres inválidos
    const esValido = inputElement.value === valorOriginal && inputElement.value.trim() !== '';
    
    // Aplicar clases de validación
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity(""); // Limpiar mensaje de error
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        inputElement.setCustomValidity("Solo se permiten letras (no números ni símbolos)");
        inputElement.reportValidity(); // Mostrar mensaje de error
    }
    
    return esValido;
}


// Función para validar correos
function validarCorreos(inputElement) {
    const valor = inputElement.value.trim();
    
    // Expresión regular mejorada para correos
    const regexCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;    
    const esValido = valor !== '' && regexCorreo.test(valor);
    
    // Aplicar clases de validación
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity(""); // Limpiar mensaje de error
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        inputElement.setCustomValidity("Por favor ingrese un correo válido (ejemplo: usuario@gmail.com)");
        inputElement.reportValidity();
    }
    
    return esValido;
}

// Función para validar números positivos
function validarSoloNumeros(inputElement) {
    // Guardar el valor original antes de limpiar
    const valorOriginal = inputElement.value;
    
    // Eliminar todo lo que no sea número (incluyendo el 0)
    inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
    
    // Verificar si el valor original tenía caracteres inválidos
    const esValido = inputElement.value === valorOriginal && inputElement.value !== '';
    
    // Aplicar clases de validación
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity(""); // Limpiar mensaje de error
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        inputElement.setCustomValidity("Solo se permiten números (no letras ni símbolos)");
        inputElement.reportValidity(); // Mostrar mensaje de error
    }
    
    return esValido;
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
                alert("Usuario Eliminado");
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
    if (inputTelefono && !validarSoloNumeros(inputTelefono)) {
        alert("Por favor ingrese un número de teléfono válido");
        inputTelefono.focus();
        return;
    }
    
    const id = document.getElementById("idUsuario").value.trim();
    const correo = document.getElementById("correo2").value.trim();
    const telefono = inputTelefono.value.trim();
    const idRol = document.getElementById("rol1").value.trim();
    
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
}

// Función para registrar el usuario
function registrarUsuario(event) {
    event.preventDefault(); // Evita que el formulario recargue la página

    // Validar campo de teléfono celular
    const inputCelular = document.getElementById("celular");
    if (!validarSoloNumeros(inputCelular)) {
        alert("Por favor ingrese un número de celular válido");
        inputCelular.focus();
        return;
    }
    
    // Obtener valores de los campos
    const nombre = document.getElementById("name").value.trim();
    const apellidoP = document.getElementById("apellidoP").value.trim();
    const apellidoM = document.getElementById("apellidoM").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const telefono = inputCelular.value.trim();
    const idRol = document.getElementById("rol").value;
    const contra = document.getElementById("contra").value.trim();

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
            alert("Usuario registrado con éxito");  
            frm.reset(); 
        } else {
            alert(data.message || "Ocurrió un error al registrar el usuario");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Hubo un problema al registrar el usuario");
    });
}
