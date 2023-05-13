<?php

namespace gewinum\asyncforms\components;

class ButtonImage implements \JsonSerializable
{
    public const TYPE_URL = "url";
    public const TYPE_PATH = "path";

    public function __construct(
        public string $type,
        public string $path
    )
    {}

    public function jsonSerialize(): array
    {
        return [
            "type" => $this->type,
            "data" => $this->path
        ];
    }
}