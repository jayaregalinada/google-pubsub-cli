<?php

namespace App\Commands;

use Google\Cloud\PubSub\PubSubClient;
use App\Concerns\GetProjectIdConcern;
use Google\Cloud\PubSub\Subscription;
use App\Contracts\PubSubClientContract;
use LaravelZero\Framework\Commands\Command;

class MakeSubscriptionCommand extends Command
{
    use GetProjectIdConcern;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:subscription
                            {subscription : The subscription name}
                            {topic : Topic to subscribe}
                            {--P|project_id= : Your project ID}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a subscription';

    /**
     * Execute the console command.
     *
     * @param \App\Contracts\PubSubClientContract $client
     *
     * @return void
     */
    public function handle(PubSubClientContract $client)
    {
        if ($this->option('project_id') !== null) {
            $client->setProjectId($this->option('project_id'));
        }
        $subscription = $this->getSubscriptionName($client->getClient());
        $this->info("Successfully added new subscription [${subscription}]");
    }

    protected function getSubscriptionName(PubSubClient $client) : string
    {
        $subscription = $this->createSubscription($client, $this->getSubscription(), $this->getTopic());

        return $subscription->name();
    }

    protected function createSubscription(PubSubClient $client, $name, $topic) : Subscription
    {
        return $client->subscribe($name, $topic, $this->getProjectId());
    }

    protected function getTopic() : string
    {
        return $this->argument('topic');
    }

    protected function getSubscription() : string
    {
        return $this->argument('subscription');
    }
}
