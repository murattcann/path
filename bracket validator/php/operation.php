<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once("./Enums.php");
require_once("./ClosedBracketValidator.php");
require_once("./CharacterValidator.php");

use Enums\Enums;
use Validator\ClosedBracketValidator;
use Validator\CharacterValidator;

if(isset($_POST["operation"])){
    $string = $_POST["stringVal"];

    $bracketValidator = new ClosedBracketValidator();
    $isStringAccepted = CharacterValidator::validate($string); // parametre sadece parantez mi içeriyor?
    $isRegularlyClosed = CharacterValidator::isCorrectSyntax($string);// parametredeki parantezler doğru şekilde kapanmış mı?

    // Eğer parantez harici karakter içeriyorsa 
    if(!$isStringAccepted){
        echo json_encode(["status" => 400, "reason" => "not_verified_string"]);
        exit;
    }

    // Eğer parantezler hiyerarşik anlamda doğru kapanmadıysa => {[]{}(})
    if(!$isRegularlyClosed ){
        echo json_encode(["status" => 400, "reason" => "has_open_brackets"]);
        exit;
    }

    // Tüm parantez türlerinin kapalı olma durumunu kontrol eder
    $bracketValidator->validate($string, Enums::ROUND_BRACKET)
    ->validate($string, Enums::SQUARE_BRACKET)
    ->validate($string, Enums::CURLY_BRACKET);
    
    $notClosedBracketCount = $bracketValidator->openedBracketCount();
   
    // Hepsi başarılı şekilde kapandıysa => {{{}[]}}
    if($notClosedBracketCount == 0){
        echo json_encode(["status" => 200]);
        exit;
    }

   // Kapanmayan parantezler varsa ve bunların sayısı 10'a eşit veya küçükse
    if($notClosedBracketCount > 0 && $notClosedBracketCount <= 10){
        echo json_encode(["status" => 400, "reason" => "has_open_brackets"]);
        exit;
    }

    // Kapanmayan parantezlerin sayısı 10'dan büyükse
    if($notClosedBracketCount > 10){
        echo json_encode(["status" => 400, "reason" => "has_too_many_open_brackets"]);
        exit;
    }
    
}
?>