<?php

namespace EolabsIo\AmazonSpApiClient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class AmazonSpApiClientModel extends Model
{
    use HasFactory;

    /**
     * Get the current connection name for the model.
     *
     * @return string|null
     */
    public function getConnectionName()
    {
        return config('amazon-sp-api-client.database.connection') ?? $this->connection;
    }
}
