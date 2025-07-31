<?php

namespace App\Application\Contracts;

interface BySearchFilterDataInterface
{
    public function getSkip(): ?int;
    public function getTake(): ?int;
}
