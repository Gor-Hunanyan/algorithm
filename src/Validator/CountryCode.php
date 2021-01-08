<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class CountryCode extends Constraint
{
    public $message = ' "{{ string }}" is invalid country code.';
}
