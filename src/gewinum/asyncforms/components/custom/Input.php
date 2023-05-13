<?php

namespace gewinum\asyncforms\components\custom;

use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;

class Input extends FormComponent implements IValidateComponent
{
    public function __construct(
        private string $text,
        private ?string $placeholder = null,
        private ?string $default = null
    )
    {
    }

    public function serialize(): array
    {
        $data = [
            "type" => "input",
            "text" => $this->text
        ];

        if (isset($this->placeholder)) {
            $data["placeholder"] = $this->placeholder;
        }

        if (isset($this->default)) {
            $data["default"] = $this->default;
        }

        return $data;
    }

    public function validateInput(mixed $input): bool
    {
        return is_string($input);
    }
}