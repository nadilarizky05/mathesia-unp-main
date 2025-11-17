<?php

namespace App\Exceptions;

use Exception;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Render extends Exception
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof HttpException) {
            $status = $e->getStatusCode();

            if (in_array($status, [403, 404, 500])) {
                return Inertia::render("Errors/{$status}", [
                    'status' => $status
                ])->toResponse($request)
                  ->setStatusCode($status);
            }
        }

        throw $e;
    }
}