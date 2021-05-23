<?php

require '../dados/people.php';

class Node {
    private ?Node $next;
    private People $data;

    /**
     * Recebe um dado do tipo People para ser adicionado. Opcionalmente recebe
     * o próximo nó. Caso não seja especificado, o próximo nó será nulo.
     */
    public function __construct(People $data, Node $next = null){
        $this->data = $data;
        $this->next = $next;
    }

    /**
     * Adiciona/altera o próximo objeto.
     */
    public function setNext(Node $next){
        $this->next = $next;
    }

    /**
     * Altera os dados armazenados no nó.
     */
    public function setData(People $data){
        $this->data = $data;
    }

    /**
     * Retorna o dado do nó
     */
    public function getData(){
        return $this->data;
    }

    /**
     * Retorna o próximo nó
     */
    public function getNext(){
        return $this->next;
    }
}