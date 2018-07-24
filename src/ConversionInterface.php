<?php

namespace Wearesho\Bobra\Cpa;

/**
 * Interface ConversionInterface
 * @package Wearesho\Bobra\Cpa
 */
interface ConversionInterface
{
    public function getId(): string;

    public function getUser(): int;

    public function getConfig(): array;

    public function getProduct(): ?string;
}
