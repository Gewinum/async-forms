<?php

namespace gewinum\asyncforms;

use gewinum\asyncforms\responses\IFormResponse;
use pocketmine\form\Form;
use pocketmine\player\Player;
use SOFe\AwaitGenerator\GeneratorUtil;
use SOFe\AwaitGenerator\Mutex;

/**
 * @template T
 * @template-implements IFormResponse
 */
abstract class BaseForm implements Form
{
    private ?IFormResponse $response = null;

    private string $title = "";

    private ?Mutex $mutex = null;

    abstract public function getType(): string;

    abstract public function serializeForm(): array;

    abstract public function produceResponse(Player $player, mixed $data);

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return T|null
     */
    public function getResponse(): ?IFormResponse
    {
        return $this->response;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function awaitForResponse(): \Generator
    {
        if (!isset($this->mutex)) {
            $this->mutex = new Mutex;
            yield from $this->mutex->acquire();
        }

        yield from $this->mutex->run(GeneratorUtil::empty());
    }

    public final function jsonSerialize(): array
    {
        return array_merge($this->serializeForm(),
        [
            "type" => $this->getType(),
            "title" => $this->getTitle()
        ]);
    }

    public final function handleResponse(Player $player, $data): void
    {
        $this->response = $this->produceResponse($player, $data);

        if (isset($this->mutex)) {
            $this->mutex->release();
        }
    }
}