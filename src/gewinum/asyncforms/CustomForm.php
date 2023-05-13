<?php

namespace gewinum\asyncforms;

use gewinum\asyncforms\components\custom\Label;
use gewinum\asyncforms\components\custom\Slider;
use gewinum\asyncforms\components\custom\StepSlider;
use gewinum\asyncforms\components\custom\Toggle;
use gewinum\asyncforms\components\FormComponent;
use gewinum\asyncforms\components\IValidateComponent;
use gewinum\asyncforms\responses\CustomFormResponse;
use gewinum\asyncforms\responses\IFormResponse;
use gewinum\asyncforms\responses\ModalFormResponse;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

/**
 * @extends BaseForm<CustomFormResponse>
 */
class CustomForm extends BaseForm
{
    public function __construct(
        string $title,
        private array $components
    )
    {
        $this->setTitle($title);
    }

    public function getType(): string
    {
        return FormTypes::CUSTOM;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function addComponent(FormComponent $component): void
    {
        $this->components[] = $component;
    }

    public function serializeForm(): array
    {
        $contents = [];

        foreach ($this->components as $component) {
            $contents[] = $component->serialize();
        }

        return [
            "content" => $contents
        ];
    }

    public function produceResponse(Player $player, mixed $data): IFormResponse
    {
        if (is_null($data)) {
            return new CustomFormResponse(null);
        }

        if (!is_array($data)) {
            throw new FormValidationException("Response of CustomForm is expected to be array. Got " . gettype($data));
        }

        if (count($data) !== count($this->getComponents())) {
            throw new FormValidationException("Invalid response of CustomForm");
        }

        $componentsKeys = array_keys($this->getComponents());
        $responseData = [];

        for($i = 0; $i < count($data); $i++) {
            $currentKey = $componentsKeys[$i];
            $currentData = $data[$i];

            $currentComponent = $this->getComponents()[$currentKey];

            if ($currentComponent instanceof IValidateComponent) {
                if (!$currentComponent->validateInput($currentData)) {
                    throw new FormValidationException("Couldn't validate custom form");
                }
            }

            $responseData[$currentKey] = $currentData;
        }

        return new CustomFormResponse($responseData);
    }
}