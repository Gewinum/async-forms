<?php

namespace gewinum\asyncforms;

use gewinum\asyncforms\responses\IFormResponse;
use gewinum\asyncforms\responses\ModalFormResponse;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

/**
 * @extends BaseForm<ModalFormResponse>
 */
class ModalForm extends BaseForm
{
    public function __construct(
        string $title,
        public string $content,
        public string $buttonYes,
        public string $buttonNo
    )
    {
        $this->setTitle($title);
    }

    public function getType(): string
    {
        return FormTypes::MODAL;
    }

    public function serializeForm(): array
    {
        return [
            "content" => $this->content,
            "button1" => $this->buttonYes,
            "button2" => $this->buttonNo
        ];
    }

    public function produceResponse(Player $player, mixed $data): IFormResponse
    {
        if (is_null($data)) {
            return new ModalFormResponse(null);
        }

        if (!is_bool($data)) {
            throw new FormValidationException("Response of ModalForm has to be boolean");
        }

        return new ModalFormResponse($data);
    }
}