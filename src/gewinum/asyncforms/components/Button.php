<?php

namespace gewinum\asyncforms\components;

class Button implements \JsonSerializable
{
    public function __construct(
        public string $text,
        public ?ButtonImage $image = null
    )
    {}

    public function jsonSerialize(): array
    {
        $data = [
            "text" => $this->text
        ];

        if (isset($this->image)) {
            $data["image"] = $this->image->jsonSerialize();
        }

        return $data;
    }
}