<?php

namespace gewinum\asyncforms;

use gewinum\asyncforms\components\Button;
use gewinum\asyncforms\responses\IFormResponse;
use gewinum\asyncforms\responses\SimpleFormResponse;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use SOFe\AwaitGenerator\GeneratorUtil;

/**
 * @extends BaseForm<SimpleFormResponse>
 */
class SimpleForm extends BaseForm
{
    /**
     * @param string $content
     * @param Button[] $buttons
     */
    public function __construct(
        string $title,
        public string $content,
        public array $buttons = []
    )
    {
        $this->setTitle($title);
    }

    public function getType(): string
    {
        return FormTypes::SIMPLE;
    }

    public function serializeForm(): array
    {
        $data = [
            "content" => $this->content,
            "buttons" => []
        ];

        foreach ($this->buttons as $identifier => $button) {
            $data["buttons"][] = $button->jsonSerialize();
        }

        return $data;
    }

    public function produceResponse(Player $player, mixed $data): IFormResponse
    {
        if (is_null($data)) {
            return new SimpleFormResponse(null);
        }

        if (!is_int($data)) {
            throw new FormValidationException("Response for SimpleForm has to be int");
        }

        $selectedButton = array_keys($this->buttons)[$data] ?? null;

        if (is_null($selectedButton)) {
            throw new FormValidationException("Response of SimpleForm out of bounds");
        }

        return new SimpleFormResponse($selectedButton);
    }
}