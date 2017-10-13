        <?php
            if (!defined('ABSPATH')) {  exit(); }

            if (filter_input(INPUT_GET, 're', FILTER_DEFAULT)) {
                $encode_id = filter_input(INPUT_GET, 're', FILTER_DEFAULT);
                //var_dump($encode_id);die;
                $modelo->delRegister($encode_id);

                # Destroy variavel não mais utilizadas
                unset($encode_id);
            }
                # Verifica se existe a requisição POST se existir executa o método se não faz nada
                (filter_input_array(INPUT_POST)) ? $modelo->validate_register_form() : FALSE;

                # Paginação parametros-------->
                $limit = 5;
                $pagConfig = [
                    'totalRows' => COUNT($modelo->searchTable('payments')),
                    'perPage'   => $limit,
                    'link_func' => 'searchFilter'];

                $pagination =  new Pagination($pagConfig);

                #-->
                $payments = $modelo->searchTable('payments', ['order_by'=>'payments_id DESC ', 'limit'=>$limit]);

                # Verifica se existe feedback e retorna o feedback se sim se não retorna false
                $form_msg = $modelo->form_msg;

                //date_default_timezone_set('America/Sao_Paulo');
                $date = (date('Y-m-d H:i'));
                date('Y-m-d H:i:s', time());
        ?>
        <div class="row">
            <div class="col-md-1  col-sm-0 col-xs-0"></div>
            <div class="col-md-10  col-sm-12 col-xs-12">
                <div id="loading" style="display: none;"><!--Loading.. este aqui-->
                    <ul class="bokeh">
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div><!--End loandind-->
            </div>
            <div class="col-md-1  col-sm-0 col-xs-0"></div>
        </div><!-- End row feedback -->
        
        <div class="row">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <form id="" enctype="multipart/form-data" class="form-register" data-id="" method="post" action="" role="form" >
                    <fieldset>
                        <legend >FORNECEDORES <span></span></legend>
                        
                        <div class="row form-hide" style="display: none;"><!-- Start div hidden 1 -->
                            <div class="col-md-12  col-sm-12 col-xs-12"><small class="text-muted">INFORMAÇÕES DO FORNECEDOR</small></div>
                        </div>    
                        <div class="row form-hide" style="display: none;"><!-- Start div hidden 1 -->
                            <div class="form-group col-md-3 col-sm-12 col-xs-12">
                                <label for="payments_venc">Empresa:</label>
                                <input type="hidden" id="provider_id" name="provider_id" value="" >
                                <input id="provider_name" name="provider_name" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>

                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="payments_date_pay">CPF/CNPJ:</label>
                                <input id="provider_cpf_cnpj" name="provider_cpf_cnpj" type="text" class="form-control form-control-sm" placeholder="CPF/CNPJ" >
                            </div>

                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rs"> Razão social:</label>
                                <input id="provider_rs" name="provider_rs" class="form-control form-control-sm" type="text" placeholder="Razão social..." value="">
                            </div>

                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_atua">Área de atuação:</label>
                                <input id="provider_atua" name="provider_atua" class="form-control form-control-sm" type="text" placeholder="Área de atuação..." value="">
                            </div>
                            <div class="form-group col-md-3 col-sm-12 col-xs-12" >
                                <label for="provider_end">Endereço:</label>
                                <input id="provider_end" name="provider_end" type="text" class="form-control form-control-sm" placeholder="Endereço..." >
                            </div>
                        </div><!-- End div hidden 1 -->
                        
                        <div class="row form-hide" style="display: none;"><!--Start div hidden 2-->
                            <div class="form-group col-md-3 col-sm-12 col-xs-12">
                                <label for="provider_district">Bairro:</label>
                                <input id="provider_district" name="provider_district" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-3 col-sm-12 col-xs-12">
                                <label for="provider_city">Cidade:</label>
                                <input id="provider_city" name="provider_city" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-1 col-sm-12 col-xs-12">
                                <label for="provider_uf">UF:</label>
                                <input id="provider_uf" name="provider_uf" type="text" class="form-control form-control-sm" placeholder="UF..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_pais">Pais:</label>
                                <input id="provider_pais" name="provider_pais" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-3 col-sm-12 col-xs-12">
                                <label for="provider_cep">CEP:</label>
                                <input id="provider_cep" name="provider_cep" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_cel">Celular:</label>
                                <input id="provider_cel" name="provider_cel" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_tel1">Telefone 1:</label>
                                <input id="provider_tel1" name="provider_tel1" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_tel2">Telefone 2:</label>
                                <input id="provider_tel2" name="provider_tel2" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_insc">Inscrição Estadual:</label>
                                <input id="provider_insc" name="provider_insc" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_email">E-mail:</label>
                                <input id="provider_email" name="provider_email" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_site">Web Site:</label>
                                <input id="provider_site" name="provider_site" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                        </div><!-- End div hidden 2 -->
                        
                        <div class="row form-hide" style="display: none;"><!-- Start div hidden 1 -->
                            <div class="col-md-12  col-sm-12 col-xs-12"><small class="text-muted">INFORMAÇÕES DO REPRESENTANTE - PESSOA DE CONTATO</small></div>
                        </div> 
                        
                        <div class="row form-hide" style="display: none;"><!--Start div hidden 3-->
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rep_nome">Nome:</label>
                                <input id="provider_rep_nome" name="provider_rep_nome" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rep_apel">Apelido:</label>
                                <input id="provider_rep_apel" name="provider_rep_apel" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rep_email">E-mail:</label>
                                <input id="provider_rep_email" name="provider_rep_email" type="text" class="form-control form-control-sm" placeholder="UF..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rep_cel">Celular:</label>
                                <input id="provider_rep_cel" name="provider_rep_cel" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rep_tel1">Telefone 1:</label>
                                <input id="provider_rep_tel1" name="provider_rep_tel1" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_rep_tel2">Telefone 2:</label>
                                <input id="provider_rep_tel2" name="provider_rep_tel2" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                        </div><!-- End div hidden 3 -->
                        
                        <div class="row form-hide" style="display: none;"><!-- Start div hidden 1 -->
                            <div class="col-md-12  col-sm-12 col-xs-12"><small class="text-muted">INFORMAÇÕES BANCÁRIAS</small></div>
                        </div> 
                        
                        <div class="row form-hide" style="display: none;"><!--Start div hidden 4-->
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_ban_1">Banco 1:</label>
                                <input id="provider_ban_1" name="provider_ban_1" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_ag_1">Agência 1:</label>
                                <input id="provider_ag_1" name="provider_ag_1" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_con_1">Conta 1:</label>
                                <input id="provider_con_1" name="provider_con_1" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_ti_1">Titular 1:</label>
                                <input id="provider_ti_1" name="provider_ti_1" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                        </div><!-- End div hidden 4 -->
                        
                        <div class="row form-hide" style="display: none;"><!--Start div hidden 4-->
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_ban_2">Banco 2:</label>
                                <input id="provider_ban_2" name="provider_ban_2" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_ag_2">Agência 2:</label>
                                <input id="provider_ag_2" name="provider_ag_2" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_con_2">Conta 2:</label>
                                <input id="provider_con_2" name="provider_con_2" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                            <div class="form-group col-md-2 col-sm-12 col-xs-12">
                                <label for="provider_ti_2">Titular 2:</label>
                                <input id="provider_ti_2" name="provider_ti_2" type="text" class="form-control form-control-sm" placeholder="Nome da empresa..." >
                            </div>
                        </div><!-- End div hidden 5 -->
                        
                        <div class="row form-hide" style="display: none;"><!--Start div hidden 4-->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12">
                                <label for="provider_obs">Observações:</label>
                                <textarea id="provider_obs" class="form-control" name="provider_obs" style="margin-top: 0px; width: 100%; max-width: 100%;  margin-bottom: 0px; height: 150px; text-align: justify;" rows="3" placeholder="Outras informações..." ><?php echo htmlentities(chk_array($modelo->form_data, 'provider_obs')); ?></textarea>
                            </div>
                        </div><!-- End div hidden 6 -->
                        
                        <div class="row form-compact row-button-hide" style="display: none;">
                            <div class="form-group col-md-5 col-sm-12 col-xs-12">
                                <div id="group-btn-save" class="btn-group">
                                    <button id="btn-save" title="Salvar informações" class="btn btn-outline-primary btn-sm" type="button"></button>
                                </div>
                                <div id="group-btn-reset" class="btn-group">
                                    <button title="Limpar formulário" class="btn btn-light btn-sm marg-top fees-clear" type="reset"><i class="text-warning glyphicon glyphicon-erase"></i> <span class="text-warning">LIMPAR</span></button>
                                </div>
                                <div id="group-btn-form-new" class="btn-group" style="display:none;">
                                    <button id="btn-form-new" title="Inserir nova conta a pagar" class="btn btn-light btn-sm  marg-top" type="reset"><i class="text-primary glyphicon glyphicon-plus"></i> <span>MODO NOVO REGISTRO</span></button>
                                </div>
                            </div>
                        </div>

                        <div class="row form-compact" >
                            <div class="form-group col-md-5 col-sm-12 col-xs-12">
                                <div id="group-btn-new" class="btn-group">
                                    <button id="btn-new-show" title="Insere novo registro" class="btn btn-dark btn-sm marg-top" type="reset">
                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<span>NOVO REGISTRO</span>
                                    </button>
                                </div>
                                <div id="group-btn-show" style="display: none;" class="btn-group">
                                    <button id="btn-show" title="Mostrar formulário" class="btn btn-sm btn-default marg-top" type="reset">
                                        <i class="glyphicon glyphicon-eye-open"></i> Mostrar Formulário
                                    </button>
                                </div>
                                <div id="group-btn-hide" style="display: none;" class="btn-group">
                                    <button id="btn-hide" title="Ocultar formulário" class="btn btn-sm btn-default marg-top" type="reset"><i class="glyphicon glyphicon-eye-close"></i> OCULTAR FORMULÁRIO</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div><!-- End row button new form -->
        <?php if (!empty($payments)) { ?>
        <div id="filtros" class="row">
            <div class="form-group col-md-4 col-sm-10 col-xs-12">
                <div class="input-group">
                    <div class="input-group-addon" >
                        <i class="glyphicon glyphicon-search text-primary" title="Efetue um pesqisa no sistema." aria-hidden="true"></i>
                    </div>
                    <input style="border-radius: 0px !important;" type="text" class="search form-control " id="keywords" placeholder="Buscar por: Descrição ou Data de Vencimento..." onkeyup="objFinanca.ajaxFilter();">
                </div>
            </div><!--/End col-->

            <div class="col-md-5 col-sm-0 col-xs-0"></div><!--End/-->

            <div class="form-group col-md-1  col-sm-3 col-xs-12">
                <div class="input-group">
                    <input type="text" class="text-center form-control" id="qtdLine"  placeholder="5" onkeyup="objFinanca.ajaxFilter();" data-toggle="tooltip" data-placement="bottom" title="Quantidade de registro por página de 1 até 50." >
                </div>
            </div><!--/End col-->

            <div class="form-group col-md-2  col-sm-3 col-xs-12">
                <select id="sortBy" class="form-control" onchange="objFinanca.ajaxFilter();">
                    <option value="">Ordenar Por</option>
                    <option value="asc">Ascendente</option>
                    <option value="desc">descendente</option>
                    <option value="active">Pago</option>
                    <option value="inactive">Não Pago</option>
                </select>
            </div><!--/End col-->
        </div><!-- End row filtros -->
        
        <?php } ?>
        <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12">
                <div id="tableData" class="table-responsive" style="border: none;">
                    
                </div>
            </div>
        </div><!-- End row table -->
        <!-- Start Modal deletar fornecedores -->
        <div class="modal in fade"  role="dialog" id="dellReg">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title"><span class=" info glyphicon glyphicon-floppy-remove">&nbsp;</span>ELIMINAR REGISTRO</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-justify">Tem certeza que deseja remover este registro? não sera possível reverter isso.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a href="javascript:void();" class="btn btn-danger delete-yes" >Eliminar</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Start Modal Informações de pagamentos -->
        <div id="inforView" class="modal fade" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <!--Conteudo do modal-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> INFORMAÇÕES</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="list-inline list-modal-forn">
                            <li class="list-group-item list-group-item-info list-group-item-text"><b>Vencimento: </b> <span class="payments_venc">---</span></li> 
                            <li class="list-group-item list-group-item-warning list-group-item-text"><b>Data de Pagamento: </b> <span class="payments_date_pay">----</span></li>
                            <li class="list-group-item list-group-item-success list-group-item-text"><b>Categoria: </b> <span class="payments_cat">----</span> </li>
                            <li class="list-group-item list-group-item-info list-group-item-text"><b>Descrição: </b> <span class="payments_desc"></span></li>
                            <li class="list-group-item list-group-item-warning list-group-item-text"><b>Valor: </b> <span class="payments_val">----</span></li>
                            <li class="list-group-item list-group-item-success list-group-item-text"><b>Data da inclusao: </b> <span class="payments_created">----</span></li>
                            <li class="list-group-item list-group-item-success list-group-item-text"><b>Modificado em: </b> <span class="payments_modified">----</span></li>
                            <li class="list-group-item list-group-item-success list-group-item-text"><b>Status: </b> <span class="payments_status">----</span></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar X</button>
                    </div>
                </div>
            </div>
        </div><!-- End modal visualizar -->
        
        <!-- Modal editar inserir -->
        <div class="modal fade" id="modalForm" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Fechar X</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Contact Form</h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p class="statusMsg"></p>
                        <form class="form" role="form">
                            <div class="form-group">
                                <label for="inputName">Name</label>
                                <input type="text" class="form-control" id="inputName" placeholder="Enter your name"/>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" placeholder="Enter your email"/>
                            </div>
                            <div class="form-group">
                                <label for="inputMessage">Message</label>
                                <textarea class="form-control" id="inputMessage" placeholder="Enter your message"></textarea>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <a href="JavaScript:void(0);" class="btn btn-success" onclick="userAction('add')">Add User</a>
                    </div>
                </div>
            </div>
        </div><!--End modal editar inserir-->
        <script>
            //Setando valores do ajax
            var objFinanca = new Financeiro();
            objFinanca.setAjaxData('finances-payments/filters');
            objFinanca.ajaxData();
            objFinanca.getAjaxData();
            
            //  Muda url da pagina
            //  window.history.pushState("fees", "", "fees");
            //  Faz um refresh de url apos fechar modal
            //$(function () {
            //    $('body').on('hidden.bs.modal', function () {
            //        $(this).removeData('bs.modal');
            //    });
            //});

            // Invoca a edição de registro
            function editRegister( id ){
               $.ajax({
                    type: 'POST',
                    dataType:'JSON',
                    url: '<?=HOME_URI;?>/finances-payments/ajax-process',
                    data: 'action_type=data&id='+id,
                    async: true,
                    success:function(result) {
                        console.log(result);
                        document.getElementById('payments_id').value = result.payments_id;
                        document.getElementById('payments_venc').value = result.payments_venc;
                        document.getElementById('payments_date_pay').value = result.payments_date_pay;
                        document.getElementById('payments_desc').value = result.payments_desc;
                        document.getElementById('payments_cat').value = result.payments_cat;
                        document.getElementById('payments_val').value = result.payments_val;
                    }
                });
            }
            
            //Açoes de remoção e inserção
            function userAction(type,id){
                id = (typeof id === "undefined") ? '' : id;
                //var statusArr = {add:"added",edit:"updated",delete:"deleted"};
                var userData = '';
                if (type === 'add') {
                    userData = $("#addForm").serialize()+'&action_type='+type+'&id='+id;
                    feedback = 'Inserido com sucesso!';
                }else if (type === 'edit'){
                    userData = $("#editForm").serialize()+'&action_type='+type;
                    feedback = 'Atualizado com sucessso!';
                }else{
                    if(confirm('Deseja remover esse registro?')){
                        userData = 'action_type='+type+'&id='+id;
                        feedback = 'Remoção realizada com sucesso!';
                    }else{
                        return false;
                    }   
                }
                $.ajax({
                    type: 'POST',
                    url: '<?= HOME_URI; ?>/finances-payments/ajax-process',
                    data: userData,
                    success:function(msg){
                        objFinanca.ajaxData();
                        if(msg === 'ok'){
                            toastr.success(feedback, 'Sucesso!', {timeOut: 5000});
                            $('.form-register')[0].reset();
                        }else{
                            toastr.warning('Ocorreu algum problema, tente novamente', 'Erro!', {timeOut: 5000});
                        }
                    }
                });
            }
            // Invoca a visualização do registro
            function infoView(id){
                $.ajax({
                    type: 'POST',
                    dataType:'JSON',
                    url: '<?=HOME_URI;?>/finances-payments/ajax-process',
                    data: 'action_type=data&id='+id,
                    success:function(data){
                        $('.payments_venc').text((data.payments_venc) ? data.payments_venc : '---' );
                        $('.payments_date_pay').text((data.payments_date_pay) ? data.payments_date_pay : '---');
                        $('.payments_cat').text((data.payments_cat) ? data.payments_cat  : '---');
                        $('.payments_desc').text((data.payments_desc) ? data.payments_desc : '---');
                        $('.payments_val').text((data.payments_val) ? data.payments_val : '---');
                        $('.payments_created').text((data.payments_created) ? data.payments_created : ' ---');
                        $('.payments_modified').text((data.payments_modified) ? data.payments_modified  : '');
                        $('.payments_status').text((data.payments_date_pay) ? 'Pago' : 'Em débito');
                        //$('#editForm').slideDown();
                    }
                });
            }
            
        </script>