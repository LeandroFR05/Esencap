<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use PhpParser\Node\Expr\FuncCall;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', route('dashboard'));
});

//LOTES
    //Bajo stock
    Breadcrumbs::for('bajoStock', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Insumos con bajo stock', route('lotes.infoStock'));
    });

    //Vencidos
    Breadcrumbs::for('vencidos', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Insumos próximos a vencerse', route('lotes.infoVencimientos'));
    });


//PRODUCTOS
    //Estante de productos
    Breadcrumbs::for('productos', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Estante de Productos', route('productos.estante'));
    });

    //Editar
    Breadcrumbs::for('editar', function (BreadcrumbTrail $trail, $producto) {
        $trail->parent('productos');
        $trail->push('Editar', route('productos.edit', $producto));
    });

    //Nuevo
    Breadcrumbs::for('nuevo', function (BreadcrumbTrail $trail) {
        $trail->parent('productos');
        $trail->push('Nuevo', route('productos.create'));
    });

    //Reponer
    Breadcrumbs::for('reponerProducto', function (BreadcrumbTrail $trail, $producto) {
        $trail->parent('productos');
        $trail->push('Reponer', route('productos.reponer', $producto));
    });

    //Lotes
    Breadcrumbs::for('lotesProducto', function (BreadcrumbTrail $trail, $producto) {
        $trail->parent('productos');
        $trail->push('Lotes', route('productos.lotes', $producto));
    });

    //Eliminados
    Breadcrumbs::for('productos.eliminados', function (BreadcrumbTrail $trail) {
        $trail->parent('productos');
        $trail->push('Productos eliminados', route('productos.eliminados'));
    });


//INSUMOS
    //Estante de insumos
    Breadcrumbs::for('insumos', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Estante de Insumos', route('insumos.estante'));
    });

    //Editar
    Breadcrumbs::for('editarInsumo', function (BreadcrumbTrail $trail, $insumo) {
        $trail->parent('insumos');
        $trail->push('Editar', route('insumos.edit', $insumo));
    });

    //Nuevo
    Breadcrumbs::for('nuevoInsumo', function (BreadcrumbTrail $trail) {
        $trail->parent('insumos');
        $trail->push('Nuevo', route('insumos.create'));
    });

    //Reponer
    Breadcrumbs::for('reponerInsumo', function (BreadcrumbTrail $trail, $insumo) {
        $trail->parent('insumos');
        $trail->push('Reponer', route('insumos.reponer', $insumo));
    });

    //Eliminados
    Breadcrumbs::for('insumos.eliminados', function (BreadcrumbTrail $trail) {
        $trail->parent('insumos');
        $trail->push('Insumos eliminados', route('insumos.eliminados'));
    });

    //Lotes
    Breadcrumbs::for('lotes', function (BreadcrumbTrail $trail, $insumo) {
        $trail->parent('insumos');
        $trail->push('Lotes', route('insumos.lotes', $insumo));
    });

    //Historial
    Breadcrumbs::for('historialInsumos', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Historial', route('insumos.historial'));
    });


//HISTORIAL
Breadcrumbs::for('historialGeneral', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Historial', route('productos.historial'));
});


//VENTA
    Breadcrumbs::for('ventas', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Ventas', route('ventas.index'));
    });

    Breadcrumbs::for('ventasHistorial', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Historial de Ventas', route('ventas.index'));
    });

// Home > Blog
// Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });