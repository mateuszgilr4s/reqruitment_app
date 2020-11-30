<?php

declare(strict_types=1);


namespace App\Service;


use App\Entity\JobInterface;

interface JobCalculatorStrategyInterface
{
    public function supports(JobInterface $job);

    public function calculateTime(JobInterface $job);
}
