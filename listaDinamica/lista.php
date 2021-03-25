<?php
    require "../dados/pessoa.php";
    /*---------------------------------------------------------------------------------------------
    / Lista Dinâmicamente Alocada
    / Autor: Pedro Henrique S. Pires 
    / Descrição:
    /   Uma lista dinamica é uma estrutura de dados que guarda uma lista de outros objetos, em que
    /   cada objeto aponta para seu próximo objeto e, dentro deste, uma referência para um outro
    /   objeto que guarda os dados da lista.
    /   A lógica que mais usei foram as chamadas recursivas. Porém, fiz uma função de inserção
    /   com estrutura de repetição, apenas para demonstrar que é possível.
    */

    class Lista{
        private ?Pessoa $dados = null;
        private ?Lista $proximo = null;


        // Remove todos os elementos da lista -----------------------------------------------------
        public function liberaLista(){
            if($this->listaVazia())
                return null;
            else
                if($this->proximoExiste())
                    if($this->proximo->proximoExiste())
                        $this->proximo->liberaLista();
            unset($this->proximo);
            $this->proximo = null;
            unset($this->dados);
            $this->dados = null;
            return true;
        }


        // Verificações ---------------------------------------------------------------------------
        // Verifica se a lista está vazia
        public function listaVazia(){
            if($this->proximo == null && $this->dados == null)
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


        // Consultas ------------------------------------------------------------------------------
        // Quantidade de elementos na lista
        public function tamanhoLista(){
            $cont = 1;
            if($this->listaVazia())
                return 0;
            if($this->proximo == null)
                return 1;
            else
                return $cont + $this->proximo->tamanhoLista();
        }


        // Busca e retorna o objeto Pessoa que corresponde ao nome buscado.
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
                
                return null;
            }
        }


        // Inserções ------------------------------------------------------------------------------
        // Inserir no final
        public function adicionaNoFinal(Pessoa $dado){
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }else{
                $listaTemp = $this;
                if($listaTemp->proximoExiste()){
                    while($listaTemp->proximoExiste())
                        $listaTemp = $listaTemp->proximo;
                }
                $listaTemp->proximo = new Lista();
                if($listaTemp->proximo == null)
                    return null; // caso não seja possível criar um novo local em memória
                $listaTemp->proximo->dados = $dado;
                return $listaTemp->proximo->dados;
            }
        }


        // Insere no início
        public function adicionaNoInicio(Pessoa $dado){
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }else{
                $listaTemp = new Lista();
                if($listaTemp == null)
                    return null;
                $listaTemp->dados = $this->dados;
                $this->dados = $dado;
                $listaTemp->proximo = $this->proximo;
                $this->proximo = $listaTemp;
                return $this->dados;
            }
        }


        // Insere após um determinado dado
        public function adicionaDepois(Pessoa $dados, string $nome){
            removeQuebraDeLinha($nome);
            if($this->listaVazia())
                return null;
            else{
                if(strcmp($this->dados->getNome(), $nome) == 0){
                    $this->proximo->adicionaNoInicio($dados);
                }else
                    if($this->proximo->proximoExiste())
                        return $this->proximo->adicionaDepois($dados, $nome);
                    else
                        return null;
            }
        }


        // Remoções -------------------------------------------------------------------------------
        // Remove um item no início da lista
        public function removeNoInicio(){
            if($this->listaVazia())
                return null;
            if($this->proximoExiste()){
                $dadoTemp = $this->dados;
                $this->dados = $this->proximo->dados;
                $listaTemp = $this->proximo->proximo;
                unset($this->proximo);
                $this->proximo = $listaTemp;
                return $dadoTemp;
            }
        }

        // Remove um item no final da lista
        public function removeNoFinal(){
            if($this->listaVazia())
                return null;
            else{
                if($this->proximoExiste()){
                    if(!$this->proximo->proximoExiste()){
                        $dadoTemp = $this->proximo->dados;
                        unset($this->proximo);
                        $this->proximo = null;
                        return $dadoTemp;
                    }else
                        return $this->proximo->removeNoFinal();
                }else{
                    $dadoTemp = $this->dados;
                    unset($this->dados);
                    $this->dados = null;
                    return $dadoTemp;
                }
            }
        }

        // Remove um item pelo nome
        public function removePeloNome(string $nome){
            removeQuebraDeLinha($nome);
            if($this->listaVazia())
                return null;
            if($this->proximoExiste()){
                if(strcmp($this->dados->getNome(), $nome) == 0){
                    $dadoTemp = $this->dados;
                    $this->dados = $this->proximo->dados;
                    $listaTemp = $this->proximo->proximo;
                    unset($this->proximo);
                    $this->proximo = $listaTemp;
                    return $dadoTemp;
                }else
                    return $this->proximo->removePeloNome($nome);
            }
            if(strcmp($this->dados->getNome(), $nome) == 0){
                $dadoTemp = $this->dados;
                unset($this->dados);
                $this->dados = null;
                return $this->dados;
            }
        }


        // Mostra a lista -------------------------------------------------------------------------
        public function printLista(){
            if($this->listaVazia())
                return null;
            else{
                echo $this->dados->getNome()." ";
                echo $this->dados->getIdade()."\n";
                if($this->proximoExiste())
                    $this->proximo->printLista();
                return true;
            }
        }
    }
?>