<?php

namespace App\Models;

use App\Framework\Exceptions\InvalidFieldValueException;
use App\Helpers\DBConnection;
use App\Models\Enums\GetUserBy;
use Exception;
use PDOException;

class User {
    private int $id;
    private string $email;
    private string $username;
    private string $password;
    private string $pfp;
    private int $max_poggers;
    private bool $is_banned;
    private bool $is_admin;
    private string $created_at;

    public function __construct()
    {
        $this->id = 0;
        $this->email = "";
        $this->username = "";
        $this->password = "";
        $this->pfp = "";
        $this->max_poggers = 0;
        $this->is_banned = false;
        $this->is_admin = false;
        $this->created_at = "";
    }

    public function load(GetUserBy $column, int|string $value): ?User
    {
        $pdo = DBConnection::getDB();
        $row = $pdo->query("SELECT * FROM user WHERE $column->value='$value'")->fetch();

        if (!$row) return null;

        $this->id = $row["id"];
        $this->email = $row["email"];
        $this->username = $row["username"];
        $this->password = $row["password"];
        $this->pfp = $row["pfp"];
        $this->max_poggers = $row["max_poggers"];
        $this->is_banned = $row["is_banned"];
        $this->is_admin = $row["is_admin"];
        $this->created_at = $row["created_at"];
        return $this;
    }

    public function save(): User|string
    {
        $pdo = DBConnection::getDB();
        try
        {
            if ($this->id != 0)
            {
                $stmt = $pdo->prepare("UPDATE user SET username=?, email=?, password=?, pfp=?, current_poggers=?, max_poggers=?, is_banned=?, is_admin=? WHERE id=?");
                $stmt->execute([$this->username, $this->email, $this->password, $this->pfp, $this->current_poggers, $this->max_poggers, $this->is_banned, $this->is_admin, $this->id]);
            }
            else
            {
                $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$this->username, $this->email, $this->password]);
            }

            return $this;
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public static function exists(GetUserBy $column, int|string $value): bool
    {
        $pdo = DBConnection::getDB();
        return (bool) $pdo->query("SELECT * FROM user WHERE $column->value='$value'")->fetch();
    }

    /**
     * @throws InvalidFieldValueException
     */
    public static function build(string $username, string $email, string $password): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        return $user;
    }

    public static function fetch(int $id): ?User
    {
        $user = new User();
        return $user->load(GetUserBy::ID, $id);
    }

    public function getComments(): array
    {
        $pdo = DBConnection::getDB();
        $comments = [];
        $stmt = $pdo->query("SELECT * FROM comment WHERE owner_id=$this->id");

        while ($row = $stmt->fetch()) {
            $comments[] = Comment::parseToObject($row);
        }

        return $comments;
    }

    public function getPosts(): array
    {
        $pdo = DBConnection::getDB();
        $posts = [];
        $stmt = $pdo->query("SELECT id FROM post WHERE user_id=$this->id");

        while ($row = $stmt->fetch()) {
            $post = new Post();
            $post->load($row["id"]);
            $posts[] = $post;
        }

        return $posts;
    }

    public function getRemainingPoggers(): int
    {
        $pdo = DBConnection::getDB();
        $result = $pdo->query("SELECT SUM(amount) FROM vote, post, competition WHERE vote.user_id=$this->id AND vote.post_id=post.id AND post.comp_id=competition.id AND competition.is_active=true")->fetch();

        $sumOfVotes = $result["SUM(amount)"] ?? 0;
        return $this->max_poggers - $sumOfVotes;
    }

    #region Getters & Setters
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @throws InvalidFieldValueException
     */
    public function setEmail(string $email): void
    {
        if (User::exists(GetUserBy::EMAIL, $email)) {
            throw new InvalidFieldValueException("Account with this email already exists", "email");
        }

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @throws InvalidFieldValueException
     */
    public function setUsername(string $username): void
    {
        if (User::exists(GetUserBy::USERNAME, $username)) {
            throw new InvalidFieldValueException("Account with this username already exists", "username");
        }

        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPfp(): string
    {
        return $this->pfp;
    }

    /**
     * @param string $pfp
     */
    public function setPfp(string $pfp): void
    {
        $this->pfp = $pfp;
    }

    /**
     * @return int
     */
    public function getMaxPoggers(): int
    {
        return $this->max_poggers;
    }

    /**
     * @param int $max_poggers
     */
    public function setMaxPoggers(int $max_poggers): void
    {
        $this->max_poggers = $max_poggers;
    }

    /**
     * @return bool
     */
    public function isIsBanned(): bool
    {
        return $this->is_banned;
    }

    /**
     * @param bool $is_banned
     */
    public function setIsBanned(bool $is_banned): void
    {
        $this->is_banned = $is_banned;
    }

    /**
     * @return bool
     */
    public function isIsAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * @param bool $is_admin
     */
    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
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
    #endregion
}