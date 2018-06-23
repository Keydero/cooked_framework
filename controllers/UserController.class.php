<?php 
 namespace MyFramework;

 class UserController extends UserModel
 {
   public function showLogin()
   {
       $this->render(['login' => $this->getLogin()]);
       echo "<h1>showLogin.html </h1>";
   }
}