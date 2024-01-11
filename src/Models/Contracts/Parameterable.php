<?php

namespace EolabsIo\AmazonSpApiClient\Models\Contracts;

interface Parameterable
{
    public function toParameters(): array;
}
