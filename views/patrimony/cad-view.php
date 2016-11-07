<?php 
    if (!defined('ABSPATH')){ exit(); }
    $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    
    if(isset($get['pa'])){ $parametros = $get['pa']; }
    
    # Carrega todos os métodos do modelo
    $modelo->validate_register_form();
    $form_msg = $modelo->form_msg;
    $modelo->get_register_form($parametros, 1);
    unset($parametros, $get);
?>
<script>window.history.pushState("cad", "", "cad");</script>
<div class="row-fluid">
    <div class="col-md-1  col-sm-0 col-xs-0"></div>
    <div class="col-md-10  col-sm-12 col-xs-12">
        <!--<h4 class="text-center">CADASTRO DE FORNECEDORES</h4>-->
        <form id="form-register" enctype="multipart/form-data" method="post" role="form" class="">
            <?php
                if ($form_msg == true) {
                    echo'<div class="alert alertH ' . $form_msg[0] . '  alert-dismissible fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="'. $form_msg[1] .'" >&nbsp;</i>
                            <strong>' . $form_msg[2] . '</strong>&nbsp;' . $form_msg[3] . ' 
                            </div>';
                    unset($form_msg);
                }
            ?>
            <fieldset>
                <legend><h6>INFORMAÇÕES DO PATRIMÔNIO</h6></legend>
                <div class="row form-compact">
                    <div class="form-group col-md-2 col-sm-12 col-xs-12">
                        <label for="patrimony_cod"><i style="color: red;">*</i> Código:</label>
                        <input type="hidden" name="patrimony_id" value="<?= htmlentities(chk_array($modelo->form_data, 'patrimony_id')); ?>">
                        <input id="patrimony_cod" type="text" name="provider_nome" placeholder="Código do patrimônio... " value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_cod')); ?>" class="form-control" 
                        data-validation="custom" data-validation-regexp="^([A-z0-9\s]{3,40})$" data-validation-error-msg="Preencha corretamente o campo."
                        data-validation-help="Digite um nome com (3) ou mais caracteres.">
                        <br>
                    </div>

                    <div class="form-group col-md-3 col-sm-4 col-xs-12">
                        <label for="patrimony_desc"><i style="color: red;">*</i> Descrição:</label>
                        <input id="patrimony_desc" name="patrimony_desc" class="form-control" type="text" placeholder="Descrição sobre o patrimônio..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_desc')); ?>">
                        <br>
                    </div>

                    <div class="form-group col-md-2 col-sm-12 col-xs-12">
                        <label for="patrimony_data_aq">Data da Aquisição:</label>
                        <input id="patrimony_data_aq" name="patrimony_data_aq" class="form-control data" type="text" placeholder="__/__/____" value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_data_aq')); ?>">
                        <br>
                    </div>


                    <div class="form-group col-md-2 col-sm-12 col-xs-12">
                        <label for="patrimony_cor">Cor:</label>
                        <input id="patrimony_cor" name="patrimony_cor" class="form-control" type="text" placeholder="Cor..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_cor')); ?>" >
                        <br>
                    </div>

                    <div class="form-group col-md-3 col-sm-12 col-xs-12">
                        <label for="patrimony_for">Fornecedor:</label>
                        <input id="patrimony_for" name="patrimony_for" class="form-control" type="text" placeholder="Fornecedor..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_for')); ?>" >
                        <br>
                    </div>
                    <br>
                </div>

                <div class="row form-compact">
                    <div class="form-group col-md-2 col-sm-12 col-xs-12">
                        <label for="patrimony_dimen">Dimensões:</label>
                        <input id="patrimony_dimen" name="patrimony_dimen" class="form-control" type="text" placeholder="Dimensões..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_dimen')); ?>">
                        <br>
                    </div>

                    <div class="form-group col-md-2 col-sm-12 col-xs-12">
                        <label for="patrimony_setor">Setor:</label>
                        <input id="patrimony_setor" name="patrimony_setor" class="form-control" type="text" placeholder="Setor..."   value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_setor')); ?>">
                        <br>
                    </div>

                    <div class="form-group col-md-2 col-sm-12 col-xs-12">
                        <label for="patrimony_valor">Valor do patrimônio:</label>
                        <input id="patrimony_valor" name="patrimony_valor" class="form-control" type="text" placeholder="R$..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_valor')); ?>">
                        <br>
                    </div>

                    <div class="form-group col-md-2 col-sm-4 col-xs-6">
                        <label for="patrimony_garan">Garantia:</label>
                        <input id="patrimony_garan" name="patrimony_garan" class="form-control" type="text" placeholder="Garantia..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_garan')); ?>">
                        <br>
                    </div>
                    
                    <div class="form-group col-md-2 col-sm-4 col-xs-6">
                        <label for="patrimony_quant">Quantidade:</label>
                        <input id="patrimony_quant" name="patrimony_quant" class="form-control" type="text" placeholder="Quantidade..."  value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_quant')); ?>">
                    </div>
                    
                    <div class="form-group col-md-2 col-sm-4 col-xs-6">
                        <label for="patrimony_nf">Nota Fiscal:</label>
                        <input id="patrimony_nf" name="patrimony_nf" class="form-control" type="text" placeholder="Nota fiscal..." value="<?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_nf')); ?>">
                    </div>
                </div>
                
            </fieldset>
                       
            <div class="row form-compact">
                <div class="form-group col-xs-12 col-sm-12 col-md-12">
                    <label for="patrimony_obs">Observações:</label>
                    <textarea id="patrimony_obs" class="form-control" name="patrimony_obs" style="margin-top: 0px; width: 100%; max-width: 100%;  margin-bottom: 0px; height: 150px; text-align: justify;" rows="3" placeholder="Outras informações..." ><?php
                        echo htmlentities(chk_array($modelo->form_data, 'patrimony_obs')); ?></textarea>
                </div>
            </div>
            <div class="row form-compact">
                <div class="form-group col-xs-6 col-sm-3 col-md-2 ">
                    <div class="input-group-btn ">
                        <a href="<?= HOME_URI; ?>/patrimony" class="btn btn-sx btn-primary" title="Ir a página de patrimônio"><i class="fa fa-eye fa-1x" aria-hidden="true"></i> Visualizar todos os patrimônios</a>
                    </div>
                    <br>
                </div>
                <div class="form-group col-xs-6 col-sm-3 col-md-1">
                    <div class="input-group-btn">
                        <button title="Salvar informações" class="btn btn-sx btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-save"></span> Salvar</button>
                    </div>
                    <br>
                </div>
                <div class="form-group col-xs-4 col-sm-3 col-md-1 ">
                    <div class="input-group-btn">
                        <button title="Limpar formulário" class="btn btn-sx btn-warning" type="reset"><span class="glyphicon glyphicon-erase"></span> Limpar</button>
                    </div>
                    
                </div>
                <div class="form-group col-xs-4 col-sm-3 col-md-1 ">
                    <div class="input-group-btn">
                        <span title="Ir ao topo da página" class=" btn btn-primary top glyphicon glyphicon-arrow-up"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-1  col-sm-0 col-xs-0"></div>
</div> <!-- /row  -->


<script>
    
     
       $('.top').click(function(){ 
            $('html, body').animate({scrollTop:0}, 'slow');
            return false;

         });
     
</script>