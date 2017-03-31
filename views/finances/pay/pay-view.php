<?php
if (!defined('ABSPATH')) {
    exit();
}

if (filter_input(INPUT_GET, 're', FILTER_DEFAULT)) {
    $encode_id = filter_input(INPUT_GET, 're', FILTER_DEFAULT);
    $modelo->delRegister($encode_id);

    # Destroy variavel não mais utilizadas
    unset($encode_id);
}
    # Verifica se existe a requisição POST se existir executa o método se não faz nada
    (filter_input_array(INPUT_POST)) ? $modelo->validate_register_form() : FALSE;

    # Verifica se existe feedback e retorna o feedback se sim se não retorna false
    $form_msg = $modelo->form_msg;
?>

<script>
    //  Muda url da pagina
    //  window.history.pushState("fees", "", "fees");

    //  Faz um refresh de url apos fechar modal
    $(function () {
        $('#infor-view').on('hidden.bs.modal', function () {
            //document.location.reload();
            $(this).removeData('bs.modal');
        });
    });
</script>

<div class="row-fluid">
    <div class="col-md-12  col-sm-12 col-xs-12">
        <!--Implementação da nova tabela-->
        
        <div class="row">
            <div class="col-md-2  col-sm-0 col-xs-0"></div>
            <div class="col-md-8  col-sm-12 col-xs-12">
                <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
                    <!--Search Start-->
                    <div class="input-group">
                        <input id="name" name="name" type="text" class="form-control" placeholder="Procurar por...">
                        <span class="input-group-btn">
                            <button class="btn btn-default btnSearch" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div><!-- /input-group -->
                    <!--Search End-->
                </form>
            </div>
            <div class="col-md-2  col-sm-0 col-xs-0"></div>
        </div> <!-- End row -->
        
        <div class="row">
            <div class="col-md-2  col-sm-0 col-xs-0"></div>
            <div class="col-md-8  col-sm-12 col-xs-12">
                
                <br>
                <div class="panel panel-default tablesearch">
                    <div class="panel-heading">
                        <span><strong>RESULTADO DA CONSULTA:</strong></span>
                    </div>
                    <div id="toolbar-admin" class="panel-body">
                        <table id="resultTable" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th class="small text-center">#</th>
                                    <th class="small text-center">DATA DE VENCIMENTO</th>
                                    <th class="small text-center">DATA DE PAGAMENTO</th>
                                    <th class="small text-center">CATEGORIA</th>
                                    <th class="small text-center">DESCRIÇÃO</th>
                                    <th class="small text-center">VALOR</th>
                                    <th class="small text-center">AÇÃO</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <nav class="text-center">
                            <ul class="pagination">
                                <li class="pag_prev">
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="pag_next">
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                    </div>

                </div>
            </div>
            <div class="col-md-2  col-sm-0 col-xs-0"></div> 
        </div><!-- End row -->
        
        <!--Implementação da nova tabela-->
        
        <!-- Start Modal deletar fornecedores -->
        <div class="modal in fade"  role="dialog" id="myModal">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title"><span style="colo" class=" info glyphicon glyphicon-floppy-remove">&nbsp;</span>ELIMINAR REGISTRO</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-justify">Tem certeza que deseja remover este registro? não sera possível reverter isso.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?= HOME_URI; ?>/finances-pay" class="btn btn-primary">Desistir</a>
                        <a href="<?= HOME_URI; ?>/finances-pay?re=<?= $modelo->encode_decode($fetch_userdata['pay_id']); ?> " class="btn btn-danger" >Eliminar</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!-- Start Modal Informações de pagamentos -->
        <div id="infor-view" class="modal fade" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <!--Conteudo do modal-->
                </div>
            </div>
        </div>
        <!-- End modal -->
    </div>
</div>

