import qz from 'qz-tray';

window.qz = qz;

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
const certificateUrl = document.querySelector('meta[name="qz-certificate-url"]')?.content;
const signatureUrl = document.querySelector('meta[name="qz-signature-url"]')?.content;

qz.security.setCertificatePromise((resolve, reject) => {
    fetch(certificateUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin',
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Unable to load the QZ Tray certificate.');
            }

            return response.text();
        })
        .then(resolve)
        .catch(reject);
});

qz.security.setSignaturePromise((dataToSign) => (resolve, reject) => {
    fetch(signatureUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
        body: JSON.stringify({ data: dataToSign }),
    })
        .then(async (response) => {
            const result = await response.json();
            if (!response.ok) {
                throw new Error(result.message || 'Unable to sign the QZ Tray request.');
            }

            return result.signature;
        })
        .then(resolve)
        .catch(reject);
});
