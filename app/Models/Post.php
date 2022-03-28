<?php

use App\Helpers\DBConnection;

class Post {
    protected int $id;
    protected int $user_id;
    protected int $comp_id;
    protected string $title;
    protected string $img;
    protected string $created_at;

    public function __construct()
    {
        $this->id = 0;
        $this->user_id = 0;
        $this->comp_id = 0;
        $this->title = "";
        $this->img = "";
        $this->created_at = "";
    }

    public function load(int $id): ?Post
    {
        $pdo = DBConnection::getDB();
        $row = $pdo->query("SELECT * FROM post WHERE user_id=$id")->fetch();
        if ($row) {
            $this->$row['id'];
            $this->$row['comp_id'];
            $this->$row['title'];
            $this->$row['img'];
            $this->$row['created_at'];
            return $this;
        } else {
            return null;
        }
    }

    public function save(): ?post
    {
        $pdo = DBConnection::getDB();
        try {
            if ($this->id != 0)
            {
                $stmt = $pdo->prepare("UPDATE post SET title=?, img=? WHERE id=?");
                $stmt->execute([$this->title, $this->img, $this->id]);
            }
            else
            {
                $stmt = $pdo->prepare("INSERT INTO post (user_id, comp_id, title, img, created_at) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$this->user_id, $this->comp_id, $this->title, $this->img, $this->created_at]);
            }
            return $this->load($pdo, )
        }
        catch (Exception $e)
        {
            return null;
        }
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
