@auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (sessionStorage.getItem('ricox_notif_checked')) return;
            sessionStorage.setItem('ricox_notif_checked', '1');

            fetch('/ricox/verificar-notificaciones', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
                    'Content-Type': 'application/json',
                }
            });

            if (!sessionStorage.getItem('logros_verificados')) {
                sessionStorage.setItem('logros_verificados', '1');
                fetch('/ricox/verificar-logros', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
            }
        });

        const mesActual = new Date().getFullYear() + '_' + (new Date().getMonth() + 1);
        if (sessionStorage.getItem('gastos_inusuales') !== mesActual) {
            sessionStorage.setItem('gastos_inusuales', mesActual);
            fetch('/ricox/verificar-gastos-inusuales', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
        }
    </script>
@endauth
