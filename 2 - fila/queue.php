<?php
require_once './node.php';

class Queue{
    private ?Node $first;
    private int $cont;

    public function __construct(Node $first = null){
        $this->first = $first;
        $this->cont = 0;
        if($first != null)
            $this->cont=1;
    }

    // apagar a pilha da memória --------------------------------------------------------------
    public function clean(){
        if(!$this->isEmpty()){
            while($this->first!=null){
                $nodeTemp = $this->first;
                $this->first = $nodeTemp->next;
                unset($nodeTemp);
            }
            $this->cont = 0;
        }
        return true;
    }


    // Verificações ---------------------------------------------------------------------------
    // Verifica se a fila está vazia
    public function isEmpty(){
        if($this->cont==0 || $this->first==null)
            return true;
        return false;
    }


    // Retorna a quantidade de elmentos na fila ----------------------------------------------
    public function length(){
        return $this->cont;
    }


    // Insere no final
    public function push(string $name, int $age){
        removeLineBreak($name);
        $dataTemp = new People($name, $age);
        
        // Caso o nó não esteja vazio
        if(!$this->isEmpty()){
            $current = null;
            $nodeTemp = $this->first;
            while($nodeTemp!=null){
                $current = $nodeTemp;
                $nodeTemp = $nodeTemp->next;
            }
            $current->next = new Node($dataTemp);
            $this->cont++;
            return true;
        }

        // Caso o nó esteja vazio
        $this->first = new Node($dataTemp);
        $this->cont++;
        return true;
    }


    // Remove no início
    public function pop(){
        if(!$this->isEmpty()){
            $nodeTemp = $this->first;
            $this->first = $nodeTemp->next;
            $dataTemp = $nodeTemp->data;
            unset($nodeTemp);
            $this->cont--;
            return $dataTemp;
        }
        return null;
    }

    
    // Mostra a pilha -------------------------------------------------------------------------
    public function printFila($funcao){
        if(!$this->isEmpty()){
            $nodeTemp = $this->first;
            echo "Pessoas na fila: ".($this->cont+1)."\n";
            echo "Início da fila\n";
            echo "-----------------------------------\n";
            while($nodeTemp!=null){
                echo "Nome: ".$nodeTemp->data->getName()."\n";
                echo "Idade: ".$nodeTemp->data->getAge()."\n";
                echo "-----------------------------------\n";
                $nodeTemp = $nodeTemp->next;
            }
        }else echo "Fila vazia!\n";
    }
}