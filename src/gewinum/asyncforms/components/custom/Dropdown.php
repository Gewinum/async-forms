<?php

namespace gewinum\asyncforms\components\custom;

use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;

class Dropdown extends FormComponent implements IValidateComponent
{
    public function __construct(
        public string $text,
        public array $options,
        public ?int $default = null
    )
    {}

    public function serialize(): array
    {
        $data = [
            "type" => "dropdown",
            "text" => $this->text,
            "options" => $this->options
        ];

        if (isset($this->default)) {
            $data["default"] = $this->default;
        }

        return $data;
    }

    public function validateInput(mixed $input): bool
    {
        return is_int($input) and isset($this->options[$input]);
    }
}