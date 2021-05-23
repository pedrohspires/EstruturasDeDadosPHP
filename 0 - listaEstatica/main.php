<?php
    require 'list.php';

    // variaveis
    $lista = new StaticList();
    $lista->insertBeginning("Pedro", 21);
    $lista->insertBeginning("Eric", 15);
    $lista->insertBeginning("Geruza", 42);

    
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
        print "-------Lista estática-------\n";
        print "----------------------------\n\n";
    }

    function menu(){
        titulo();
        print "------------Menu------------\n";
        print "1 - Apagar lista;\n";
        print "2 - Quantidade de elementos;\n";
        print "3 - Buscar indice por nome;\n";
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

    function apagaLista(StaticList $list){
        system("clear");
        titulo();
        $list->cleanList();
        print "A lista foi apagada! Tecle enter para continuar.";
        fgets(STDIN);
    }

    function quantidadeDeElementos(StaticList $list){
        system("clear");
        titulo();
        print "A lista contém " . $list->listLenght() . " elementos.\n";
        print "Tecle enter para continuar.\n";
        fgets(STDIN);
    }

    function buscarIndicePorNome(StaticList $list){
        system("clear");
        titulo();
        print "Digite o nome: ";
        $nome = (string) fgets(STDIN);
        removeLineBreak($nome);
        $busca = $list->returnIndexByName($nome);
        if($busca == false && !is_int($busca)){ //não encontrou ou está vazia
            if($list->isEmpty()) //verifica se a lista está vazia
                error_log("A lista está vazia");
            else{
                error_log($nome." não foi encontrado na lista");
            }
            print "Tecle enter para continuar.";
            fgets(STDIN);
            return false;
        }
        print "O nome ".$nome." pertence ao índice: ".$busca."\n";
        print "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function menuInserir(StaticList $list){
        while(1){
            titulo();
            print "------------Inserir------------\n";
            print "1 - Inserir no final da lista\n";
            print "2 - Inserir no inicio da lista\n";
            print "3 - Inserir após um nome ou em um indice\n";
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

    function inserirNoFinal(StaticList $list, string $nome, int $idade){
        titulo();
        if($list->insertEnd($nome, $idade) == false)
            error_log("Erro ao inserir no final da lista. A lista está cheia.");
    }

    function inserirNoInicio(StaticList $list, string $nome, int $idade){
        titulo();
        if($list->insertBeginning($nome, $idade) == false)
            error_log("Erro ao inserir no inicio da lista. A lista está cheia.");
    }

    function inserirAposNome(StaticList $list, string $nome, int $idade){
        titulo();
        print "Digite o nome já existente na lista ou um indice: ";
        $nomeIndiceExistente = fgets(STDIN);
        if(is_int($nomeIndiceExistente)){
            if($nomeIndiceExistente>$list->listLenght() || $nomeIndiceExistente<1)
                error_log("Indice não pode ser maior que o tamanho da lista");
            else
                if($list->insertAtIndex($nomeIndiceExistente, $nome, $idade) === false)
                    error_log("Erro ao inserir no meio da lista. A lista está cheia ou indice inválido.");

        }else{
            $indexExistente = $list->returnIndexByName($nomeIndiceExistente);
            if($indexExistente === false)
                $list->insertEnd($nome, $idade);
            else
                if($list->insertAtIndex($indexExistente, $nome, $idade) == false)
                    error_log("Erro ao inserir no inicio da lista. A lista está cheia.");
        }
    }


    function menuRemove(StaticList $list){
        while(1){
            titulo();
            print "------------Remover------------\n";
            print "1 - Remover no final da lista\n";
            print "2 - Remover no inicio da lista\n";
            print "3 - Remover por nome ou indice\n";
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

    function removeNoFinal(StaticList $list){
        titulo();
        if($list->removeEnd() == false)
            error_log("Erro ao remover no final! Lista vazia.");
    }
    
    function removeNoInicio(StaticList $list){
        titulo();
        if($list->removeBeginning() == false)
            error_log("Erro ao remover no início! Lista vazia.");
    }

    function removeNomeOuIndice(StaticList $list){
        titulo();
        print "Digite um nome ou um indice para remover: ";
        $nomeOuIndice = fgets(STDIN);
        if(is_int($nomeOuIndice)){
            if($list->removeIndex($nomeOuIndice) == false)
                error_log("Erro ao remover o indice. Lista vazia ou indice inválido");
        }else{
            if($list->returnIndexByName($nomeOuIndice) == false && !is_int($list->returnIndexByName($nomeOuIndice))){
                error_log("Erro ao remover pelo nome. Nome não encontrado.");
            }
            else
                if($list->removeIndex($list->returnIndexByName($nomeOuIndice)) == false)
                    error_log("Erro ao remover pelo nome. Lista vazia");
            
            print "Tecle enter para continuar.\n";
            fgets(STDIN);
        }
    }


    function mostrarLista(StaticList $list){
        system("clear");
        titulo();
        if($list->printList() == false)
            print "Lista vazia.";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }
?>