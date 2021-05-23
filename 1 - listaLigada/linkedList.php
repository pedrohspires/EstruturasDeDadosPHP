<?php

define("TAM_MAX", 50);
require './node.php';

class LinkedList{
    private ?Node $first;
    private int $cont;

    // Cria a lista vazia, sem elementos ----------------------------------------------------------------
    public function __construct(){
        $this->first = null;
        $this->cont = 0;
    }

    // Apaga todos os itens da lista --------------------------------------------------------------------
    public function cleanList(){

    }

    // Verificações -------------------------------------------------------------------------------------
    // Lista vazia
    public function isEmpty(){

    }

    // Lista cheia
    public function isFull(){

    }

    // Consultas ----------------------------------------------------------------------------------------
    // Quantidade de elementos
    public function listLenght(){

    }

    // Retorna o índice de um nome
    public function returnIndexByName(string $name){
        
    }

    // Inserções ----------------------------------------------------------------------------------------
    // Insere no final
    public function insertEnd(string $name, int $age){
        
    }

    // Insere no inicio
    public function insertBeginning(string $name, int $age){
        
    }

    // Insere com base na posição
    public function insertAtIndex(int $index, string $name, int $age){
        
    }
    
    // Remoções ---------------------------------------------------------------------------------------------
    // Remoção no final
    public function removeEnd(){
        
    }

    // Remoção no início
    public function removeBeginning(){
        
    }

    // Remove um íncide
    public function removeIndex(int $index){
        
    }
        

    
    // Mostra a lista -----------------------------------------------------------------------------------
    public function printList(){
        
    }
}