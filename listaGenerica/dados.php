<?php
    require "../libs/input.php";
    class Dados{
        private string $nome;
        private int $idade;

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