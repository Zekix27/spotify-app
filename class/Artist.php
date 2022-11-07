<?php

namespace App\Entity;

class Artist {

public function __construct(
    public ?string $name,
    public ?string $id,
    public ?int $followers,
    public array $genders = [],
    public ?string $linked,
    public ?string $picture,
) {}

    /**
     * @return string|null
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getFollowers(): ?int
    {
        return $this->followers;
    }

    /**
     * @param int|null $followers
     */
    public function setFollowers(?int $followers): void
    {
        $this->followers = $followers;
    }

    /**
     * @return array
     */
    public function getGenders(): array
    {
        return $this->genders;
    }

    /**
     * @param array $genders
     */
    public function setGenders(array $genders): void
    {
        $this->genders = $genders;
    }

    /**
     * @return string|null
     */
    public function getLinked(): ?string
    {
        return $this->linked;
    }

    /**
     * @param string|null $linked
     */
    public function setLinked(?string $linked): void
    {
        $this->linked = $linked;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     */
    public function setPicture(?string $picture): void
    {
        $this->picture = $picture;
    }

    public function display(Artist $artist) {
        echo '<div class="col">
                    <div class="card shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#55595c"></rect>
                    </svg>

                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted"></small>
                            </div>
                        </div>
                    </div>
                </div>';
    }
}