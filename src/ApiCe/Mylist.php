<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

use NicoNicoRestClient\Base\Mylist as BaseMylist;

class Mylist extends BaseMylist
{
    public function getId(): int
    {
        return (int)$this->item['mylistgroup'][0]['id'];
    }

    public function getUserId(): int
    {
        return (int)$this->item['mylistgroup'][0]['user_id'];
    }

    public function getName(): string
    {
        return $this->item['mylistgroup'][0]['name'];
    }

    public function getDescription(): string
    {
        return $this->item['mylistgroup'][0]['description'];
    }

    public function getPublic(): bool
    {
        return (bool)$this->item['mylistgroup'][0]['public'];
    }

    /**
     * デフォルトのソート(default_sort_method=a,default_sort_order=d)
     */
    public function getDefaultSort(): bool
    {
        return (bool)$this->item['mylistgroup'][0]['default_sort'];
    }

    /**
     * a:マイリスト登録日時, t:タイトル, c:メモ, f:投稿日時, v:再生数, n:コメント日時, r:コメント数, m:マイリスト数, l:再生時間
     */
    public function getDefaultSortMethod(): string
    {
        return $this->item['mylistgroup'][0]['default_sort_method'];
    }

    /**
     * d: desc(新しい順), a: asc(古い順)
     */
    public function getDefaultSortOrder(): string
    {
        return $this->item['mylistgroup'][0]['default_sort_order'];
    }

    public function getCount(): int
    {
        return (int)$this->item['mylistgroup'][0]['count'];
    }
}
