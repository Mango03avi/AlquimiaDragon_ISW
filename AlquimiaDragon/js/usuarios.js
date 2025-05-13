let frm;
document.addEventListener("DOMContentLoaded", function () {
    cargarUsuarios();
    cargarRoles(); // Cargar roles en el select
    // Agregar evento de búsqueda
    document.getElementById("searchInput").addEventListener("input", filtrarTablaUsuarios);
    document.getElementById("btn-update").addEventListener("click", actualizarUsuario);
     // eliminamos listener al botón y cambiamos al formulario:
    frm = document.getElementById("registerForm");
    frm.addEventListener("submit", registrarUsuario);

    document.addEventListener("DOMContentLoaded", function () {
        const boton = document.getElementById("btn-ticket");
        if (boton) {
            boton.addEventListener("click", function (e) {
                e.preventDefault();
                generarTicketDelDia();
            });
        }
    });
});


//Funcion para generar el ticket del día
function generarTicketDelDia() {
    const hoy = new Date().toISOString().split("T")[0]; // Formato: YYYY-MM-DD
    const url = "../base/generarTicket.php?fecha=" + hoy;
    window.open(url, "_blank");
}

// Función para validar números positivos
function validarSoloTexto(inputElement, minLength = 5, maxLength = 35) {
    // Guardar el valor original antes de limpiar
    const valorOriginal = inputElement.value;
    
    // Eliminar todo lo que no sea letra (incluye acentos, espacios y Ñ)
    inputElement.value = inputElement.value.replace(/[^A-Za-záéíóúüñÁÉÍÓÚÜÑ\s]/g, '');
    //Para validar longitud de texto
    const valor = inputElement.value.trim();
    const longitudValida = valor.length >= minLength && valor.length <= maxLength;
    // Verificar si el valor original tenía caracteres inválidos
    const esValido = valor === valorOriginal.trim() && longitudValida;
    
    // Aplicar clases de validación
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity(""); // Limpiar mensaje de error
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        let mensaje = "Solo se permiten letras";
        if (!longitudValida) {
            mensaje += ` (${minLength}-${maxLength} caracteres requeridos)`;
        }
        inputElement.setCustomValidity(mensaje);
        inputElement.reportValidity();//Muestra el mensaje
    }
    
    return esValido;
}


// Función para validar correos
function validarCorreos(inputElement, minLength = 10, maxLength = 35) {
    const valor = inputElement.value.trim();
    
    // Expresión regular mejorada para correos
    const regexCorreo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;    
    const longitudValida = valor.length >= minLength && valor.length <= maxLength;
    const esValido = regexCorreo.test(valor) && longitudValida;
    
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity("");
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        let mensaje = "Correo inválido.";
        if (!longitudValida) {
            mensaje += ` Debe tener entre ${minLength} y ${maxLength} caracteres.`;
        }
        inputElement.setCustomValidity(mensaje);
        inputElement.reportValidity();
    }
    
    return esValido;
}

// Función para validar números positivos
function validarSoloNumeros(inputElement, minLength = 9, maxLength = 11) {
    // Guardar el valor original antes de limpiar
    const valorOriginal = inputElement.value;
    
    // Eliminar todo lo que no sea número (incluyendo el 0)
    inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
    const valor = inputElement.value;
    
    // Verificar si el valor original tenía caracteres inválidos y el largo correcto
    const longitudValida = valor.length >= minLength && valor.length <= maxLength;
    const esValido = valor === valorOriginal.trim() && longitudValida;
    
    // Aplicar clases de validación
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity("");
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        let mensaje = "Solo se permiten números.";
        if (!longitudValida) {
            mensaje += ` Debe tener entre ${minLength} y ${maxLength} dígitos.`;
        }
        inputElement.setCustomValidity(mensaje);
        inputElement.reportValidity();
    }

    
    return esValido;
}

function validarPrecio(inputElement, minLength = 2, maxLength = 7) {
    //guardar posición del cursor y valor original
    const inicioSeleccion = inputElement.selectionStart;
    const valorOriginal = inputElement.value;
    // Obtener el botón
    const boton = document.getElementById("btn-updateP");

    //Filtrado de caracteres no válidos
    inputElement.value = inputElement.value
        .replace(/[^0-9.]/g, '')  // Elimina todo lo que no sean números o puntos
        .replace(/(\..*)\./g, '$1') // Elimina puntos adicionales
        .replace(/^(\d{4,})(\.\d{0,2})?/g, (m, p1) => p1.slice(0,4)) // Limita a 4 enteros
        .replace(/(\.\d{2})\d+/g, '$1'); // Limita a 2 decimales
    
    //validaciones
    const regexPrecio = /^[0-9]{2,4}(\.[0-9]{1,2})?$/;
    const formatoValido = regexPrecio.test(inputElement.value);
    const longitudValida = inputElement.value.length >= minLength && 
                        inputElement.value.length <= maxLength;
    const esValido = formatoValido && longitudValida && inputElement.value !== '';
    
    // 3. Ajustar posición del cursor
    const cambios = valorOriginal.length - inputElement.value.length;
    inputElement.selectionEnd = inputElement.selectionStart = Math.max(0, inicioSeleccion - cambios);
    
    //Alerta
    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        inputElement.setCustomValidity("");
    } else {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');
        
        let mensaje = "Formato: 2-4 enteros y hasta 2 decimales (ej: 99.99)";
        if (!longitudValida) {
            mensaje += `\nDebe tener entre ${minLength} y ${maxLength} caracteres.`;
        }
        inputElement.setCustomValidity(mensaje);
        inputElement.reportValidity();
    }
    if (boton) {
        boton.disabled = !esValido;
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
<<<<<<< HEAD
            alert("Usuario registrado con éxito");  
            frm.reset(); 
=======
            // Mensaje de registro exitoso
            alert(data.message || "Usuario registrado con éxito");  
            document.querySelector('form').reset(); 
>>>>>>> 398daddc07b8f10be4a6dd36f39d1d0318f42f66
        } else {
            // Aquí cae si el correo ya existe o hay otro error
            alert(data.message || "Ocurrió un error al registrar el usuario");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Hubo un problema al registrar el usuario");
    });
}
 //Error dice que frm no esta declarado cuando