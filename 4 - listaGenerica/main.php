<?php
    require "./lista.php";
    require "../dados/pessoa.php";

    // variaveis
    $lista = new Lista();


    // Programa
    while(1){
        $opcaoMenu = (int) menu();
        if($opcaoMenu == 7)
            break;
        switch($opcaoMenu){
            case 1: apagaLista($lista); break;
            case 2: quantidadeDeElementos($lista); break;
            case 3: buscarIndicePorNome($lista); break;
            case 4: menuInserir($lista); break;
            case 5: menuRemove($lista); break;
            case 6: mostrarLista($lista); break;
        }
    }



    // Funções
    function titulo(){
        system("clear");
        print "----------------------------\n";
        print "-------Lista Genérica-------\n";
        print "----------------------------\n\n";
    }

    function menu(){
        titulo();
        print "------------Menu------------\n";
        print "1 - Apagar lista;\n";
        print "2 - Quantidade de elementos;\n";
        print "3 - Buscar dados por nome;\n";
        print "4 - Inserir;\n";
        print "5 - Remover;\n";
        print "6 - Mostrar lista;\n";
        print "7 - Sair;\n";
        print "Digite sua resposta: ";
        $opcao = (int) fgets(STDIN);
        if($opcao<1 || $opcao>7){
            system("clear");
            print "Opção inválida! Tecle enter para tentar novamente.\n";
            fgets(STDIN);
            $opcao = menu();
        }
        return $opcao;
    }

    function apagaLista(Lista $list){
        system("clear");
        titulo();
        $list->liberaLista();
        print "A lista foi apagada! Tecle enter para continuar.";
        fgets(STDIN);
    }

    function quantidadeDeElementos(Lista $list){
        system("clear");
        titulo();
        print "A lista contém " . $list->quantidadeDeElementos() . " elementos.\n";
        print "Tecle enter para continuar.\n";
        fgets(STDIN);
    }

    function buscarIndicePorNome(Lista $list){
        system("clear");
        titulo();
        print "Digite o nome: ";
        $nome = (string) fgets(STDIN);
        $busca = $list->retornaDado($nome, function($dadoLista, $nomeBuscado){
            $nomeTemp = (string)$nomeBuscado;
            removeQuebraDeLinha($nomeTemp);
            if(strcmp($dadoLista->getNome(), $nomeTemp))
                return true;
            else
                return false;
        });
        if($busca == null){
            removeQuebraDeLinha($nome);
            echo ("O nome ".$nome." não foi encontrado na lista\n");
        }
        else{
            print "Nome: ".$busca->getNome();
            print "Idade: ".$busca->getIdade()."\n";
        }
        print "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function menuInserir(Lista $list){
        while(1){
            titulo();
            print "------------Inserir------------\n";
            print "1 - Inserir no final da lista\n";
            print "2 - Inserir no inicio da lista\n";
            print "3 - Inserir após um nome\n";
            print "Digite a opção desejada: ";
            $opcaoInserir = (int) fgets(STDIN);
            if($opcaoInserir < 1 || $opcaoInserir > 3){
                system("clear");
                print "Opção inválida! Tecle enter para tentar novamente.\n";
                fgets(STDIN);
            }else break;
        }
        titulo();
        print "Digite o nome para adicionar: ";
        $nome = (string) fgets(STDIN);
        print "Digite a idade: ";
        $idade = (int) fgets(STDIN);
        switch($opcaoInserir){
            case 1: inserirNoFinal($list, $nome, $idade); break;
            case 2: inserirNoInicio($list, $nome, $idade); break;
            case 3: inserirAposNome($list, $nome, $idade); break;
        }
        titulo();
        print "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function inserirNoFinal(Lista $list, string $nome, int $idade){
        titulo();
        if($list->adicionaNoFinal(new Pessoa($nome, $idade)) == false)
            error_log("Erro ao inserir no final da lista.");
    }

    function inserirNoInicio(Lista $list, string $nome, int $idade){
        titulo();
        if($list->adicionaNoInicio(new Pessoa($nome, $idade)) == false)
            error_log("Erro ao inserir no inicio da lista.");
    }

    function inserirAposNome(Lista $list, string $nome, int $idade){
        titulo();
        print "Digite o nome já existente na lista ou um indice: ";
        $nomeExistente = fgets(STDIN);
        removeQuebraDeLinha($nomeExistente);
        $list->adicionaDepois($nomeExistente ,new Pessoa($nome, $idade), 'compara');
    }


    function menuRemove(Lista $list){
        while(1){
            titulo();
            print "------------Remover------------\n";
            print "1 - Remover no final da lista\n";
            print "2 - Remover no inicio da lista\n";
            print "3 - Remover por nome\n";
            print "Digite a opção desejada: ";
            $opcaoInserir = (int) fgets(STDIN);
            if($opcaoInserir < 1 || $opcaoInserir > 3){
                system("clear");
                print "Opção inválida! Tecle enter para tentar novamente.\n";
                fgets(STDIN);
            }else break;
        }
        switch($opcaoInserir){
            case 1: removeNoFinalMain($list); break;
            case 2: removeNoInicioMain($list); break;
            case 3: removeNome($list); break;
        }
        titulo();
        print "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function removeNoFinalMain(Lista $list){
        titulo();
        $dadoRemovido = $list->removeNoFinal();
        if($dadoRemovido == null)
            error_log("Erro ao remover no final. Não há itens.");
        else{
            print "Dado removido: ";
            print "Nome: ".$dadoRemovido->getNome();
            print "Idade: ".$dadoRemovido->getIdade();
        }
    }
    
    function removeNoInicioMain(Lista $list){
        titulo();
        $dadoRemovido = $list->removeNoInicio();
        if($dadoRemovido == null)
            error_log("Erro ao remover no início. Não há itens.");
        else{
            print "Dado removido: ";
            print "Nome: ".$dadoRemovido->getNome();
            print "Idade: ".$dadoRemovido->getIdade();
        }
    }

    function removeNome(Lista $list){
        titulo();
        print "Digite um nome ou um indice para remover: ";
        $nome = fgets(STDIN);
        removeQuebraDeLinha($nome);
        $dadoRemovido = $list->removeDado($nome, 'compara');
        if($dadoRemovido == null)
            error_log("Erro ao remover pelo nome. Nome não encontrado.");
        else{
            print "Dado removido: ";
            print "Nome: ".$dadoRemovido->getNome();
            print "Idade: ".$dadoRemovido->getIdade();
        }
    }


    function mostrarLista(Lista $list){
        system("clear");
        titulo();
        if($list->printLista('imprimeDado') == false)
            print "Lista vazia.";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }


    // funções auxiliares (passadas para a lista)
    function compara($dadoLista, $nomeBuscado){
        $nomeTemp = (string)$nomeBuscado;
        removeQuebraDeLinha($nomeTemp);
        if(strcmp($dadoLista->getNome(), $nomeTemp) == 0)
            return true;
        else
            return false;
    }

    // imprime dado
    function imprimeDado($dado){
        echo $dado->getNome()." ";
        echo $dado->getIdade()."\n";
    }
?>