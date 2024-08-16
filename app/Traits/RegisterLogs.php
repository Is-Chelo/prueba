<?php

namespace App\Traits;

use App\Exceptions\BadRequestException;
use App\Exceptions\CustomException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Models\HandleError;
use App\Services\ApiResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

trait RegisterLogs
{
    public function log(Exception $exception)
    {
        if ($exception instanceof CustomException) {
            $message = substr($exception->getMessage(), 0, 1500);
            return $this->handleValidationsException($message);
        } elseif ($exception instanceof ValidationException) {
            $message = substr($exception->getMessage(), 0, 1500);
            $formatted_errors = [];
            $errors = $exception->errors();
            foreach ($errors as $error) {
                $formatted_errors[] = $error[0];
            }
            return $this->handleFormValidationException($message, $formatted_errors);
        } elseif ($exception instanceof UnauthorizedException) {

            $message = substr($exception->getMessage(), 0, 1500);
            return $this->handleValidationsException($message);
        } elseif ($exception instanceof NotFoundException) {

            $message = substr($exception->getMessage(), 0, 1500);
            return $this->handleNotFoundException($message);
        } elseif ($exception instanceof ForbiddenException) {

            $message = substr($exception->getMessage(), 0, 1500);
            return $this->handleNotForbiddenException($message);
        } elseif ($exception instanceof BadRequestException) {
            $message = substr($exception->getMessage(), 0, 1500);
            return $this->handleBadRequestException($message);
        } else {
            $message = $exception->getMessage();
            return $this->handleGeneralException($exception, $message);
        }
    }

    private function handleValidationsException($message)
    {
        return ApiResponseService::error($message, [$message]);
    }

    private function handleFormValidationException($message = 'Hubo un problema.', $errors)
    {
        return ApiResponseService::error($message, $errors);
    }

    private function handleUnauthorizedException($message)
    {
        return ApiResponseService::unauthorized($message);
    }

    private function handleNotFoundException($message)
    {
        return ApiResponseService::not_found($message, [$message]);
    }

    private function handleNotForbiddenException($message)
    {
        return ApiResponseService::forbidden($message, [$message]);
    }

    private function handleBadRequestException($message)
    {
        return ApiResponseService::badRequest($message, [$message]);
    }


    private function handleGeneralException(Exception $exception, $message)
    {

        if (config('app.debug') == true) {
            Log::info($exception);
            return ApiResponseService::error(message: $message, errors: [[
                'code'  => $exception->getCode(),
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'url'   => request()->url(),
            ]], code: 500);
        } else {
            Log::info($exception);
            return ApiResponseService::error(message: 'Error. en el Servidor', errors: ["Error en el Servidor"], code: 500);
        }
    }
}
