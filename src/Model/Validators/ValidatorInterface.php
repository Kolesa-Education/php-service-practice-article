<?php

namespace App\Model\Validators;

interface ValidatorInterface
{
    public function validate(array $data): array;
}