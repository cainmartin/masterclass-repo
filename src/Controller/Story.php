<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as StoryModel;
use Masterclass\Model\Comment;
use Aura\Web\Response;
use Aura\Web\Request;
use Aura\View\View;

class Story {
    
    protected $storyModel;
    protected $commentModel;
    protected $response;
    protected $template;
    protected $request;
    
    public function __construct(StoryModel $story, 
                                Comment $comment, 
                                Response $response, 
                                View $template,
                                Request $request) 
    {
        $this->storyModel = $story;
        $this->commentModel = $comment;
        $this->response = $response;
        $this->template = $template;
        $this->request = $request;
    }
    
    public function index() 
    {
        $id = $this->request->query->get('id');
        if (!$id) {
            $this->response->redirect->to('/');
            return $this->response;
        }
        
        $story = $this->storyModel->getStory($id);
        if(!$story) {
            $this->response->redirect->to('/');
            return $this->response;
        }
        
        $comments = $this->commentModel->getStoryComments($id);
        $comment_count = sizeof($comments);

        $this->template->setLayout('layout');
        $this->template->setView('story');
        $this->template->setData([
            'id' => $id,
            'url' => $story['url'],
            'headline' => $story['headline'],
            'created_by' => $story['created_by'],
            'comment_count' => $comment_count,
            'created_on' => $story['created_on'],
            'comments' => $comments
        ]);
        
        $this->response->content->set($this->template->__invoke());
        return $this->response;
    }
    
    public function create() 
    {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            $this->response->redirect->to('/users/login');
            return $this->response;
        }
        
        $headline = $this->request->post->get('headline');
        $url = $this->request->post->get('url');
        
        $error = '';
        if(isset($_POST['create'])) {
            if(!$headline || !$url || !filter_var($url, FILTER_VALIDATE_URL)) {
                $error = 'You did not fill in all the fields or the URL did not validate.';       
            } else {
                $id = $this->storyModel->createStory($headline, $url, $_SESSION['username']);
                $this->response->redirect->to("/story?id=$id");
                return $this->response;
            }
        }
        
        $this->template->setLayout('layout');
        $this->template->setView('story_create');
        $this->template->setData(['error' => $error]);
        
        $this->response->content->set($this->template->__invoke());
        
        return $this->response;
    }
}