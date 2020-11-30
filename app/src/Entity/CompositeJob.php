<?php

declare(strict_types=1);


namespace App\Entity;


class CompositeJob implements JobInterface
{
    private $id;
    private $jobs;

    /**
     * CompositeJob constructor.
     * @param $id
     * @param $jobs
     */
    public function __construct($id, $jobs)
    {
        $this->id = $id;
        $this->jobs = $jobs;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    public function addJob($job)
    {
        $this->jobs[] = $job;
    }
}
