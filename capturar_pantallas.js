import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

// Asegurar que la carpeta de destino existe
const screenshotDir = path.resolve('public/images/manual');
if (!fs.existsSync(screenshotDir)) {
    fs.mkdirSync(screenshotDir, { recursive: true });
}

const sleep = (ms) => new Promise(r => setTimeout(r, ms));

async function run() {
    console.log("Iniciando navegador automatizado...");
    const browser = await puppeteer.launch({
        headless: "new",
        defaultViewport: { width: 1366, height: 768 }
    });
    const page = await browser.newPage();

    console.log("Navegando a la página de inicio de sesión...");
    try {
        await page.goto("http://127.0.0.1:8000/login", { waitUntil: "networkidle2" });
    } catch (err) {
        console.error("Error: No se pudo conectar al servidor local en http://127.0.0.1:8000.");
        console.error("Asegúrate de que 'php artisan serve' esté corriendo.");
        await browser.close();
        process.exit(1);
    }

    // Tomar captura de la pantalla de Login
    console.log("Capturando pantalla de Inicio de Sesión...");
    await page.screenshot({ path: path.join(screenshotDir, "login.png") });

    // Completar el formulario de Login
    console.log("Iniciando sesión como administrador...");
    await page.type('input[type="email"]', 'admin@gmail.com');
    await page.type('input[type="password"]', 'admin123');
    await Promise.all([
        page.click('button[type="submit"]'),
        page.waitForNavigation({ waitUntil: "networkidle2" })
    ]);

    const screens = [
        { name: "dashboard", url: "http://127.0.0.1:8000/dashboard", delay: 3000 }, // más tiempo para gráficos
        { name: "insumos_estante", url: "http://127.0.0.1:8000/insumos", delay: 1500 },
        { name: "insumos_crear", url: "http://127.0.0.1:8000/insumos/create", delay: 1500 },
        { name: "insumos_historial", url: "http://127.0.0.1:8000/insumos/historial", delay: 1500 },
        { name: "insumos_eliminados", url: "http://127.0.0.1:8000/insumos/eliminados", delay: 1500 },
        { name: "productos_estante", url: "http://127.0.0.1:8000/productos", delay: 1500 },
        { name: "productos_crear", url: "http://127.0.0.1:8000/productos/create", delay: 1500 },
        { name: "productos_historial", url: "http://127.0.0.1:8000/productos/historial", delay: 1500 },
        { name: "productos_eliminados", url: "http://127.0.0.1:8000/productos/eliminados", delay: 1500 },
        { name: "ventas_registrar", url: "http://127.0.0.1:8000/ventas", delay: 1500 },
        { name: "ventas_historial", url: "http://127.0.0.1:8000/ventas/historial", delay: 1500 },
        { name: "perfil_usuario", url: "http://127.0.0.1:8000/profile", delay: 1500 },
        { name: "registro_usuario", url: "http://127.0.0.1:8000/register", delay: 1500 }
    ];

    for (const screen of screens) {
        console.log(`Navegando y capturando: ${screen.name}...`);
        try {
            await page.goto(screen.url, { waitUntil: "networkidle2" });
            await sleep(screen.delay); // Espera a que carguen animaciones/gráficos/Vite
            await page.screenshot({ path: path.join(screenshotDir, `${screen.name}.png`) });
        } catch (err) {
            console.error(`Error al capturar ${screen.name}:`, err.message);
        }
    }

    console.log("Proceso de captura completado exitosamente.");
    await browser.close();
}

run();
