<?php

namespace App\Contracts;

use Google\Cloud\PubSub\PubSubClient;

interface PubSubClientContract
{
    public function getClient() : PubSubClient;

    public function setProjectId(string $projectId) : self;
}
