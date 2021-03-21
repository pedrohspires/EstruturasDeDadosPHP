<?php
    function removeQuebraDeLinha(string &$string){
        if(isset($string)){
            $cont=0;
            while($string[$cont] != "\0"){
                if($string[$cont] == "\n"){
                    $string[$cont] = "\0";
                    break;
                }
                $cont++;
            }
            return $string;
        }else
            error_log("input.php::removeQuebraDeLinha(): string vazia.");
    }
?>