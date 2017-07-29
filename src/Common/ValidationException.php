<?php

namespace Hexagonal\Common;


class ValidationException extends \Exception
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * ValidationException constructor.
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->validator->getErrors();
    }
    
    
}
