	<?php if ( ! defined('ABSPATH')) exit; ?>


    <?php
        // Definimos nuestra zona horaria
        date_default_timezone_set("America/Santiago");

        // incluimos el archivo de funciones
        require_once('_agenda/funciones.php');

        // incluimos el archivo de configuracion
        //require_once '_agenda/config.php';

        // Verificamos si se ha enviado el campo con name from
        if (isset($_POST['from'])) 
        {

            // Si se ha enviado verificamos que no vengan vacios
            if ($_POST['from']!="" AND $_POST['to']!="") 
            {

                // Recibimos el fecha de inicio y la fecha final desde el form

                $inicio = _formatear($_POST['from']);
                // y la formateamos con la funcion _formatear

                $final  = _formatear($_POST['to']);

                // Recibimos el fecha de inicio y la fecha final desde el form

                $inicio_normal = $_POST['from'];

                // y la formateamos con la funcion _formatear
                $final_normal  = $_POST['to'];

                // Recibimos los demas datos desde el form
                $titulo = evaluar($_POST['title']);

                // y con la funcion evaluar
                $body   = evaluar($_POST['event']);

                // reemplazamos los caracteres no permitidos
                $clase  = evaluar($_POST['class']);

                // insertamos el evento
                $query="INSERT INTO eventos VALUES(null,'$titulo','$body','','$clase','$inicio','$final','$inicio_normal','$final_normal')";

                // Ejecutamos nuestra sentencia sql
                $conexion->query($query);

                // Obtenemos el ultimo id insetado
                $im=$conexion->query("SELECT MAX(id) AS id FROM eventos");
                $row = $im->fetch_row();
                $id = trim($row[0]);

                // para generar el link del evento
                $link = HOME_URI."_agenda/descripcion_evento.php?id=$id";

                // y actualizamos su link
                $query="UPDATE eventos SET url = '$link' WHERE id = $id";

                // Ejecutamos nuestra sentencia sql
                $conexion->query($query); 

                // redireccionamos a nuestro calendario
                header("Location: HOME_URI"); 
            }
        }

    ?>

    <!-- Agenda bibliotecas js -->
    <script src="<?php echo HOME_URI;?>/_agenda/js/pt-BR.js"></script>
    <script src="<?php echo HOME_URI;?>/_agenda/js/moment.js"></script>
    <script src="<?php echo HOME_URI;?>/_agenda/js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo HOME_URI;?>/_agenda/js/bootstrap-datetimepicker.es.js"></script>
    <!-- Final agenda js -->

                <div class="row">
                        <div class="page-header"><h2>AGENDA DE CONSULTAS</h2></div>
                                <div class="pull-left form-inline"><br>
                                        <div class="btn-group">
                                            <button class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
                                            <button class="btn" data-calendar-nav="today">Hoje</button>
                                            <button class="btn btn-primary" data-calendar-nav="next">Próximo >></button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-warning" data-calendar-view="year">Ano</button>
                                            <button class="btn btn-warning active" data-calendar-view="month">Mês</button>
                                            <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                                            <button class="btn btn-warning" data-calendar-view="day">Dia</button>
                                        </div>

                                </div>
                                    <div class="pull-right form-inline"><br>
                                        <button class="btn btn-info" data-toggle='modal' data-target='#add_evento'>Nova consulta</button>
                                    </div>

                </div><hr>

                <div class="row">
                        <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->
                        <br><br>
                </div>

                <!--ventana modal para el calendario-->
                <div class="modal fade" id="events-modal">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                    <div class="modal-body" style="height: 400px">
                                        <p>One fine body&hellip;</p>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
    <script src="<?php echo HOME_URI;?>/_agenda/js/underscore-min.js"></script>
    <script src="<?php echo HOME_URI;?>/_agenda/js/calendar.js"></script>
    <script type="text/javascript">
        (function($){
                //creamos la fecha actual
                var date = new Date();
                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
                var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

                //establecemos los valores del calendario
                var options = {

                    // definimos que los eventos se mostraran en ventana modal
                        modal: '#events-modal',

                        // dentro de un iframe
                        modal_type:'iframe',

                        //obtenemos los eventos de la base de datos
                        events_source: '<?=HOME_URI ?>/_agenda/obtener_eventos.php',

                        // mostramos el calendario en el mes
                        view: 'month',

                        // y dia actual
                        day: yyyy+"-"+mm+"-"+dd,


                        // definimos el idioma por defecto
                        language: 'pt-BR',

                        //Template de nuestro calendario
                        tmpl_path: '<?=HOME_URI ?>/_agenda/tmpls/', 
                        tmpl_cache: false,


                        // Hora de inicio
                        time_start: '08:00', 

                        // y Hora final de cada dia
                        time_end: '22:00',   

                        // intervalo de tiempo entre las hora, en este caso son 30 minutos
                        time_split: '30',    

                        // Definimos un ancho del 100% a nuestro calendario
                        width: '100%', 

                        onAfterEventsLoad: function(events)
                        {
                                if(!events)
                                {
                                        return;
                                }
                                var list = $('#eventlist');
                                list.html('');

                                $.each(events, function(key, val)
                                {
                                        $(document.createElement('li'))
                                                .html('<a href="' + val.url + '">' + val.title + '</a>')
                                                .appendTo(list);
                                });
                        },
                        onAfterViewLoad: function(view)
                        {
                                $('.page-header h2').text(this.getTitle());
                                $('.btn-group button').removeClass('active');
                                $('button[data-calendar-view="' + view + '"]').addClass('active');
                        },
                        classes: {
                                months: {
                                        general: 'label'
                                }
                        }
                };


                // id del div donde se mostrara el calendario
                var calendar = $('#calendar').calendar(options); 

                $('.btn-group button[data-calendar-nav]').each(function()
                {
                        var $this = $(this);
                        $this.click(function()
                        {
                                calendar.navigate($this.data('calendar-nav'));
                        });
                });

                $('.btn-group button[data-calendar-view]').each(function()
                {
                        var $this = $(this);
                        $this.click(function()
                        {
                                calendar.view($this.data('calendar-view'));
                        });
                });

                $('#first_day').change(function()
                {
                        var value = $(this).val();
                        value = value.length ? parseInt(value) : null;
                        calendar.setOptions({first_day: value});
                        calendar.view();
                });
        }(jQuery));
    </script>

<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Inserir nova consulta</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post">
                    <label for="from">Inicio</label>
                    <div class='input-group date' id='from'>
                        <input type='text' id="from" name="from" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>

                    <br>

                    <label for="to">Final</label>
                    <div class='input-group date' id='to'>
                        <input type='text' name="to" id="to" class="form-control" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </div>

                    <br>

                    <label for="tipo">Tipo de evento</label>
                    <select class="form-control" name="class" id="tipo">
                        <option value="event-info">Informacion</option>
                        <option value="event-success">Exito</option>
                        <option value="event-important">Importantante</option>
                        <option value="event-warning">Advertencia</option>
                        <option value="event-special">Especial</option>
                    </select>

                    <br>


                    <label for="title">Título</label>
                    <input type="text" required autocomplete="off" name="title" class="form-control" id="title" placeholder="Introduce un título">

                    <br>


                    <label for="body">Consulta</label>
                    <textarea id="body" name="event" required class="form-control" rows="3"></textarea>

    <script type="text/javascript">
        $(function () {
            $('#from').datetimepicker({
                language: 'es',
                minDate: new Date()
            });
            $('#to').datetimepicker({
                language: 'es',
                minDate: new Date()
            });

        });
    </script>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>Gravar</button>
        </form>
    </div>
  </div>
</div>
</div>