<?php

    echo ' ' . $this->error . '<br />

    <label>Username:</label> ' . $this->details['username'] . '<br />
    <label>Email:</label>' . $this->details['email'] . ' <br />

     <form method="post" action="/user/account/save">
            ' . $this->error . '<br />
        <label>Password</label> <input type="password" name="password" value="" /><br />
        <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
        <input type="submit" name="updatepw" value="Create User" />
    </form>';

