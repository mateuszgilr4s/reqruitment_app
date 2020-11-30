<?php


namespace App\Entity;


interface TaskInterface
{
    public function getTime();

    public function getName();

    public function getDescription();
}
