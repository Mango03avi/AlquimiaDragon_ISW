document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("btn-ticket");
    if (btn) {
        btn.addEventListener("click", generarTicket);
    }
});

async function generarTicket() {
    try {
        const response = await fetch("../base/generarTicket.php");
        const data = await response.json();
        const { tickets, productos } = data;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const hoy = new Date();
        const fechaStr = hoy.getFullYear() + "-" +
        String(hoy.getMonth() + 1).padStart(2, '0') + "-" +
        String(hoy.getDate()).padStart(2, '0');
        const fechaFormateada = hoy.toLocaleDateString("es-MX");

        // Cargar imagen y agregarla al PDF antes de cualquier texto
        const logo = new Image();
        logo.src = "../media/images/logo_CH .png"; // Asegúrate de que exista en esa ruta

        logo.onload = function () {
            const imgWidth = 20;
            const x = (doc.internal.pageSize.getWidth() - imgWidth) / 2;
            doc.addImage(logo, "PNG", x, 10, imgWidth, 20); // x, y, width, height

            let startY = 35; // Después de la imagen
            doc.setFontSize(16);
            doc.text("AlquimiaDragon", 105, startY, { align: "center" });
            doc.setFontSize(12);
            doc.text(`Reporte de ventas del día: ${fechaFormateada}`, 105, startY + 8, { align: "center" });

            const ticketHeaders = [["#", "ID Ticket", "Método de pago", "Total", "Fecha"]];
            const ticketData = tickets.map((t, i) => [
                i + 1,
                t.ID_ticket,
                t.Metodo_pago,
                `$${parseFloat(t.Total).toFixed(2)}`,
                t.Fecha
            ]);

            doc.autoTable({
                startY: startY + 15,
                head: ticketHeaders,
                body: ticketData,
                styles: { halign: "center" },
                headStyles: { fillColor: [52, 73, 94] },
            });

            const afterTickets = doc.lastAutoTable.finalY + 10;

            const productosHeaders = [["#", "Producto", "Tipo", "Cantidad", "Precio Unitario", "Total"]];
            const productosData = productos.map((p, i) => [
                i + 1,
                p.Nombre,
                p.Tipo,
                p.Cantidad,
                `$${parseFloat(p.Precio_individual).toFixed(2)}`,
                `$${parseFloat(p.Total).toFixed(2)}`
            ]);

            doc.autoTable({
                startY: afterTickets,
                head: productosHeaders,
                body: productosData,
                styles: { halign: "center" },
                headStyles: { fillColor: [39, 174, 96] },
            });

            const totalVentas = tickets.reduce((sum, t) => sum + parseFloat(t.Total || 0), 0);
            const totalProductos = productos.reduce((sum, p) => sum + parseFloat(p.Cantidad || 0), 0);

            const afterProductos = doc.lastAutoTable.finalY + 10;
            doc.setFontSize(12);
            doc.text(`Total productos vendidos: ${totalProductos}`, 14, afterProductos);
            doc.text(`Total de ingresos del día: $${totalVentas.toFixed(2)}`, 14, afterProductos + 7);

            // Guardar con nombre dinámico
            doc.save(`ventas_${fechaStr}.pdf`);
        };

        logo.onerror = function () {
            alert("No se pudo cargar el logo. Asegúrate de que la ruta sea correcta.");
        };

    } catch (error) {
        console.error("Error al generar el PDF:", error);
        alert("Error al generar el ticket.");
    }
}
