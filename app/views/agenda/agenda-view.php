<?php   
    if (!defined('ABSPATH'))    {   exit();    } elseif (isset($_GET['ag'])){
        $id = $modelo->avaliar($_GET['ag']);
        $modelo->delRegister($id);
        unset($id);
    }
    
    // Carrega todos os metódos necessarios
    $modelo->validate_register_form();
    $form_msg = $modelo->form_msg;
?>

    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php
                if ($form_msg) {
                    echo'<div class="alert alertH ' . $form_msg[0] . ' alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <i class="' . $form_msg[1] . '" >&nbsp;</i>
                                <strong>' . $form_msg[2] . '</strong>&nbsp;' . $form_msg[3] . ' 
                            </div>';
                    unset($form_msg);
                } else {
                    unset($form_msg);
                }
            ?>
            
            <div class="row">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="btn-group btn-group-justified" role="group" aria-label="First group">
                        <button type="button" title="Adiciona nova consulta no sistema" class="btn btn-sm btn-primary btn-responsive" data-toggle='modal' data-target='#addRegister'>
                            <i class="fa fa-calendar-plus-o" aria-hidden="false"></i> NOVA CONSULTA 
                        </button>
                    </div>
                    
                    <div class="btn-group btn-group-justified" role="group" aria-label="First group">
                        <button class="btn btn-sm btn-danger btn-responsive" data-calendar-nav="prev">
                            <i class="fa fa-backward" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-sm btn-info btn-responsive" data-calendar-nav="today">Hoje</button>
                        <button class="btn btn-sm btn-danger btn-responsive" data-calendar-nav="next">
                            <i class="fa fa-forward" aria-hidden="true"></i>
                        </button>
                    </div>
                    
                    <div class="btn-group btn-group-justified" role="group" aria-label="First group">
                        <button class="btn btn-sm btn-info btn-responsive" data-calendar-view="year">Ano</button>
                        <button class="btn btn-sm btn-warning active btn-responsive" data-calendar-view="month">Mês</button>
                        <button class="btn btn-sm btn-info btn-responsive" data-calendar-view="week">Semana</button>
                        <button class="btn btn-sm btn-warning btn-responsive" data-calendar-view="day">Dia</button>
                    </div>
                    <h3 class="badge badge-light calendarTitle"></h3>
                </div> <!--End botoes-->
                
                <div class="col-md-3 col-sm-8 col-xs-8">
                    
                    <a class="btn btn-success btn-select btn-select-light">
                        <input type="hidden" class="btn-select-input btn-responsive" id="" name="" value="" />
                        <span class="btn-select-value">Select an Item</span>
                        <span class='btn-select-arrow fa fa-angle-down'></span>
                        <ul>
                            <li>Option 1</li>
                            <li class="selected">Option 2</li>
                            <li>Option 3</li>
                            <li>Option 4</li>
                        </ul>
                    </a>
                </div>
            </div> <!--End row-->

            <div class="row">
                <div id="calendar" class="col-md-12 col-sm-12 col-xs-12"></div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <span class="badge badge-light">Default</span>
                    <span class="badge badge-primary">Primary</span>
                    <span class="badge badge-success">Success</span>
                    <span class="badge badge-info">Info</span>
                    <span class="badge badge-warning">Warning</span>
                    <span class="badge badge-danger">Danger</span>
                </div>
            </div><!--End row-->
        </div><!-- /End agenda container-->
        
        <div class="col-md-3 col-sm-12 col-xs-12"><!-- Start widget container aside-right -->
            
            <div class="card text-white mb-3" style="max-width: 20rem;">
                <div class="card-header bg-info text-center">AGENDAMENTOS DO DIA</div>
                <div class="card-body bg-info">
                    <div class="paginadorAgenda alert alert-info" role="alert"></div>
                    <ul id="listConsul" class="list-group"></ul>
                </div>
                <div class="card-footer bg-info text-muted">
                    <ul class="pagination pagination-sm" id="paginador">

                    </ul>
                </div>
            </div><!--/End widget 2-->
            
        </div><!--/End widget container-->
    </div><!--/End row-->
    
    <!-- Modal -->
    <div class="modal fade" id="addRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="agenda-form-modal-cad" action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i  class="fa fa-calendar-plus-o" aria-hidden="true"></i> Inserir consulta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="from">Começa as:</label>
                            <input id="from" class="form-control dataTime" size="16" type="text" value="" name="from" placeholder="dd/mm/aaaa hh:mm">
                        </div>

                        <div class="form-group">
                            <label for="to">Termina as:</label>
                            <input id="to" class="form-control dataTimeEnd" type="text" value="" name="to" placeholder="dd/mm/aaaa hh:mm">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="tipo">Marcadores: </label>
                            <select id="tipo" name="calendar_class" class="form-control">
                                <option value="event-info">Media</option>
                                <option value="event-success">Normal</option>
                                <option value="event-important">Urgente</option>
                                <option value="event-warning">Advertencia</option>
                                <option value="event-special">Especial</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo">Procedimento:</label>
                            <select class="form-control" name="calendar_proc" id="tipo">
                                <option value="Canal">Canal</option>
                                <option value="Obturação">Obturação</option>
                                <option value="Implante">Implante</option>
                                <option value="Limpeza">Limpeza</option>
                                <option value="Orçamento">Orçamento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="paciente">Paciente:</label>
                            <input type="text" required autocomplete="off" name="calendar_pat" class="form-control" id="paciente" placeholder="Nome do paciente...">
                        </div>

                        <div class="form-group">
                            <label for="desc">Descrição da consulta:</label>
                            <textarea id="desc" name="calendar_desc" required class="form-control" rows="4" placeholder="Descreva aqui informações extras da consultas..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">X Fechar</button>
                        <button type="submit" id="cad-agenda-modal" class="btn btn-primary">Adicionar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Apresenta informações referente ao registro -->
    <div class="modal fade" id="event-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">INFORMAÇÕES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-inline list-modal-forn">
                        <li class="list-group-item list-group-item-info list-group-item-text"><b>Nome:&nbsp;</b> <span class="name">---</span></li> 
                        <li class="list-group-item list-group-item-warning list-group-item-text"><b>Descrição:&nbsp;</b> <span class="desc">----</span></li>
                        <li class="list-group-item list-group-item-success list-group-item-text"><b>Início:&nbsp;</b> <span class="start_normal">----</span> </li>
                        <li class="list-group-item list-group-item-info list-group-item-text"><b>Fim:&nbsp;</b> <span class="end_normal">----</span> </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Editar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">X Fechar</button>
                </div>
            </div>
        </div>
    </div>