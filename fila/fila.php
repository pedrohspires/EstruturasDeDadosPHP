<?php
    // A pilha (stack) é um tipo de lista em que só se insere e remove dados no final,
    // logo poderia ser usada qualquer lista, implementando apenas as suas funções
    // de remoção no final e inserção no final. Muitas funções serão simplesmente copiadas
    // da lista genéria, que será usada como base.
    require "../dados/pessoa.php";

    $cont = 0; // variável $cont não é necessária na fila. Criei apenas para fins estéticos na
               // função "printFila()"
    class Fila{
        private ?Fila $proximo = null;
        private mixed $dados = null;
        private bool $flag = false; //usado simplesmente para indicar o primeiro elemento na hora
                                    //de mostrar os dados com printPilha()

        // apagar a pilha da memória --------------------------------------------------------------
        public function liberaFila(){
            if($this->proximo == null){
                $this->dados = null;
                return null;   
            }else{
                $listaTemp = $this->proximo->proximo;
                unset($this->proximo);
                $this->proximo = $listaTemp;
                $this->liberaFila();
                if($this->proximo != null)
                    $this->liberaFila();
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
        public function filaVazia(){
            if(!$this->proximoExiste() && !$this->dadosExistem())
                return true;
            else
                return false;
        }


        // Retorna a quantidade de elmentos na lista ----------------------------------------------
        public function quantidadeDeElementos(){
            $cont = 1;
            if($this->filaVazia())
                return 0;
            else
                if(!$this->proximoExiste() && $this->dadosExistem())
                    return 1;
                else
                    return $cont + $this->proximo->quantidadeDeElementos();
                
        }


        // Insere no final
        public function enQueue($dado){
            if($this->filaVazia()){
                $this->flag = true;
                $this->dados = $dado;
                return $this->dados;
            }else{
                if(!$this->proximoExiste()){
                    $listaTemp = new Fila();
                    if($listaTemp == null)
                        return null;
                    $listaTemp->dados = $dado;
                    $this->proximo = $listaTemp;
                    return $this->proximo->dados;
                }else $this->proximo->enQueue($dado);
            }
        }


        // Remove no início
        public function deQueue(){
            if($this->filaVazia())
                return null;
            else{
                $dadoTemp = $this->dados;
                if(!$this->proximoExiste()){
                    unset($this->dados);
                    $this->dados = null;
                    return $dadoTemp;
                }
                $this->dados = $this->proximo->dados;
                $listaTemp = $this->proximo;
                unset($this->proximo);
                $this->proximo = $listaTemp->proximo;
                unset($listaTemp);
                $listaTemp = null;
                return $dadoTemp;
            }
        }

        
        // Mostra a pilha -------------------------------------------------------------------------
        public function printFila($funcao){
            global $cont;
            if($this->filaVazia())
                return null;
            else{
                if($this->flag)
                        echo "PRIMEIRO DA FILA -> ";
                if($this->proximoExiste()){
                    $funcao($this->dados);
                    if($cont == 3){
                        echo "\n";
                        $cont=0;
                    }else{
                        echo " | ";
                        $cont++;
                    }
                    $this->proximo->printFila($funcao);
                }else{
                    $funcao($this->dados);
                    $cont = 0;
                    echo " <- ÚLTIMO DA FILA\n";
                }
            }
            return true;
        }
    }
?>