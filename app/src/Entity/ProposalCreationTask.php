<?php

declare(strict_types=1);


namespace App\Entity;


class ProposalCreationTask implements TaskInterface
{
    public function getTime()
    {
        return 50;
    }

    public function getName()
    {
        return "proposal creation";
    }

    public function getDescription()
    {
       return "even more important";
    }

}
