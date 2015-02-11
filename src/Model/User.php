<?php

namespace Masterclass\Model;

use PDO;

/**
 * Description of User
 *
 * @author cainmartin
 */
class User
{
    protected $db;
    
    public function __construct($config)
    {
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * 
     * @param type $username
     * @return boolean
     */
    public function checkUserExists($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ?';
        $check_stmt = $this->db->prepare($check_sql);
        $check_stmt->execute(array($username));
        if($check_stmt->rowCount() > 0) {
            return true;
        }
        
        return false;
    }
    
    /**
     * 
     * @param type $username
     * @param type $email
     * @param type $password
     */
    public function createUser($username, $email, $password)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username,
                             $email,
                             md5($username . $password)
                       ));
    }
    
    /**
     * 
     * @param type $password
     * @param type $username
     */
    public function updatePassword($password, $username)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
           md5($username . $password), // THIS IS NOT SECURE. 
           $username
        ));
    }
    
    /**
     * 
     * @param type $username
     * @return type
     */
    public function getUserDetails($username)
    {
        $dsql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->db->prepare($dsql);
        $stmt->execute(array($_SESSION['username']));
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $details;
    }
    
    /**
     * 
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function validateUser($username, $password)
    {
        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username, $password));
        if($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC); 
            return $data;
        }
        
        return false;
    }
}
