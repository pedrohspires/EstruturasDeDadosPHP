<?php
    require "./fila.php";

    $fila = new Fila();

    // Programa
    while(1){
        $opcaoMenu = (int) menu();
        if($opcaoMenu == 6)
            break;
        switch($opcaoMenu){
            case 1: apagarFila(); break;
            case 2: quantidadeDeElementos(); break;
            case 3: inserir(); break;
            case 4: remover(); break;
            case 5: mostrarFila(); break;
        }
    }


    // Funções
    function titulo(){
        system("clear");
        print "-----------------------------------\n";
        print "-------------- Fila ---------------\n";
        print "-----------------------------------\n\n";
    }

    function menu(){
        titulo();
        print "-------------- Menu ---------------\n";
        print "1 - Apagar fila;\n";
        print "2 - Quantidade de elementos;\n";
        print "3 - inserir;\n";
        print "4 - Remover;\n";
        print "5 - Mostrar fila;\n";
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

    function apagarFila(){
        global $fila;
        titulo();
        if($fila->liberaFila() == null)
            echo "Fila vazia!";
        echo " Tecle enter para continuar.";
        fgets(STDIN);
    }

    function quantidadeDeElementos(){
        global $fila;
        titulo();
        $qtd = $fila->quantidadeDeElementos();
        if($qtd != null)
            echo "Existe ".$qtd." elemento(s) na fila.\n";
        else
            echo "A fila está vazia. ";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }

    function inserir(){
        global $fila;
        titulo();
        echo "Nome: ";
        $nome = (string) fgets(STDIN);
        echo "Idade: ";
        $idade = (int) fgets(STDIN);
        if($fila->enQueue(new Pessoa($nome, $idade)) != null)
            echo "Sucesso ao inserir na fila.";
        else
            echo "Erro ao inserir na fila. Falta de memória.";
    }


    function remover(){
        global $fila;
        titulo();
        $dadoRemovido = $fila->deQueue();
        if($dadoRemovido != null){
            echo "Pessoa removida:\n";
            echo "Nome: ".$dadoRemovido->getNome()."\n";
            echo "Idade: ".$dadoRemovido->getIdade()."\n";
        }else
            echo "Fila está vazia. ";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }


    function printDado($dado){
        echo $dado->getNome()." ".$dado->getIdade();
    }


    function mostrarFila(){
        global $fila;
        titulo();
        if($fila->printFila('printDado') == null)
            echo "Fila está vazia.";
        echo "Tecle enter para continuar.";
        fgets(STDIN);
    }
?>