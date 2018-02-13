<?php

/**
 * AdminInspecao.class [ MODEL ADMIN ]
 * Responável por gerenciar as inspecaos no admin do sistema!
 * 
 * @copyright (c) 2017, Dikson Delgado
 */
class AdminInspecao {

    private $Data;
    private $Inspecao;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'tipo_inspecao';

    /**
     * <b>Cadastrar a Inspecao:</b> Envelope os dados da inspecao em um array atribuitivo e execute esse método
     * para cadastrar a mesma no banco.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Cadastrar: Para cadastrar inspeção, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
//            $this->setName();
//            $this->sendDocumento();
            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar a Inspecao:</b> Envelope os dados em uma array atribuitivo e informe o id de uma inspecao
     * para atualiza-la no banco de dados!
     * @param INT $InspecaoId = Id da Inspecao
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($idInspecao, array $Data) {
        $this->Inspecao = (int) $idInspecao;
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Atualizar: Para atualizar a inspecao <b>{$this->Data['descricaoInspecao']}</b>, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
//            $this->setData();
//            $this->setName();
//            $this->sendCapa();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta Inspecaos:</b> Informe o ID da inspecao a ser removida para que esse método realize uma
     * checagem excluinto todos os dados nessesários e removendo a inspecao do banco!
     * @param INT $VooId = Id da inspecao!
     */
    public function ExeDelete($idInsp) {
        $this->Inspecao = (int) $idInsp;

        $ReadEmp = new Read;
        $ReadEmp->ExeRead(self::Entity, "WHERE id_tipo_inspecao = :insp", "insp={$this->Inspecao}");
        if (!$ReadEmp->getResult()):
            $this->Error = ["A inspeção que você tentou deletar não existe no sistema!", WS_ERROR];
            $this->Result = false;
        else:
            $InspecaoDelete = $ReadEmp->getResult()[0];

            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE id_tipo_inspecao = :insp", "insp={$this->Inspecao}");

            $this->Error = ["O tipo de inspeção <b>{$InspecaoDelete['descricaoInspecao']}</b> foi removido com sucesso do sistema!", WS_ACCEPT];
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
        $this->Data['descricaoInspecao'] = Check::Name($this->Data['descricaoInspecao']);
//        $this->Data['data_do_voo'] = date('Y-m-d H:i:s');
    }

    //Cadastra a inspecao no banco!
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["A inspeção <b>{$this->Data['descricaoInspecao']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
        endif;
    }

    //Atualiza a inspecao no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id_tipo_inspecao = :id", "id={$this->Inspecao}");
        if ($Update->getRowCount() >= 1):
            $this->Error = ["A inspeção <b>{$this->Data['descricaoInspecao']}</b> foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function sendDocumento() {
        if (isset($this->Data['itens_inspecao']) && !empty($this->Data['itens_inspecao'])):
            move_uploaded_file($this->Data['itens_inspecao'], 'teste');
            unset($this->Data['itens_inspecao']);
        endif;
    }

}
