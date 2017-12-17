
<div class="content form_create">

    <article>

        <header>
            <h1>Registro de Atividade Aérea:</h1>
        </header>

        <form id="form" name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Data do Voo:</span></label> 
                        <input id="datavoo" class="form-control" type="date" name="data_do_voo" value="2017-12-13"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Número do Voo:</span> </label>
                        <input class="form-control" type="text" name="numero_voo" value="454"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Aeronave:</span></label>
                        <select class="form-control j_loadcity" name="idaeronave">
                            <option>HARPIA 05</option>
                            <?php
                            $readAero = new Read;
                            $readAero->ExeRead("aeronave");

                            if ($readAero->getRowCount()):
                                foreach ($readAero->getResult() as $aeronave):
                                    extract($aeronave);
                                    echo "<option value=\"{$idAeronave}\" ";
                                    if (isset($data['aeronave']) && $data['aeronave'] == $idAeronave):
                                        echo "selected";
                                    endif;
                                    echo "> {$nomeAeronave} </option>";
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

            </div><!--/line-->

            <div class="row">
                <div class="form-group col-md-3">
                    <label><span class="field">Comandante:</span></label>
                    <select class="form-control j_loadcity" name="comandante">
                        <option>Caus</option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Comandante");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);
                                echo "<option value=\"{$nome}\" ";
                                if (isset($data['funcao']) && $data['funcao'] == $idservidor):
                                    echo "selected";
                                endif;
                                echo "> {$nome} </option>";
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="form-group  col-md-3">
                    <label><span class="field">Copiloto:</span></label>
                    <select class="form-control j_loadcity" name="copiloto">
                        <option>Laura</option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Copiloto");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);
                                echo "<option value=\"{$nome}\" ";
                                if (isset($data['funcao']) && $data['funcao'] == $idservidor):
                                    echo "selected";
                                endif;
                                echo "> {$nome} </option>";
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label><span class="field">Top D:</span> </label>
                    <select class="form-control j_loadcity" name="topD">
                        <option>Erick</option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Tripulante");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);
                                echo "<option value=\"{$nome}\" ";
                                if (isset($data['funcao']) && $data['funcao'] == $idservidor):
                                    echo "selected";
                                endif;
                                echo "> {$nome} </option>";
                            endforeach;
                        endif;
                        ?>
                    </select>

                </div>
                <div class="form-group col-md-3">
                    <label><span class="field">Top E:</span></label>
                    <select class="form-control j_loadcity" name="topE">
                        <option>Freitas</option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Tripulante");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);
                                echo "<option value=\"{$nome}\" ";
                                if (isset($data['funcao']) && $data['funcao'] == $idservidor):
                                    echo "selected";
                                endif;
                                echo "> {$nome} </option>";
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>

            <!--/line-->
            <div class="row">

                <div class="form-group col-md-12">
                    <label><span class="field">Natureza:</span></label>
                    <select  class="form-control j_loadcity"  name="natureza">
                        <option>A1 - Abastecimento</option>
                        <option>A1 - Abastecimento</option>
                        <option>A2 - Traslado</option>
                        <option>A3 - Experiência (Manutenção)</option>
                        <option>A4 - Exame para concessão ou renovação de licença/tipo (Cheque/Recheque)</option>
                        <option>A5 - Demonstração</option>
                        <option>I1 - Concessão de licença</option>
                        <option>I2 - Habilitação no tipo</option>
                        <option>I3 - Instrução revisória/Experiência Recente</option>
                        <option>I4 - Qualificação/Requalificação Profissional</option>
                        <option>I5 - Treinamento para outras Instituições ou unidades da PMES</option>
                        <option>O111 - Radiopatrulhamento aéreo preventivo</option>
                        <option>O112 - Acompanhamento de veículos em fuga</option>
                        <option>O121 - Mandado de Busca e Apreensão</option>
                        <option>O122 - Controle de Distúrbios Civis</option>
                        <option>O124 - Saturação de Área</option>
                        <option>O131 - Ocorrências em estabelecimentos prisionais</option>
                        <option>O141 - Transporte de Efetivo</option>
                        <option>O143 - Transporte de equipamentos</option>
                        <option>O151 - Filmagem e fotografia</option>
                        <option>O161 - Fiscalização ambiental</option>
                        <option>O171 - Fiscalização de Trânsito</option>
                        <option>O181 - Transporte de Autoridades/Dignitários</option>
                        <option>O213 - Resgate de vitimas de afogamento</option>
                        <option>O214 - Resgate de vitimas de naufrágio</option>
                        <option>O215 - Resgate de pessoas em embarcação à deriva</option>
                        <option>O221 - Localização de pessoas perdidas ou desaparecidas</option>
                        <option>O222 - Resgate de pessoas em local de difícil acesso</option>
                        <option>O223 - Remoção/Transporte de cadáveres</option>
                        <option>O231 - Atendimento pré-hospitalar de urgências</option>
                        <option>O232 - Transporte inter-hospitalar de pacientes</option>
                        <option>O233 - Transporte de órgãos</option>
                        <option>O241 - Avaliação de desastres</option>
                        <option>O242 - Remoção de vítimas isoladas por desastres</option>
                        <option>O243 - Transporte de materiais para vítimas de desastres</option>
                        <option>O244 - Transporte de equipes para apoio a vítimas isoladas</option>
                        <option>O251 - Lançamento de Água/Espuma</option>
                        <option>O252 - Transporte de Efetivo/equipamentos</option>
                        <option>O253 - Avaliação</option>
                    </select>
                    <!--</div>-->

                </div><!--/line-->
            </div>

            <div class="form-etapas">
                <label><b>V  O  O  S</b></label>
                <div class="form-group ">
                    <div id="etapas">
                        <div class="row">
                            <div class="form-group col-md-1">
                                <label><span class="field">Etapa:</span></label>
                                <input id="ne" class="form-control" type="text" name="numero_etapa" readonly="" /> 
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Origem:</span></label>
                                <input class="form-control" type="text" name="origem" value="Vitória"/>

                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Destino:</span></label>
                                <input class="form-control" type="text" name="destino" value="Vila Velha"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Partida:</span></label>
                                <input class="form-control" type="time" name="partida" value="10:00"/> 
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Decolagem:</span></label>
                                <input class="form-control" type="time" name="decolagem" value="10:05"/>

                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Pouso:</span></label>
                                <input class="form-control" type="time" name="pouso" value="10:20"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Corte:</span></label>
                                <input class="form-control" type="time" name="corte" value="10:22"/>
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group col-md-2">
                                <label><span class="field">NG:</span></label>
                                <input class="form-control"  type="number" name="ng" step="0.01" min="0" value="1"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">NTL:</span></label>
                                <input class="form-control"  type="number" name="ntl" step="0.01" min="0" value="1"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Diu:</span></label>
                                <input class="form-control"  type="number" name="diurno" step="0.01" min="0" value="1"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Not:</span></label>
                                <input class="form-control"  type="number" name="noturno" step="0.01" min="0" value="1"/>
                            </div>

                            <div class="form-group col-md-1">
                                <label><span class="field">Pousos:</span></label>
                                <input class="form-control"  type="text"  name="qtepouso"  min="0" value="1"/>
                            </div>

                            <div class="form-group col-md-1">
                                <label><span class="field">Gas:</span></label>
                                <input id="cc" class="form-control"  type="text" name="combustivel_consumido" min="0" value="15"/>
                            </div>


                        </div>
                    </div>
                </div>


                <a class="btn blue" href="#" data-id="1" id="adicionarEtapa">Adicionar Etapa</a> 
            </div>
            <div class="row">

                <div class="form-group col-md-2">
                    <label><span class="field">T. Tempo de Voo</span></label> 
                    <input id="ttv" class="form-control" type="text" name="tempo_total_de_voo"  value="250" readonly="" />
                </div>
                <div class="form-group col-md-2">           
                    <label><span class="field">T. Pousos:</span></label>
                    <input id="tp" class="form-control"  type="text" name="total_de_pousos" value="1" readonly=""/> 
                </div>
                <div class="form-group col-md-2">           
                    <label><span class="field">Qte Etapas:</span></label>
                    <input id="qteEtapas" class="form-control"  type="text" name="qte_etapas" readonly=""/> 
                </div>
             
                <div class="form-group col-md-2">
                    <label><span class="field">T. Gas Consumido:</span></label>
                    <input id="ctc" class="form-control"  type="number" name="combustivel_total_consumido" readonly="" value="45" step="0.01"/>
                </div>

            </div>
            <!--/line-->    
            <div class="form-group">
                <label><span class="field">Histórico do voo:</span></label>
                <textarea id="historico" class="form-control" name="historico">Histórico</textarea>
            </div>

            <div class="form-group">
                <label><span class="field">Ocorrências:</span></label>
                <textarea class="form-control" name="ocorrencia">Ocorrência</textarea>
            </div>

            <div class="form-group">
                <label><span class="field">Discrepância:</span></label>
                <textarea class="form-control" name="discrepancia">Discrepância</textarea>
            </div>

            <div class="form-group">
                <label><span class="field">RelPrev:</span></label>
                <textarea class="form-control" name="relprev">Relatório Prevenção</textarea>
            </div>

            <!--<div class="form-fim">-->
            <!--<input id="tp" type="hidden" name="qte_etapas"/>--> 
            <input type="hidden" name="voo_status" value="0" />
                           <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>

        <div class="div">

        </div>

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->