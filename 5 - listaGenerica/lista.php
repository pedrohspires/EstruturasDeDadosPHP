<?php
    class Lista{
        private ?Lista $proximo = null;
        private mixed $dados = null;


        // apagar a lista da memória --------------------------------------------------------------
        public function liberaLista(){
            if($this->proximo == null){
                $this->dados = null;
                return null;   
            }else{
                $listaTemp = $this->proximo->proximo;
                unset($this->proximo);
                $this->proximo = $listaTemp;
                $this->liberaLista();
                if($this->proximo != null)
                    $this->liberaLista();
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
        public function listaVazia(){
            if(!$this->proximoExiste() && !$this->dadosExistem())
                return true;
            else
                return false;
        }


        // Consultas ------------------------------------------------------------------------------
        // Retorna a quantidade de elmentos na lista
        public function quantidadeDeElementos(){
            $cont = 1;
            if($this->listaVazia())
                return 0;
            else
                if(!$this->proximoExiste() && $this->dadosExistem())
                    return 1;
                else
                    return $cont + $this->proximo->quantidadeDeElementos();
                
        }

        // Retorna o dado referente ao nome
        public function retornaDado($dado,$func){
            /*
            *   $func = é uma função de callback passada pelo usuário para fins de comparação
            *   $dado = é o dado passado para buscar
            *   $func deve receber dois dados, o primeiro é o dado da lista e o segundo é o
            *         dado passado para comparação.
            *   $func deve retornar um valor booleano. True para dados iguais e false para dados
            *         diferentes
            *   retorna null caso o objeto não exista ou o objeto, caso encontrado.
            */
            if($this->listaVazia())
                return null;
            else{
                if($func($this->dados, $dado))
                    return $this->dados;
                else
                    if($this->proximoExiste())
                        return $this->proximo->retornaDado($dado, $func);
            }
        }


        // Inserções ------------------------------------------------------------------------------
        // Insere no inicio
        public function adicionaNoInicio($dado){
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }
            else{
                $listaTemp = new Lista();
                if($listaTemp == null)
                    return null;
                $listaTemp->proximo = $this->proximo;
                $listaTemp->dados = $this->dados;
                $this->proximo = $listaTemp;
                $this->dados = $dado;
                return $this->dados;
            }
        }

        // Insere no final
        public function adicionaNoFinal($dado){
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }else{
                if(!$this->proximoExiste()){
                    $listaTemp = new Lista();
                    if($listaTemp == null)
                        return null;
                    $listaTemp->dados = $dado;
                    $this->proximo = $listaTemp;
                    return $this->proximo->dados;
                }else $this->proximo->adicionaNoFinal($dado);
            }
        }

        // Insere após um dado
        public function adicionaDepois($dado, $dadoParaAdicionar, $funcao, bool $INSERE_FINAL=false){
            if($this->listaVazia()){
                $this->dados = $dado;
                return $this->dados;
            }else{
                if($funcao($this->dados, $dado)){
                    // verifica por callback se os dados são iguais
                    // se for, adiciona o item ao próximo elemento
                    $listaTemp = new Lista();
                    if($listaTemp == null)
                        return null;
                    $listaTemp->dados = $dadoParaAdicionar;
                    $listaTemp->proximo = $this->proximo;
                    $this->proximo = $listaTemp;
                    return $this->proximo->dados;
                } else // se não for igual, verifica se existe um próximo elemento para verificar
                       // e chama esse elemento. Caso não exista, significa que chegou ao final da
                       // lista e, caso o usuário queira colocar no final, utilizando a flag
                       // $INSERE_FINAL, o dado será adicionado ao final da lista. Por padrão,
                       // a flag é inicializada com false, ou seja, não será adicionada.
                    if($this->proximoExiste())
                        return $this->proximo->adicionaDepois($dado, $dadoParaAdicionar, 
                                                              $funcao, $INSERE_FINAL);
                    else
                        if($INSERE_FINAL)
                            return $this->adicionaNoFinal($dadoParaAdicionar);
                        else
                            return null;
            }
        }


        // Remoções -------------------------------------------------------------------------------
        // Remove no início
        public function removeNoInicio(){
            if($this->listaVazia())
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

        // Remove no final
        public function removeNoFinal(){
            if($this->listaVazia())
                return null;
            else{
                if($this->proximoExiste())
                    if($this->proximo->proximoExiste())
                        return $this->proximo->removeNoFinal();
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

        // Remove dado igual
        public function removeDado($remover, $funcao){
            if($this->listaVazia())
                return null;
            else{
                if(!$this->proximoExiste()){
                    if($funcao($this->dados, $remover)){
                        //remover se for o primeiro dado
                        return $this->removeNoInicio();
                    }else return null;
                }else
                    if($funcao($this->dados, $remover)){
                        //remove se for o primeiro item e se existir um próximo elemento
                        return $this->removeNoInicio();
                    }else 
                        if($funcao($this->proximo->dados, $remover)){
                            $dadoTemp = $this->proximo->dados;
                            $listaTemp = $this->proximo->proximo;
                            unset($this->proximo);
                            $this->proximo = $listaTemp;
                            return $dadoTemp;
                        }else
                            if($this->proximo->proximoExiste())
                                return $this->proximo->removeDado($remover, $funcao);
                            else return null;
            }
        }

        public function printLista($funcao){
            if($this->listaVazia())
                return null;
            else{
                $funcao($this->dados);
                if($this->proximoExiste())
                    return $this->proximo->printLista($funcao);
                else
                    return true;
            }
        }
    }
?>