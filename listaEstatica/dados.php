<?php
    class Dado {
        private ?string $nome = null;
        private ?int $idade = null;

        public function __construct(string $nome, int $idade){
            removeQuebraDeLinha($nome);
            $this->nome = $nome;
            $this->idade = $idade;
        }

        public function getNome(){
            return $this->nome;
        }

        public function getIdade(){
            return $this->idade;
        }
    }
?>