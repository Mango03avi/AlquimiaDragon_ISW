document.addEventListener("DOMContentLoaded", function () {
    cargarProductos();

    // Agregar evento de búsqueda
    document.getElementById("searchItem").addEventListener("input", filtrarTablaMenu);
    // Agrega el evento de actualizar
    document.getElementById("btn-updateP").addEventListener("click", actualizarProducto);
});

// Función para cargar productos
function cargarProductos() {
    fetch("../base/menu.php?action=fetch")
        .then(response => response.json())
        .then(data => {
            const productosTableBody = document.getElementById("productosTableBody");
            productosTableBody.innerHTML = "";

            data.forEach(producto => {
                const row = `
                    <tr onclick="llenarFormularioP('${producto.ID_producto}', '${producto.Nombre}', '${producto.Tipo}', '${producto.Costo}')">
                        <td>${producto.ID_producto}</td>
                        <td>${producto.Nombre}</td>
                        <td>${producto.Tipo}</td>
                        <td>${producto.Costo}</td>
                        <td>${producto.Disponibilidad == 1 ? 'Sí' : 'No'}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" class="toggle-disponibilidad" 
                                    data-id="${producto.ID_producto}" 
                                    ${producto.Disponibilidad == 1 ? 'checked' : ''}
                                    onchange="cambioStatus(${producto.ID_producto}, this.checked)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${producto.ID_producto})">Eliminar</button>
                        </td>
                    </tr>
                `;
                productosTableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error al obtener productos:", error));
}

// Función para filtrar la tabla
function filtrarTablaMenu() {
    const input = document.getElementById("searchItem").value.toLowerCase();
    const rows = document.querySelectorAll("#productosTableBody tr");

    rows.forEach(row => {
        const cells = row.getElementsByTagName("td");
        const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(input));
        row.style.display = match ? "" : "none";
    });
}

// Función para eliminar un producto
function eliminarProducto(IdProducto) {
    if (confirm("¿Estás seguro de eliminar este producto?")) {
        fetch(`../base/menu.php?action=delete&id=${IdProducto}`, { method: "GET" })
            .then(response => response.json())  // Esperamos un JSON como respuesta
            .then(data => {
                alert(data.message);
                if (data.success) {
                    cargarProductos(); // Recargar productos después de eliminar si la respuesta es exitosa
                }
            })
            .catch(error => console.error("Error al eliminar el producto:", error));
    }
}

// Llenar formulario al hacer clic en un producto
function llenarFormularioP(id, nombre, tipo, precio) {
    document.getElementById("idProducto").value = id;  // ID
    document.getElementById("nombreProducto").value = nombre;  //llena el nombre
    document.getElementById("tipo").value = tipo;  // Autocompleta el tipo de cafe
    document.getElementById("precio").value = precio;  //Llena el precio
}


// Función para cambiar la disponibilidad del producto con confirmación
function cambioStatus(IdProducto, disponibilidad) {
    // Mostrar alerta de confirmación
    const confirmacion = confirm(`¿Estás seguro que deseas cambiar el estado a ${disponibilidad ? '"Disponible"' : '"No Disponible"'}?`);
    
    if (!confirmacion) {
        // Si el usuario cancela, revertimos el cambio en el checkbox
        const checkbox = document.querySelector(`input[data-id="${IdProducto}"]`);
        if (checkbox) {
            checkbox.checked = !disponibilidad; // Volvemos al estado anterior
        }
        return; // Salimos de la función sin hacer cambios
    }

    // Si el usuario confirma, procedemos con el cambio
    fetch("../base/menu.php?action=updateDisponibilidad", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: IdProducto, disponibilidad: disponibilidad ? 1 : 0 })
    })
    .then(response => response.text())
    .then(responseText => {
        console.log(responseText);
        
        // Mostrar alerta de éxito
        alert("El estado del producto se ha actualizado correctamente");

        // Actualizar la interfaz sin recargar
        const checkbox = document.querySelector(`input[data-id="${IdProducto}"]`);
        if (checkbox) {
            const row = checkbox.closest("tr");
            const disponibilidadCell = row.querySelector("td:nth-child(5)");
            disponibilidadCell.textContent = disponibilidad ? "Sí" : "No";
        }
    })
    .catch(error => {
        console.error("Error al actualizar disponibilidad:", error);
        // Mostrar alerta de error
        alert("Hubo un error al actualizar el estado del producto");
        
        // Revertir el cambio en el checkbox si hay error
        const checkbox = document.querySelector(`input[data-id="${IdProducto}"]`);
        if (checkbox) {
            checkbox.checked = !disponibilidad;
        }
    });
}

// Función para actualizar un producto
function actualizarProducto() {
    const id = document.getElementById('idProducto').value.trim();
    const nombre = document.getElementById('nombreProducto').value.trim();
    const tipo = document.getElementById('tipo').value.trim();
    const precio = parseFloat(document.getElementById('precio').value.trim());

    // Validar que nombre, tipo y precio no estén vacíos
    if (!nombre || !tipo || isNaN(precio)) {
        alert('Por favor llena todos los campos');
        return;
    }

    let action = id ? 'update' : 'insert'; // Si hay ID -> update, si no -> insert

    fetch('../base/menu.php?action=' + action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: id,
            nombre: nombre,
            tipo: tipo,
            precio: precio,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Aquí puedes limpiar el formulario o recargar la tabla
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

