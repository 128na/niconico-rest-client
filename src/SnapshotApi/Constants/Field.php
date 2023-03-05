<?php

declare(strict_types=1);

namespace NicoNicoApi\SnapshotApi\Constants;

class Field
{
    public const CONTENT_ID = 'contentId';
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const USER_ID = 'userId';
    public const CHANNEL_ID = 'channelId';
    public const VIEW_COUNTER = 'viewCounter';
    public const MYLIST_COUNTER = 'mylistCounter';
    public const LIKE_COUNTER = 'likeCounter';
    public const LENGTH_SECONDS = 'lengthSeconds';
    public const THUMBNAIL_URL = 'thumbnailUrl';
    public const START_TIME = 'startTime';
    public const LAST_RES_BODY = 'lastResBody';
    public const COMMENT_COUNTER = 'commentCounter';
    public const LAST_COMMENT_TIME = 'lastCommentTime';
    public const CATEGORY_TAGS = 'categoryTags';
    public const TAGS = 'tags';
    public const GENRE = 'genre';

    public const ALL = [
        self::CONTENT_ID,
        self::TITLE,
        self::DESCRIPTION,
        self::USER_ID,
        self::CHANNEL_ID,
        self::VIEW_COUNTER,
        self::MYLIST_COUNTER,
        self::LIKE_COUNTER,
        self::LENGTH_SECONDS,
        self::THUMBNAIL_URL,
        self::START_TIME,
        self::LAST_RES_BODY,
        self::COMMENT_COUNTER,
        self::LAST_COMMENT_TIME,
        self::CATEGORY_TAGS,
        self::TAGS,
        self::GENRE,
    ];
}
