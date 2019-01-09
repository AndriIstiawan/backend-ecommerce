<?php 

if( ! function_exists('price') ){
    function price($str, $value){
        return "$str " . number_format($value, 0, ".", ".");
    }
}