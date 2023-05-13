<?php

namespace gewinum\asyncforms\components\custom;

use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;

class Label extends FormComponent implements IValidateComponent
{
    public function __construct(
        public string $text
    )
    {
    }

    public function serialize(): array
    {
        return [
            "type" => "label",
            "text" => $this->text
        ];
    }

    public function validateInput(mixed $input): bool
    {
        return is_null($input);
    }
}