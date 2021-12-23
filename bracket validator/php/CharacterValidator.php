<?php
  namespace Validator;
require_once("./Enums.php");

use Enums\Enums;

class CharacterValidator 
  {
    
      protected static $bracketsToCheck = ["{", "[", "(", ")", "]", "}"];

      /**
       * Verilen parametre parantezler haricinde bir karakter içeriyor mu diye kontrol eder
       * @param string $string
       * 
       * @return bool
       */
      public static function validate($string){
        $charset =  str_split($string);
        $status = true;
        foreach($charset as $char){
            if(!in_array($char, self::$bracketsToCheck)){
                return false;
            }
        }

        return $status;
      }

      /**
       * Verilen parametredeki parantezler hiyerarşik olarak doğru kapatılmış mı diye kontrol eder
       * @param string $string
       * 
       * @return bool
       */
      public static function isCorrectSyntax($string){
          if(preg_match('/^(?<p>(?:[^()\[\]{}]++|\((?&p)\)|\[(?&p)\]|\{(?&p)\})*)$/', $string)){
            return true;
          }

          return false;
      }

      /**
       * Aşağıdaki metod isCorrectSyntax() metodunun bir diğer versiyonudur.
       * İkisi de aynı sonucu veriyor, isCorrectSyntax() metodunu okumak daha kolay olduğu için tercih edilmiştir
       */
      /**
       * @param string $string
       * 
       * @return bool
       */
      public function isRegular($string) {
        $stack = [];
    
        foreach (str_split($string) as $c) {
            switch($c) {
                case "(":
                case "[":
                case "{":
                    array_push($stack, $c);
                    break;
                case ")":
                    if (array_pop($stack) != "(")
                        return false;
                    break;
                case "]":
                    if (array_pop($stack) != "[")
                        return false;
                    break;
                case "}":
                    if (array_pop($stack) != "{")
                        return false;
                    break;
            }
        }
    
        return count($stack) == 0;
    }
  }

?>