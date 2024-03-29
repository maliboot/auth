<?php

declare(strict_types=1);

namespace MaliBoot\Auth\Exception\Handler;

use MaliBoot\Auth\Exception\UnauthorizedException;
use MaliBoot\ErrorCode\Constants\ServerErrorCode;
use MaliBoot\ExceptionHandler\Handler\AbstractExceptionHandler;
use Psr\Http\Message\ResponseInterface;

class AuthExceptionHandler extends AbstractExceptionHandler
{
    public function handle(\Throwable $throwable, ResponseInterface $response)
    {
        $this->log($throwable, $response);
        [$errCode, $errMessage] = $this->formatError($throwable);
        return $this->response($errCode, $errMessage, $throwable, $response);
    }

    public function isValid(\Throwable $throwable): bool
    {
        return $throwable instanceof UnauthorizedException;
    }

    protected function formatError(\Throwable $throwable): array
    {
        /** @var UnauthorizedException $throwable */
        $errCode = ServerErrorCode::AUTH_SESSION_EXPIRED;

        return [$errCode, $throwable->getMessage()];
    }
}