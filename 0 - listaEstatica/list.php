<?php


define("TAM_MAX", 50);
require '../dados/people.php';

class StaticList{
    private array $data;
    private int $cont;

    // Cria a lista vazia, sem elementos ----------------------------------------------------------------
    public function __construct(){
        $this->cont = 0;
    }

    // Apaga todos os itens da lista --------------------------------------------------------------------
    public function cleanList(){
        unset($this->first);
        $this->cont = 0;
    }

    // Verificações -------------------------------------------------------------------------------------
    // Lista vazia
    public function isEmpty(){
        return $this->cont == 0;
    }

    // Lista cheia
    public function isFull(){
        return $this->cont == TAM_MAX;
    }

    // Consultas ----------------------------------------------------------------------------------------
    // Quantidade de elementos
    public function listLenght(){
        return $this->cont;
    }

    // Retorna o índice de um nome
    public function returnIndexByName(string $name){
        removeLineBreak($name);
        if(!$this->isEmpty()){
            foreach($this->data as $index => $nameInList){
                if(strcmp($name, $nameInList->getName()) == 0)
                    return $index;
            }
        }
        return false;
    }

    // Inserções ----------------------------------------------------------------------------------------
    // Insere no final
    public function insertEnd(string $name, int $age){
        removeLineBreak($name);
        if(!$this->isFull()){
            $this->data[$this->cont++] = new People($name, $age);
            return true;
        }
        return false;
    }

    // Insere no inicio
    public function insertBeginning(string $name, int $age){
        removeLineBreak($name);
        if(!$this->isFull()){
            for($cont=$this->cont; $cont>0; $cont--)
                $this->data[$cont] = $this->data[$cont-1];
            $this->data[0] = new People($name, $age);
            $this->cont++;
            return true;
        }
        return false;
    }

    // Insere com base na posição
    public function insertAtIndex(int $index, string $name, int $age){
        removeLineBreak($name);
        if(!$this->isFull() && !($index >= TAM_MAX-1)){
            for($cont=$this->cont; $cont>$index; $cont--)
                $this->data[$cont] = $this->data[$cont-1];
            $this->data[$index+1] = new People($name, $age);
            $this->cont++;
            return true;
        }
        return false;
    }
    
    // Remoções ---------------------------------------------------------------------------------------------
    // Remoção no final
    public function removeEnd(){
        if(!$this->isEmpty()){
            $this->cont--;
            return true;
        }
        return false;
    }

    // Remoção no início
    public function removeBeginning(){
        if(!$this->isEmpty()){
            for($cont=0; $cont<$this->cont-1; $cont++)
                $this->data[$cont] = $this->data[$cont+1];
            $this->cont--;
            return true;
        }
        return false;
    }

    // Remove um íncide
    public function removeIndex(int $index){
        if(!$this->isEmpty() && $index < TAM_MAX){
            for($cont=$index; $cont<$this->cont; $cont++)
                $this->data[$cont] = $this->data[$cont+1];
            $this->cont--;
            return true;
        }
        return false;
    }
        

    
    // Mostra a lista -----------------------------------------------------------------------------------
    public function printList(){
        if(!$this->isEmpty()){
            for($cont=0; $cont<$this->cont; $cont++){
                echo "Nome: ".$this->data[$cont]->getName()."\n";
                echo "Idade: ".$this->data[$cont]->getAge()."\n";
                echo "------------------------\n";
            }
            return true;
        }
        return false;
    }
}