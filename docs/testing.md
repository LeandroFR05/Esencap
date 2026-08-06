# Documentación de Pruebas con Factories y Seeders

## Descripción general

Para verificar el comportamiento del sistema ante volúmenes de datos representativos, se implementaron **Factories** de Laravel para cada entidad principal del sistema y **Seeders** que las orquestan. Las pruebas se ejecutaron mediante el comando:

```bash
php artisan db:seed
```

Este proceso pobló la base de datos con datos sintéticos y relacionados entre sí, permitiendo navegar el sistema en condiciones cercanas a un uso real.

---

## Entorno de prueba

| Parámetro         | Valor                         |
|-------------------|-------------------------------|
| Framework         | Laravel                       |
| Base de datos     | SQLite (archivo local)        |
| Motor de datos falsos | Faker (vía `fake()`)      |
| Comando ejecutado | `php artisan db:seed`         |
| Trait utilizado   | `WithoutModelEvents`          |

> **Nota:** El trait `WithoutModelEvents` se utilizó para evitar que los observers/eventos del modelo se dispararan durante el seeding, garantizando que los datos se inserten directamente sin efectos secundarios no deseados en la prueba.

---

## Factories implementadas

Se crearon 8 factories, una por cada modelo del sistema:

| Factory                | Modelo asociado   | Archivo                                          |
|------------------------|-------------------|--------------------------------------------------|
| `UserFactory`          | `User`            | `database/factories/UserFactory.php`             |
| `InsumoFactory`        | `Insumo`          | `database/factories/InsumoFactory.php`           |
| `LoteInsumoFactory`    | `LoteInsumo`      | `database/factories/LoteInsumoFactory.php`       |
| `ProductoFactory`      | `Producto`        | `database/factories/ProductoFactory.php`         |
| `LoteProductoFactory`  | `LoteProducto`    | `database/factories/LoteProductoFactory.php`     |
| `FormulaFactory`       | `Formula`         | `database/factories/FormulaFactory.php`          |
| `VentaFactory`         | `Venta`           | `database/factories/VentaFactory.php`            |
| `DetalleVentaFactory`  | `DetalleVenta`    | `database/factories/DetalleVentaFactory.php`     |

---

## Detalle de cada Factory

### `InsumoFactory`

Genera insumos con datos aleatorios en los campos controlados, respetando los valores válidos del dominio.

| Campo            | Estrategia de generación                                    |
|------------------|-------------------------------------------------------------|
| `nombre`         | Palabra aleatoria (`fake()->word()`)                        |
| `foto`           | `null` (sin imagen en pruebas)                              |
| `idFamilia`      | Número entre 1 y 5 (familias precargadas por `FamiliaSeeder`) |
| `fase`           | Uno de: `Acuosa`, `Oleosa`, `Activos`                       |
| `estado`         | `1` (activo)                                                |
| `unidadDeMedida` | Uno de: `gramos`, `unidades`, `kilos`, `litros`             |

**State personalizado — `withLotes(int $count = 1)`:**  
Permite crear un insumo junto con sus lotes asociados en una sola llamada, usando la relación `lotes` del modelo.

```php
// Ejemplo de uso
Insumo::factory()->withLotes(2)->create();
```

---

### `LoteInsumoFactory`

Genera lotes de insumos con stock y fechas coherentes entre sí.

| Campo               | Estrategia de generación                                          |
|---------------------|-------------------------------------------------------------------|
| `stockInicial`      | Float aleatorio entre 10 y 1000                                   |
| `stockActual`       | Igual a `stockInicial` (sin consumo al momento de la carga)       |
| `fechaCompra`       | Fecha aleatoria dentro del último año                             |
| `fechaVencimiento`  | Entre 1 y 24 meses posterior a la `fechaCompra`                   |
| `numeroLote`        | Asignado automáticamente por trigger de base de datos             |

> **Nota:** El campo `numeroLote` no se define en la factory porque el modelo lo asigna automáticamente en su hook `creating` (`booted()`), calculando `max(numeroLote) + 1` para cada insumo.

---

### `ProductoFactory`

Genera productos terminados con campos básicos.

| Campo                | Estrategia de generación               |
|----------------------|----------------------------------------|
| `nombre`             | Palabra aleatoria (`fake()->word()`)   |
| `foto`               | `null` (sin imagen en pruebas)         |
| `contenidoPorUnidad` | Número entre 100 y 1000               |
| `estado`             | `1` (activo)                           |

**State personalizado — `withLotes(int $formulasCount = 1)`:**  
Crea un producto con su lote de producción y las fórmulas asociadas a ese lote.

```php
// Ejemplo de uso
Producto::factory()->withLotes(2)->create();
```

---

### `LoteProductoFactory`

Genera lotes de producción de productos terminados.

| Campo             | Estrategia de generación                              |
|-------------------|-------------------------------------------------------|
| `idUsuario`       | `1` (usuario admin creado por `UserSeeder`)           |
| `stockInicial`    | Float aleatorio entre 10 y 70                         |
| `stockActual`     | Igual a `stockInicial`                                |
| `fechaElaboracion`| Fecha aleatoria dentro de los últimos 6 meses         |

**State personalizado — `withFormulas(int $count = 1)`:**  
Asocia fórmulas al lote de producción.

```php
// Ejemplo de uso
LoteProducto::factory()->withFormulas(3)->create();
```

---

### `FormulaFactory`

Genera las fórmulas que componen un lote de producción, vinculándolas a insumos existentes.

| Campo        | Estrategia de generación                                              |
|--------------|-----------------------------------------------------------------------|
| `porcentaje` | Float aleatorio entre 1 y 100                                         |
| `idInsumo`   | Insumo tomado aleatoriamente de la tabla (requiere que existan insumos) |
| `contenido`  | Float aleatorio entre 10 y 1000                                       |

> **Dependencia:** Esta factory requiere que la tabla `insumos` ya tenga registros al momento de ejecutarse. Por eso el `InsumoSeeder` debe correr antes que el `ProductoSeeder`.

---

### `VentaFactory`

Genera registros de ventas con fechas distribuidas en el último año.

| Campo       | Estrategia de generación                              |
|-------------|-------------------------------------------------------|
| `idUsuario` | `1` (usuario admin)                                   |
| `fecha`     | Fecha aleatoria dentro del último año                 |
| `cliente`   | Nombre completo aleatorio (`fake()->name()`)           |

**State personalizado — `withDetalleVentas()`:**  
Asocia un detalle de venta a la venta creada.

```php
// Ejemplo de uso
Venta::factory()->withDetalleVentas()->create();
```

---

### `DetalleVentaFactory`

Genera los ítems de cada venta, vinculados a productos existentes.

| Campo            | Estrategia de generación                                              |
|------------------|-----------------------------------------------------------------------|
| `idProducto`     | Producto tomado aleatoriamente de la tabla `productos`                |
| `precioUnitario` | Float aleatorio entre 1 y 100                                         |
| `cantidad`       | Entero aleatorio entre 1 y 10                                         |

> **Dependencia:** Esta factory requiere que la tabla `productos` ya tenga registros al momento de ejecutarse.

---

## Seeders y volumen de datos generados

Los seeders orquestan la ejecución de las factories en el orden correcto, respetando las dependencias entre entidades.

### Orden de ejecución en `DatabaseSeeder`

```php
$this->call([
    UserSeeder::class,
    FamiliaSeeder::class,
    InsumoSeeder::class,
    ProductoSeeder::class,
    VentaSeeder::class,
]);
```


### Resumen de registros generados por seeder

| Seeder            | Registros directos | Registros relacionados generados                        | Total estimado |
|-------------------|--------------------|---------------------------------------------------------|----------------|
| `UserSeeder`      | 1 usuario          | —                                                       | **1**          |
| `FamiliaSeeder`   | 5 familias (fijos) | —                                                       | **5**          |
| `InsumoSeeder`    | 20 insumos         | 2 lotes por insumo → 40 lotes                           | **60**         |
| `ProductoSeeder`  | 40 productos       | 2 lotes por producto → 40 lotes + fórmulas por lote    | **~120+**      |
| `VentaSeeder`     | 20 ventas          | 1 detalle por venta → 20 detalles                       | **40**         |
| **Total general** |                    |                                                         | **~226+**      |

### Detalle por seeder

#### `UserSeeder`
Crea el usuario administrador del sistema con credenciales fijas para no depender de la factory en este caso.

```php
User::create([
    'name'     => 'admin',
    'email'    => 'admin@gmail.com',
    'password' => bcrypt('admin123'),
]);
```

#### `FamiliaSeeder`
Inserta 5 familias de insumos con datos reales del dominio. No usa factory porque los valores son datos de referencia fijos.

```
Aceites | Polvos | Colorantes | Emulsionantes | Conservantes
```

#### `InsumoSeeder`
Genera 20 insumos, cada uno con 2 lotes asociados, resultando en 40 registros en la tabla `lotes_insumos`.

```php
Insumo::factory(20)->withLotes(2)->create();
```

#### `ProductoSeeder`
Genera 40 productos, cada uno con 2 lotes de producción. Cada lote de producción incluye fórmulas que referencian insumos existentes.

```php
Producto::factory(40)->withLotes(2)->create();
```

#### `VentaSeeder`
Genera 20 ventas, cada una con un detalle de venta que referencia un producto existente.

```php
Venta::factory(20)->withDetalleVentas()->create();
```

---

## Aspectos verificados durante las pruebas

Al ejecutar `php artisan db:seed` con todos los seeders activos, se verificó el comportamiento del sistema en los siguientes aspectos:

| Aspecto verificado                                  | Resultado observado                                                  |
|-----------------------------------------------------|----------------------------------------------------------------------|
| Creación masiva de insumos con lotes                | El sistema creó los 20 insumos y 40 lotes sin errores               |
| Asignación automática de `numeroLote`               | El modelo asignó el número correlativo (max + 1) correctamente        |
| Navegación del listado de insumos con muchos registros | Las vistas respondieron de forma fluida con los 20 registros      |
| Creación de productos con lotes y fórmulas anidadas | Las relaciones Producto → Lote → Fórmula se crearon correctamente   |
| Referencias a insumos existentes en fórmulas        | `FormulaFactory` resolvió insumos existentes sin crear duplicados    |
| Referencias a productos existentes en ventas        | `DetalleVentaFactory` vinculó correctamente productos a ventas       |
| Coherencia de fechas en lotes de insumos            | `fechaVencimiento` siempre posterior a `fechaCompra`                 |
| Coherencia de stock inicial y actual                | `stockActual` igual a `stockInicial` al momento de la carga         |

---

## Cómo volver a ejecutar las pruebas

Para restablecer la base de datos y volver a poblarla desde cero:

```bash
# Opción 1: Recrear todas las tablas y volver a sembrar
php artisan migrate:fresh --seed

# Opción 2: Solo ejecutar los seeders (sin recrear tablas)
php artisan db:seed
```

---

## Test de estrés

Para evaluar cómo se comporta la aplicación bajo una carga mayor a la normal, se ampliaron los volúmenes de los seeders a 100 registros por entidad y se repobló la base de datos completa. El objetivo fue comprobar que los listados, historiales y reportes siguieran respondiendo con fluidez con un volumen aproximado de **~1.000 registros** en total (más de 4 veces la carga base).

### Volúmenes usados

| Seeder            | Registros directos | Registros relacionados generados                                 | Total  |
|-------------------|--------------------|------------------------------------------------------------------|--------|
| `UserSeeder`      | 1 usuario          | —                                                                | 1      |
| `FamiliaSeeder`   | 5 familias (fijos) | —                                                                | 5      |
| `InsumoSeeder`    | 100 insumos        | 2 lotes por insumo → 200 lotes                                   | 300    |
| `ProductoSeeder`  | 100 productos      | 2 lotes de producción + 1 fórmula por lote → 200 lotes + 200 fórmulas | 500 |
| `VentaSeeder`     | 100 ventas         | 1 detalle por venta → 100 detalles                               | 200    |
| **Total general** |                    |                                                                  | **1.006** |

### Cómo se ejecutó

Se modificaron los contadores de los seeders para que generen 100 registros por entidad:

```php
Insumo::factory(100)->withLotes(2)->create();
Producto::factory(100)->withLotes(2)->create();
Venta::factory(100)->withDetalleVentas()->create();
```

Y se repobló la base de datos desde cero:

```bash
php artisan migrate:fresh --seed
```

### Resultados

Con el volumen de carga de ~1.000 registros, la aplicación respondió de forma fluida:

| Aspecto verificado                                     | Resultado                          |
|--------------------------------------------------------|------------------------------------|
| Navegación de listados e historiales                   | Sin demoras perceptibles           |
| Creación masiva de lotes con `numeroLote` correlativo  | Correcta (max + 1 por insumo/producto) |
| Carga de relaciones anidadas (Producto → Lote → Fórmula) | Correcta                         |
| Referencias entre entidades (fórmulas e insumos, detalles de venta) | Sin datos huérfanos ni errores |

### Ajustes realizados para esta prueba

Para que la generación masiva funcionara, se reemplazó la asignación de `numeroLote` que antes hacían los triggers de base de datos:

1. Se eliminaron los triggers SQL que asignaban `numeroLote`.
2. Ahora lo asigna cada modelo en su hook `creating` (`booted()`), calculando `max(numeroLote) + 1` por insumo o producto. Por eso `LoteInsumoFactory` y `LoteProductoFactory` ya no definen el campo.
3. Se quitó el trait `WithoutModelEvents` de los seeders (`DatabaseSeeder` y `ProductoSeeder`): como ya no hay observers en la aplicación, ese trait solo silenciaba el evento `creating` del modelo e impedía el auto-generado de `numeroLote`, provocando el error `Field 'numeroLote' doesn't have a default value`.


