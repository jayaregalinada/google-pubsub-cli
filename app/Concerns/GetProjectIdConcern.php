<?php

namespace App\Concerns;

trait GetProjectIdConcern
{
    protected function getProjectId() : array
    {
        if ($this->hasOption('project_id')) {
            return [
                'projectId' => $this->option('project_id'),
            ];
        }

        return [];
    }
}
