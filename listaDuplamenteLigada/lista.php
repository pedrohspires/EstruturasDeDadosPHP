<?php
    require "./dados.php";
    /*---------------------------------------------------------------------------------------------
    / Lista Dinâmicamente Alocada
    / Autor: Pedro Henrique S. Pires 
    / Descrição:
    /   Uma lista duplamente ligada é uma estrutura de dados que guarda uma lista de outros 
    /   objetos, em que cada objeto aponta para seu próximo objeto e, dentro deste, uma 
    /   referência para um outro objeto que guarda os dados da lista.
    /   A lógica que mais usei foram as chamadas recursivas. 
    */

    class Lista{
        private ?Dado $dados = null;
        private ?Lista $proximo = null;
        private ?Lista $anterior = null;

        
        // Remove todos os itens da lista ---------------------------------------------------------
        public function liberaLista(){
            if(!$this->listaVazia()){
                $listaTemp = $this->proximo;
                while($listaTemp->proximoExiste()){
                    $clean = $listaTemp;
                    $listaTemp = $listaTemp->proximo;
                    unset($clean);
                    $clean = null;
                }
                $this->dados = null;
            }
        }


        // Verificações ---------------------------------------------------------------------------
        // Verifica se a lista está vazia
        public function listaVazia(){
            if(!$this->proximoExiste() && !$this->anteriorExiste() && $this->dados == null)
                return true;
            else
                return false;
        }


        // Verifica se existe um próximo elemento
        public function proximoExiste(){
            if($this->proximo != null)
                return true;
            else
                return false;
        }


        // Verifica se existe um elemento anterior ao atual
        public function anteriorExiste(){
            if($this->anterior != null)
                return true;
            else
                return false;
        }


        // Consultas ------------------------------------------------------------------------------
        // Quantidade de elementos na lista
        public function tamanhoLista(){
            $cont = 1;
            if($this->listaVazia() || !$this->proximoExiste())
                return $cont;
            else
                return $cont+$this->proximo->tamanhoLista();
        }


        // Retorna os dados de um determinado nome
        public function retornaDado(string $nome){
            removeQuebraDeLinha($nome);
            if($this->listaVazia())
                return null;
            else{
                if(strcmp($this->dados->getNome(), $nome) == 0)
                    return $this->dados;
                else
                    if($this->proximoExiste())
                        return $this->proximo->retornaDado($nome);
                    else
                        return null;
            }
        }


        // Inserções ------------------------------------------------------------------------------
        // Insere no final
        public function adicionaNoFinal(Dado $dado){
            if($this->listaVazia() && $this->dados == null){
                $this->dados = $dado;
                return $this->dados;
            }else{
                if($this->proximoExiste())
                    return $this->proximo->adicionaNoFinal($dado);
                else{
                    $listaTemp = new Lista();
                    if(!isset($listaTemp))
                        return null;
                    $listaTemp->dados = $dado;
                    $listaTemp->anterior = $this;
                    $this->proximo = $listaTemp;
                    return $this->proximo->dados;
                }
            }   
        }


        // Inserir no início
        public function adicionaNoInicio(Dado $dado){
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }else{
                $listaTemp = new Lista();
                if(!isset($listaTemp))
                    return null;
                $listaTemp->dados = $this->dados;
                $listaTemp->anterior = $this;
                $listaTemp->proximo = $this->proximo;
                $this->proximo->anterior = $listaTemp;
                $this->proximo = $listaTemp;
                $this->dados = $dado;
                return $this->dados;
            }
        }


        // Insere após um determinado dado
        public function adicionaDepois(Dado $dado, string $nome){
            removeQuebraDeLinha($nome);
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }else{
                if(strcmp($this->dados->getNome(), $nome) == 0){
                    $listaTemp = new Lista();
                    if(!isset($listaTemp))
                        return null;
                    $listaTemp->dados = $dado;
                    $listaTemp->proximo = $this->proximo;
                    $listaTemp->anterior = $this;
                    $this->proximo->anterior = $listaTemp;
                    $this->proximo = $listaTemp;
                    return $this->proximo->dados;
                }else echo "aqui";
                if($this->proximoExiste())
                    return $this->proximo->adicionaDepois($dado, $nome);
                else
                    return $this->adicionaNoFinal($dado);
            }
        }


        // Remoções -------------------------------------------------------------------------------
        // Remove um item no final da lista
        public function removeNoFinal(){
            if($this->listaVazia())
                return null;
            else{
                if(!$this->proximoExiste()){
                    $dadoTemp = $this->dados;
                    unset($this->dados);
                    $this->dados = null;
                    return $dadoTemp;
                }
                if(!$this->proximo->proximoExiste()){
                    $dadoTemp = $this->proximo->dados;
                    unset($this->proximo);
                    $this->proximo = null;
                    return $dadoTemp;
                }else return $this->proximo->removeNoFinal();
            }
        }


        // Remove no início
        public function removeNoInicio(){
            if($this->listaVazia())
                return null;
            else{
                if(!$this->proximoExiste()){
                    $dadoTemp = $this->dados;
                    unset($this->dados);
                    $this->dados = null;
                    return $dadoTemp;
                }else{
                    $dadoTemp = $this->dados;
                    $this->dados = $this->proximo->dados;
                    $listaTemp = $this->proximo->proximo;
                    $this->proximo->anterior = $this;
                    unset($this->proximo);
                    $this->proximo = $listaTemp;
                    return $dadoTemp;
                }
            }
        }


        // Remove por nome
        public function removePeloNome(string $nome){
            removeQuebraDeLinha($nome);
            if($this->listaVazia())
                return null;
            else{
                if(strcmp($this->dados->getNome(), $nome) == 0)
                    return $this->removeNoInicio();
                else
                    if($this->proximoExiste())
                        if(strcmp($this->proximo->dados->getNome(), $nome) == 0)
                            return $this->removeProximo();
                        else 
                            if($this->proximo->proximoExiste())
                                return $this->proximo->removePeloNome($nome);
                            else return null;
            }
        }
        // Auxiliares da função removePeloNome
        private function removeProximo(){
            $listaTemp = $this->proximo->proximo;
            $dadoTemp = $this->proximo->dados;
            if($listaTemp!=null)
                $listaTemp->anterior = $this;
            unset($this->proximo);
            $this->proximo = $listaTemp;
            return $dadoTemp;
        }

        
        // Mostra a lista -------------------------------------------------------------------------
        public function printLista(){
            if(!$this->listaVazia()){
                echo $this->dados->getNome()." ".$this->dados->getIdade()."\n";
                if($this->proximoExiste())
                    $this->proximo->printLista();
                return true;
            }else return false;
        }


        // Mostra cada elemento, junto com seu anterior e seu próximo -----------------------------
        public function printAllLista(){
            if(!$this->listaVazia()){
                if(!$this->anteriorExiste())
                    echo "null | ".$this->dados->getNome();
                else
                    echo $this->anterior->dados->getNome()." | ".$this->dados->getNome();
                if(!$this->proximoExiste())
                    echo " | null\n";
                else{
                    echo " | ".$this->proximo->dados->getNome()."\n";
                    $this->proximo->printAllLista();
                }
                return true;
            }else return false;
        }
    }
?>