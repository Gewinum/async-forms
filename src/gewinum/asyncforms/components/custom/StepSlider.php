<?php

namespace gewinum\asyncforms\components\custom;

use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;

class StepSlider extends FormComponent implements IValidateComponent
{
    public function __construct(
        public string $text,
        public array $steps,
        public ?int $defaultIndex = null
    )
    {
    }

    public function serialize(): array
    {
        $data = [
            "type" => "step_slider",
            "text" => $this->text,
            "steps" => $this->steps
        ];

        if (isset($this->defaultIndex)) {
            $data["default"] = $this->defaultIndex;
        }

        return $data;
    }

    public function validateInput(mixed $input): bool
    {
        return isset($input) and isset($this->steps[$input]);
    }
}