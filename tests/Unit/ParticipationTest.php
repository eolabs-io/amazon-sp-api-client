<?php

namespace EolabsIo\AmazonSpApiClient\Tests\Unit;

use EolabsIo\AmazonSpApiClient\Models\Participation;
use EolabsIo\AmazonSpApiClient\Tests\BaseModelTest;

class ParticipationTest extends BaseModelTest
{

    protected function getModelClass()
    {
        return Participation::class;
    }

}
