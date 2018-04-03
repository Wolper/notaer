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
    private $tcInspecao;
    private $in_dataInspecao;
    private $in_anvInspecao;
    private $in_tsnInspecao;
    private $in_tsoInspecao;
    private $frequencia_for_time;
    private $vencimento_for_time;
    private $frequencia_for_date;
    private $vencimento_for_date;
    private $horasDeVooAeronave;
    private $limiteInspecao;
    private $ntl;
    private $ng;

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
        $this->Update();
    }

    public function modificaControles($idAeronave) {
        $query = "SELECT * FROM (SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.idtipoinspecao = ti.id_tipo_inspecao  WHERE i.idAeronave = '" . $idAeronave . "' GROUP BY i.idtipoinspecao) AS ma JOIN (SELECT * FROM aeronave) AS aero ON aero.idAeronave = ma.idAeronave WHERE aero.idAeronave = '" . $idAeronave . "'";

        $readRegVoo = new Read;
        $readRegVoo->FullRead($query);

        if (!$readRegVoo->getRowCount() > 0):
            return 'Ainda não há dados das aeronaves cadastrados';
        else:

            foreach ($readRegVoo->getResult() as $cons):

                $this->tcInspecao = $cons['tcInspecao'];
                $this->in_dataInspecao = $cons['in_dataInspecao'];
                $this->in_anvInspecao = $cons['in_anvInspecao'];
                $this->in_tsnInspecao = $cons['in_tsnInspecao'];
                $this->in_tsoInspecao = $cons['in_tsoInspecao'];
                $this->frequencia_for_time = $cons['frequencia_for_time'];
                $this->vencimento_for_time = $cons['vencimento_for_time'];
                $this->vencimento_for_date = $cons['vencimento_for_date'];
                $this->frequencia_for_date = $cons['frequencia_for_date'];
                $this->horasDeVooAeronave = $cons['horasDeVooAeronave'];
                $this->limiteInspecao = $cons['limiteInspecao'];
                $this->ntl = $cons['ntl1'];
                $this->ng = $cons['ng1'];

                $this->selecionaTC();
                $this->ExeUpdate($cons['idInspecao'], $this->Data);

            endforeach;
        endif;
    }

    public static function retornaTempoDeVoo($tempoDeVoo, $decolagem, $pouso) {
        $dec = new DateTime($decolagem);
        $pou = new DateTime($pouso);
        $interval = $pou->diff($dec);

        if (isset($tempoDeVoo)):
            $tempoDeVoo->h = $tempoDeVoo->h + $interval->h;
            $tempoDeVoo->i = $tempoDeVoo->i + $interval->i;
        else:
            $tempoDeVoo = $interval;
        endif;
        
        return $tempoDeVoo;
    }

    public static function somaTime($time) {
        $tempo = explode(':', $time);
        return ($tempo[0] * 60) + $tempo[1];
    }

    public static function formataTime($time) {
        $hora = explode('.', $time);
        $difMinutos = $time - $hora[0];
        $minuto = ($difMinutos * 60);
        return $hora[0] . ':' . self::acrescentaZeroNoTime($minuto);
    }

    public static function acrescentaZeroNoTime($time) {
        if (strlen($time) < 2):
            return $time = '0' . $time;
        else:
            return $time;
        endif;
    }

    /* @disponibilidadeDataLimite
     * Esta Função subtrai as datas de vencimento e instalação de uma inspeção 
     * averiguando o fator multiplicativo (percentual) de limite de alerta e retorna
     * true ou false para alertas
     */

    public static function disponibilidadeDataLimite($dataInst, $dataVenc, $limite) {
        $inst = new DateTime($dataInst);
        $venc = new DateTime($dataVenc);
        $interval1 = $venc->diff($inst);
        $limitePercentual = $venc->format(($interval1->y * 365) + ($interval1->m * 30) + $interval1->d) * ($limite * 0.01);

        $disp = new DateTime(date('Y-m-d'));
        $interval2 = $disp->diff($venc);

        $tempoAteVenc = $interval2->format(($interval2->y * 365) + ($interval2->m * 30) + $interval2->d);
        $total = $tempoAteVenc - $limitePercentual;

        if ($interval2->invert === 1):
            $alerta = 2;
        elseif ($total < 0 && $interval2->invert === 0):
            $alerta = 1;
        else:
            $alerta = 0;
        endif;

        if ($dataVenc === '' || is_null($dataVenc)):
            $alerta = 0;
        endif;

        return $alerta;
    }

    public static function exibeCorAlerta($alerta, $alerta2) {

        if ($alerta === 2 || $alerta2 === 2):
            $style = '<tr style="background: #EE0000">';
        elseif ($alerta === 1 || $alerta2 === 1):
            $style = '<tr style="background: #FFE7A1">';
        else:
            $style = '<tr style="background: #4cae4c">';
        endif;

        return $style;
    }

    public static function disponibilidadeTempoLimite($tempInst, $tempVenc, $tempAero, $limite) {
        if (($tempInst === '' || is_null($tempInst) || is_null($tempVenc) || $tempVenc === '')):

            $alerta = 0;
        else:
            $horasInst = explode(':', $tempInst);
            $horasVenc = explode(':', $tempVenc);
            $horasAero = explode(':', $tempAero);
            $limitePercentual = (((float) $horasVenc[0] * 60 + (float) $horasVenc[1]) - ((float) $horasInst[0] * 60 + (float) $horasInst[1])) * (float) ($limite * 0.01);
            $tempoAteVenc = (($horasVenc[0] * 60 + $horasVenc[1]) - ($horasAero[0] * 60 + $horasAero[1]));
            $timeTotal = $tempoAteVenc - $limitePercentual;

            if ($tempoAteVenc < $limitePercentual):
                $alerta = 2;
            elseif ($timeTotal < 0):
                $alerta = 1;
            else:
                $alerta = 0;
            endif;
        endif;

        return $alerta;
    }

    private function selecionaTC() {
        if ($this->tcInspecao === 'H'):
            $this->Data = $this->modificaTime();

        elseif ($this->tcInspecao === 'D'):
            $this->Data = $this->modificaDateD();

        elseif ($this->tcInspecao === 'M'):
            $this->Data = $this->modificaDateM();

        elseif ($this->tcInspecao === 'D/H'):
            $this->Data = $this->modificaDateDH();

        elseif ($this->tcInspecao === 'M/H'):
            $this->Data = $this->modificaDateMH();

        elseif ($this->tcInspecao === 'T'):
            $this->Data = $this->modificaNTL();

        elseif ($this->tcInspecao === 'N'):
            $this->Data = $this->modificaNG();

        endif;
    }

    private function modificaTime() {
        $hora = explode(':', $this->in_anvInspecao);
        $tsn[0] = 0;
        $tso[0] = 0;

        if (isset($this->in_tsnInspecao)):
            $tsn = explode(':', $this->in_tsnInspecao);
        endif;

        if (isset($this->in_tsoInspecao)):
            $tso = explode(':', $this->in_tsoInspecao);
        endif;

        $tempoVenc = (int) ($hora[0] * 60 + $hora[1]) + ((int) $this->frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
        $tempoVenc /= 60;

        $Data['vencimento_for_time'] = self::formataTime(floor($tempoVenc));
        $Data['vencimento_for_date'] = NULL;

        if (isset($this->vencimento_for_time)):
            $horasAero = explode(':', $this->horasDeVooAeronave);
            $kmAero = (int) $horasAero[0] * 60 + (int) $horasAero[1];
            $tempoVenc *= 60;

            $totalMinutos = $tempoVenc - $kmAero;
            $totalMinutos /= 60;


            $Data['disponivel_for_time'] = self::formataTime(floor($totalMinutos));
            $Data['disponivel_for_date'] = NULL;
        endif;

        return $Data;
    }

    private function modificaDateD() {
        $vencimento = new DateTime($this->in_dataInspecao);
        $vencimento->add(new DateInterval('P' . $this->frequencia_for_time . 'D'));
        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');
        $Data['vencimento_for_time'] = NULL;

        $venc = new DateTime($this->vencimento_for_date);
        $disp = new DateTime(date('Y-m-d'));
        $interval = $disp->diff($venc);
        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');
        $Data['disponivel_for_time'] = NULL;

        return $Data;
    }

    private function modificaDateM() {
        $vencimento = new DateTime($this->in_dataInspecao);
        $vencimento->add(new DateInterval('P' . $this->frequencia_for_time . 'M'));
        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');
        $Data['vencimento_for_time'] = NULL;

        $venc = new DateTime($this->vencimento_for_date);
        $disp = new DateTime(date('Y-m-d'));
        $interval = $disp->diff($venc);
        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');
        $Data['disponivel_for_time'] = NULL;

        return $Data;
    }

    private function modificaDateDH() {
        $hora = explode(':', $this->in_anvInspecao);
        $tsn[0] = 0;
        $tso[0] = 0;

        if (isset($this->in_tsnInspecao)):
            $tsn = explode(':', $this->in_tsnInspecao);
        endif;

        if (isset($this->in_tsoInspecao)):
            $tso = explode(':', $this->in_tsoInspecao);
        endif;

        $tempoVenc = (int) ($hora[0] * 60 + $hora[1]) + ((int) $this->frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
        $tempoVenc /= 60;

        $Data['vencimento_for_time'] = self::formataTime(floor($tempoVenc));
        $Data['vencimento_for_date'] = NULL;

        if (isset($this->vencimento_for_time)):
            $horasAero = explode(':', $this->horasDeVooAeronave);
            $in_anv = explode(':', $this->in_anvInspecao);

            $kmAero = (int) $horasAero[0] * 60 + (int) $horasAero[1];

            $tempoVenc *= 60;

            $totalMinutos = $tempoVenc - $kmAero;
            $totalMinutos /= 60;

            $Data['disponivel_for_time'] = self::formataTime(floor($totalMinutos));
            $Data['disponivel_for_date'] = NULL;
        endif;


        $vencimento = new DateTime($this->in_dataInspecao);
        $vencimento->add(new DateInterval('P' . $this->frequencia_for_date . 'D'));
        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

        $venc = new DateTime($this->vencimento_for_date);
        $disp = new DateTime(date('Y-m-d'));
        $interval = $disp->diff($venc);
        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

        return $Data;
    }

    private function modificaDateMH() {
        $hora = explode(':', $this->in_anvInspecao);
        $hora[0] = (int) $hora[0];
        $tsn[0] = 0;
        $tso[0] = 0;

        if (isset($in_tsnInspecao)):
            $tsn = explode(':', $this->in_tsnInspecao);
            $tsn[0] = (int) $tsn[0];
        endif;

        if (isset($in_tsoInspecao)):
            $tso = explode(':', $this->in_tsoInspecao);
            $tso[0] = (int) $tsn[0];
        endif;

        if (isset($hora[1])):
            $tempoVenc = (int) ($hora[0] * 60 + $hora[1]) + ((int) $this->frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
        else:
            $tempoVenc = (int) ($hora[0] * 60) + ((int) $this->frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
        endif;
        $tempoVenc /= 60;

        $Data['vencimento_for_time'] = self::formataTime(floor($tempoVenc));
        $Data['vencimento_for_date'] = NULL;



        if (isset($this->vencimento_for_time)):
            $horasAero = explode(':', $this->horasDeVooAeronave);
            $in_anv = explode(':', $this->in_anvInspecao);

            $kmAero = (int) $horasAero[0] * 60 + (int) $horasAero[1];

            $tempoVenc *= 60;

            $totalMinutos = $tempoVenc - $kmAero;
            $totalMinutos /= 60;
            $Data['disponivel_for_time'] = self::formataTime(floor($totalMinutos));
            $Data['disponivel_for_date'] = NULL;
        endif;

        $vencimento = new DateTime($this->in_dataInspecao);
        $vencimento->add(new DateInterval('P' . $this->frequencia_for_date . 'M'));
        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

        $venc = new DateTime($this->vencimento_for_date);
        $disp = new DateTime(date('Y-m-d'));
        $interval = $disp->diff($venc);
        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

        return $Data;
    }

    private function modificaNTL() {
        $in_ntl = explode(':', $this->in_anvInspecao);
        $venc = $in_ntl[0] + $this->frequencia_for_time;

        $Data['vencimento_for_time'] = $venc;
        $Data['disponivel_for_time'] = $Data['vencimento_for_time'] - $this->ntl;

        return $Data;
    }

    private function modificaNG() {
        $in_ng = explode(':', $this->in_anvInspecao);
        $venc = $in_ng[0] + $this->frequencia_for_time;

        $Data['vencimento_for_time'] = $venc;
        $Data['disponivel_for_time'] = $Data['vencimento_for_time'] - $this->ng;

        return $Data;
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
