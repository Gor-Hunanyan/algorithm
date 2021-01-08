<?php



namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class TimeZone extends Constraint
{
    public $message = ' "{{ string }}" is invalid timezone.';
}
