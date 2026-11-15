import './qz-tray';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-qz-printer-settings]');
    const discoverButton = document.querySelector('[data-qz-discover-printers]');
    const status = document.querySelector('[data-qz-printer-status]');

    if (!form || !discoverButton || !status) {
        return;
    }

    discoverButton.addEventListener('click', async () => {
        discoverButton.disabled = true;
        status.textContent = 'جارٍ البحث عن الطابعات...';

        try {
            if (!window.qz.websocket.isActive()) {
                await window.qz.websocket.connect();
            }

            const printers = await window.qz.printers.find();
            if (!printers.length) {
                status.textContent = 'لم يتم العثور على طابعات. تأكد من تثبيت QZ Tray وتعريف الطابعات.';
                return;
            }

            const datalist = form.querySelector('datalist');
            datalist.replaceChildren(...printers.map((printer) => {
                const option = document.createElement('option');
                option.value = printer;
                return option;
            }));
            status.textContent = 'تم العثور على ' + printers.length + ' طابعة.';
        } catch (error) {
            console.error('Unable to discover QZ Tray printers.', error);
            status.textContent = error.message || 'تعذر الاتصال بـ QZ Tray.';
        } finally {
            discoverButton.disabled = false;
        }
    });
});
