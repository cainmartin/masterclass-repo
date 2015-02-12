<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;

/**
 * Comment controller - provides interface for creating comments
 */
class Comment 
{
    /**
     *
     * @var Masterclass\Model\Comment
     */
    protected $commentModel;
    
    /**
     * 
     * @param \Masterclass\Model\Comment $comment - pointer to comment persistence
     */
    public function __construct(CommentModel $comment) 
    {
        $this->commentModel = $comment;
    }
    
    /**
     * Creates a comment for the current story
     */
    public function create() 
    {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }
        
        $this->commentModel->createComment($_SESSION['username'], 
                                           $_POST['story_id'], 
                                           $_POST['comment']);
        
        
        header("Location: /story?id=" . $_POST['story_id']);
    }
}