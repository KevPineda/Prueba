SELECT
    fd.sku                              AS `Código de Producto`,
    SUM(fd.cantidad)                    AS `Sumatoria Total Cantidades`,
    SUM(fd.precio_unitario * fd.cantidad - fd.descuento) AS `Sumatoria Valor Venta`,
    SUM(fd.costo_unitario * fd.cantidad) AS `Sumatoria Total Costo`
FROM facturacion_detalle fd
INNER JOIN facturacion f ON f.id_factura = fd.id_factura
WHERE f.estado = 1
GROUP BY fd.sku
ORDER BY SUM(fd.cantidad) DESC;


SELECT
    f.fecha_realizacion                                     AS `Fecha Venta`,
    t.documento                                             AS `Doc Cliente`,
    CONCAT(t.nombre, ' ', t.apellido)                       AS `Nombre Cliente`,
    GROUP_CONCAT(
        CONCAT(f.fact_prefijo, '-', f.fact_consecutivo)
        ORDER BY f.fact_consecutivo
        SEPARATOR ', '
    )                                                       AS `Consecutivos de Venta`,
    SUM(fd.precio_unitario * fd.cantidad - fd.descuento)    AS `Total Venta`,
    SUM(fd.cantidad)                                        AS `Total Cantidad`,
    SUM(fd.iva)                                             AS `Total IVA`
FROM facturacion f
INNER JOIN tercero t       ON t.id_tercero  = f.id_tercero
INNER JOIN facturacion_detalle fd ON fd.id_factura = f.id_factura
WHERE f.estado = 1
GROUP BY
    f.fecha_realizacion,
    t.id_tercero
ORDER BY
    f.fecha_realizacion ASC,
    SUM(fd.precio_unitario * fd.cantidad - fd.descuento) DESC;