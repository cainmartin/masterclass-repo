<?php

namespace Masterclass\Controller;

use PDO;
use Masterclass\Model\Comment as CommentModel;
class Comment 
{
    
    protected $commentModel;
    
    public function __construct(CommentModel $comment) 
    {
        $this->commentModel = $comment;
    }
    
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
        
        
        header("Location: /story/?id=" . $_POST['story_id']);
    }
}