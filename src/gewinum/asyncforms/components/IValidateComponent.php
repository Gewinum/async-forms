<?php

namespace gewinum\asyncforms\components;

interface IValidateComponent
{
    public function validateInput(mixed $input): bool;
}