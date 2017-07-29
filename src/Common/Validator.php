<?php

namespace Hexagonal\Common;


interface Validator
{
    public function isValidFromAssoc(array $assoc);

    public function getErrors();


}