import fs from 'fs';
import path from 'path';
import { 
    Document, 
    Packer, 
    Paragraph, 
    TextRun, 
    HeadingLevel, 
    Table, 
    TableRow, 
    TableCell, 
    BorderStyle, 
    WidthType, 
    AlignmentType,
    Header,
    Footer,
    PageNumber,
    ShadingType,
    ImageRun
} from 'docx';

const mdPath = path.resolve('Manual_de_Usuario.md');
const docxPath = path.resolve('Manual_de_Usuario.docx');

if (!fs.existsSync(mdPath)) {
    console.error(`Error: No se encontró el archivo ${mdPath}`);
    process.exit(1);
}

const markdown = fs.readFileSync(mdPath, 'utf-8');
const lines = markdown.split(/\r?\n/);

const docChildren = [];

// ==========================================
// 1. PORTADA PROFESIONAL (ESTILO PREMIUM)
// ==========================================
docChildren.push(new Paragraph({
    text: "",
    spacing: { before: 1200 }
}));

docChildren.push(new Paragraph({
    children: [
        new TextRun({
            text: "ESENCAP",
            bold: true,
            size: 80, // 40 pt
            color: "1A5C96",
            font: "Source Sans 3"
        })
    ],
    alignment: AlignmentType.CENTER,
    spacing: { after: 200 }
}));

docChildren.push(new Paragraph({
    children: [
        new TextRun({
            text: "SISTEMA DE GESTIÓN DE INVENTARIO, ELABORACIÓN Y VENTAS",
            bold: true,
            size: 26, // 13 pt
            color: "555555",
            font: "Source Sans 3"
        })
    ],
    alignment: AlignmentType.CENTER,
    spacing: { after: 1200 }
}));

docChildren.push(new Paragraph({
    children: [
        new TextRun({
            text: "MANUAL DE USUARIO",
            bold: true,
            size: 56, // 28 pt
            color: "222222",
            font: "Source Sans 3"
        })
    ],
    alignment: AlignmentType.CENTER,
    spacing: { after: 200 }
}));

docChildren.push(new Paragraph({
    children: [
        new TextRun({
            text: "Guía completa paso a paso para el control de materias primas, producción en laboratorio y facturación comercial con capturas reales.",
            italic: true,
            size: 24, // 12 pt
            color: "666666",
            font: "Source Sans 3"
        })
    ],
    alignment: AlignmentType.CENTER,
    spacing: { after: 2400 }
}));

// Tabla de metadatos en portada
const metadataTable = new Table({
    width: {
        size: 100,
        type: WidthType.PERCENTAGE,
    },
    rows: [
        new TableRow({
            children: [
                new TableCell({
                    children: [
                        new Paragraph({
                            children: [
                                new TextRun({ text: "Versión:", bold: true, size: 20, color: "555555" })
                            ]
                        }),
                        new Paragraph({
                            children: [
                                new TextRun({ text: "1.0 (Mayo 2026)", size: 20, color: "333333" })
                            ]
                        })
                    ],
                    width: { size: 33, type: WidthType.PERCENTAGE },
                    borders: {
                        top: { style: BorderStyle.NONE },
                        bottom: { style: BorderStyle.NONE },
                        left: { style: BorderStyle.NONE },
                        right: { style: BorderStyle.NONE }
                    }
                }),
                new TableCell({
                    children: [
                        new Paragraph({
                            children: [
                                new TextRun({ text: "Autor:", bold: true, size: 20, color: "555555" })
                            ]
                        }),
                        new Paragraph({
                            children: [
                                new TextRun({ text: "Antigravity AI Team", size: 20, color: "333333" })
                            ]
                        })
                    ],
                    width: { size: 34, type: WidthType.PERCENTAGE },
                    borders: {
                        top: { style: BorderStyle.NONE },
                        bottom: { style: BorderStyle.NONE },
                        left: { style: BorderStyle.NONE },
                        right: { style: BorderStyle.NONE }
                    }
                }),
                new TableCell({
                    children: [
                        new Paragraph({
                            children: [
                                new TextRun({ text: "Soporte:", bold: true, size: 20, color: "555555" })
                            ]
                        }),
                        new Paragraph({
                            children: [
                                new TextRun({ text: "TI Esencap", size: 20, color: "333333" })
                            ]
                        })
                    ],
                    width: { size: 33, type: WidthType.PERCENTAGE },
                    borders: {
                        top: { style: BorderStyle.NONE },
                        bottom: { style: BorderStyle.NONE },
                        left: { style: BorderStyle.NONE },
                        right: { style: BorderStyle.NONE }
                    }
                })
            ]
        })
    ]
});

docChildren.push(metadataTable);

// Salto de página para el contenido
docChildren.push(new Paragraph({
    text: "",
    pageBreakBefore: true
}));

// ==========================================
// 2. PARSEO DE CONTENIDO MARKDOWN
// ==========================================

let inAlert = false;
let alertText = "";
let alertType = ""; // NOTE, IMPORTANT, TIP, CAUTION, WARNING

function cleanMarkdown(text) {
    let cleaned = text.replace(/\*\*(.*?)\*\*/g, '$1');
    cleaned = cleaned.replace(/\*(.*?)\*/g, '$1');
    cleaned = cleaned.replace(/\[(.*?)\]\(.*?\)/g, '$1');
    cleaned = cleaned.replace(/`(.*?)`/g, '$1');
    return cleaned;
}

function addImageIfExist(imageName) {
    const imgPath = path.resolve(`public/images/manual/${imageName}.png`);
    if (fs.existsSync(imgPath)) {
        docChildren.push(new Paragraph({
            text: "",
            spacing: { before: 100 }
        }));
        
        // Cargar y redimensionar la imagen para que encaje perfectamente en el Word
        docChildren.push(new Paragraph({
            children: [
                new ImageRun({
                    data: fs.readFileSync(imgPath),
                    transformation: {
                        width: 540,
                        height: 300
                    }
                })
            ],
            alignment: AlignmentType.CENTER,
            spacing: { before: 150, after: 100 }
        }));

        docChildren.push(new Paragraph({
            children: [
                new TextRun({ 
                    text: `Figura: Captura de pantalla de la sección ${imageName.replace('_', ' ').toUpperCase()}`, 
                    italic: true, 
                    size: 16, 
                    color: "888888" 
                })
            ],
            alignment: AlignmentType.CENTER,
            spacing: { after: 200 }
        }));
    }
}

for (let i = 0; i < lines.length; i++) {
    let line = lines[i].trim();

    // Saltear la cabecera original del manual Markdown (portada)
    if (i < 8 && (line.startsWith('#') || line.startsWith('!') || line.startsWith('**'))) {
        continue;
    }

    // Detectar líneas de imagen Markdown: ![alt text](ruta/a/imagen.png)
    const imgMatch = line.match(/^!\[([^\]]*)\]\(([^)]+)\)$/);
    if (imgMatch) {
        const altText = imgMatch[1];
        const imgRelPath = imgMatch[2];
        // Ignorar la imagen del logo en la portada (ya procesada arriba)
        if (imgRelPath.includes('logoEsencap')) {
            continue;
        }
        const imgAbsPath = path.resolve(imgRelPath);
        if (fs.existsSync(imgAbsPath)) {
            docChildren.push(new Paragraph({ text: "", spacing: { before: 100 } }));
            docChildren.push(new Paragraph({
                children: [
                    new ImageRun({
                        data: fs.readFileSync(imgAbsPath),
                        transformation: { width: 540, height: 300 }
                    })
                ],
                alignment: AlignmentType.CENTER,
                spacing: { before: 150, after: 100 }
            }));
            docChildren.push(new Paragraph({
                children: [
                    new TextRun({
                        text: altText,
                        italic: true,
                        size: 16,
                        color: "888888"
                    })
                ],
                alignment: AlignmentType.CENTER,
                spacing: { after: 200 }
            }));
        } else {
            console.warn(`Imagen no encontrada: ${imgAbsPath}`);
        }
        continue;
    }

    // Alertas (comienzan con >)
    if (line.startsWith('>')) {
        inAlert = true;
        let content = line.substring(1).trim();
        if (content.startsWith('[!NOTE]')) {
            alertType = "NOTE";
            alertText += content.replace('[!NOTE]', '').trim() + " ";
        } else if (content.startsWith('[!IMPORTANT]')) {
            alertType = "IMPORTANT";
            alertText += content.replace('[!IMPORTANT]', '').trim() + " ";
        } else if (content.startsWith('[!TIP]')) {
            alertType = "TIP";
            alertText += content.replace('[!TIP]', '').trim() + " ";
        } else if (content.startsWith('[!CAUTION]')) {
            alertType = "CAUTION";
            alertText += content.replace('[!CAUTION]', '').trim() + " ";
        } else if (content.startsWith('[!WARNING]')) {
            alertType = "WARNING";
            alertText += content.replace('[!WARNING]', '').trim() + " ";
        } else {
            alertText += content + " ";
        }
        continue;
    } else if (inAlert && line === "") {
        let bgColor = "F2F2F2";
        let borderColor = "555555";
        let title = "NOTA";
        if (alertType === "IMPORTANT") {
            bgColor = "FFF3CD";
            borderColor = "FFC107";
            title = "IMPORTANTE";
        } else if (alertType === "TIP") {
            bgColor = "D1E7DD";
            borderColor = "198754";
            title = "SUGERENCIA";
        } else if (alertType === "WARNING" || alertType === "CAUTION") {
            bgColor = "F8D7DA";
            borderColor = "DC3545";
            title = "ATENCIÓN";
        }

        const alertTable = new Table({
            width: { size: 100, type: WidthType.PERCENTAGE },
            rows: [
                new TableRow({
                    children: [
                        new TableCell({
                            children: [
                                new Paragraph({
                                    children: [
                                        new TextRun({ text: `${title}: `, bold: true, size: 20, color: borderColor }),
                                        new TextRun({ text: cleanMarkdown(alertText.trim()), size: 20, color: "333333" })
                                    ],
                                    spacing: { before: 120, after: 120, line: 360 }
                                })
                            ],
                            shading: {
                                fill: bgColor,
                                type: ShadingType.CLEAR,
                                color: "auto"
                            },
                            borders: {
                                left: { style: BorderStyle.SINGLE, size: 24, color: borderColor },
                                top: { style: BorderStyle.NONE },
                                bottom: { style: BorderStyle.NONE },
                                right: { style: BorderStyle.NONE }
                            }
                        })
                    ]
                })
            ]
        });

        docChildren.push(new Paragraph({ text: "", spacing: { before: 100, after: 100 } }));
        docChildren.push(alertTable);
        docChildren.push(new Paragraph({ text: "", spacing: { before: 100, after: 100 } }));

        inAlert = false;
        alertText = "";
        alertType = "";
        continue;
    }

    if (line === "") {
        continue;
    }

    // Encabezados H1
    if (line.startsWith('# ')) {
        const text = line.substring(2).trim();
        docChildren.push(new Paragraph({
            text: cleanMarkdown(text),
            heading: HeadingLevel.HEADING_1,
            spacing: { before: 400, after: 200 },
            keepNext: true
        }));
        continue;
    }

    // Encabezados H2
    if (line.startsWith('## ')) {
        const text = line.substring(3).trim();
        docChildren.push(new Paragraph({
            text: cleanMarkdown(text),
            heading: HeadingLevel.HEADING_2,
            spacing: { before: 300, after: 150 },
            keepNext: true
        }));
        continue;
    }

    // Encabezados H3
    if (line.startsWith('### ')) {
        const text = line.substring(4).trim();
        docChildren.push(new Paragraph({
            text: cleanMarkdown(text),
            heading: HeadingLevel.HEADING_3,
            spacing: { before: 200, after: 100 },
            keepNext: true
        }));
        continue;
    }

    // Encabezados H4
    if (line.startsWith('#### ')) {
        const text = line.substring(5).trim();
        docChildren.push(new Paragraph({
            text: cleanMarkdown(text),
            heading: HeadingLevel.HEADING_4,
            spacing: { before: 150, after: 100 },
            keepNext: true
        }));
        continue;
    }

    // Listas con viñetas (incluyendo sub-listas con espacios)
    if (line.startsWith('* ') || line.startsWith('- ')) {
        const text = line.substring(2).trim();
        docChildren.push(new Paragraph({
            children: [
                new TextRun({ text: "•  ", bold: true, size: 22, color: "1A5C96" }),
                new TextRun({ text: cleanMarkdown(text), size: 22, color: "333333" })
            ],
            spacing: { before: 60, after: 60, line: 320 },
            indent: { left: 400 }
        }));
        continue;
    }

    // Listas numeradas
    const numListMatch = line.match(/^(\d+)\.\s(.*)/);
    if (numListMatch) {
        const num = numListMatch[1];
        const text = numListMatch[2].trim();
        docChildren.push(new Paragraph({
            children: [
                new TextRun({ text: `${num}.  `, bold: true, size: 22, color: "1A5C96" }),
                new TextRun({ text: cleanMarkdown(text), size: 22, color: "333333" })
            ],
            spacing: { before: 80, after: 80, line: 320 },
            indent: { left: 400 }
        }));
        continue;
    }

    // Separadores ---
    if (line === '---') {
        docChildren.push(new Paragraph({
            text: "",
            border: {
                bottom: { style: BorderStyle.SINGLE, size: 6, color: "CCCCCC" }
            },
            spacing: { before: 200, after: 200 }
        }));
        continue;
    }

    // Bloques de código (ignorar, no incluir en DOCX)
    if (line.startsWith('```')) {
        continue;
    }

    // Párrafo de texto común
    docChildren.push(new Paragraph({
        children: [
            new TextRun({ text: cleanMarkdown(line), size: 22, color: "333333" })
        ],
        spacing: { before: 120, after: 120, line: 360 }
    }));
}

// ==========================================
// 3. DEFINICIÓN DEL DOCUMENTO Y GUARDADO
// ==========================================
const doc = new Document({
    sections: [
        {
            properties: {
                page: {
                    margin: {
                        top: 1440,
                        bottom: 1440,
                        left: 1440,
                        right: 1440
                    }
                }
            },
            headers: {
                default: new Header({
                    children: [
                        new Paragraph({
                            children: [
                                new TextRun({ text: "Manual de Usuario ESENCAP", size: 16, color: "888888", font: "Source Sans 3" })
                            ],
                            alignment: AlignmentType.RIGHT,
                            spacing: { after: 200 }
                        })
                    ]
                })
            },
            footers: {
                default: new Footer({
                    children: [
                        new Paragraph({
                            children: [
                                new TextRun({ text: "Página ", size: 16, color: "888888", font: "Source Sans 3" }),
                                new TextRun({ children: [PageNumber.CURRENT], size: 16, color: "888888", font: "Source Sans 3" }),
                                new TextRun({ text: " de ", size: 16, color: "888888", font: "Source Sans 3" }),
                                new TextRun({ children: [PageNumber.TOTAL_PAGES], size: 16, color: "888888", font: "Source Sans 3" })
                            ],
                            alignment: AlignmentType.CENTER
                        })
                    ]
                })
            },
            children: docChildren
        }
    ],
    features: {
        updateFields: true
    },
    styles: {
        paragraphStyles: [
            {
                id: "Heading1",
                name: "Heading 1",
                basedOn: "Normal",
                nextParagraphStyle: "Normal",
                quickFormat: true,
                run: {
                    font: "Source Sans 3",
                    size: 36,
                    bold: true,
                    color: "1A5C96"
                },
                paragraph: {
                    spacing: { before: 400, after: 200 }
                }
            },
            {
                id: "Heading2",
                name: "Heading 2",
                basedOn: "Normal",
                nextParagraphStyle: "Normal",
                quickFormat: true,
                run: {
                    font: "Source Sans 3",
                    size: 28,
                    bold: true,
                    color: "2E7D32"
                },
                paragraph: {
                    spacing: { before: 300, after: 150 }
                }
            },
            {
                id: "Heading3",
                name: "Heading 3",
                basedOn: "Normal",
                nextParagraphStyle: "Normal",
                quickFormat: true,
                run: {
                    font: "Source Sans 3",
                    size: 24,
                    bold: true,
                    color: "444444"
                },
                paragraph: {
                    spacing: { before: 200, after: 100 }
                }
            },
            {
                id: "Normal",
                name: "Normal",
                quickFormat: true,
                run: {
                    font: "Source Sans 3",
                    size: 22,
                    color: "333333"
                },
                paragraph: {
                    spacing: { before: 120, after: 120, line: 360 }
                }
            }
        ]
    }
});

Packer.toBuffer(doc).then((buffer) => {
    fs.writeFileSync(docxPath, buffer);
    console.log(`¡Éxito! El archivo DOCX profesional se guardó en: ${docxPath}`);
}).catch((err) => {
    console.error("Error al generar el archivo DOCX:", err);
});
