<?php
require_once './node.php';

class Stack{
    private ?Node $first;
    private int $cont;

    public function __construct(string $name = null, int $age = null){
        if($name != null){
            $this->first = new Node(new People($name, $age));
            $this->cont=1;
            return;
        }
        $this->first = null;
        $this->cont = 0;
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
    // Verifica se a lista está vazia
    public function isEmpty(){
        if($this->cont==0 || $this->first==null)
            return true;
        return false;
    }


    // Retorna a quantidade de elmentos na lista ----------------------------------------------
    public function length(){
        return $this->cont;
    }


    // Insere no final ------------------------------------------------------------------------
    public function push(string $name, int $age){
        removeLineBreak($name);
        $dataTemp = new People($name, $age);

        // Caso não seja o primeiro
        if(!$this->isEmpty()){
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

        // Caso seja o primeiro
        $this->first = new Node($dataTemp);
        $this->cont++;
        return true;
    }


    // Remove no final ------------------------------------------------------------------------
    public function pop(){
        if(!$this->isEmpty()){
            // Vai até o último elemento para remover
            $current = null;
            $nodeTemp = $this->first;
            while($nodeTemp->next != null){
                $current = $nodeTemp;
                $nodeTemp = $nodeTemp->next;
            }

            // Caso só exista um elemento
            if($current == null){
                $dataTemp = $this->first->data;
                unset($this->first);
                $this->cont--;
                return $dataTemp;
            }

            // Caso exista mais elementos
            $dataTemp = $nodeTemp->data; // nodeTemp é o ultimo elemento
            $current->next = null;
            unset($nodeTemp);
            $this->cont--;
            return $dataTemp;
        }
        return false;
    }


    // Mostra a pilha -------------------------------------------------------------------------
    public function printStack(Node $nodeTemp = null, int $cont = 0){
        if($this->isEmpty())
            return null;
        else 
            if($cont == 0)
                $nodeTemp = $this->first;

        // Imrpime a pilha recusivamente do final para o início
        if($nodeTemp->next == null){
            echo "Topo da pilha\n";
            echo "-----------------------------------\n";
            echo "Nome: ".$nodeTemp->data->getName()."\n";
            echo "Idade: ".$nodeTemp->data->getAge()."\n";
            echo "-----------------------------------\n";
        }else{
            $cont++;
            $this->printStack($nodeTemp->next, $cont);
            echo "Nome: ".$nodeTemp->data->getName()."\n";
            echo "Idade: ".$nodeTemp->data->getAge()."\n";
            echo "-----------------------------------\n";
            $cont--;
        }
        if($cont==0)
            echo "Fundo da pilha\n\n";
        return true;
    }
}