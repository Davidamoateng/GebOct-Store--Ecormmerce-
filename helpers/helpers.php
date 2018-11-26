<?php
   function display_errors($errors){
       $display = '<ul class="text-center text-danger" style="background-color:pink; padding:0; list-style:none;">';
       foreach ($errors as $error) {
         $display .= '<li class""><span class="fa fa-exclamation-triangle"></span> '.$error.'</li>';
       }
       $display .= '</ul>';
       return $display;
   }
 
   function sanitize($dirty){
       return htmlentities($dirty,ENT_QUOTES,"UTF-8");
   }

   function money($number){
       return '$'.number_format($number,2);
   }

