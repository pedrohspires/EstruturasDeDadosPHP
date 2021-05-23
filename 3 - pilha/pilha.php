<?php
    // A pilha (stack) é um tipo de lista em que só se insere e remove dados no final,
    // logo poderia ser usada qualquer lista, implementando apenas as suas funções
    // de remoção no final e inserção no final. Muitas funções serão simplesmente copiadas
    // da lista genéria, que será usada como base.
    require "../dados/pessoa.php";

    class Pilha{
        private ?Pilha $proximo = null;
        private mixed $dados = null;
        private bool $flag = false; //usado simplesmente para indicar o primeiro elemento na hora
                                    //de mostrar os dados com printPilha()

        // apagar a pilha da memória --------------------------------------------------------------
        public function liberaPilha(){
            if($this->proximo == null){
                $this->dados = null;
                return null;   
            }else{
                $listaTemp = $this->proximo->proximo;
                unset($this->proximo);
                $this->proximo = $listaTemp;
                $this->liberaPilha();
                if($this->proximo != null)
                    $this->liberaPilha();
                else{
                    unset($this->dados);
                    $this->dados = null;
                    return null;
                }
            }
        }


        // Verificações ---------------------------------------------------------------------------
        // verifica se o próximo existe
        public function proximoExiste(){
            if($this->proximo != null)
                return true;
            else
                return false;
        }

        // Verifica se existe dados
        public function dadosExistem(){
            if($this->dados != null)
                return true;
            else
                return false;
        }

        // Verifica se a lista está vazia
        public function pilhaVazia(){
            if(!$this->proximoExiste() && !$this->dadosExistem())
                return true;
            else
                return false;
        }


        // Retorna a quantidade de elmentos na lista ----------------------------------------------
        public function quantidadeDeElementos(){
            $cont = 1;
            if($this->pilhaVazia())
                return 0;
            else
                if(!$this->proximoExiste() && $this->dadosExistem())
                    return 1;
                else
                    return $cont + $this->proximo->quantidadeDeElementos();
                
        }


        // Insere no final ------------------------------------------------------------------------
        public function push($dado){
            if($this->pilhaVazia()){
                $this->dados = $dado;
                $this->flag = true;
                return $this->dados;
            }else{
                if(!$this->proximoExiste()){
                    $listaTemp = new Pilha();
                    if($listaTemp == null)
                        return null;
                    $listaTemp->dados = $dado;
                    $this->proximo = $listaTemp;
                    return $this->proximo->dados;
                }else $this->proximo->push($dado);
            }
        }


        // Remove no final ------------------------------------------------------------------------
        public function pop(){
            if($this->pilhaVazia())
                return null;
            else{
                if($this->proximoExiste())
                    if($this->proximo->proximoExiste())
                        return $this->proximo->pop();
                    else{
                        
                        $dadoTemp = $this->proximo->dados;
                        unset($this->proximo);
                        $this->proximo = null;
                        return $dadoTemp;
                    }
                $dadoTemp = $this->dados;
                unset($this->dados);
                $this->dados = null;
                return $dadoTemp;
            }
        }


        // Mostra a pilha -------------------------------------------------------------------------
        public function printPilha($funcao){
            if($this->pilhaVazia())
                return null;
            else{
                if($this->proximoExiste()){
                    $this->proximo->printPilha($funcao);
                }else 
                    echo "---------- TOPO DA PILHA ----------\n";
                $funcao($this->dados);
                if($this->flag)
                    echo "---------- FUNDO DA PILHA ---------\n";
                return true;
            }
        }
    }
?>