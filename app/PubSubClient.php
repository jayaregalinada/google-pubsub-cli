<?php

namespace App;

use App\Contracts\PubSubClientContract;
use Google\Cloud\PubSub\PubSubClient as GPubSubClient;

class PubSubClient implements PubSubClientContract
{
    /**
     * @var \Google\Cloud\PubSub\PubSubClient
     */
    protected $client;

    public function __construct(GPubSubClient $client)
    {
        $this->client = $client;
    }

    public function getClient() : GPubSubClient
    {
        return $this->client;
    }

    public function setProjectId(string $projectId) : PubSubClientContract
    {
        $this->client = new GPubSubClient(compact('projectId'));

        return $this;
    }
}
