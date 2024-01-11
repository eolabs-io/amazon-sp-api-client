<?php

namespace EolabsIo\AmazonSpApiClient\Tests\Unit;

use EolabsIo\AmazonSpApiClient\Models\Endpoint;
use EolabsIo\AmazonSpApiClient\Tests\BaseModelTest;

class EndpointTest extends BaseModelTest
{
    protected function getModelClass()
    {
        return Endpoint::class;
    }
}
