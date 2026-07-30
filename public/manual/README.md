# Manual de Usuario

## Instrucciones

1. Coloca tu archivo PDF del manual aquí con el nombre: **manual.pdf**
2. Los usuarios autenticados podrán descargarlo desde el menú principal bajo la opción "Manual de usuario"
3. El archivo se desargará como "Manual_de_Usuario.pdf"

### Cambios realizados:

- Se agregó una nueva ruta: `/manual/descargar`
- Se agregó el controlador `ManualController`
- Se actualizó el menú con un enlace funcional al manual
- Solo usuarios autenticados pueden descargar el manual
