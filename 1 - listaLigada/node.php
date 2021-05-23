<?php
require_once '../dados/people.php';

class Node {
    public ?Node $next;
    public People $data;

    // Método construtor. Recebe um dado do tipo pessoa e armazena no nó
    public function __construct(People $data){
        $this->data = $data;
        $this->next = null;
    }

    // Retorna o dado armazenado no nó.
    public function getData(){
        return $this->data;
    }
}