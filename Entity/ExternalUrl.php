<?php

namespace App\Entity;

class ExternalUrl
{
    /**
     * @param string $spotify
     */
    public function __construct(public string $spotify)
    {
    }

    /**
     * @return string
     */
    public function getSpotify(): string
    {
        return $this->spotify;
    }

    /**
     * @param string $spotify
     * @return self
     */
    public function setSpotify(string $spotify): self
    {
        $this->spotify = $spotify;
        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromJson(array $data): self
    {
        return new self(
            $data['spotify']
        );
    }
}