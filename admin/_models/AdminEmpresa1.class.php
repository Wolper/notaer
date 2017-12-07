<?php

/**
 * AdminEmpresa.class [ MODEL ADMIN ]
 * Responável por gerenciar as empresas no admin do sistema!
 * 
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class AdminVoo {

    private $Data;
    private $Voo;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'voo';

    /**
     * <b>Cadastrar a Empresa:</b> Envelope os dados da empresa em um array atribuitivo e execute esse método
     * para cadastrar a mesma no banco.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Cadastrar: Para cadastrar voo, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
            $this->setName();
//            $this->sendCapa();
            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar a Empresa:</b> Envelope os dados em uma array atribuitivo e informe o id de uma empresa
     * para atualiza-la no banco de dados!
     * @param INT $EmpresaId = Id da Empresa
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($VooID, array $Data) {
        $this->Voo = (int) $VooID;
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Atualizar: Para atualizar o voo nº <b>{$this->Data['numero_voo']}</b>, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
            $this->setName();
//            $this->sendCapa();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta Empresas:</b> Informe o ID da empresa a ser removida para que esse método realize uma
     * checagem excluinto todos os dados nessesários e removendo a empresa do banco!
     * @param INT $VooId = Id do voo!
     */
    public function ExeDelete($VooId) {
        $this->Voo = (int) $VooId;

        $ReadEmp = new Read;
        $ReadEmp->ExeRead(self::Entity, "WHERE idvoo = :emp", "emp={$this->Voo}");
        if (!$ReadEmp->getResult()):
            $this->Error = ["O voo que você tentou deletar não existe no sistema!", WS_ERROR];
            $this->Result = false;
        else:
            $VooDelete = $ReadEmp->getResult()[0];
           
            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE idvoo = :emp", "emp={$this->Voo}");

            $this->Error = ["O voo <b>{$VooDelete['numero_voo']}</b> foi removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    /**
     * <b>Verificar Ação:</b> Retorna TRUE se ação for efetuada ou FALSE se não. Para verificar erros
     * execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com um erro e um tipo.
     * @return ARRAY $Error = Array associativo com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro. Realiza Upload da Capa!
    private function setData() {
        $this->Data['historico'] = Check::Name($this->Data['historico']);
//        $this->Data['data_do_voo'] = date('Y-m-d H:i:s');
    }

    //Cadastra a empresa no banco!
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["O voo <b>{$this->Data['numero_do_voo']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
        endif;
    }

    //Atualiza a empresa no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE idvoo = :id", "id={$this->Voo}");
        if ($Update->getRowCount() >= 1):
            $this->Error = ["O voo <b>{$this->Data['numero_voo']}</b> foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
