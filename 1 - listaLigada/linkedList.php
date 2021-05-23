<?php
require_once './node.php';

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
        if(!$this->isEmpty()){
            while($this->first!=null){
                $nodeTemp = $this->first;
                $this->first = $nodeTemp->next;
                unset($nodeTemp);
            }
            $this->cont = 0;
            return true;
        }
        return false;
    }

    // Verificações -------------------------------------------------------------------------------------
    // Lista vazia
    public function isEmpty(){
        if($this->cont == 0)
            return true;
        return false;
    }

    // Verifica se a lista está cheia
    // Uma lista encadeada só estará cheia quando não houver mais memória para alocar novos elementos
    public function isFull(){
        if(new Node(new People("Verify is Full", 0)) === null)
            return true;
        return false;
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
            $cont = 0;
            $nodeTemp = $this->first;
            while($nodeTemp!=null){
                if(strcmp($nodeTemp->data->getName(), $name) == 0)
                    return $cont;
                $cont++;
                $nodeTemp = $nodeTemp->next;
            }
            return false;
        }
        return false;
    }

    // Inserções ----------------------------------------------------------------------------------------
    // Insere no final
    public function insertEnd(string $name, int $age){
        removeLineBreak($name);
        if(!$this->isFull()){
            if($this->first == null){
                $this->first = new Node(new People($name, $age));
                $this->cont++;
                return true;
            }
            $current = null;
            $nodeTemp = $this->first;
            while($nodeTemp != null){
                $current = $nodeTemp;
                $nodeTemp = $nodeTemp->next;
            }
            $current->next = new Node(new People($name, $age));
            $this->cont++;
            return true;
        }
        return false;
    }

    // Insere no inicio
    public function insertBeginning(string $name, int $age){
        removeLineBreak($name);
        if(!$this->isFull()){
            $newNode = new Node(new People($name, $age));
            if(!$this->isEmpty()){
                $newNode->next = $this->first;
                $this->first = $newNode;
            }else
                $this->first = $newNode;
            $this->cont++;
            return true;
        }
        return false;
    }

    // Insere com base na posição
    public function insertInIndex(int $index, string $name, int $age){
        if(!$this->isFull() && $index<=$this->cont){
            if($this->isEmpty() || $index == 0)
                return $this->insertBeginning($name, $age);
            
            if($index == $this->cont)
                return $this->insertEnd($name, $age);

            $nodeTemp = $this->first;
            $current = null;
            for($cont=0; $cont<$index; $cont++){
                $current = $nodeTemp;
                $nodeTemp = $nodeTemp->next;
            }
            $newNode = new Node(new People($name, $age));
            $current->next = $newNode;
            $newNode->next = $nodeTemp;
            $this->cont++;
            return true;
        }
        return false;
    }
    
    // Remoções ---------------------------------------------------------------------------------------------
    // Remoção no final
    public function removeEnd(){
        if(!$this->isEmpty()){
            if($this->first->next == null){
                $dataTemp = $this->first->data;
                $this->first = null;
                $this->cont--;
                return $dataTemp;
            }

            $current = null;
            $nodeTemp = $this->first;
            while($nodeTemp->next != null){
                $current = $nodeTemp;
                $nodeTemp = $nodeTemp->next;
            }
            $dataTemp = $current->next->data;
            $current->next = null;
            $this->cont--;
            return $dataTemp;
        }
        return false;
    }

    // Remoção no início
    public function removeBeginning(){
        if(!$this->isEmpty()){
            $dataTemp = $this->first->data;
            $this->first = $this->first->next;
            $this->cont--;
            return $dataTemp;
        }
        return false;
    }

    // Remove um íncide específico
    public function removeIndex(int $index){
        if(!$this->isEmpty() && $this->cont>$index){
            if($index == 0)
                return $this->removeBeginning();
            if($index == $this->cont-1)
                return $this->removeEnd();
            
            $current = null;
            $nodeTemp = $this->first;
            for($cont=0; $cont<$index; $cont++){
                $current = $nodeTemp;
                $nodeTemp = $nodeTemp->next;
            }
            $dataTemp = $current->next->data;
            $current->next = $current->next->next;
            $this->cont--;
            return $dataTemp;
        }
        return false;
    }
        

    
    // Mostra a lista -----------------------------------------------------------------------------------
    public function printList(){
        if(!$this->isEmpty()){
            $nodeTemp = $this->first;
            echo "Tamanho da lista: ".$this->cont."\n";
            echo "---------------------------------\n";
            while($nodeTemp != null){
                $dataTemp = $nodeTemp->data;
                echo "Nome: ".$dataTemp->getName()."\n";
                echo "Idade: ".$dataTemp->getAge()."\n";
                echo "---------------------------------\n";
                $nodeTemp = $nodeTemp->next;
            }
            return true;
        }
        return false;
    }
}