/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// --> Sistema de paginação da página da agenda

var paginador;
        var totalPaginas;
        var itemsPorPagina = 4;
        var numerosPorPagina = 4;

        function creaPaginador(totalItems)
        {
                paginador = $(".pagination");

                totalPaginas = Math.ceil(totalItems/itemsPorPagina);

                $('<li><a href="#" class="first_link"><</a></li>').appendTo(paginador);
                $('<li><a href="#" class="prev_link">«</a></li>').appendTo(paginador);

                var pag = 0;
                while(totalPaginas > pag)
                {
                        $('<li><a href="#" class="page_link">'+(pag+1)+'</a></li>').appendTo(paginador);
                        pag++;
                }


                if(numerosPorPagina > 1)
                {
                        $(".page_link").hide();
                        $(".page_link").slice(0,numerosPorPagina).show();
                }

                $('<li><a href="#" class="next_link">»</a></li>').appendTo(paginador);
                $('<li><a href="#" class="last_link">></a></li>').appendTo(paginador);

                paginador.find(".page_link:first").addClass("active");
                paginador.find(".page_link:first").parents("li").addClass("active");

                paginador.find(".prev_link").hide();

                paginador.find("li .page_link").click(function()
                {
                        var irpagina =$(this).html().valueOf()-1;
                        cargaPagina(irpagina);
                        return false;
                });

                paginador.find("li .first_link").click(function()
                {
                        var irpagina =0;
                        cargaPagina(irpagina);
                        return false;
                });

                paginador.find("li .prev_link").click(function()
                {
                        var irpagina =parseInt(paginador.data("pag")) -1;
                        cargaPagina(irpagina);
                        return false;
                });

                paginador.find("li .next_link").click(function()
                {
                        var irpagina =parseInt(paginador.data("pag")) +1;
                        cargaPagina(irpagina);
                        return false;
                });

                paginador.find("li .last_link").click(function()
                {
                        var irpagina = totalPaginas -1;
                        cargaPagina(irpagina);
                        return false;
                });

                cargaPagina(0);




        }

        function cargaPagina(pagina)
        {
                var desde = pagina * itemsPorPagina;

                alert(desde);

                $.ajax({

                        type: 'GET',
                        dataType: 'json',
                        data:{'param1':'dame', 'limit':itemsPorPagina, 'offset':desde},
                        url: '<?= HOME_URI; ?>/agenda/json-pagination'
                }).done(function(data, textStatus, jqXHR){

                        var lista = data.lista;



                        $("#miTabla").html("");

                        $.each(lista, function(ind, elem){

                                $("<tr>"+
                                        "<td>"+elem.agenda_id+"</td>"+
                                        "<td>"+elem.agenda_pac+"</td>"+
                                        "<td>"+elem.agenda_proc+"</td>"+
                                        "<td>"+elem.agenda_desc+"</td>"+
                                        "</tr>").appendTo($("#miTabla"));


                        });		




                }).fail(function(jqXHR,textStatus,textError){




                        alert("Error al realizar la peticion dame".textError);

                });

                if(pagina >= 1)
                {
                        paginador.find(".prev_link").show();

                }
                else
                {
                        paginador.find(".prev_link").hide();
                }


                if(pagina <(totalPaginas- numerosPorPagina))
                {
                        paginador.find(".next_link").show();
                }else
                {
                        paginador.find(".next_link").hide();
                }

                paginador.data("pag",pagina);

                if(numerosPorPagina>1)
                {
                        $(".page_link").hide();
                        if(pagina < (totalPaginas- numerosPorPagina))
                        {
                                $(".page_link").slice(pagina,numerosPorPagina + pagina).show();
                        }
                        else{
                                if(totalPaginas > numerosPorPagina)
                                        $(".page_link").slice(totalPaginas- numerosPorPagina).show();
                                else
                                        $(".page_link").slice(0).show();

                        }
                }

                paginador.children().removeClass("active");
                paginador.children().eq(pagina+2).addClass("active");


        }


        $(function()
        {

                $.ajax({

                        data:{"param1":"cuantos"},
                        type:"GET",
                        dataType:"json",
                        url:'<?= HOME_URI; ?>/agenda/json-pagination'
                }).done(function(data,textStatus,jqXHR){
                        var total = data.total;
                        creaPaginador(total);




                }).fail(function(jqXHR,textStatus,textError){
                        alert("Error al realizar la peticion cuantos".textError);

                });



        });

     
