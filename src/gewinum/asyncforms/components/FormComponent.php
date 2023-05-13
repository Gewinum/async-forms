<?php

namespace gewinum\asyncforms\components;

abstract class FormComponent
{
    abstract public function serialize(): array;
}