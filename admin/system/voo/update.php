<div class="content form_create">

    <article>

        <header>
            <h1>Editar Atividade Aérea:</h1>
        </header>

        <?php
        $voo = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $etapas = array();

        if ($dados && $dados['SendPostForm']):
            $dados['voo_status'] = ($dados['SendPostForm'] == 'Atualizar' ? '0' : '1');

            $data[0]['data_do_voo'] = ($dados['data_do_voo']);
            $data[0]['numero_voo'] = ($dados['numero_voo']);
            $data[0]['idaeronave'] = ($dados['idaeronave']);
            $data[0]['comandante'] = ($dados['comandante']);
            $data[0]['copiloto'] = ($dados['copiloto']);
            $data[0]['topD'] = ($dados['topD']);
            $data[0]['topE'] = ($dados['topE']);
            $data[0]['historico'] = ($dados['historico']);
            $data[0]['partida'] = ($dados['partida']);
            $data[0]['corte'] = ($dados['corte']);
            $data[0]['qte'] = ($dados['ciclo']);
            $data[0]['tempo_total_de_voo'] = ($dados['tempo_total_de_voo']);
            $data[0]['total_de_pousos'] = ($dados['total_de_pousos']);
            $data[0]['combustivel_total_consumido'] = ($dados['combustivel_total_consumido']);
            $data[0]['natureza'] = ($dados['natureza']);
            $data[0]['voo_status'] = ($dados['voo_status']);

            require('_models/AdminEtapaVoo.class.php');
            $atualizaEtapa = new AdminEtapaVoo();
            for ($i = 0; $i < $dados['total_de_pousos']; $i++):
                if ($i <= 0):
                    $indice = '';
                else:
                    $indice = $i;
                endif;

                $data[$i + 1]['idvoo'] = $voo;
                $data[$i + 1]['origem'] = $dados['origem' . $indice];
                $data[$i + 1]['destino'] = $dados['destino' . $indice];
                $data[$i + 1]['partida'] = $dados['partida' . $indice];
                $data[$i + 1]['decolagem'] = $dados['decolagem' . $indice];
                $data[$i + 1]['pouso'] = $dados['pouso' . $indice];
                $data[$i + 1]['corte'] = $dados['corte' . $indice];
                $data[$i + 1]['combustivel_consumido'] = $dados['combustivel_consumido' . $indice];

                $atualizaEtapa->ExeUpdate($voo, $i + 1, $data[$i + 1]);

            endfor;

            unset($data['SendPostForm']);
            require('_models/AdminVoo.class.php');
            $cadastraVoo = new AdminVoo;
            $cadastraVoo->ExeUpdate($voo, $data[0]);


            WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);


        else:
            $readVoo = new Read;
            $readVoo->ExeRead("voo", "WHERE idvoo = :idvoo", "idvoo={$voo}");
            $readEtapa = new Read;
            $readEtapa->ExeRead("etapas_voo", "WHERE idvoo = :idvoo", "idvoo={$voo}");
            if (!$readVoo->getResult() || !$readEtapa->getResult()):
                header('Location: painel.php?exe=voo/index&empty=true');
            else:
                $data[0] = $readVoo->getResult()[0];
                foreach ($readEtapa->getResult() as $etapa):
                    for ($i = 0; $i <= $readVoo->getResult()[0]['total_de_pousos'] - 1; $i++):
                        $data[$i + 1] = $readEtapa->getResult()[$i];
                    endfor;
                endforeach;
            endif;
        endif;
        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);

        if ($checkCreate && empty($cadastraVoo)):
            WSErro("O voo nº <b>{$data[0]['numero_voo']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT);
        endif;
        ?>


        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">

                    <div class="form-group col-md-4">
                        <label><span class="field">Data do Voo</span></label> 
                        <input class="form-control" type="date" name="data_do_voo" value="<?= $data[0]['data_do_voo']; ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Número:</span> </label>
                        <input class="form-control" type="text" name="numero_voo" value="<?= $data[0]['numero_voo']; ?>" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Aeronave:</span></label>
                        <select class="form-control j_loadcity" name="idaeronave" value="<?= $data[0]['idaeronave']; ?>">

                            <?php
                            $readAero = new Read;
                            $readAero->ExeRead("aeronave");

                            if ($readAero->getRowCount()):
                                foreach ($readAero->getResult() as $aeronave):
                                    extract($aeronave);
                                    echo "<option value=\"{$idaeronave}\" ";

                                    if (isset($data[0]['idaeronave']) && $data[0]['idaeronave'] == $idAeronave):
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
                        <option></option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Comandante");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);

                                echo "<option value=\"{$nome}\" ";
                                if (isset($data[0]['comandante']) && $data[0]['comandante'] == $nome):
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
                        <option></option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Copiloto");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);

                                echo "<option value=\"{$nome}\" ";
                                if (isset($data[0]['copiloto']) && $data[0]['copiloto'] == $nome):
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
                        <option></option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Tripulante");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);

                                echo "<option value=\"{$nome}\" ";
                                if (isset($data[0]['topD']) && $data[0]['topD'] == $nome):
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
                        <option></option>
                        <?php
                        $readServ = new Read;
                        $readServ->ExeRead("servidor", "WHERE funcao = :func", "func=Tripulante");

                        if ($readServ->getRowCount()):
                            foreach ($readServ->getResult() as $servidor):
                                extract($servidor);

                                echo "<option value=\"{$nome}\" ";
                                if (isset($data[0]['topE']) && $data[0]['topE'] == $nome):
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
                        <option selected="" <?= $data[0]['natureza']; ?>><?= $data[0]['natureza']; ?></option>
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
                <span class="field text-center"><b>E T A P A S</b></span>
                <?php
//                print_r($data);
                for ($i = 0; $i <= $data[0]['total_de_pousos'] - 1; $i++):
                    if ($i < 1):
                        $indice = '';
                    else:
                        $indice = $i;
                    endif;
                    ?>
                    <div class="row form-group ">
                        <div id="etapas">
                        <div class="row">
                            <!--                            <div class="form-group col-md-1">
                                                            <label><span class="field">Etapa:</span></label>
                                                            <input id="ne" class="form-control" type="text" name="numero_etapa" readonly="" /> 
                                                        </div>-->

                            <div class="form-group col-md-2">
                                <label><span class="field">Origem:</span></label>
                                <input class="form-control" type="text" name="origem<?= $indice ?>" value="<?= $data[$i + 1]['origem'] ?>"/>

                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Destino:</span></label>
                                <input class="form-control" type="text" name="destino<?= $indice ?>" value="<?= $data[$i + 1]['destino'] ?>"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Partida:</span></label>
                                <input class="form-control" type="time" name="partida<?= $indice ?>" value="<?= $data[$i + 1]['partida'] ?>"/> 
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Decolagem:</span></label>
                                <input class="form-control" type="time" name="decolagem<?= $indice ?>" value="<?= $data[$i + 1]['decolagem'] ?>"/>

                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Pouso:</span></label>
                                <input class="form-control" type="time" name="pouso<?= $indice ?>" value="<?= $data[$i + 1]['pouso'] ?>"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Corte:</span></label>
                                <input class="form-control" type="time" name="corte<?= $indice ?>" value="<?= $data[$i + 1]['corte'] ?>"/>
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group col-md-2">
                                <label><span class="field">NG:</span></label>
                                <input class="form-control"  type="number" name="ng<?= $indice ?>" step="0.01" min="0" value="<?= $data[$i + 1]['ng'] ?>"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">NTL:</span></label>
                                <input class="form-control"  type="number" name="ntl<?= $indice ?>" step="0.01" min="0" value="<?= $data[$i + 1]['ntl'] ?>"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Diu:</span></label>
                                <input class="form-control"  type="number" name="diurno<?= $indice ?>" step="0.01" min="0" value="<?= $data[$i + 1]['diurno'] ?>"/>
                            </div>

                            <div class="form-group col-md-2">
                                <label><span class="field">Not:</span></label>
                                <input class="form-control"  type="number" name="noturno<?= $indice ?>" step="0.01" min="0" value="<?= $data[$i + 1]['noturno'] ?>"/>
                            </div>

                            <div class="form-group col-md-1">
                                <label><span class="field">Pousos:</span></label>
                                <input class="form-control"  type="text"  name="qtepouso<?= $indice ?>"  min="0" value="<?= $data[$i + 1]['qtepouso'] ?>"/>
                            </div>

                            <div class="form-group col-md-1">
                                <label><span class="field">Gas:</span></label>
                                <input id="cc" class="form-control"  type="text" name="combustivel_consumido<?= $indice ?>" min="0" value="<?= $data[$i + 1]['combustivel_consumido'] ?>"/>
                            </div>


                        </div>
                    </div>
                        
                    </div>
                    <?php
                endfor;
                ?>
                <a class="btn blue" href="#" data-id="1" id="adicionarEtapa">Adicionar Etapa</a> 
            </div>

           <div class="row">

                <div class="form-group col-md-2">
                    <label><span class="field">T. Tempo de Voo</span></label> 
                    <input id="ttv" class="form-control" type="text" name="tempo_total_de_voo"  value="<?= $data[0]['tempo_total_de_voo'] ?>" readonly="" />
                </div>
                <div class="form-group col-md-2">           
                    <label><span class="field">T. Pousos:</span></label>
                    <input id="tp" class="form-control"  type="text" name="total_de_pousos"  value="<?= $data[0]['total_de_pousos'] ?>" readonly=""/> 
                </div>
                <div class="form-group col-md-2">
                    <label><span class="field">T. Gas Consumido:</span></label>
                    <input id="ctc" class="form-control"  type="number" name="combustivel_total_consumido" readonly=""  value="<?= $data[0]['combustivel_total_consumido'] ?>" step="0.01"/>
                </div>

            </div>
            <!--/line-->    


            <div class="form-group">
                <label><span class="field">Histórico do voo:</span></label>
                <textarea class="form-control" name="historico" ><?= $data[0]['historico'] ?></textarea>
            </div>


            <div class="form-group">
                <label><span class="field">Ocorrências:</span></label>
                <textarea class="form-control" name="ocorrencia"><?= $data[0]['ocorrencia'] ?></textarea>
            </div>

            <div class="form-group">
                <label><span class="field">Discrepância:</span></label>
                <textarea class="form-control" name="discrepancia"><?= $data[0]['discrepancia'] ?></textarea>
            </div>

            <div class="form-group">
                <label><span class="field">RelPrev:</span></label>
                <textarea class="form-control" name="relprev"><?= $data[0]['relprev'] ?></textarea>
            </div>

            <!--<div class="form-fim">-->


            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Atualizar" name="SendPostForm" />
            <!--<input type="submit" class="btn green" value="Cadastrar & Publicar" name="SendPostForm" />-->
            </div>
        </form>


        <!--       <form name="PostForm" action="" method="post" enctype="multipart/form-data">
        
                   <label class="label">
                       <span class="field">Logo da empresa: <sup>Exatamente 578x288px (JPG ou PNG)</sup></span>
                       <input type="file" name="empresa_capa" />
                   </label>
        
                   <label class="label">
                       <span class="field">Nome da Empresa:</span>
                       <input type="text" name="empresa_title" value="<?php if (isset($data['empresa_title'])) echo $data['empresa_title']; ?>" />
                   </label>
        
                   <label class="label">
                       <span class="field">Ramo de atividade:</span>
                       <input type="text" name="empresa_ramo" value="<?php if (isset($data['empresa_ramo'])) echo $data['empresa_ramo']; ?>" />
                   </label>
        
                   <label class="label">
                       <span class="field">Sobre a empresa:</span>
                       <textarea name="empresa_sobre" rows="3"><?php if (isset($data['empresa_sobre'])) echo $data['empresa_sobre']; ?></textarea>
                   </label>
        
                   <div class="label_line">
                       <label class="label_medium">
                           <span class="field">Site da Empresa:</span>
                           <input type="url" placeholder="http://www.upinside.com.br" name="empresa_site" value="<?php if (isset($data['empresa_site'])) echo $data['empresa_site']; ?>" />
                       </label>
        
                       <label class="label_medium">
                           <span class="field">Facebook Page:</span>
                           <input type="text" placeholder="upinside" name="empresa_facebook" value="<?php if (isset($data['empresa_facebook'])) echo $data['empresa_facebook']; ?>" />
                       </label>                
                   </div> line 
        
                   <label class="label">
                       <span class="field">Nome da rua / Número:</span>
                       <input type="text" placeholder="Rua Nome da Rua / 1287" name="empresa_endereco" value="<?php if (isset($data['empresa_endereco'])) echo $data['empresa_endereco']; ?>" />
                   </label>            
        
                   <div class="label_line">
                       <label class="label_small">
                           <span class="field">Estado UF:</span>
                           <select class="j_loadstate" name="empresa_uf">
                               <option value="" selected> Selecione o estado </option>
        <?php
        $readState = new Read;
        $readState->ExeRead("app_estados", "ORDER BY estado_nome ASC");
        foreach ($readState->getResult() as $estado):
            extract($estado);
            echo "<option value=\"{$estado_id}\" ";
            if (isset($data['empresa_uf']) && $data['empresa_uf'] == $estado_id): echo 'selected';
            endif;
            echo "> {$estado_uf} / {$estado_nome} </option>";
        endforeach;
        ?>                        
                           </select>
                       </label>
        
                       <label class="label_small">
                           <span class="field">Cidade:</span>
                           <select class="j_loadcity" name="empresa_cidade">
        <?php if (!isset($data['empresa_cidade'])): ?>
                                                                                                                                                                                                            <option value="" selected disabled> Selecione antes um estado </option>
            <?php
        else:
            $readAero = new Read;
            $readAero->ExeRead("app_cidades", "WHERE estado_id = :uf ORDER BY cidade_nome ASC", "uf={$data['empresa_uf']}");
            if ($readAero->getRowCount()):
                foreach ($readAero->getResult() as $cidade):
                    extract($cidade);
                    echo "<option value=\"{$cidade_id}\" ";
                    if (isset($data['empresa_cidade']) && $data['empresa_cidade'] == $cidade_id):
                        echo "selected";
                    endif;
                    echo "> {$cidade_nome} </option>";
                endforeach;
            endif;
        endif;
        ?>
                           </select>
                       </label>
        
                       <label class="label_small">
                           <span class="field">Indicação:</span>
                           <select name="empresa_categoria">
                               <option value="" selected> Indique a empresa como </option>
                               <option value="onde-comer" <?php if (isset($data['empresa_categoria']) && $data['empresa_categoria'] == 'onde-comer') echo 'selected'; ?>> Onde Comer </option>
                               <option value="onde-ficar" <?php if (isset($data['empresa_categoria']) && $data['empresa_categoria'] == 'onde-ficar') echo 'selected'; ?>> Onde Ficar </option>
                               <option value="onde-comprar" <?php if (isset($data['empresa_categoria']) && $data['empresa_categoria'] == 'onde-comprar') echo 'selected'; ?>> Onde Comprar </option>
                               <option value="onde-se-divertir" <?php if (isset($data['empresa_categoria']) && $data['empresa_categoria'] == 'onde-se-divertir') echo 'selected'; ?>> Onde se Divertir </option>
                           </select>
                       </label>
                   </div>/line
        
                   <div class="gbform"></div>
        
                   <input type="submit" class="btn blue" value="Atualizar" name="SendPostForm" />
                   <input type="submit" class="btn green" value="Atualizar & Publicar" name="SendPostForm" />
               </form>-->

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->