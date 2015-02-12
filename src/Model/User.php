<?php

namespace Masterclass\Model;

use Masterclass\Dbal\AbstractDb;

/**
 * Description of User
 *
 * @author cainmartin
 */
class User
{
    /**
     *
     * @var AbstractDb 
     */
    protected $db;
    
    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }
    
    /**
     * 
     * @param type $username
     * @return boolean
     */
    public function checkUserExists($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        
        if($this->db->fetchOne($sql, array($username))) {
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
        $this->db->execute($sql, array($username,
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
        $this->db->execute($sql, array(md5($username . $password), // THIS IS NOT SECURE. 
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
        $sql = 'SELECT * FROM user WHERE username = ?';
        $details = $this->db->fetchOne($sql, array($_SESSION['username']));
        
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
        $data = $this->db->fetchOne($sql, array($username, $password));
        if($data) {
            return $data;
        }
        
        return false;
    }
}
