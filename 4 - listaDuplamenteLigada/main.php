<?php
    require "./lista.php";

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
            case 6: menuMostraLista($lista); break;
        }
    }



    // Funções
    function titulo(){
        system("clear");
        print "----------------------------\n";
        print "-------Lista Dinâmica-------\n";
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
        print "A lista contém " . $list->tamanhoLista() . " elementos.\n";
        print "Tecle enter para continuar.\n";
        fgets(STDIN);
    }

    function buscarIndicePorNome(Lista $list){
        system("clear");
        titulo();
        print "Digite o nome: ";
        $nome = (string) fgets(STDIN);
        $busca = $list->retornaDado($nome);
        if($busca == null){
            removeQuebraDeLinha($nome);
            echo ("O nome ".$nome." não foi encontrado na lista\n");
        }
        else{
            print "Nome: ".$busca->getNome()."\n";
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
        $list->adicionaDepois(new Pessoa($nome, $idade), $nomeExistente);
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
            case 1: removeNoFinal($list); break;
            case 2: removeNoInicio($list); break;
            case 3: removeNomeOuIndice($list); break;
        }
        titulo();
        print "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function removeNoFinal(Lista $list){
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
    
    function removeNoInicio(Lista $list){
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

    function removeNomeOuIndice(Lista $list){
        titulo();
        print "Digite um nome ou um indice para remover: ";
        $nome = fgets(STDIN);
        $dadoRemovido = $list->removePeloNome($nome);
        if($dadoRemovido == null)
            error_log("Erro ao remover pelo nome. Nome não encontrado.");
        else{
            print "Dado removido: ";
            print "Nome: ".$dadoRemovido->getNome();
            print "Idade: ".$dadoRemovido->getIdade();
        }
    }


    function menuMostraLista(Lista $list){
        while(1){
            titulo();
            print "---------Mostrar Lista---------\n";
            print "1 - Mostrar lista resumida\n";
            print "2 - Mostrar cada elemento com seu anterior e próximo\n";
            print "Digite a opção desejada: ";
            $opcaoInserir = (int) fgets(STDIN);
            if($opcaoInserir < 1 || $opcaoInserir > 2){
                system("clear");
                print "Opção inválida! Tecle enter para tentar novamente.\n";
                fgets(STDIN);
            }else break;
        }
        switch($opcaoInserir){
            case 1: mostrarListaResumida($list); break;
            case 2: mostrarListaCompleta($list); break;
        }
    }


    function mostrarListaResumida(Lista $list){
        system("clear");
        titulo();
        if($list->printLista() == false)
            print "Lista vazia. ";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }


    function mostrarListaCompleta(Lista $list){
        system("clear");
        titulo();
        echo "ante. | atual | prox.\n";
        if($list->printAllLista() == false)
            print "Lista vazia. ";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }
?>