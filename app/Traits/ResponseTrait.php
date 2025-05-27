<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ResponseTrait
{
    /**
     * Summary of toResponse
     * @param mixed $code
     * @param mixed $message
     * @param array|object|null $data
     * @param mixed $ttl
     * @param mixed $headers
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function toResponse(?int $code = 200, ?string $message = null, array|object|null $data = null, ?array $headers = null, ?array $meta = null): JsonResponse
    {
        $response = [
            'status' => $code,
            'message' => $message ?? null
        ];

        if ($message === null) {
            unset($response['message']);
        }

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!is_null($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json(
            data: $response,
            status: $code,
            headers: $headers ?? []
        );
    }
}
