<?php

class Post {
    protected int $id;
    protected int $user_id;
    protected int $comp_id;
    protected string $title;
    protected string $img;
    protected string $created_at;

    /**
     * @param int $id
     * @param int $user_id
     * @param int $comp_id
     * @param string $title
     * @param string $img
     * @param string $created_at
     */

    public function __construct(int $id, int $user_id, int $comp_id, string $title, string $img, string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->comp_id = $comp_id;
        $this->title = $title;
        $this->img = $img;
        $this->created_at = $created_at;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCompId(): int
    {
        return $this->comp_id;
    }

    /**
     * @param int $comp_id
     */
    public function setCompId(int $comp_id): void
    {
        $this->comp_id = $comp_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
