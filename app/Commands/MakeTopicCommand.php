<?php

namespace App\Commands;

use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\PubSubClient;
use App\Concerns\GetProjectIdConcern;
use App\Contracts\PubSubClientContract;
use LaravelZero\Framework\Commands\Command;

class MakeTopicCommand extends Command
{
    use GetProjectIdConcern;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:topic
                            {topic : Topic Name}
                            {--P|project_id= : Your project ID}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create A topic';

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
        $topic = $this->getTopic($client->getClient(), $this->argument('topic'));
        $this->info("Successfully created new topic [${topic}]");
    }

    protected function getTopic(PubSubClient $client, $topicName) : string
    {
        return $this->createTopic($client, $topicName)->name();
    }

    protected function createTopic(PubSubClient $client, $topicName) : Topic
    {
        return $client->createTopic($topicName, $this->getProjectId());
    }
}
