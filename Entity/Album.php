<?php

namespace App\Entity;

class Album extends Model
{
    public int $id;
    /**
     * @param ?string $albumGroup
     * @param ?string $albumType
     * @param Artist[] $artists
     * @param string[] $availableMarkets
     * @param ExternalUrl $externalUrls
     * @param string $href
     * @param string $albumId
     * @param Image[] $images
     * @param string $name
     * @param string $releaseDate
     * @param string $releaseDatePrecision
     * @param int $totalTracks
     * @param string $type
     * @param string $uri
     */
    public function __construct(
        public ?string $albumGroup,
        public ?string $albumType,
        public array $artists,
        public array $availableMarkets,
        public ExternalUrl $externalUrls,
        public string $href,
        public string $albumId,
        public array $images,
        public string $name,
        public string $releaseDate,
        public string $releaseDatePrecision,
        public int $totalTracks,
        public string $type,
        public string $uri,
    )
    {
        $this->table = 'album';
    }

    /**
     * @return string | null
     */
    public function getAlbumGroup(): string | null
    {
        return $this->albumGroup;
    }

    /**
     * @return string | null
     */
    public function getAlbumType(): string | null
    {
        return $this->albumType;
    }

    /**
     * @return Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @return string[]
     */
    public function getAvailableMarkets(): array
    {
        return $this->availableMarkets;
    }

    /**
     * @return ExternalUrl
     */
    public function getExternalUrls(): ExternalUrl
    {
        return $this->externalUrls;
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
    public function getAlbumId(): string
    {
        return $this->albumId;
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
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @return string
     */
    public function getReleaseDatePrecision(): string
    {
        return $this->releaseDatePrecision;
    }

    /**
     * @return int
     */
    public function getTotalTracks(): int
    {
        return $this->totalTracks;
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
     * @param string | null $albumGroup
     * @return self
     */
    public function setAlbumGroup(string | null $albumGroup): self
    {
        $this->albumGroup = $albumGroup;
        return $this;
    }

    /**
     * @param string | null $albumType
     * @return self
     */
    public function setAlbumType(string | null $albumType): self
    {
        $this->albumType = $albumType;
        return $this;
    }

    /**
     * @param Artist[] $artists
     * @return self
     */
    public function setArtists(array $artists): self
    {
        $this->artists = $artists;
        return $this;
    }

    /**
     * @param string[] $availableMarkets
     * @return self
     */
    public function setAvailableMarkets(array $availableMarkets): self
    {
        $this->availableMarkets = $availableMarkets;
        return $this;
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
     * @param string $href
     * @return self
     */
    public function setHref(string $href): self
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param string $albumId
     * @return self
     */
    public function setId(string $albumId): self
    {
        $this->albumId = $albumId;
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
     * @param string $releaseDate
     * @return self
     */
    public function setReleaseDate(string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @param string $releaseDatePrecision
     * @return self
     */
    public function setReleaseDatePrecision(string $releaseDatePrecision): self
    {
        $this->releaseDatePrecision = $releaseDatePrecision;
        return $this;
    }

    /**
     * @param int $totalTracks
     * @return self
     */
    public function setTotalTracks(int $totalTracks): self
    {
        $this->totalTracks = $totalTracks;
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
            $data['album_group'] ?? null,
            $data['album_type'] ?? null,
            array_map(static function($data) {
                return Artist::fromJson($data);
            }, $data['spotify'] ?? []),
            $data['available_markets'] ?? [],
            ExternalUrl::fromJson($data['external_urls']),
            $data['href'],
            $data['id'],
            array_map(static function($data) {
                return Image::fromJson($data);
            }, $data['images']),
            $data['name'],
            $data['release_date'],
            $data['release_date_precision'],
            $data['total_tracks'],
            $data['type'],
            $data['uri']
        );
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromJsonDB(array $data): self
    {
        return new self(
            $data['albumGroup'] ?? null,
            $data['albumType'] ?? null,
            array_map(static function($data) {
                return Artist::fromJson($data);
            }, $data['spotify'] ?? []),
            json_decode($data['availableMarkets'], true) ?? [],
            ExternalUrl::fromJson(json_decode($data['externalUrls'], true)),
            $data['href'],
            $data['albumId'],
            array_map(static function($data) {
                return Image::fromJson($data);
            }, json_decode($data['images'], true)),
            $data['name'],
            $data['releaseDate'],
            $data['releaseDatePrecision'],
            $data['totalTracks'],
            $data['type'],
            $data['uri']
        );
    }

    /**
     * @return self
     */
    public static function createEmptyAlbum(): self
    {
        return new self(
            '',
            '',
            [],
            [],
            new ExternalUrl(''),
            '',
            '',
            [],
            '',
            '',
            '',
            0,
            '',
            ''
        );
    }
}