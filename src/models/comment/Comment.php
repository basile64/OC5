<?php

namespace application\src\models\comment;

use application\src\models\user\UserManager;

class Comment
{
    private const ID_COLUMN = 'id';
    private const TEXT_COLUMN = 'text';
    private const DATE_COLUMN = 'date';
    private const STATUS_COLUMN = 'status';
    private const POST_ID_COLUMN = 'postId';
    private const USER_ID_COLUMN = 'userId';

    private $id;
    private $text;
    private $date;
    private $status;
    private $postId;
    private $userId;

    public function __construct($comment)
    {
        $this->setCommentId($comment[self::ID_COLUMN] ?? null);
        $this->setText($comment[self::TEXT_COLUMN] ?? null);
        $this->setDate($comment[self::DATE_COLUMN] ?? null);
        $this->setStatus($comment[self::STATUS_COLUMN] ?? null);
        $this->setPostId($comment[self::POST_ID_COLUMN] ?? null); 
        $this->setUserId($comment[self::USER_ID_COLUMN] ?? null); 
    }

    // Getters
    public function getCommentId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getDate($format = "Y-m-d")
    {
        return ((new \DateTime($this->date))->format($format));
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getUser()
    {
        $userManager = new UserManager;
        $user = $userManager->get($this->userId);
        return $user;
    }

    // Setters
    private function setCommentId($id)
    {
        $this->id = $id;
    }

    private function setText($text)
    {
        $this->text = $text;
    }

    private function setDate($date)
    {
        $this->date = $date;
    }

    private function setStatus($status)
    {
        $this->status = $status;
    }

    private function setPostId($postId)
    {
        $this->postId = $postId;
    }

    private function setUserId($userId)
    {
        $this->userId = $userId;
    }

}
