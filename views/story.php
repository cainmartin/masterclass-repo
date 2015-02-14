<?php

    echo '
        <a class="headline" href="' . $this->url . '">' . $this->headline . '</a><br />
        <span class="details">' . $this->created_by . ' | ' . $this->comment_count . ' Comments | 
        ' . date('n/j/Y g:i a', strtotime($this->created_on)) . '</span>
    ';

    if(isset($_SESSION['AUTHENTICATED'])) {
        echo '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $this->id . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>            
            ';
    }

    foreach($this->comments as $comment) {
        echo '
            <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
            date('n/j/Y g:i a', strtotime($this->created_on)) . '</span>
            ' . $comment['comment'] . '</div>
        ';
    }
    
?>

