<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QzPrinterController extends Controller
{
    public function certificate(): Response|JsonResponse
    {
        $path = config('qz.certificate_path');

        if (! is_string($path) || ! is_readable($path)) {
            return response()->json([
                'message' => 'QZ Tray signing certificate is not configured on the server.',
            ], 503);
        }

        $certificate = file_get_contents($path);

        if ($certificate === false) {
            Log::error('Unable to read QZ Tray certificate.');

            return response()->json([
                'message' => 'Unable to load the QZ Tray signing certificate.',
            ], 503);
        }

        return response($certificate, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function signature(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'data' => ['required', 'string', 'max:1000000'],
        ]);
        $path = config('qz.private_key_path');

        if (! is_string($path) || ! is_readable($path)) {
            return response()->json([
                'message' => 'QZ Tray signing key is not configured on the server.',
            ], 503);
        }

        $privateKeyContent = file_get_contents($path);

        if ($privateKeyContent === false) {
            Log::error('Unable to read QZ Tray private key.');

            return response()->json([
                'message' => 'Unable to load the QZ Tray signing key.',
            ], 503);
        }

        $privateKey = openssl_pkey_get_private(
            $privateKeyContent,
            (string) config('qz.private_key_passphrase', '')
        );

        if ($privateKey === false) {
            Log::error('Unable to open configured QZ Tray private key.');

            return response()->json([
                'message' => 'Unable to open the QZ Tray signing key.',
            ], 503);
        }

        $signature = '';
        $signed = openssl_sign($validated['data'], $signature, $privateKey, OPENSSL_ALGO_SHA512);
        openssl_pkey_free($privateKey);

        if (! $signed) {
            Log::error('Unable to sign QZ Tray request.');

            return response()->json([
                'message' => 'Unable to sign the QZ Tray request.',
            ], 503);
        }

        return response()->json([
            'signature' => base64_encode($signature),
        ]);
    }
}
