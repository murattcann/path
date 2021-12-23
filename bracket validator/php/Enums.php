<?php
namespace Enums;
class Enums
{
    const ROUND_BRACKET  = "round"; 
    const SQUARE_BRACKET = "square"; 
    const CURLY_BRACKET  = "curly"; 

    const BRACKETS = [
        self::ROUND_BRACKET => [
            "opened" => "(",
            "closed" => ")",
        ],
        self::SQUARE_BRACKET => [
            "opened" => "[",
            "closed" => "]",
        ],
        self::CURLY_BRACKET => [
            "opened" => "{",
            "closed" => "}",
        ],
    ];
}

?>