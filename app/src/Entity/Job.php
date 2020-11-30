<?php

declare(strict_types=1);


namespace App\Entity;


class Job implements JobInterface
{
    private $id;

    /**
     * @var TaskInterface[]
     */
    private $tasks;

    /**
     * Job constructor.
     * @param $id
     * @param TaskInterface[] $tasks
     */
    public function __construct($id, array $tasks)
    {
        $this->id = $id;
        $this->tasks = $tasks;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TaskInterface[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }


}
