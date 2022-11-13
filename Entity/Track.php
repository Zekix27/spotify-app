<?php

namespace App\Entity;

class Track extends Model
{
    public int $id;
    /**
     * @param Artist[] $artists
     * @param string[] $availableMarkets
     * @param int $discNumber
     * @param int $durationMs
     * @param bool $explicit
     * @param ExternalUrl $externalUrls
     * @param string $href
     * @param string $trackId
     * @param bool $isLocal
     * @param string $name
     * @param string | null $previewUrl
     * @param int $trackNumber
     * @param string $type
     * @param string $uri
     */
    public function __construct(
        public array $artists,
        public array $availableMarkets,
        public int $discNumber,
        public int $durationMs,
        public bool $explicit,
        public ExternalUrl $externalUrls,
        public string $href,
        public string $trackId,
        public bool $isLocal,
        public string $name,
        public string | null $previewUrl,
        public int $trackNumber,
        public string $type,
        public string $uri,
    )
    {
        $this->table = 'track';
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
     * @return int
     */
    public function getDiscNumber(): int
    {
        return $this->discNumber;
    }

    /**
     * @return int
     */
    public function getDurationMs(): int
    {
        return $this->durationMs;
    }

    /**
     * @return bool
     */
    public function getExplicit(): bool
    {
        return $this->explicit;
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
    public function getTrackId(): string
    {
        return $this->trackId;
    }

    /**
     * @return bool
     */
    public function getIsLocal(): bool
    {
        return $this->isLocal;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string | null
     */
    public function getPreviewUrl(): string | null
    {
        return $this->previewUrl;
    }

    /**
     * @return int
     */
    public function getTrackNumber(): int
    {
        return $this->trackNumber;
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
     * @param int $discNumber
     * @return self
     */
    public function setDiscNumber(int $discNumber): self
    {
        $this->discNumber = $discNumber;
        return $this;
    }

    /**
     * @param int $durationMs
     * @return self
     */
    public function setDurationMs(int $durationMs): self
    {
        $this->durationMs = $durationMs;
        return $this;
    }

    /**
     * @param bool $explicit
     * @return self
     */
    public function setExplicit(bool $explicit): self
    {
        $this->explicit = $explicit;
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
     * @param string $trackId
     * @return self
     */
    public function setId(string $trackId): self
    {
        $this->trackId = $trackId;
        return $this;
    }

    /**
     * @param bool $isLocal
     * @return self
     */
    public function setIsLocal(bool $isLocal): self
    {
        $this->isLocal = $isLocal;
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
     * @param string | null $previewUrl
     * @return self
     */
    public function setPreviewUrl(string | null $previewUrl): self
    {
        $this->previewUrl = $previewUrl;
        return $this;
    }

    /**
     * @param int $trackNumber
     * @return self
     */
    public function setTrackNumber(int $trackNumber): self
    {
        $this->trackNumber = $trackNumber;
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
            array_map(static function($data) {
                return Artist::fromJson($data);
            }, $data['spotify'] ?? []),
            $data['available_markets'],
            $data['disc_number'],
            $data['duration_ms'],
            $data['explicit'],
            ExternalUrl::fromJson($data['external_urls']),
            $data['href'],
            $data['id'],
            $data['is_local'],
            $data['name'],
            $data['preview_url'],
            $data['track_number'],
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
            array_map(static function($data) {
                return Artist::fromJson($data);
            }, $data['spotify'] ?? []),
            json_decode($data['availableMarkets'], true),
            $data['discNumber'],
            $data['durationMs'],
            $data['explicit'],
            ExternalUrl::fromJson(json_decode($data['externalUrls'], true)),
            $data['href'],
            $data['trackId'],
            $data['isLocal'],
            $data['name'],
            $data['previewUrl'],
            $data['trackNumber'],
            $data['type'],
            $data['uri']
        );
    }

    /**
     * @return self
     */
    public static function createEmptyTrack(): self
    {
        return new self(
            [],
            [],
            0,
            0,
            false,
            new ExternalUrl(''),
            '',
            '',
            false,
            '',
            null,
            0,
            '',
            ''
        );
    }
}