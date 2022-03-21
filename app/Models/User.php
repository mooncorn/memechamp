<?php

namespace App\Models;

use Exception;
use PDO;

class User {
    private int $id;
    private string $email;
    private string $username;
    private string $password;
    private string $pfp;
    private int $current_poggers;
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
        $this->current_poggers = 0;
        $this->max_poggers = 0;
        $this->is_banned = false;
        $this->is_admin = false;
        $this->created_at = "";
    }

    /**
     * @throws Exception
     */
    public function load(PDO $pdo, string $uniqueIdentifierName, int|string $value): ?User {
        $identifier = strtolower($uniqueIdentifierName);

        if ($identifier != 'id' && $identifier != 'username' && $identifier != 'email') {
            throw new Exception('Invalid identifier. Must be id, username or email.');
        }

        $stmt = $pdo->query("SELECT * FROM user WHERE $identifier='$value'");
        $row = $stmt->fetch();

        if ($row) {
          $this->id = $row["id"];
          $this->email = $row["email"];
          $this->username = $row["username"];
          $this->password = $row["password"];
          $this->pfp = $row["pfp"];
          $this->current_poggers = $row["current_poggers"];
          $this->max_poggers = $row["max_poggers"];
          $this->is_banned = $row["is_banned"];
          $this->is_admin = $row["is_admin"];
          $this->created_at = $row["created_at"];

          return $this;
        }

        return null;
    }

    public function save(PDO $pdo): ?User {
        // if user already has an id, update existing user
        if ($this->isLoaded()) {
            $stmt = $pdo->prepare("UPDATE user SET username=?, email=?, password=?, pfp=?, current_poggers=?, max_poggers=?, is_banned=?, is_admin=? WHERE id=?");
            $stmt->execute([$this->username, $this->email, $this->password, $this->pfp, $this->current_poggers, $this->max_poggers, $this->is_banned, $this->is_admin, $this->id]);
        }
        // if user does not have an id, insert new user
        else {
            $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$this->username, $this->email, $this->password]);
        }

        if ($this->load($pdo, "username", $this->username)) {
            return $this;
        }

        return null;
    }

    public static function exists(PDO $pdo, string $uniqueIdentifierName, int|string $value): bool {
        $identifier = strtolower($uniqueIdentifierName);

        if ($identifier != 'id' && $identifier != 'username' && $identifier != 'email') {
            throw new Exception('Invalid identifier. Must be id, username or email.');
        }

        $stmt = $pdo->query("SELECT * FROM user WHERE $identifier='$value'");
        $row = $stmt->fetch();

        if ($row) {
            return true;
        }

        return false;
    }

    public static function build(string $username, string $email, string $password): User {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        return $user;
    }

    public function isLoaded(): bool {
        return $this->id != 0;
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
     */
    public function setEmail(string $email): void
    {
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
     */
    public function setUsername(string $username): void
    {
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
    public function setPfp(string|null $pfp): void
    {
        if ($pfp) {
            $this->pfp = $pfp;
        } else {
            $this->pfp = "";
        }
    }

    /**
     * @return int
     */
    public function getCurrentPoggers(): int
    {
        return $this->current_poggers;
    }

    /**
     * @param int $current_poggers
     */
    public function setCurrentPoggers(int $current_poggers): void
    {
        $this->current_poggers = $current_poggers;
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
    public function isBanned(): bool
    {
        return $this->is_banned;
    }

    /**
     * @param bool $is_admin
     */
    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * @param bool $is_banned
     */
    public function setIsBanned(bool $is_banned): void
    {
        $this->is_banned = $is_banned;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return CommentCollection
     */
    public function getCommentCollection($pdo): CommentCollection
    {
        $comments = new CommentCollection();
        $comments->load($pdo, 'owner_id', $this->id);
        return $comments;
    }

    #endregion
}