<?php

namespace application\src\models\comment;

use application\src\models\user\UserManager;

/**
 * Represents a comment entity.
 */
class Comment
{
    
    /**
     * Database column name for the comment ID.
     *
     * @var string
     */
    private const ID_COLUMN = 'id';

    /**
     * Database column name for the comment text.
     *
     * @var string
     */
    private const TEXT_COLUMN = 'text';

    /**
     * Database column name for the comment date.
     *
     * @var string
     */
    private const DATE_COLUMN = 'date';

    /**
     * Database column name for the comment status.
     *
     * @var string
     */
    private const STATUS_COLUMN = 'status';

    /**
     * Database column name for the post ID associated with the comment.
     *
     * @var string
     */
    private const POST_ID_COLUMN = 'postId';

    /**
     * Database column name for the user ID associated with the comment.
     *
     * @var string
     */
    private const USER_ID_COLUMN = 'userId';

    /**
     * The unique identifier of the comment.
     *
     * @var mixed
     */
    private $id;

    /**
     * The text content of the comment.
     *
     * @var string
     */
    private $text;

    /**
     * The date and time when the comment was created.
     *
     * @var string
     */
    private $date;

    /**
     * The status of the comment (e.g., approved, pending, deleted).
     *
     * @var string
     */
    private $status;

    /**
     * The ID of the post associated with the comment.
     *
     * @var mixed
     */
    private $postId;

    /**
     * The ID of the user who made the comment.
     *
     * @var mixed
     */
    private $userId;


    /**
     * Constructor for Comment object.
     *
     * @param array $comment An associative array representing the comment data.
     * @return void
     */
    public function __construct($comment)
    {
        $this->setCommentId($comment[self::ID_COLUMN] ?? null);
        $this->setText($comment[self::TEXT_COLUMN] ?? null);
        $this->setDate($comment[self::DATE_COLUMN] ?? null);
        $this->setStatus($comment[self::STATUS_COLUMN] ?? null);
        $this->setPostId($comment[self::POST_ID_COLUMN] ?? null); 
        $this->setUserId($comment[self::USER_ID_COLUMN] ?? null); 
    }

    /**
     * Get the unique identifier of the comment.
     *
     * @return mixed The comment ID.
     */
    public function getCommentId()
    {
        return $this->id;
    }

    /**
     * Get the text content of the comment.
     *
     * @return string The comment text.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the date and time when the comment was created.
     *
     * @param string $format The format of the date (default: "Y-m-d").
     * @return string The formatted date.
     */
    public function getDate($format = "Y-m-d")
    {
        return ((new \DateTime($this->date))->format($format));
    }

    /**
     * Get the status of the comment (e.g., approved, pending, deleted).
     *
     * @return string The comment status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the ID of the post associated with the comment.
     *
     * @return mixed The post ID.
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Get the ID of the user who made the comment.
     *
     * @return mixed The user ID.
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the user who made the comment.
     *
     * @return User The user object.
     */
    public function getUser()
    {
        $userManager = new UserManager;
        $user = $userManager->get($this->userId);
        return $user;
    }

    /**
     * Set the unique identifier of the comment.
     *
     * @param mixed $id The comment ID.
     * @return void
     */
    private function setCommentId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the text content of the comment.
     *
     * @param string $text The comment text.
     * @return void
     */
    private function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Set the date and time when the comment was created.
     *
     * @param string $date The comment date.
     * @return void
     */
    private function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Set the status of the comment.
     *
     * @param string $status The comment status.
     * @return void
     */
    private function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set the ID of the post associated with the comment.
     *
     * @param mixed $postId The post ID.
     * @return void
     */
    private function setPostId($postId)
    {
        $this->postId = $postId;
    }

    /**
     * Set the ID of the user who made the comment.
     *
     * @param mixed $userId The user ID.
     * @return void
     */
    private function setUserId($userId)
    {
        $this->userId = $userId;
    }
}
