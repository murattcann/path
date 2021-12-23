<?php
  namespace Validator;
require_once("./Enums.php");

use Enums\Enums;

class ClosedBracketValidator 
  {

      private  $openBracketCount = 0;


       /**
        * String olarak verilen parametreyi, ikinci parametere olarak verilen türe göre validate eder
        * Kapanmamış parantezlerin sayılarını set eder
       * @param string $string
       * @param string $charSet
       * 
       * @return int|mixed
       */
      public function validate($string, $charSet = Enums::ROUND_BRACKET){
          $firstBracket = Enums::BRACKETS[$charSet]["opened"];
          $secondBracket = Enums::BRACKETS[$charSet]["closed"];
          
          $strlen = strlen($string);
          $openBrackets = 0;
          for ($i = 0; $i < $strlen; $i++)
          {
              $char = $string[$i];
              if ($char == $firstBracket) 
                  $openBrackets++;
              if ($char == $secondBracket)  
                  $openBrackets--;
          }
          $this->openBracketCount +=  $openBrackets;

          return  $this;
      }
      /**
       * Kapanmamış parantezlerin sayılarını döndürür.
       * Aksi durumda negatif sonuç döneceği için mutlak değeri alınmıştır
       * @return int
       */
      public function openedBracketCount(){
            return abs($this->openBracketCount);
      }
     
     
  }

?>