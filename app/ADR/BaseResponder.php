<?php

namespace App\ADR;

use App\ADR\Domain\Enums\ResponseLevel;
use Illuminate\Http\JsonResponse;

abstract class BaseResponder
{
    /**
     * Respond with data
     *
     * @param array $data
     * @param string $status
     * @param ResponseLevel $level
     * @param int $httpStatus
     * @return JsonResponse
     */
    public function respondWithData(
        array $data,
        string $status = 'SUCCESS',
        ResponseLevel $level = ResponseLevel::INFO,
        int $httpStatus = 200
    ): JsonResponse
    {
        return response()->json($this->getBaseResponse(
            status: $status,
            level: $level,
            data: $data
        ), $httpStatus);
    }

    /**
     * Respond with error
     *
     * @param \BackedEnum $status
     * @param ResponseLevel $level
     * @param int $httpStatus
     * @return JsonResponse
     */
    public function respondWithError(
        \BackedEnum $status,
        ResponseLevel $level = ResponseLevel::ERROR,
        int $httpStatus = 400
    ): JsonResponse
    {
        return response()->json($this->getBaseResponse(
            status: $status->value,
            level: $level,
            data: null
        ), $httpStatus);
    }

    /**
     * Get base response
     *
     * @param string $status
     * @param ResponseLevel $level
     * @param array|null $data
     * @return array
     */
    private function getBaseResponse(
        string $status,
        ResponseLevel $level,
        ?array $data
    ): array
    {
        return [
            'status' => $status,
            'level' => $level,
            'data' => $data ?? [],
            'errors' => null
        ];
    }
}

