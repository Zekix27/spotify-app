<?php

namespace App\Entity;

class Artist extends Model
{
    public int $id;
    /**
     * @param ExternalUrl $externalUrls
     * @param Follower|null $followers
     * @param string[] $genres
     * @param string $href
     * @param string $artistId
     * @param Image[] $images
     * @param string $name
     * @param int|null $popularity
     * @param string $type
     * @param string $uri
     */
    public function __construct(
        public ExternalUrl $externalUrls,
        public ?Follower $followers,
        public array $genres,
        public string $href,
        public string $artistId,
        public array $images,
        public string $name,
        public ?int $popularity,
        public string $type,
        public string $uri,
        )
    {
        $this->table = 'artist';
    }

    /**
     * @return ExternalUrl
     */
    public function getExternalUrls(): ExternalUrl
    {
        return $this->externalUrls;
    }

    /**
     * @return Follower
     */
    public function getFollowers(): Follower
    {
        return $this->followers;
    }

    /**
     * @return string[]
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getArtistId(): string
    {
        return $this->artistId;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPopularity(): int
    {
        return $this->popularity;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param ExternalUrl $externalUrls
     * @return self
     */
    public function setExternalUrls(ExternalUrl $externalUrls): self
    {
        $this->externalUrls = $externalUrls;
        return $this;
    }

    /**
     * @param Follower $followers
     * @return self
     */
    public function setFollowers(Follower $followers): self
    {
        $this->followers = $followers;
        return $this;
    }

    /**
     * @param string[] $genres
     * @return self
     */
    public function setGenres(array $genres): self
    {
        $this->genres = $genres;
        return $this;
    }

    /**
     * @param string $href
     * @return self
     */
    public function setHref(string $href): self
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param string $artistId
     * @return self
     */
    public function setArtistId(string $artistId): self
    {
        $this->artistId = $artistId;
        return $this;
    }

    /**
     * @param Image[] $images
     * @return self
     */
    public function setImages(array $images): self
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $popularity
     * @return self
     */
    public function setPopularity(int $popularity): self
    {
        $this->popularity = $popularity;
        return $this;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromJson(array $data): self
    {
        return new self(
            ExternalUrl::fromJson($data['external_urls']),
            isset($data['followers']) ? Follower::fromJson($data['followers']) : null,
            $data['genres'] ?? [],
            $data['href'],
            $data['id'],
            array_map(static function($data) {
                return Image::fromJson($data);
            }, $data['images'] ?? []),
            $data['name'],
            $data['popularity'] ?? null,
            $data['type'],
            $data['uri']
        );
    }

    /**
     * @return self
     */
    public static function createEmptyArtist(): self
    {
        return new self(
            new ExternalUrl(''),
            null,
            [],
            '',
            '',
            [],
            '',
            null,
            '',
            ''
        );
    }
}