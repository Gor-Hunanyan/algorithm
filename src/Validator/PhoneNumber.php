<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class PhoneNumber extends Constraint
{
    public $message = ' "{{ string }}" is invalid phone number.';
}
