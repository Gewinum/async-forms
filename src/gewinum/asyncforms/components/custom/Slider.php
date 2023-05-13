<?php

namespace gewinum\asyncforms\components\custom;

use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;

class Slider extends FormComponent implements IValidateComponent
{
    public function __construct(
        public string $text,
        public int $min,
        public int $max,
        public ?int $step = null,
        public ?int $default = null
    )
    {}

    public function serialize(): array
    {
        $data = [
            "type" => "slider",
            "text" => $this->text,
            "min" => $this->min,
            "max" => $this->max,
        ];

        if (isset($this->step)) {
            $data["step"] = $this->step;
        }

        if (isset($this->default)) {
            $data["default"] = $this->default;
        }

        return $data;
    }

    public function validateInput(mixed $input): bool
    {
        return (is_int($input) or is_float($input)) and $input >= $this->min and $input <= $this->max;
    }
}