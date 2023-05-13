<?php

namespace gewinum\asyncforms\components\custom;

use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;

class Toggle extends FormComponent implements IValidateComponent
{
    public function __construct(
        private string $text,
        private ?bool $default = null
    )
    {
    }

    public function serialize(): array
    {
        $data = [
            "type" => "toggle",
            "text" => $this->text
        ];

        if (isset($this->default)) {
            $data["default"] = $this->default;
        }

        return $data;
    }

    public function validateInput(mixed $input): bool
    {
        return is_bool($input);
    }
}