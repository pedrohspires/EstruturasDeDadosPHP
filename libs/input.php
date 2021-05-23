<?php
    function removeLineBreak(string &$string){
        if(!empty($string)){
            $cont = 0;
            while(1){
                if(empty($string[$cont])){
                    $string[$cont] = "\0";
                    break;
                }
                if($string[$cont] == "\n" || $string[$cont] == "\0"){
                    $string[$cont] = "\0";
                    break;
                }
                $cont++;
            }
        }else{
            $string[0]="\0";
            return $string;
        }
    }
?>