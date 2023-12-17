<?php
namespace App\Http\Traits;


use Illuminate\Http\JsonResponse;

trait ApiStatus
{
    protected int $successStatus = 200;
    protected int $failureStatus = 100;

    public function successResponse($response): JsonResponse
    {
        return response()->json(['meta' => array('status' => $this->successStatus), 'response' => $response]);
    }

    public function failureResponse($response): JsonResponse
    {
        return response()->json(['meta' => array('status' => $this->failureStatus), 'response' => $response]);
    }
}
