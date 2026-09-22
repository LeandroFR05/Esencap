import '../css/estGeneral.css';

// AdminLTE
import 'admin-lte/dist/js/adminlte.js';

// Configuración de la detección de errores del navegador
import './form-validation';

// Sweetalert 2
import Swal from 'sweetalert2';
window.Swal = Swal;

import { formatFecha } from './helpers/formatFecha';
window.formatFecha = formatFecha;
