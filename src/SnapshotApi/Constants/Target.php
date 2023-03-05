<?php

declare(strict_types=1);

namespace NicoNicoApi\SnapshotApi\Constants;

class Target
{
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const TAGS = 'tags';
    public const TAGS_EXACT = 'tagsExact';

    public const ALL = [
        self::TITLE,
        self::DESCRIPTION,
        self::TAGS
    ];
}
