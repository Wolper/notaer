<?php

/**
 * AdminCategory.class [ MODEL ADMIN ]
 * Responável por gerenciar as aeronaves do sistema no admin!
 * 
 * @copyright (c) 2017, Dikson Delgado
 */
class AdminAeronave {

    private $Data;
    private $idAeronave;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'aeronave';

    /**
     * <b>Cadastrar Aeronave:</b> Envelope titulo, descrição, data e sessão em um array atribuitivo e execute esse método
     * para cadastrar a aeronave. Case seja uma sessão, envie o aeronave_parent como STRING null.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ['<b>Erro ao cadastrar:</b> Para cadastrar uma aeronave, preencha todos os campos!', WS_ALERT];
        else:
//            $this->setData();
//            $this->setName();
            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar Categoria:</b> Envelope os dados em uma array atribuitivo e informe o id de uma
     * aeronave para atualiza-la!
     * @param INT $$idAero = Id da aeronave
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($idAero, array $Data) {
        $this->idAeronave = (int) $idAero;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["<b>Erro ao atualizar:</b> Para atualizar a aeronave {$this->Data['nomeAeronave']}, preencha todos os campos!", WS_ALERT];
        else:
//            $this->setData();
//            $this->setName();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta aeronave:</b> Informe o ID de uma aeronave para remove-la do sistema. Esse método verifica
     * o tipo de aeronave e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $idAero = Id da aeronave
     */
    public function ExeDelete($idAero) {
        $this->idAeronave = (int) $idAero;

        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE idAeronave = :idAero", "idAero={$this->idAeronave}");

        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ['Oppsss, você tentou remover uma aeronave que não existe no sistema!', WS_INFOR];
        else:
            extract($read->getResult()[0]);
            $delete = new Delete;
            $delete->ExeDelete(self::Entity, "WHERE idAeronave = :idAero", "idAero={$this->idAeronave}");

            $this->Result = true;
            $this->Error = ["A <b>{$nomeAeronave}</b> foi removida com sucesso do sistema!", WS_ACCEPT];
        endif;
    }

    /**
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não. Para verificar
     * erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com a mensagem e o tipo de erro!
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Cadastra a aeronave no banco!
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["<b>Sucesso:</b> A aeronave {$this->Data['nomeAeronave']} foi cadastrada no sistema!", WS_ACCEPT];
        endif;
    }

    //Atualiza Categoria
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE idAeronave = :idAero", "idAero={$this->idAeronave}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> A atualização foi realizada no sistema!", WS_ACCEPT];
        endif;
    }

}
