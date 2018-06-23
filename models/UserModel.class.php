<?php 
 namespace MyFramework;
class UserModel extends Core {



    public function getLogin() 
    {
        extract($_POST);
       return $login;
    }
}