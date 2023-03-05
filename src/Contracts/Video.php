<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Contracts;

use DateTimeImmutable;

interface Video
{
    /**
     * @return array<mixed>
     */
    public function getItem(): array;

    /**
     * 動画ID
     */
    public function getContentId(): ?string;

    /**
     */
    public function getWatchUrl(): ?string;

    /**
     * 動画タイトル
     */
    public function getTitle(): ?string;

    /**
     * 動画説明文

     */
    public function getDescription(): ?string;

    /**
     * ユーザーID
     */
    public function getUserId(): ?int;

    /**
     * サムネイルURL
     */
    public function getThumbnailUrl(): ?string;


    /**
     * 投稿日時
     */
    public function getStartTime(): ?DateTimeImmutable;

    /**
     * 再生時間（i:s or h:i:s）
     */
    public function getLengthString(): ?string;

    /**
     * 再生時間（秒）
     */
    public function getLengthSeconds(): ?int;


    /**
     * 再生数
     */
    public function getViewCounter(): ?int;

    /**
     * コメント数
     */
    public function getCommentCounter(): ?int;

    /**
     * マイリスト数
     */
    public function getMylistCounter(): ?int;

    /**
     * いいね数
     */
    public function getLikeCounter(): ?int;

    /**
     * 最後のコメント日時
     */
    public function getLastCommentTime(): ?DateTimeImmutable;

    /**
     * 最後のコメント本文
     */
    public function getLastResBody(): ?string;

    /**
     * タグ一覧（配列）
     * @return array<string>
     */
    public function getTags(): array;

    /**
     * カテゴリタグ一覧（配列）
     * @return array<string>
     */
    public function getCategoryTags(): array;

    /**
     * ジャンル名
     */
    public function getGenre(): ?string;

    /**
     * チャンネルID
     */
    public function getChannelId(): ?int;
}
