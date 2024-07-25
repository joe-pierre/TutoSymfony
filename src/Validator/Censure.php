<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Censure extends Constraint
{
    public array $listeDesMotsCensures = ['pute', 'idiote', 'salope', 'doul', 'menteur', 'menteuse', 'xam', 'go', 'ladjoumala'];

    public string $message = 'Ce mot "{{ mot }}" est censuré';
}
