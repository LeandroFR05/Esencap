// Generador del diagrama de secuencia UML para ProductoController::store()
// Version: transacciones como self-messages en Producto (sin participante DB)
// Salida: docs/diagrams/secuencia_crear_producto_transacciones.drawio
//
// Participantes (de izq. a der.):
//   Administrador (actor) -> Producto -> Insumo -> LoteProducto -> Formula
//
// Estructura:
//   - DB::beginTransaction() como self-loop ANTES del alt
//   - alt [No hay stock] con DB::rollBack() como self-loop
//   - alt [Hay stock] con el flujo de creacion
//   - DB::commit() como self-loop DESPUES del alt
//   - opt [excepcion] con DB::rollBack() como self-loop

const fs = require('fs');
const path = require('path');

let id = 0;
const nextId = () => `c${++id}`;
const cells = [];
const add = (cell) => cells.push(cell);

const escapeXml = (s) =>
  String(s)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&apos;');

// ------------------------------------------------------------------
// Geometria
// ------------------------------------------------------------------
const PARTICIPANTS = [
  { name: 'Administrador',   kind: 'actor' },
  { name: 'Producto',        kind: 'box' },
  { name: 'Insumo',          kind: 'box' },
  { name: 'LoteProducto',    kind: 'box' },
  { name: 'Formula',         kind: 'box' },
];

const BOX_W = 130;
const ACTOR_W = 30;
const GAP = 40;
const LEFT_PAD = 50;
const HEADER_Y = 100;
const LIFELINE_TOP = 160;
const MSG_GAP = 55;
const PADDING = 30;

const positions = {};
let cursorX = LEFT_PAD;
PARTICIPANTS.forEach((p) => {
  if (p.kind === 'actor') {
    positions[p.name] = { x: cursorX, w: ACTOR_W, kind: 'actor' };
    cursorX += ACTOR_W + GAP;
  } else {
    positions[p.name] = { x: cursorX, w: BOX_W, kind: 'box' };
    cursorX += BOX_W + GAP;
  }
});
const lifelineXOf = (name) => positions[name].x + positions[name].w / 2;
const totalWidth = cursorX + 50;

// ------------------------------------------------------------------
// Raiz y titulo
// ------------------------------------------------------------------
add(`<mxCell id="0" />`);
add(`<mxCell id="1" parent="0" />`);
add(`<mxCell id="${nextId()}" value="Diagrama de Secuencia UML - Crear Producto (ProductoController::store)&#10;Transacciones como self-messages en Producto" style="text;html=1;strokeColor=none;fillColor=none;align=center;verticalAlign=middle;whiteSpace=wrap;rounded=0;fontSize=16;fontStyle=1" vertex="1" parent="1"><mxGeometry x="${LEFT_PAD}" y="20" width="${totalWidth - LEFT_PAD * 2}" height="45" as="geometry"/></mxCell>`);

const lifelineRefs = [];
PARTICIPANTS.forEach((p) => {
  const pos = positions[p.name];
  if (p.kind === 'actor') {
    add(`<mxCell id="${nextId()}" value="${escapeXml(p.name)}" style="shape=umlActor;verticalLabelPosition=bottom;labelBackgroundColor=#ffffff;verticalAlign=top;html=1;outlineConnect=0;fontSize=13;fontStyle=1" vertex="1" parent="1"><mxGeometry x="${pos.x}" y="${HEADER_Y}" width="${pos.w}" height="60" as="geometry"/></mxCell>`);
  } else {
    add(`<mxCell id="${nextId()}" value="${escapeXml(p.name)}" style="rounded=0;whiteSpace=wrap;html=1;fillColor=#d5e8d4;strokeColor=#82b366;fontSize=13;fontStyle=1" vertex="1" parent="1"><mxGeometry x="${pos.x}" y="${HEADER_Y}" width="${pos.w}" height="50" as="geometry"/></mxCell>`);
  }
  lifelineRefs.push({ name: p.name, x: lifelineXOf(p.name) });
});

// ------------------------------------------------------------------
// Mensajes
// ------------------------------------------------------------------
let y = LIFELINE_TOP + 30;
const msg = (from, to, label, kind = 'sync') => {
  const fx = lifelineXOf(from);
  const tx = lifelineXOf(to);
  const yPos = y;
  let style, edge = 1;
  if (kind === 'return') {
    style = 'html=1;verticalAlign=bottom;endArrow=open;dashed=1;endSize=8;rounded=0;labelBackgroundColor=#ffffff;';
  } else if (kind === 'self') {
    style = 'html=1;verticalAlign=bottom;endArrow=block;endSize=8;rounded=0;labelBackgroundColor=#ffffff;';
  } else {
    style = 'html=1;verticalAlign=bottom;endArrow=block;endSize=10;rounded=0;labelBackgroundColor=#ffffff;';
  }
  if (kind === 'self') {
    add(`<mxCell id="${nextId()}" value="${escapeXml(label)}" style="${style}" edge="${edge}" parent="1"><mxGeometry relative="1" as="geometry"><mxPoint x="${fx}" y="${yPos}" as="sourcePoint"/><mxPoint x="${fx + 50}" y="${yPos}" as="targetPoint"/><Array as="points"><mxPoint x="${fx + 50}" y="${yPos}"/><mxPoint x="${fx + 50}" y="${yPos + 20}"/><mxPoint x="${fx}" y="${yPos + 20}"/></Array></mxGeometry></mxCell>`);
  } else {
    add(`<mxCell id="${nextId()}" value="${escapeXml(label)}" style="${style}" edge="${edge}" parent="1"><mxGeometry relative="1" as="geometry"><mxPoint x="${fx}" y="${yPos}" as="sourcePoint"/><mxPoint x="${tx}" y="${yPos}" as="targetPoint"/></mxGeometry></mxCell>`);
  }
  y += MSG_GAP;
};

// ------------------------------------------------------------------
// Flujo previo al alt: completar form + beginTransaction
// ------------------------------------------------------------------
msg('Administrador', 'Producto', '1: completar datos del producto');
msg('Producto', 'Producto', 'DB::beginTransaction()', 'self');
msg('Producto', 'Insumo', '2: descontar stock lotes');
msg('Insumo', 'Producto', 'sin stock', 'return');

// ------------------------------------------------------------------
// Fragmento ALT: [No hay stock] / [Hay stock]
// ------------------------------------------------------------------
const altTop = y;
const INSUF_MSG_COUNT = 2;
const OK_MSG_COUNT = 5;
const dashedOffset = MSG_GAP * 3;
const altHeight = dashedOffset + PADDING + OK_MSG_COUNT * MSG_GAP + PADDING;
const altLeft = LEFT_PAD - 10;
const altWidth = totalWidth - LEFT_PAD * 2 + 20;

add(`<mxCell id="${nextId()}" value="alt" style="shape=umlFrame;whiteSpace=wrap;html=1;pointerEvents=0;fillColor=none;swimlaneFillColor=#ffffff;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="${altLeft}" y="${altTop}" width="${altWidth}" height="${altHeight}" as="geometry"/></mxCell>`);
add(`<mxCell id="${nextId()}" value="[resultado != null — No hay stock]" style="text;html=1;strokeColor=none;fillColor=none;align=left;verticalAlign=top;whiteSpace=wrap;fontSize=11;fontStyle=2" vertex="1" parent="1"><mxGeometry x="${altLeft + 10}" y="${altTop + 4}" width="350" height="20" as="geometry"/></mxCell>`);

const dashedY = altTop + dashedOffset;
add(`<mxCell id="${nextId()}" value="[resultado == null — Hay stock]" style="text;html=1;strokeColor=none;fillColor=none;align=left;verticalAlign=top;whiteSpace=wrap;fontSize=11;fontStyle=2" vertex="1" parent="1"><mxGeometry x="${altLeft + 10}" y="${dashedY + 4}" width="350" height="20" as="geometry"/></mxCell>`);
add(`<mxCell id="${nextId()}" value="" style="line;html=1;strokeWidth=1;dashed=1;labelPosition=right;align=left;verticalAlign=middle;spacingLeft=-2" vertex="1" parent="1"><mxGeometry x="${altLeft + 10}" y="${dashedY}" width="${altWidth - 20}" height="1" as="geometry"/></mxCell>`);

// Rama [No hay stock]: rollBack + redirect error
y = altTop + PADDING;
msg('Producto', 'Producto', 'DB::rollBack()', 'self');
msg('Producto', 'Administrador', 'no hay suficiente stock', 'return');

// Rama [Hay stock]: flujo de creacion
y = dashedY + PADDING;
msg('Producto', 'Producto', 'guardar foto', 'self');
msg('Producto', 'Producto', 'crear producto', 'self');
msg('Producto', 'LoteProducto', 'crear lote');
msg('LoteProducto', 'Producto', 'ok', 'return');
msg('Producto', 'Formula', 'crear formula');
msg('Formula', 'Producto', 'ok', 'return');

y = altTop + altHeight + 40;

// ------------------------------------------------------------------
// DB::commit() (despues del alt, solo si se alcanzo la rama Hay stock)
// ------------------------------------------------------------------
msg('Producto', 'Producto', 'DB::commit()', 'self');
msg('Producto', 'Administrador', 'producto creado exitosamente', 'return');

y += 10;

// ------------------------------------------------------------------
// Fragmento OPT: [excepcion en el try]
// ------------------------------------------------------------------
const optTop = y;
const optHeight = PADDING + 2 * MSG_GAP + PADDING;
add(`<mxCell id="${nextId()}" value="opt" style="shape=umlFrame;whiteSpace=wrap;html=1;pointerEvents=0;fillColor=none;swimlaneFillColor=#ffffff;strokeColor=#000000;" vertex="1" parent="1"><mxGeometry x="${altLeft}" y="${optTop}" width="${altWidth}" height="${optHeight}" as="geometry"/></mxCell>`);
add(`<mxCell id="${nextId()}" value="[excepcion capturada por el catch del bloque try]" style="text;html=1;strokeColor=none;fillColor=none;align=left;verticalAlign=top;whiteSpace=wrap;fontSize=11;fontStyle=2" vertex="1" parent="1"><mxGeometry x="${altLeft + 10}" y="${optTop + 4}" width="450" height="20" as="geometry"/></mxCell>`);

y = optTop + PADDING;
msg('Producto', 'Producto', 'DB::rollBack()', 'self');
msg('Producto', 'Administrador', 'redirect con error', 'return');

const contentBottom = optTop + optHeight + 40;

// ------------------------------------------------------------------
// Lifelines
// ------------------------------------------------------------------
const lifelineHeight = contentBottom - LIFELINE_TOP + 40;
lifelineRefs.forEach(({ x }) => {
  add(`<mxCell id="${nextId()}" value="" style="html=1;points=[];perimeter=orthogonalPerimeter;outlineConnect=0;shape=umlLifeline;perimeter=rectanglePerimeter;whiteSpace=wrap;container=1;collapsible=0;recursiveResize=0;expand=0;drawIt=0;dashPattern=8 4" vertex="1" parent="1"><mxGeometry x="${x - 10}" y="${LIFELINE_TOP}" width="20" height="${lifelineHeight}" as="geometry"/></mxCell>`);
});

// ------------------------------------------------------------------
// Nota aclaratoria
// ------------------------------------------------------------------
add(`<mxCell id="${nextId()}" value="Notas:&#10;• DB::beginTransaction() se ejecuta ANTES del alt (siempre).&#10;• DB::rollBack() aparece en DOS lugares: rama [No hay stock] del alt Y en el opt [excepcion].&#10;• DB::commit() se ejecuta DESPUES del alt, solo si se alcanzo la rama [Hay stock].&#10;• Los self-loops en Producto representan llamadas al facade DB de Laravel (beginTransaction, commit, rollBack)." style="shape=note;whiteSpace=wrap;html=1;backgroundOutline=1;darkOpacity=0.05;fillColor=#fff2cc;strokeColor=#d6b656;fontSize=11;align=left;verticalAlign=top;spacingLeft=10;spacingTop=8" vertex="1" parent="1"><mxGeometry x="${altLeft}" y="${contentBottom}" width="${altWidth}" height="110" as="geometry"/></mxCell>`);

const pageHeight = contentBottom + 140;

// ------------------------------------------------------------------
// XML
// ------------------------------------------------------------------
const xml = `<?xml version="1.0" encoding="UTF-8"?>
<mxfile host="app.diagrams.net" modified="2026-06-18T00:00:00.000Z" agent="opencode" version="22.0.0" type="device">
  <diagram id="seq-store-producto-tx" name="Secuencia - Crear Producto (Transacciones)">
    <mxGraphModel dx="1600" dy="900" grid="1" gridSize="10" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="${Math.max(totalWidth + 40, 1200)}" pageHeight="${pageHeight}" math="0" shadow="0">
      <root>
        ${cells.join('\n        ')}
      </root>
    </mxGraphModel>
  </diagram>
</mxfile>
`;

const outPath = path.join(__dirname, 'secuencia_crear_producto_transacciones.drawio');
fs.writeFileSync(outPath, xml, 'utf8');
console.log(`Diagrama generado: ${outPath}`);
console.log(`Tamanho del XML: ${xml.length} bytes`);
console.log(`Ancho total: ${totalWidth}px`);
console.log(`Alto pagina: ${pageHeight}px`);
console.log(`Celdas: ${cells.length}`);
