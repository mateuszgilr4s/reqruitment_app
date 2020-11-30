<?php

declare(strict_types=1);


namespace App\Controller;

use App\Entity\AnalyseAgreementTask;
use App\Entity\CompositeJob;
use App\Entity\Job;
use App\Entity\ProposalCreationTask;
use App\Factory\JobTimeCalculatorFactory;
use App\Repository\JobRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController
{
    /**
     * @Route("/")
     */
    public function index(JobRepository $jobRepository, JobTimeCalculatorFactory  $calculatorFactory)
    {
        $job = $jobRepository->getJob();
        $calculator = $calculatorFactory->createCalculator();

        $time = $calculator->calculateTime($job);

        return new Response("$time");
    }
}
