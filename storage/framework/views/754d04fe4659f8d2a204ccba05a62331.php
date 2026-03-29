<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shepherd.js/11.2.0/css/shepherd.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/shepherd.js/11.2.0/js/shepherd.min.js"></script>

<style>
    .shepherd-element {
        border-radius: 0.875rem !important;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3) !important;
        max-width: 320px !important;
    }

    .shepherd-content {
        border-radius: 0.875rem !important;
        padding: 0 !important;
        overflow: hidden;
    }

    .shepherd-header {
        background: #0f172a !important;
        padding: 1rem 1.25rem 0.75rem !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    .shepherd-title {
        font-size: 0.875rem !important;
        font-weight: 700 !important;
        color: #f9fafb !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    .shepherd-cancel-icon {
        color: #6b7280 !important;
        font-size: 1.2rem !important;
    }

    .shepherd-cancel-icon:hover {
        color: #f9fafb !important;
    }

    .shepherd-text {
        background: #0f172a !important;
        padding: 0.875rem 1.25rem !important;
        font-size: 0.8rem !important;
        color: #9ca3af !important;
        line-height: 1.6 !important;
    }

    .shepherd-footer {
        background: #0f172a !important;
        padding: 0.75rem 1.25rem !important;
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }

    .shepherd-button {
        border-radius: 0.5rem !important;
        font-size: 0.775rem !important;
        font-weight: 600 !important;
        padding: 0.4rem 0.875rem !important;
        border: none !important;
        cursor: pointer !important;
        transition: opacity 0.15s !important;
    }

    .shepherd-button:hover {
        opacity: 0.85 !important;
    }

    .shepherd-button-primary {
        background: #fbbf24 !important;
        color: #0f172a !important;
    }

    .shepherd-button-secondary {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #9ca3af !important;
    }

    .shepherd-arrow:before {
        background: #0f172a !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }

    .tour-fab {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 50%;
        background: #fbbf24;
        color: #0f172a;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(251, 191, 36, 0.4);
        z-index: 9999;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .tour-fab:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 24px rgba(251, 191, 36, 0.5);
    }

    .tour-fab svg {
        width: 18px;
        height: 18px;
    }

    .tour-step-counter {
        font-size: 0.68rem;
        color: #4b5563;
        font-weight: 500;
    }
</style>

<button class="tour-fab" onclick="startTour()" title="Iniciar tour">
    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
    </svg>
</button>

<script>
    function startTour() {
        const tour = new Shepherd.Tour({
            useModalOverlay: true,
            defaultStepOptions: {
                scrollTo: {
                    behavior: 'smooth',
                    block: 'center'
                },
                cancelIcon: {
                    enabled: true
                },
                modalOverlayOpeningRadius: 8,
                modalOverlayOpeningPadding: 6,
            }
        });

        const steps = [{
            id: 'bienvenida',
            title: '👋 Bienvenido a RICOX',
            text: 'Este tour te guiará por todas las funciones del sistema. Puedes cerrarlo en cualquier momento con la X.',
            buttons: [{
                text: 'Saltar tour',
                action: tour.cancel,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Empezar →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'escritorio',
            title: '📊 Dashboard Financiero',
            text: 'Aquí tienes un resumen completo de tu situación financiera. Puedes ver tu balance total, ingresos y egresos del mes, ahorro generado, presupuestos, movimientos recientes y estadísticas como tu racha de ahorro y regla 50/30/20. Todo se actualiza automáticamente para darte una visión clara de tu dinero.',
            attachTo: {
                element: '[href*="/admin"]',
                on: 'right'
            },
            buttons: [
                {
                    text: '← Atrás',
                    action: tour.back,
                    classes: 'shepherd-button-secondary'
                },
                {
                    text: 'Siguiente →',
                    action: tour.next,
                    classes: 'shepherd-button-primary'
                },
            ]
        },
        {
            id: 'cuentas',
            title: '🏦 Cuentas',
            text: 'Registra tus cuentas bancarias, billeteras digitales y efectivo. Cada cuenta tiene su propio saldo que se actualiza automáticamente.',
            attachTo: {
                element: '[href*="/cuentas"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'movimientos',
            title: '💸 Movimientos',
            text: 'Registra ingresos y egresos. Puedes asignarles categoría, subcategoría, cuenta y marcarlos como recurrentes para que se ejecuten automáticamente.',
            attachTo: {
                element: '[href*="/movimientos"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'transferencias',
            title: '🔁 Transferencias',
            text: 'Mueve dinero entre tus propias cuentas. El sistema ajusta los saldos de ambas cuentas automáticamente.',
            attachTo: {
                element: '[href*="transferencia"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'presupuestos',
            title: '🎯 Presupuestos',
            text: 'Define límites de gasto por categoría. Recibirás alertas al llegar al 80% y cuando superes el límite.',
            attachTo: {
                element: '[href*="presupuesto"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'metas',
            title: '🏆 Metas de Ahorro',
            text: 'Crea metas con monto objetivo y fecha límite. Lleva el seguimiento de tu progreso y recibe alertas cuando se acerque el vencimiento.',
            attachTo: {
                element: '[href*="/metas"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'deudas',
            title: '💳 Deudas',
            text: 'Registra lo que debes y lo que te deben. Puedes agregar abonos parciales y el sistema calcula automáticamente el saldo pendiente.',
            attachTo: {
                element: '[href*="/deudas"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'recurrentes',
            title: '🔄 Recurrentes',
            text: 'Ejecuta los movimientos recurrentes pendientes. El sistema detecta cuáles corresponden a hoy y actualiza los saldos automáticamente.',
            attachTo: {
                element: '[href*="recurrente"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'reporte-mensual',
            title: '📄 Reporte Mensual',
            text: 'Resumen visual del mes con ingresos, egresos, gastos por categoría y presupuestos. Descárgalo como PDF o exporta como imagen.',
            attachTo: {
                element: '[href*="reporte-mensual"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'reporte-anual',
            title: '📊 Reporte Anual',
            text: 'Análisis completo del año: mejor y peor mes, resumen por mes, top categorías y evolución de cuentas. Exportable a PDF.',
            attachTo: {
                element: '[href*="reporte-anual"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'reporte-cuenta',
            title: '🏦 Reporte por Cuenta',
            text: 'Historial completo de una cuenta específica con movimientos, transferencias y gastos por categoría en un rango de fechas.',
            attachTo: {
                element: '[href*="reporte-por-cuenta"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'reporte-metas-deudas',
            title: '📋 Reporte Metas y Deudas',
            text: 'PDF con el estado de todas tus metas de ahorro y deudas: progreso, montos pendientes y fechas de vencimiento.',
            attachTo: {
                element: '[href*="reporte-metas"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'comparativo-cuentas',
            title: '📑 Comparativo de Cuentas',
            text: 'Compara todas tus cuentas en un solo reporte: saldos, ingresos, egresos, transferencias y top categoría por cuenta.',
            attachTo: {
                element: '[href*="comparativo-cuentas"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'regla-502030',
            title: '📐 Regla 50/30/20',
            text: 'Analiza si cumples la regla de las finanzas personales: 50% necesidades, 30% deseos, 20% ahorro. Con historial de 6 meses.',
            attachTo: {
                element: '[href*="regla"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'gastos-inusuales',
            title: '⚠️ Gastos Inusuales',
            text: 'Detecta automáticamente cuando gastas más del 50% sobre tu promedio histórico en alguna categoría. Con sparklines de 6 meses.',
            attachTo: {
                element: '[href*="gastos-inusuales"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'proyeccion',
            title: '🔮 Proyección de Saldo',
            text: 'Simula cómo estará tu saldo en 3, 6 o 12 meses con 3 escenarios: actual, optimista y pesimista. Exportable a PDF.',
            attachTo: {
                element: '[href*="proyeccion"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'calculadora',
            title: '🧮 Calculadora Financiera',
            text: 'Calcula interés simple y compuesto, cuotas de préstamos con tabla de amortización, tiempo para alcanzar metas y conversión de monedas.',
            attachTo: {
                element: '[href*="calculadora"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'logros',
            title: '🏅 Logros y Nivel',
            text: 'Desbloquea logros por tus hábitos financieros y sube de nivel: Novato, Intermedio, Avanzado, Experto y Master. ¡Comparte tus logros!',
            attachTo: {
                element: '[href*="logros"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'historial-cambio',
            title: '💱 Historial Tipos de Cambio',
            text: 'Visualiza la evolución de USD, EUR, BRL y CLP con gráficos históricos. Las tasas se actualizan automáticamente cada día.',
            attachTo: {
                element: '[href*="historial-tipos"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'comparativa-periodos',
            title: '📅 Comparativa de Períodos',
            text: 'Compara dos períodos de fechas personalizados: ingresos, egresos, ahorro y top 5 categorías de cada período.',
            attachTo: {
                element: '[href*="comparativa-periodo"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'importar',
            title: '📥 Importar Movimientos',
            text: 'Importa movimientos masivamente desde un CSV. Vista previa antes de confirmar, validación fila por fila y descarga de plantilla.',
            attachTo: {
                element: '[href*="importar-movimientos"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },

        {
            id: 'tipos-cambio',
            title: '💱 Tipos de Cambio',
            text: 'Gestiona las tasas de cambio manualmente o actualízalas desde la API. Incluye un simulador de conversión.',
            attachTo: {
                element: '[href*="tipos-cambio"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'categorias',
            title: '🏷️ Categorías',
            text: 'Organiza tus movimientos con categorías y subcategorías personalizadas. Asígnales iconos y colores.',
            attachTo: {
                element: '[href*="categoria"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'backup',
            title: '🗄️ Backup y Restauración',
            text: 'Descarga un backup completo de todos tus datos en JSON o restaura desde un archivo anterior. Solo importa lo que no existe.',
            attachTo: {
                element: '[href*="backup"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'pin',
            title: '🔒 Configurar PIN',
            text: 'Activa un PIN de 6 dígitos para proteger el acceso. Se pedirá al abrir la app y tras inactividad configurable.',
            attachTo: {
                element: '[href*="configurar-pin"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'auditoria',
            title: '🛡️ Auditoría de Seguridad',
            text: 'Revisa el historial de accesos, intentos fallidos, cambios de contraseña y PIN. Te notifica por app y correo ante eventos sospechosos.',
            attachTo: {
                element: '[href*="auditoria"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'activity-logs',
            title: '📋 Activity Logs',
            text: 'Registro de todas las acciones realizadas en el sistema: creaciones, ediciones y eliminaciones con fecha, usuario e IP.',
            attachTo: {
                element: '[href*="activity"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'limpieza',
            title: '🧹 Limpieza de Logs',
            text: 'Elimina logs antiguos para mantener la base de datos limpia. Configura cuántos días conservar. Se ejecuta automáticamente cada mes.',
            attachTo: {
                element: '[href*="limpieza"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'health',
            title: '💚 Health Check',
            text: 'Estado del sistema en tiempo real: base de datos, caché, storage, API de tipos de cambio, scheduler y seguridad.',
            attachTo: {
                element: '[href*="health"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'settings',
            title: '⚙️ Ajustes del Sistema',
            text: 'Personaliza el nombre de la app, logotipos, favicon y configura el modo mantenimiento para pausar el acceso temporalmente.',
            attachTo: {
                element: '[href*="admin/settings"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },

        {
            id: 'perfil',
            title: '👤 Mi Perfil',
            text: 'Actualiza tu nombre, foto de perfil, contraseña y preferencias de idioma y tema de color.',
            attachTo: {
                element: '[href*="my-profile"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'analisis-predictivo',
            title: '🔮 Análisis Predictivo',
            text: 'Predice si cerrarás el mes en positivo o negativo. Muestra velocidad de gasto, días hasta saldo 0 y patrones por día de la semana.',
            attachTo: {
                element: '[href*="analisis-predictivo"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'mapa-calor',
            title: '🗓️ Mapa de Calor',
            text: 'Visualiza tus gastos e ingresos día a día durante todo el año, estilo GitHub. Detecta de un vistazo qué días gastas más.',
            attachTo: {
                element: '[href*="mapa-calor"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'correlaciones',
            title: '📈 Análisis de Correlaciones',
            text: 'Detecta patrones en tus finanzas: qué día gastas más, en qué mes eres más costoso, estacionalidad por trimestre y más.',
            attachTo: {
                element: '[href*="correlaciones"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'score-financiero',
            title: '⭐ Score Financiero',
            text: 'Tu puntuación financiera del 0 al 100. Evalúa ahorro, presupuestos, deudas, metas y consistencia con recomendaciones específicas.',
            attachTo: {
                element: '[href*="score-financiero"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'sesiones-activas',
            title: '🖥️ Sesiones Activas',
            text: 'Ve todos los dispositivos conectados a tu cuenta y cierra sesiones desconocidas con un click.',
            attachTo: {
                element: '[href*="sesiones-activas"]',
                on: 'right'
            },
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Siguiente →',
                action: tour.next,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        {
            id: 'lista-compras',
            title: '🛒 Lista de Compras',
            text: 'Guarda los productos que necesitas comprar con prioridad y precio estimado. Recibirás recordatorios diarios por app y correo hasta marcarlos como comprados.',
            attachTo: { element: '[href*="lista-compras"]', on: 'right' },
            buttons: [
                { text: '← Atrás', action: tour.back, classes: 'shepherd-button-secondary' },
                { text: 'Siguiente →', action: tour.next, classes: 'shepherd-button-primary' },
            ]
        },
        {
            id: 'inflacion',
            title: '📈 Inflación vs Gastos',
            text: 'Compara tus gastos con la inflación peruana del BCRP. Detecta si estás gastando más o menos que lo que la inflación justifica.',
            attachTo: { element: '[href*="inflacion"]', on: 'right' },
            buttons: [
                { text: '← Atrás', action: tour.back, classes: 'shepherd-button-secondary' },
                { text: 'Siguiente →', action: tour.next, classes: 'shepherd-button-primary' },
            ]
        },
        {
            id: 'notas',
            title: '📝 Notas Financieras',
            text: 'Bloc de notas dentro de RICOX. Crea notas, recordatorios e ideas con colores personalizados y fíjalas para tenerlas siempre arriba.',
            attachTo: { element: '[href*="notas"]', on: 'right' },
            buttons: [
                { text: '← Atrás', action: tour.back, classes: 'shepherd-button-secondary' },
                { text: 'Siguiente →', action: tour.next, classes: 'shepherd-button-primary' },
            ]
        },
        {
            id: 'fin',
            title: '✅ ¡Ya conoces RICOX!',
            text: 'Has recorrido todas las funciones. Puedes volver a iniciar este tour en cualquier momento con el botón <strong style="color:#fbbf24">?</strong> en la esquina inferior derecha.',
            buttons: [{
                text: '← Atrás',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: '¡Empezar! 🚀',
                action: tour.complete,
                classes: 'shepherd-button-primary'
            },
            ]
        },
        ];

        steps.forEach((step, index) => {
            const counter = `<span class="tour-step-counter">${index + 1} / ${steps.length}</span>`;
            tour.addStep({
                ...step,
                title: `<span style="flex:1;">${step.title}</span>${counter}`,
                when: {
                    show() {
                        if (step.attachTo) {
                            const el = document.querySelector(step.attachTo.element);
                            if (!el) {
                                this.updateStepOptions({
                                    attachTo: undefined
                                });
                            }
                        }
                    }
                }
            });
        });

        tour.start();
    }
</script><?php /**PATH C:\Users\ricoa\Documents\gestor-finanzas\resources\views/filament/tour.blade.php ENDPATH**/ ?>