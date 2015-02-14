<?php

    echo  '
        <form method="post" action="/user/login/check">
            ' . $this->error . '<br />
            <label>Username</label> <input type="text" name="user" value="" />
            <label>Password</label> <input type="password" name="pass" value="" />
            <input type="submit" name="login" value="Log In" />
        </form>
    ';
        
