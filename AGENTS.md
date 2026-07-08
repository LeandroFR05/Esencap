# [Nombre del proyecto]
El proyecto se llama EsenCap, es un sistema de gestión de insumos y de producción para una empresa de cosmética natural.
## Stack
- Lenguaje: PHP, JavaScript
- Framework / runtime: Laravel, Node
- Base de datos: MySql
- Tests: -
## Comandos
- `[comando php artisan serve]` — arranca el servidor en local
- `[comando test]` — ejecuta los tests (deben pasar antes de cada commit)
- `[comando build]` — compila para producción
## Estructura del proyecto
- `insumos/` — Contiene todos los archivos relacionados a los insumos.
- `productos/` — Contiene todos los archivos relacionados a los productos.
- `lotes/` — Contiene todos los archivos relacionados a los vencimientos y falta de stock de los lotes de insumos.
- `ventas/` — Contiene el registro de ventas y el historial.
7
## Convenciones
- [Estilo de nombres, p. ej. camelCase para variables y funciones.]
- [Dónde van los tests, p. ej. al lado del archivo: `foo.ts` +
`foo.test.ts`.]
- [Manejo de errores, p. ej. clases propias en `src/errors/`.]
- [Patrón a seguir, p. ej. validar toda entrada del usuario antes de
usarla.]
## No hagas
- No instalar dependencias sin avisar.
- No subir archivos `.env*` al repositorio.
## Flujo de trabajo
- Antes de una tarea no trivial, propón un plan y espera mi OK.
- Una tarea a la vez; al terminar, dime qué cambiaste para que lo
revise.
- Si no estás seguro al 80%, pregunta. No inventes.
## Documentación
- Referencias a más reglas, contexto, documentación y especificaciones.