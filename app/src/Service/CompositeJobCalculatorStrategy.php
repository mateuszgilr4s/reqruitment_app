<?php

declare(strict_types=1);


namespace App\Service;


use App\Entity\CompositeJob;
use App\Entity\JobInterface;

class CompositeJobCalculatorStrategy implements JobCalculatorStrategyInterface
{
    private $jobTimeCalculator;

    /**
     * CompositeJobCalculatorStrategy constructor.
     * @param $jobTimeCalculator
     */
    public function __construct(JobTimeCalculator $jobTimeCalculator)
    {
        $this->jobTimeCalculator = $jobTimeCalculator;
    }


    public function supports(JobInterface $job)
    {
        return get_class($job) === CompositeJob::class;
    }

    /**
     * @param CompositeJob|JobInterface $job
     */
    public function calculateTime(JobInterface $job)
    {
        $time = 0;
        foreach ($job->getJobs() as $job) {
            $time += $this->jobTimeCalculator->calculateTime($job);
        }

        return $time;
    }

}
