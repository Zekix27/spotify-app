<?php

namespace App\Entity;

class Follower
{
    /**
     * @param |null $href
     * @param int $total
     */
    public function __construct(
        private $href,
        private int $total
    )
    {
    }

    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param |null $href
     * @return self
     */
    public function setHref($href): self
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param int $total
     * @return self
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromJson(array $data): self
    {
        return new self(
            $data['href'] ?? null,
            $data['total']
        );
    }
}