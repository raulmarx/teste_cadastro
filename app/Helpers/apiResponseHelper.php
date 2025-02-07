<?php 
namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ApiResponseHelper
{
    public static function executeWithApiResponse(callable $callback, int $successStatusCode = 200): JsonResponse
    {
        try {
            return response()->json($callback(), $successStatusCode);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Operation failed', 'message' => $e->getMessage()], 500);
        }
    }
}
