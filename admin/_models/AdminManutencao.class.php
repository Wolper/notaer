<?php

/**
 * AdminInstalacao.class [ MODEL ADMIN ]
 * Responável por gerenciar as instalacaos no admin do sistema!
 * 
 * @copyright (c) 2017, Dikson Delgado
 */
class AdminManutencao {

    private $Data;
    private $Inspecao;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'inspecao';

   
    /**
     * <b>Atualizar a Instalacao:</b> Envelope os dados em uma array atribuitivo e informe o id de uma instalacao
     * para atualiza-la no banco de dados!
     * @param INT $InstalacaoId = Id da Instalacao
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($idInstalacao, array $Data) {
        $this->Inspecao = (int) $idInstalacao;
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Atualizar: Para atualizar a instalacao <b>{$this->Data['descricaoInstalacao']}</b>, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
//            $this->setData();
//            $this->setName();
//            $this->sendCapa();
            $this->Update();
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
//        $this->Data['descricaoInstalacao'] = Check::Name($this->Data['descricaoInstalacao']);
//        $this->Data['data_do_voo'] = date('Y-m-d H:i:s');
    }


    //Atualiza a instalacao no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE idInspecao = :id", "id={$this->Inspecao}");
        if ($Update->getRowCount() >= 1):
            $this->Error = ["A inspeção foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
