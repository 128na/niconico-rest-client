<?php

declare(strict_types=1);

namespace NicoNicoApi\SnapshotApi;

use NicoNicoApi\SnapshotApi\Constants\Field;
use NicoNicoApi\SnapshotApi\Constants\Sort;
use NicoNicoApi\SnapshotApi\Constants\Target;

class Query
{
    /**
     * @var array<int|string|null>
     */
    protected array $options = [
        'q' => null,
        'targets' => Target::ALL,
        'fields' => Field::ALL,
        'filters' => null,
        'jsonFilter' => null,
        '_sort' => Sort::VIEW_COUNTER_DESC,
        '_offset' => 0,
        '_limit' => 10,
        '_context' => 'NicoNicoApi',
    ];


    /**
     * @param array<string|int|null> $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    public function setQ(string $q): void
    {
        $this->options['q'] = $q;
    }

    public function getQ(): ?string
    {
        return $this->options['q'] ?? null;
    }

    /**
     * @param string|array<string> $targets
     */
    public function setTargets(string|array $targets): void
    {
        $this->options['targets'] = is_array($targets) ? implode(',', $targets) : $targets;
    }

    public function getTargets(): ?string
    {
        return $this->options['targets'] ?? null;
    }

    /**
     * @return array<string>
     */
    public function getTargetsAsArray(): array
    {
        return explode(',', $this->options['targets'] ?? []);
    }

    /**
     * @param string|array<string> $fields
     */
    public function setFields(string|array $fields): void
    {
        $this->options['fields'] = is_array($fields) ? implode(',', $fields) : $fields;
    }

    public function getFields(): ?string
    {
        return $this->options['fields'] ?? null;
    }

    /**
     * @return array<string>
     */
    public function getFieldsAsArray(): array
    {
        return explode(',', $this->options['fields'] ?? []);
    }

    /**
     * @param string|array<string> $filters
     */
    public function setFilters(string|array $filters): void
    {
        $this->options['filters'] = is_array($filters) ? implode(',', $filters) : $filters;
    }

    public function getFilters(): ?string
    {
        return $this->options['filters'] ?? null;
    }

    /**
     * @return array<string>
     */
    public function getFiltersAsArray(): array
    {
        return explode(',', $this->options['filters'] ?? []);
    }

    /**
     * @param string|array<string> $jsonFilter
     */
    public function setJsonFilter(string|array|object $jsonFilter): void
    {
        $this->options['jsonFilter'] = is_string($jsonFilter) ? $jsonFilter : json_encode($jsonFilter);
    }

    public function getJsonFilter(): ?string
    {
        return $this->options['jsonFilter'] ?? null;
    }

    /**
     * @return array<string>
     */
    public function getJsonFilterAsArray(): array
    {
        return json_decode($this->options['jsonFilter'] ?? '', true);
    }

    public function getJsonFilterAsObject(): object
    {
        return json_decode($this->options['jsonFilter'] ?? '', false);
    }

    public function setSort(string $sort): void
    {
        $this->options['_sort'] = $sort;
    }

    public function getSort(): ?string
    {
        return $this->options['_sort'] ?? null;
    }

    public function setOffset(int $offset): void
    {
        $this->options['_offset'] = $offset;
    }

    public function getOffset(): ?int
    {
        return $this->options['_offset'] ?? null;
    }

    public function setLimit(int $limit): void
    {
        $this->options['_limit'] = $limit;
    }

    public function getLimit(): ?int
    {
        return $this->options['_limit'] ?? null;
    }

    public function setContext(string $context): void
    {
        $this->options['_context'] = $context;
    }

    public function getContext(): ?string
    {
        return $this->options['_context'] ?? null;
    }

    public function toQueryString(): string
    {
        return http_build_query($this->options);
    }
}
