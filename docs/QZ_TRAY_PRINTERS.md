# POS printer setup with QZ Tray

The POS can send the customer receipt and kitchen receipt to separate printers
through QZ Tray. Install and run QZ Tray on each POS computer, and install the
target printers in that computer's operating system before configuring them in
**Settings**.

## Signing credentials

QZ Tray requires signed requests for trusted printing. Configure the matching
QZ digital certificate and private key on the application server:

```dotenv
QZ_CERTIFICATE_PATH=/secure/path/qz-digital-certificate.txt
QZ_PRIVATE_KEY_PATH=/secure/path/qz-private-key.pem
QZ_PRIVATE_KEY_PASSPHRASE=
```

The certificate must be trusted by QZ Tray on each POS computer and must match
the private key. Keep the private key and its passphrase outside the repository
and restrict their filesystem permissions to the application account. Restart
the application or refresh its configuration cache after changing these values.

## Select printers

In the admin settings page, choose **Discover printers** on a computer running
QZ Tray, then select the exact operating-system printer name for each field.
Save a customer printer and kitchen printer to enable direct dual-receipt
printing from the POS.

For single-receipt mode, the general receipt is sent to the customer printer.
If printer names are not configured, the POS continues to use the browser's
print dialog. If QZ Tray or signing is unavailable after direct printers have
been configured, the POS reports the failure. Restore QZ Tray or the signing
configuration before retrying the print action.
