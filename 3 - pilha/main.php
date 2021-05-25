<?php
    require_once './stack.php';

    // variaveis
    $pilha = new Stack();
    $pilha->push("Pedro", 21);
    $pilha->push("Eric", 15);
    $pilha->push("Geruza", 42);
    $pilha->push("Eduardo", 44);
    $pilha->push("Esmeralda", 21);


    // Programa
    while(1){
        $opcaoMenu = (int) menu();
        if($opcaoMenu == 6)
            break;
        switch($opcaoMenu){
            case 1: apagarPilha(); break;
            case 2: quantidadeDeElementos(); break;
            case 3: inserir(); break;
            case 4: remover(); break;
            case 5: mostrarPilha(); break;
        }
    }


    // Funções
    function titulo(){
        system("clear");
        print "-----------------------------------\n";
        print "-------------- Pilha --------------\n";
        print "-----------------------------------\n\n";
    }

    function menu(){
        titulo();
        print "-------------- Menu --------------\n";
        print "1 - Apagar pilha;\n";
        print "2 - Quantidade de elementos;\n";
        print "3 - inserir;\n";
        print "4 - Remover;\n";
        print "5 - Mostrar pilha;\n";
        print "6 - Sair;\n";
        print "Digite sua resposta: ";
        $opcao = (int) fgets(STDIN);
        if($opcao<1 || $opcao>6){
            system("clear");
            titulo();
            print "Opção inválida! Tecle enter para tentar novamente.\n";
            fgets(STDIN);
            $opcao = menu();
        }
        return $opcao;
    }

    function apagarPilha(){
        global $pilha;
        titulo();
        if($pilha->clean() == null)
            echo "Pilha vazia!";
        echo " Tecle enter para continuar.";
        fgets(STDIN);
    }

    function quantidadeDeElementos(){
        global $pilha;
        titulo();
        $qtd = $pilha->length();
        if($qtd != null)
            echo "Existe ".$qtd." elemento(s) na pilha.\n";
        else
            echo "A pilha está vazia. ";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function inserir(){
        global $pilha;
        titulo();
        echo "Nome: ";
        $nome = (string) fgets(STDIN);
        echo "Idade: ";
        $idade = (int) fgets(STDIN);
        if($pilha->push($nome, $idade) != null)
            echo "Sucesso ao inserir na pilha.";
        else
            echo "Erro ao inserir na pilha. Falta de memória.";
    }


    function remover(){
        global $pilha;
        titulo();
        $dadoRemovido = $pilha->pop();
        if($dadoRemovido != null){
            echo "Pessoa removida:\n";
            echo "Nome: ".$dadoRemovido->getName()."\n";
            echo "Idade: ".$dadoRemovido->getAge()."\n";
        }else
            echo "Pilha está vazia. ";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }


    function printDado($dado){
        echo $dado->getNome()." ".$dado->getIdade()."\n";
    }


    function mostrarPilha(){
        global $pilha;
        titulo();
        if($pilha->printStack() == null)
            echo "Pilha está vazia.";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }
?>