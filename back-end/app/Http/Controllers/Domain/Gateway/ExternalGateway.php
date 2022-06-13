<?php

namespace App\Http\Controllers\Domain\Gateway;

interface ExternalGateway
{
    public function getMethodCaller(): string;

    public function getHeadersCaller(): array;

    public function urlCaller(): string;

    public function bodyCaller(): string;
}
