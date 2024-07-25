<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CensureValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Censure $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $value = strtolower($value);
        $wordGroups = explode(' ', $value);

        foreach ($constraint->listeDesMotsCensures as $motCensure) {
            if (in_array($motCensure, $wordGroups)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ mot }}', $motCensure)
                    ->addViolation();
            }
        }

        
    }
}
