<?php

declare(strict_types=1);


namespace App\Entity;


class AnalyseAgreementTask implements TaskInterface
{
    private $id;

    public function getTime()
    {
        return 10;
    }

    public function getName()
    {
        return "analyse agreement";
    }

    public function getDescription()
    {
        return "very important task";
    }


}
