<?php
    require 'dados.php';
    require '../libs/input.php';
    define("tamanhoMaximo", 50);

    class Lista{
        private int $tamanho;
        private ?array $pessoa = null;

        // Cria a lista vazia, sem elementos ----------------------------------------------------------------
        public function __construct(){
            $this->tamanho = 0;
        }

        // Apaga todos os itens da lista --------------------------------------------------------------------
        public function liberaLista(){
            for($cont=0; $cont<$this->tamanho; $cont++){
                unset($this->pessoa[$cont]);
            }
            $this->tamanho = 0;
        }

        // Verificações -------------------------------------------------------------------------------------
        // Lista vazia
        public function listaVazia(){
            if($this->tamanho == 0)
                return true;
            else
                return false;
        }

        // Lista cheia
        public function listaCheia(){
            if($this->tamanho == tamanhoMaximo)
                return true;
            else
                return false;
        }

        // Consultas ----------------------------------------------------------------------------------------
        // Quantidade de elementos
        public function quantidadeDeElementos(){
            return $this->tamanho;
        }

        // Retorna o índice de um nome
        public function retornaIndice(string $nome){
            if($this->listaVazia()){
                return false;
            }
            removeQuebraDeLinha($nome);
            for($cont=0; $cont<$this->tamanho; $cont++){
                if(strcmp($this->pessoa[$cont]->getNome(), $nome) == 0){
                    return $cont;
                }
            }
            return false;
        }

        // Inserções ----------------------------------------------------------------------------------------
        // Insere no final
        public function adicionaNoFinal(string $nome, int $idade){
            if($this->listaCheia()){
                return false;
            }
            $this->pessoa[$this->tamanho] = new Dado($nome, $idade);
            $this->tamanho++;
            return true;
        }

        // Insere no inicio
        public function adicionaNoInicio(string $nome, int $idade){
            if($this->listaCheia()){
                return false;
            }
            $cont=$this->tamanho;
            $this->pessoa[$cont] = new Dado("\0", 0); // cria um objeto pessoa vazio para ser substituído na inserção
            while($cont>0){
                $this->pessoa[$cont] = $this->pessoa[$cont-1];
                $cont--;
            }
            $this->pessoa[0] = new Dado($nome, $idade);
            $this->tamanho++;
            return true;
        }

        // Insere com base na posição
        public function adicionaNoMeio(int $index, string $nome, int $idade){
            if($this->listaCheia())
                return false;
            if($index<0 || $index>$this->tamanho)
                return false;
            $cont = $this->tamanho;
            $this->pessoa[$cont] = new Dado("\0", 0); // cria um objeto pessoa vazio para ser substituído na inserção
            while($cont>$index){
                $this->pessoa[$cont] = $this->pessoa[$cont-1];
                $cont--;
            }
            $this->pessoa[$index] = new Dado($nome, $idade);
            $this->tamanho++;
            return true;
        }
        
        // Remoções ---------------------------------------------------------------------------------------------
        // Remoção no final
        public function removeFinal(){
            if($this->listaVazia())
                return false;
            unset($this->pessoa[$this->tamanho-1]);
            $this->tamanho--;
            return true;
        }

        // Remoção no início
        public function removeInicio(){
            if($this->listaVazia())
                return false;
            for($cont=0; $cont<$this->tamanho-1;$cont++)
                $this->pessoa[$cont] = $this->pessoa[$cont+1];
            unset($this->pessoa[$this->tamanho-1]);
            $this->tamanho--;
            return true;
        }

        // Remove um íncide
        public function removeIndice(int $index){
            if($this->listaVazia())
                return false;
            if($index<0 || $index>$this->tamanho-1)
                return false;
            for($cont=$index; $cont<$this->tamanho-1; $cont++){
                $this->pessoa[$cont] = $this->pessoa[$cont+1];
            }
            unset($this->pessoa[$this->tamanho-1]);
            $this->tamanho--;
            return true;
        }
            

        
        // Mostra a lista -----------------------------------------------------------------------------------
        public function printLista(){
            if($this->listaVazia())
                return false;
            for($cont=0; $cont<$this->tamanho; $cont++){
                print "Pessoa ".($cont+1).": ".$this->pessoa[$cont]->getNome()." ".$this->pessoa[$cont]->getIdade()."\n";
            }
            return true;
        }
    }
?>