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
        private bool $primeiro = true;
            // $primeiro serve para dizer se este é o primeiro nó da lista
            // caso seja, todos os outros atributos serão "null".
            // O motivo é que para adicionar e remover no início, é necessário
            // modificar o primeiro elemento, porém não é possível reatribuir o objeto $this.
        private ?Pessoa $dados = null;
        private ?Lista $proximo = null;


        // Remove todos os elementos da lista -----------------------------------------------------
        public function liberaLista(){
            if($this->primeiroItem() && $this->listaVazia())
                return null;
            else
                if($this->proximoExiste())
                    if($this->proximo->proximoExiste())
                        $this->proximo->liberaLista();
            unset($this->proximo);
            $this->proximo = null;
            return true;
        }


        // Verificações ---------------------------------------------------------------------------
        // Verifica se a lista está vazia
        public function listaVazia(){
            if($this->primeiroItem() && $this->proximo == null)
                return true;
            else
                return false;
        }


        // Verifica se é o primeiro item da lista
        public function primeiroItem(){
            return $this->primeiro;
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
            if($this->proximo == null)
                return 0;
            else
                return $cont + $this->proximo->tamanhoLista();
        }


        // Busca e retorna o objeto Pessoa que corresponde ao nome buscado.
        public function retornaDado(string $nome){
            removeQuebraDeLinha($nome);
            if($this->listaVazia())
                return null;
            else{
                if($this->primeiroItem())
                    return $this->proximo->retornaDado($nome);
                if(strcmp($this->dados->getNome(), $nome) == 0)
                    return $this->dados;
                else
                    if($this->proximoExiste())
                        return $this->proximo->retornaDado($nome);
            }
        }


        // Inserções ------------------------------------------------------------------------------
        // Inserir no final
        public function adicionaNoFinal(Pessoa $dado){
            if($this->listaVazia()){
                $this->proximo = new Lista();
                $this->proximo->primeiro = false;
                $this->proximo->dados = $dado;
            }else{
                $listaTemp = $this->proximo;
                while($listaTemp->proximoExiste())
                    $listaTemp = $listaTemp->proximo;
                $listaTemp->proximo = new Lista();
                if($listaTemp == null)
                    return null; // caso não seja possível criar um novo local em memória
                $listaTemp->proximo->primeiro = false;
                $listaTemp->proximo->dados = $dado;
            }
        }


        // Insere no início
        public function adicionaNoInicio(Pessoa $dado){
            if($this->listaVazia()){
                $this->proximo = new Lista();
                $this->proximo->primeiro = false;
                $this->proximo->dados = $dado;
            }else{
                $listaTemp = new Lista();
                if($listaTemp == null)
                    return null; // caso não seja possível criar um novo local em memória
                $listaTemp->primeiro = false;
                $listaTemp->dados = $dado;
                $listaTemp->proximo = $this->proximo;
                $this->proximo = $listaTemp;
            }
        }


        // Insere após um determinado dado
        public function adicionaDepois(Pessoa $dados, string $nome){
            removeQuebraDeLinha($nome);
            if($this->primeiroItem() && !$this->listaVazia())
                $this->proximo->adicionaDepois($dados, $nome);
            else{
                if(strcmp($this->dados->getNome(), $nome) == 0){
                    $listaTemp = new Lista();
                    if($listaTemp == null)
                        return null; // caso não seja possível criar um novo local em memória
                    $listaTemp->primeiro = false;
                    $listaTemp->dados = $dados;
                    $listaTemp->proximo = $this->proximo;
                    $this->proximo = $listaTemp;
                    return true;
                }else
                    if($this->proximo == null)
                        return false; //caso já seja o último dado da lista a busca para
                    else
                        return $this->proximo->adicionaDepois($dados, $nome); //chama recursivamente
                                                                              //a adição no próximo
                                                                              //item
            }
        }


        // Remoções -------------------------------------------------------------------------------
        // Remove um item no início da lista
        public function removeNoInicio(){
            if($this->listaVazia() && $this->primeiroItem())
                return null;
            if(!$this->listaVazia()){
                if($this->proximo->proximoExiste()){
                    $listaTemp = $this->proximo;
                    $this->proximo = $listaTemp->proximo;
                    $dadoTemp = $this->proximo->dados;
                    unset($listaTemp);
                    return $dadoTemp;
                }else{
                    $dadoTemp = $this->proximo->dados;
                    unset($this->proximo);
                    $this->proximo = null;
                    return $dadoTemp;
                }
            }
        }

        // Remove um item no final da lista
        public function removeNoFinal(){
            if($this->primeiroItem() && !$this->proximoExiste())
                return null;
            else{
                if(!$this->proximo->proximoExiste()){
                    $dadoTemp = $this->proximo->dados;
                    unset($this->proximo);
                    $this->proximo = null;
                    return $dadoTemp;
                }else
                    return $this->proximo->removeNoFinal();
            }
        }

        // Remove um item pelo nome
        public function removePeloNome(string $nome){
            removeQuebraDeLinha($nome);
            if($this->primeiroItem() && !$this->proximoExiste())
                return null;
            if($this->proximoExiste()){
                if(strcmp($this->proximo->dados->getNome(), $nome) == 0){
                    $listaTemp = $this->proximo;
                    $this->proximo = $listaTemp->proximo;
                    $dadoTemp = $listaTemp->dados;
                    unset ($listaTemp);
                    return $dadoTemp;
                }else{
                    if($this->proximo->proximoExiste())
                        return $this->proximo->removePeloNome($nome);
                    else
                        return null;
                }
            }
        }


        // Mostra a lista -------------------------------------------------------------------------
        public function printLista(){
            if($this->primeiroItem() && $this->proximoExiste())
                $this->proximo->printLista();
            else{
                if(!$this->primeiroItem()){
                    echo $this->dados->getNome()." ";
                    echo $this->dados->getIdade()."\n";
                    if($this->proximoExiste())
                        $this->proximo->printLista();
                }
            }
        }
    }
?>