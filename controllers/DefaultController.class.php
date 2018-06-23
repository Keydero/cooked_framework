<?php 
 namespace MyFramework;

 class DefaultController extends DefaultModel
 {
   public function default()
   {
       $this->render(['prenom' => $this->getLogin()]);
   }
}