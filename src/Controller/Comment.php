<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as CommentModel;
use Aura\Web\Response;
use Aura\Web\Request;

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
     * @var Aura\Web\Response 
     */
    protected $response;

    /**
     *
     * @var Aura\Web\Request 
     */
    protected $request;
    
    /**
     * 
     * @param \Masterclass\Model\Comment $comment - pointer to comment persistence
     */
    public function __construct(CommentModel $comment, Response $response, Request $request) 
    {
        $this->commentModel = $comment;
        $this->response = $response;
        $this->request = $request;
    }
    
    /**
     * Creates a comment for the current story
     */
    public function create() 
    {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            $this->response->redirect->to('/');
            return $this->response; 
        }
        
        $comment = $this->request->post->get('comment');
        $story_id = $this->request->post->get('story_id');
                
        $this->commentModel->createComment($_SESSION['username'], 
                                           $story_id, 
                                           $comment);
        
        $this->response->redirect->to("/story?id=" . $story_id);
        return $this->response;
    }
}