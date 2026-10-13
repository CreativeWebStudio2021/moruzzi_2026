<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCertificate;
use App\Services\ProductCertificateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

class ProductCertificateController extends Controller
{
    public function show(string $code, ProductCertificateService $service)
    {
        $certificate = $service->findByAccessCode($code);

        if (! $certificate) {
            abort(404);
        }

        $product = $certificate->product;

        return view('web.certificazioni.product-certificate', [
            'certificate' => $certificate,
            'product' => $product,
            'productAvailable' => $product !== null,
            'yliumVerifyUrl' => config('product_certificates.ylium_verify_url'),
        ]);
    }

    public function downloadPdf(string $code, ProductCertificateService $service)
    {
        $certificate = $service->findByAccessCode($code);
        if (! $certificate || ! $certificate->pdf_filename) {
            abort(404);
        }

        $path = $certificate->pdfAbsolutePath();
        if (! $path || ! is_file($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$certificate->pdf_filename.'"',
        ]);
    }

    public function verify()
    {
        $hash = request()->query('hash');
        $certificate = null;

        if (is_string($hash) && $hash !== '') {
            $normalized = strtolower(ltrim(trim($hash), '0x'));
            if (preg_match('/^[a-f0-9]{64}$/', $normalized)) {
                $certificate = ProductCertificate::query()
                    ->where('published', true)
                    ->where(function ($q) use ($normalized) {
                        $q->where('pdf_sha256', $normalized)
                            ->orWhere('notarization_hash', '0x'.$normalized)
                            ->orWhere('notarization_hash', $normalized);
                    })
                    ->with('product')
                    ->first();
            }
        }

        return view('web.certificazioni.verify-notarization', [
            'hash' => is_string($hash) ? trim($hash) : '',
            'certificate' => $certificate,
            'yliumVerifyUrl' => config('product_certificates.ylium_verify_url'),
        ]);
    }

    public function generate(Request $request, ProductCertificateService $service): JsonResponse|Response
    {
        try {
            $this->assertToken($request->query('token'));

            $product = Product::query()
                ->where('entity_id', (int) $request->query('product_id'))
                ->firstOrFail();

            $result = $service->generateOrUpdate(
                $product,
                (int) $request->query('registry_number'),
                $request->query('access_code'),
                $request->query('body_override'),
            );
        } catch (RuntimeException $e) {
            return $this->respond($request, [
                'ok' => false,
                'message' => $e->getMessage(),
            ], str_contains(strtolower($e->getMessage()), 'token') ? 403 : 422);
        }

        return $this->respond($request, [
            'ok' => true,
            'created' => $result['created'],
            'url' => $result['url'],
            'access_code' => $result['certificate']->access_code,
            'registry_number' => $result['certificate']->registry_number,
            'body_text' => $result['certificate']->body_text,
            'image_url' => $result['certificate']->imageUrl(),
        ]);
    }

    public function preview(Request $request, ProductCertificateService $service): JsonResponse|Response
    {
        try {
            $this->assertToken($request->query('token'));

            $product = Product::query()
                ->where('entity_id', (int) $request->query('product_id'))
                ->firstOrFail();

            $builder = app(\App\Services\ProductCertificateTextBuilder::class);
            $type = $builder->detectType((string) $product->name, (string) $product->description);
            $registry = (int) $request->query('registry_number');

            $body = trim($builder->build($product));
            if ($registry > 0) {
                $body .= '  '.$builder->legalFooter($registry, $type);
            }

            $existing = ProductCertificate::query()
                ->where('product_id', $product->entity_id)
                ->first();

            return $this->respond($request, [
                'ok' => true,
                'body_text' => $body,
                'existing' => $existing ? [
                    'url' => $existing->publicUrl(),
                    'access_code' => $existing->access_code,
                    'registry_number' => $existing->registry_number,
                ] : null,
            ]);
        } catch (RuntimeException $e) {
            return $this->respond($request, [
                'ok' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    }

    private function assertToken(?string $token): void
    {
        $expected = config('product_certificates.webhook_secret');

        if (! $expected || ! hash_equals((string) $expected, (string) $token)) {
            throw new RuntimeException('Token non valido.');
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function respond(Request $request, array $payload, int $status = 200): JsonResponse|Response
    {
        if ($request->query('format') === 'json' || $request->wantsJson()) {
            return response()->json($payload, $status);
        }

        return response()->view('internal.product-certificate-result', $payload, $status);
    }
}
