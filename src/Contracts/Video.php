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
     * ユーザー名
     */
    public function getUserNickname(): ?string;

    /**
     * ユーザーアイコンURL
     */
    public function getUserIconUrl(): ?string;

    /**
     * サムネイルURL
     */
    public function getThumbnailUrl(): ?string;

    /**
     * サムネイル形式
     */
    public function getThumbType(): ?string;

    /**
     * 埋め込み可
     */
    public function getEmbeddable(): ?bool;

    /**
     * ニコ生で再生禁止
     */
    public function getNoLivePlay(): ?bool;

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
     * 動画形式
     */
    public function getMovieType(): ?string;

    /**
     * 高画質容量
     */
    public function getSizeHigh(): ?int;

    /**
     * 低画質容量
     */
    public function getSizeLow(): ?int;

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
    public function getTagsArray(): array;

    /**
     * タグ一覧（スペース区切り文字列）
     */
    public function getTagsString(): ?string;

    /**
     * カテゴリタグ一覧（配列）
     * @return array<string>
     */
    public function getCategoryTagsArray(): array;

    /**
     * カテゴリタグ一覧（スペース区切り文字列）
     */
    public function getCategoryTagsString(): ?string;

    /**
     * ジャンル名
     */
    public function getGenre(): ?string;

    /**
     * チャンネルID
     */
    public function getChannelId(): ?string;
}
