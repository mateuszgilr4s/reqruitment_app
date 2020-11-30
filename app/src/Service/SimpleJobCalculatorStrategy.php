<?php

declare(strict_types=1);


namespace App\Service;


use App\Entity\Job;
use App\Entity\JobInterface;

class SimpleJobCalculatorStrategy implements JobCalculatorStrategyInterface
{

    public function supports(JobInterface $job)
    {
        return get_class($job) === Job::class;
    }

    /**
     * @param JobInterface|Job $job
     */
    public function calculateTime(JobInterface $job)
    {
        $time = 0;

        foreach ($job->getTasks() as $task) {
            $time += $task->getTime();
        }

        return $time;
    }
}
