/**********
 Versión: 001
 Fecha: 04-04-2018
 ---------------------------------------
 Modificaciones:
 Fecha: 09-07-2018
 Persona encargada: Edwin Molina Grisales
 Se consulta las faltas del estudiante y se asocia el periodo a las calificaciones
 ---------------------------------------
 Fecha: 04-04-2018
 Persona encargada: Edwin Molina Grisales
 Se muestra el código de los indicadores y se mejora la carga y mostrada de las notas
 ---------------------------------------
 **********/

$( document ).ready(function() {
    // Handler for .ready() called.
    // $( "input" ).change(function(){


    // var tr = $( this ).parent().parent().parent();

    // var tds = $( "input:text", tr );
    // var sum = 0;

    // sum += tds.eq(0).val()*0.3;
    // sum += tds.eq(1).val()*0.4;
    // sum += tds.eq(2).val()*0.3;
    // sum = sum*0.7;
    // sum += tds.eq(3).val()*0.1;
    // sum += tds.eq(4).val()*0.1;
    // sum += tds.eq(5).val()*0.1;

    // $( tds[ 6 ] ).val( Math.round( 100*sum )/100 );
    // });
	
	$( "#selDocentes" ).chosen();

    llenarComboDocentes();

    $( "#selPeriodo" ).change(function(x){
        consultarInasistencias();
    });
});

/**
 * Funcion llenar los estudiante por paralelo
 *
 * param Parámetro: id del paralelo
 * return Tipo de retorno: Los estudiantes que tiene el paralelo seleccionado
 * author : Oscar David Lopez villa
 * exception : No tiene excepciones.
 */
function consultarInasistencias()
{
    //Dejo todos los campos falta en vacio
    $( ".falta" ).each( function(){
        $( this ).val(0);
    })

    //Si los campos no son mayores a 1 no se hace la consulta
    if( $( "#selDocentes" ).val()*1 < 1 && $( "#selGrupo" ).val()*1 < 1 && $( "#selMateria" ).val()*1 < 1 ){
        return;
    }

    //consulta los estudiantes que tiene ese paralelo
    $.get( "index.php?r=calificaciones/consultar-inasitencias&docente="+$( "#selDocentes" ).val()+"&grupo="+$( "#selGrupo" ).val()+"&asignatura="+$( "#selMateria" ).val()+"&periodo="+$( "#selPeriodo" ).val(),
        function( data )
        {
            $( data ).each(function(x){
                try{
                    $( "tr[estudiante="+this.id+"] .falta" ).val( this.total );
                }
                catch(e){
                    console.log("Error al consultar las inasistencias");
                    console.log(e);
                }
            })
        },
        "json");

}


function notaFinal(obj)
{
    var tr = $( obj ).parent().parent().parent();

    var tds = $( "input:text", tr );
    var sum = 0;

    sum += tds.eq(0).val()*0.3;
    sum += tds.eq(1).val()*0.4;
    sum += tds.eq(2).val()*0.3;
    sum = sum*0.7;
    sum += tds.eq(3).val()*0.1;
    sum += tds.eq(4).val()*0.1;
    sum += tds.eq(5).val()*0.1;
	

    $( tds[ 6 ] ).val( Math.round( 100*sum )/100 );  
}


function cargarCalificacionAEstudiantes( indicadoresDesempeno ){

    //console.log("====================================")
    //console.log("indicadoresDesempeno")
    //console.log(indicadoresDesempeno)

    var idDocente =	$( "#selDocentes" ).val();

    //Creo el array con los indicadores
    var indicadores = [ "saber", "hacer","ser","personal","social","ae" ];

    //Dejo todos los campos correspondientes en blanco

    //todos los campos en blanco
    $( "input[type='text']" ).val("");

    //Deja valores por defecto a los campos de notas
    $( indicadores ).each(function(){
        var name = this;
        $( "input[name="+name+"]" ).val('0');
        $( "input[name=id"+name+"]" ).val('');
    });

    //Las notas finales se dejan en 0.0
    $( "input[disabled]" ).val("0.0");


    $( indicadoresDesempeno ).each(function(x){

        try{

            // var name = this; //this en este caso es idSaber, idHacer, ...

            //x es la posicion del array e indicadores de desempeno tiene el codigo a buscar
            var idIndicadorDesempeno = indicadoresDesempeno[ x ].id;
            var posicion			 = x;

            //llenar indicadores desempeño

            $.get( "index.php?r=calificaciones/consultar-calificaciones&idDocente="+idDocente+"&idIndicadorDesempeno="+idIndicadorDesempeno+"&periodo="+$( "#selPeriodo" ).val(),
                function( data )
                {
                    try{
                        for( var x in data ){

                            //Toda fila tienen como atributo estudiante
                            var tr = $( "[estudiante="+data[x].estudiante+"]" );

                            //Asigno la calificacion al campo corresponde

                            $( "input:text.nota", tr ).eq( posicion ).val( data[x].calificacion );

                            //llenar la nota final
                            notaFinal( $( "input:text.nota", tr ).eq( posicion ) );

                            $( "input:hidden[name=id]", tr ).eq( posicion ).val( data[x].id );

                            //En la fila busco un campo que tenga como name idSaber, idHacer, etc
                        }
                    }
                    catch(e){
                        $( "input[name="+name+"]" ).val('0');
                        $( "input[name=id"+name+"]" ).val('');
                    }
                },
                "json");
        }
        catch(e){
            console.log(this)
            console.log(x)
            console.log(e);
        }

    });

}

$( ".content a" ).click(function(){

    var nombreFormulario = $( ".content form" ).attr( "id");
    var idDocente = $( selDocentes ).val();

    if( idDocente != '' ){

        var table = $( ".content table" ).eq( $( ".content table" ).length-1 );

        var estudiantes = $( "tbody > tr[estudiante]", table );

        //Obtenendo los codigos del desempño
        var codigosDesempeno = $( "thead > tr", table ).eq(3);
        var codigosDesempeno = $( "th", codigosDesempeno );

        var data = [];

        estudiantes.each(function(x){

            var estudiante 		 = $( "[name=idPersona]", this ).val()*1;
            var inCalificaciones = $( "input:text:lt(6)", this );
            var inIds			 = $( "input:hidden:lt(7)", this );

console.log(inCalificaciones)
            inCalificaciones.each(function(y){

                data.push({
                    id										: $( inIds ).eq(y+1).val()*1,
                    calificacion							: $( this ).val()*1,
                    fecha									: "2018-03-21",
                    id_perfiles_x_personas_docentes			: idDocente,
                    id_perfiles_x_personas_estudiantes		: estudiante,
                    id_distribuciones_x_indicador_desempeno	: codigosDesempeno.eq(y).data("id")*1,
                    fecha_modificacion						: "2018-03-21",
                    estado									: 1,
                    id_periodo								: $( "#selPeriodo" ).val(),
                    id_sede_jornada							: $( "#selJornada" ).val(),
                    id_asignatura                    		: $( "#selMateria" ).val(),
                    id_paralelo								: $( "#selGrupo" ).val()
                });
            });
        });

        var myObject = {};

        $('textarea').each(function(i, v) {

            observaciones = [];
            id_estudiante = v.className.substr(-1);
            
			id_estudiante = v.className.split("_");
			
			id_estudiante = id_estudiante[ id_estudiante.length-1 ];

            observaciones.push({
                id_estudiante		: id_estudiante,
                observacion_conocer	: $( ".observaciones_0_" + id_estudiante ).val(),
                observacion_hacer	: $( ".observaciones_1_" + id_estudiante ).val(),
                observacion_saber	: $( ".observaciones_2_" + id_estudiante ).val()
            });

            myObject[id_estudiante] = observaciones[0];
        });

        console.log(myObject);

console.log(data)

        // return;
        $.post(
            "index.php?r=calificaciones/create",
            {
                data: data,
                observacion: myObject
            },
            function( data ){
                try{
                    for( var x in data ){

                        var trEstudiante = $( "[estudiante="+x+"]" );
                        var inIds		 = $( "input:hidden:lt(7)", trEstudiante );

                        $( data[x] ).each(function(y){
                            inIds.eq(y+1).val( this.id );
                        });
                    }

                    swal({
                        text: "Califiaciones guardadas exitosamente",
                        icon: "success",
                        button: "Cerrar",
                    });
                }
                catch(e){
                    swal({
                        text: "Hubo un error al guardar las calificaciones",
                        icon: "warning",
                        button: "Cerrar",
                    });
                }
            },
            "json"
        );
    }

    return false;
});


//consulta los docentes
function llenarComboDocentes()
{

    $.get( "index.php?r=calificaciones/listar-docentes",
        function( data )
        {
            $("#selDocentes").html(data);
			
			$("#selDocentes").trigger('chosen:updated');
			// .trigger( 'chosen:updated' );
        },
        "json");


}

//inicio eventos

//consulta los niveles(grados) que tiene asociado ese docente desde #selDocentes
$("#selDocentes").change(function()
{
    llenarComboGrados();
    llenarCommbosSedeJornadaPeriodo();

});

//consulta los grupo(paralelos) que tiene asociado ese docente en ese grado desde #selDocentes
$("#selGrado").change(function()
{
    llenarComboGrupo();
});

//consulta las materias que tiene asociado ese docente en ese grupo des #selGrado
$("#selGrupo").change(function()
{
    llenarComboMateria();
    llenarEstudiantes()
});

//Fin eventos


//consulta los niveles(grados) que tiene asociado ese docente
function llenarComboGrados()
{

    idDocente=$("#selDocentes").val();
    //si el id esta vacio no hace nada
    if(idDocente == "")
    {
        //si docente tiene ningun nombre seleccionado se vacia el combo de grado y se pone ese html
        $("#selGrado").html("<option value=''>Seleccione...<\/option>");
        return false;
    }

    //consulta los niveles que tiene asociado ese docente
    $.get( "index.php?r=calificaciones/niveles-docente&idDocente="+idDocente,
        function( data )
        {
            $("#selGrado").html(data);
        },
        "json");

}


//consulta los grupo(paralelos) que tiene asociado ese docente en ese grupo des #selGrado
function llenarComboGrupo()
{

    idDocente =	$("#selDocentes").val();
    idNivel   =	$("#selGrado").val();
    //si el idNivel esta vacio no hace nada
    if(idNivel == "")
    {
        //si grado tiene ningun nombre seleccionado se vacia el combo de grado y se pone ese html
        $("#selGrupo").html("<option value=''>Seleccione...<\/option>");
        return false;
    }

    //consulta los niveles que tiene asociado ese docente
    $.get( "index.php?r=calificaciones/grupo-niveles-docente&idDocente="+idDocente+"&idNivel="+idNivel,
        function( data )
        {
            $("#selGrupo").html(data);
        },
        "json");

}



//consulta las materias que tiene asociado ese docente en ese grupo des #selGrado
function llenarComboMateria()
{

    idDocente =	$("#selDocentes").val();
    idParalelo   =	$("#selGrupo").val();
    //si el idNivel esta vacio no hace nada
    if(idParalelo == "")
    {
        //si grado tiene ningun nombre seleccionado se vacia el combo de grado y se pone ese html
        $("#selMateria").html("<option value=''>Seleccione...<\/option>");
        return false;
    }

    //consulta los niveles que tiene asociado ese docente
    $.get( "index.php?r=calificaciones/materia-grupo&idDocente="+idDocente+"&idParalelo="+idParalelo,
        function( data )
        {
            $("#selMateria").html(data);
        },
        "json");


}


function llenarCommbosSedeJornadaPeriodo()
{

    idDocente =	$("#selDocentes").val();
    //si el idNivel esta vacio no hace nada
    if(idDocente == "")
    {
        //si grado tiene ningun nombre seleccionado se vacia el combo de grado y se pone ese html
        $("#xxxxxxxxxxxxxx").html("<option value=''>Seleccione...<\/option>");
        return false;
    }

    //consulta los niveles que tiene asociado ese docente
    $.get( "index.php?r=calificaciones/sede-jornada-periodo&idDocente="+idDocente,
        function( data )
        {
            $("#txtSede").val(data.nombreSede);
            $("#selJornada").html(data.jornadas);
            $("#selPeriodo").html(data.periodos);
        },
        "json");

}

/**
 * Funcion llenar los estudiante por paralelo
 *
 * param Parámetro: id del paralelo
 * return Tipo de retorno: Los estudiantes que tiene el paralelo seleccionado
 * author : Oscar David Lopez villa
 * exception : No tiene excepciones.
 */
function llenarEstudiantes()
{

    idParalelo   =	$("#selGrupo").val();
    //si el idNivel esta vacio no hace nada
    if(idParalelo == "")
    {
        $("#estudiantes").html("");
        return false;
    }

    //consulta los estudiantes que tiene ese paralelo
    $.get( "index.php?r=calificaciones/personas&idParalelo="+idParalelo,
        function( data )
        {
            /**
             * Lista de estudiantes en json, contiene el id y nombre del estudiante
             * Se para listar los estudiantes al seleccionar una asignatura
             */
            listaEstudiantes = data;
        },
        "json");

}




/**
 * Funcion llenar los indicadores de desempeño
 *
 * param Parámetro: El onchange del select id selMateria
 * return Tipo de retorno: Retorna los indicadores a calficar
 * author : Viviana Rodas
 * exception : No tiene excepciones.
 */
$("#selPeriodo").change(function(){




    function obtenerDatosEncabezado(){

        //Celdas principales de la tabla
        //html es lo que va entre las etiquetas <td> y </td>
        //colspan y rowspan solo los atributos necesarios a cada celda
        var celdaConocer 	= {
            html 	: "Saber conocer",
            colspan : 0,
            rowspan : 1,
        };

        var celdaHacer 		= {
            html 	: "Saber hacer",
            colspan : 0,
            rowspan : 1,
        };

        var celdaSer		= {
            html 	: "Saber ser",
            colspan : 0,
            rowspan : 1,
        };

        var celdaDesempeno 	= {
            html 	: "Desempeños",
            colspan : 0,
            rowspan : 1,
        };

        var celdaCognitivo 	= {
            html 	: "COGNITIVO",
            colspan : 0,
            rowspan : 1,
        };

        var celdaPersonal 	= {
            html 	: "Personal",
            colspan : 0,
            rowspan : 2,
        };


        var celdaSocial 	= {
            html 	: "Social",
            colspan : 0,
            rowspan : 2,
        };

        var celdaAe			= {
            html : "AE",
            colspan : 0,
            rowspan : 2,
        }

        //Representa el encabezado de la tabla
        var titulos = [
            [
                {
                    html 	: "No",
                    colspan : 1,
                    rowspan : 4,
                },
                {
                    html 	: "Estudiantes",
                    colspan : 1,
                    rowspan : 4,
                },
                celdaCognitivo,
                celdaPersonal,
                celdaSocial,
                celdaAe,
                {
                    html 	: "Nota final",
                    colspan : 1,
                    rowspan : 4,
                },
                {
                    html 	: "Faltas",
                    colspan : 1,
                    rowspan : 4,
                },
                {
                    html 	: "Co evaluación",
                    colspan : 1,
                    rowspan : 4,
                },
            ],
            [
                celdaConocer,
                celdaHacer,
                celdaSer,
            ],
            [
                celdaDesempeno,
            ],
            [],	//Array vacio, esta fila corresponde a los codigos e ids de inidcadores
        ];

        var indicadores = {
            conocer	: [ celdaConocer, celdaDesempeno, celdaCognitivo ],	//Este es la celda de saber
            hacer	: [ celdaHacer, celdaDesempeno, celdaCognitivo ],	//Este es la celda de saber
            ser		: [ celdaSer, celdaDesempeno, celdaCognitivo ],	//Este es la celda de saber
            personal: [ celdaPersonal, celdaDesempeno ],	//Este es la celda de saber
            social	: [ celdaSocial, celdaDesempeno ],	//Este es la celda de saber
            ae		: [ celdaAe, celdaDesempeno ],	//Este es la celda de saber
        }

        return {
            titulos		: titulos,
            indicadores : indicadores,
        }
    }

    /**
     [{
		saber: [1,2,3]
	}]
     */
    function addIndicadores( indicadores, datos )
    {

        for( var x in datos )
        {
            var cols = datos[ x ].length;

            for( var z in indicadores[x] )
                indicadores[x][z].colspan += cols;
        }
    }

    function pintarTabla( datosTablas, listaEstudiantes, indicadoresOrdenados ){

        $( "#dvEstudiantes" ).html("");

        var titulos = datosTablas.titulos;

        //Pinta el encabezado de la tabla reprensentada por titulos
        var table = "<table>";

        table += "<thead>";

        for( var x in titulos ){
            table += "<tr>";
            for( var y in titulos[x] ){
                var celda = titulos[x][y];
                if( celda.colspan > 0 )
                {
                    var atr = celda.atributos || '';
                    table += "<th rowspan="+celda.rowspan+" colspan="+celda.colspan+" "+atr+">";
                    table += celda.html;
                    table += "</th>";
                }
            }
            table += "</tr>";
        }

        table += "</thead>";

        //pintando la lista de estudiantes
        table += "<tbody id=estudiantes>";

        var cont = 0;
        for( var x in listaEstudiantes ){
            cont++;
            table += "<tr estudiante='"+listaEstudiantes[x].id+"'>";
            table += "<td><b>#"+cont+"</b></td>";
            table += "<td><b>"+listaEstudiantes[x].nombres+"</b><input type='hidden' value='"+listaEstudiantes[x].id+"' name='idPersona'></td>";

            for( var y in indicadoresOrdenados ){

                table += "<td>"
                    +"<div class='form-group field-calificacionesbuscar-observaciones'>"
                    +"<input type='text' class='form-control nota' name='' onkeyup='notaFinal(this)'>"
                    +"</div>"
                    +"<input type='hidden' value='' name='id'>"
                    +"</td>";
            }

            // //ae
            // table += "<td>"
            // +"<div class='form-group field-calificacionesbuscar-observaciones'>"
            // +"<input type='text' class='form-control nota' name='ae' onkeyup='notaFinal(this)'>"
            // +"</div>"
            // +"<input type='hidden' value='' name='idae'>"
            // +"</td>";

            //Nota final
            table += "<td>"
                +"<div class='form-group field-calificacionesbuscar-observaciones'>"
                +"<input type='text' class='form-control' disabled='disabled'>"
                +"</div>"
                +"</td>";

            //Faltas
            table += "<td>"
                +"<div class='form-group field-calificacionesbuscar-observaciones'>"
                +"<input type='text' class='form-control falta' disabled='disabled'>"
                +"</div>"
                +"</td>";

            //Co evaluación
            table += "<td>"
                +"<div class='form-group field-calificacionesbuscar-observaciones'>"
                +"<input type='text' class='form-control coevaluacion'>"
                +"</div>"
            "</td>";

                table += "</tr>";

            //Observaciones
            $.each(titulos[1], function( index, value ) {
                //console.log(titulos[1]);
                table += "<tr>" +
                    "<td colspan='10'><div class='form-group field-calificacionesbuscar-observacion'>\n" +
                    "<label style='width: 100%;'>\n" +
                    "<span style='text-align: left; display: flex;'>Observacion "+ value["html"] +"</span>\n" +
                    "<textarea class='form-control observaciones_" + index + "_" + listaEstudiantes[x].id  + "'></textarea>\n" +
                    "</label>\n" +
                    "</div></td></tr>";
            });



            dataObservacion = {
                id : listaEstudiantes[x]['id'],
                periodo: $( "#selPeriodo" ).val(),
                asignatura: $("#selMateria").val()
            };

            $.post( "index.php?r=calificaciones/observation-person", dataObservacion, function( data ) {
                //console.log(data);
                $observacion = $.parseJSON(data);
                $('.observaciones_0_' + $observacion.id_estudiante).text($observacion.observacion_conocer);
                $('.observaciones_1_' + $observacion.id_estudiante).text($observacion.observacion_hacer);
                $('.observaciones_2_' + $observacion.id_estudiante).text($observacion.observacion_saber);
                //$( "#observaciones_" + index).html( data );
            });

            table += "<tr>" +
                "<td colspan='10'><div class='form-group field-calificacionesbuscar-observacion'>\n" +
                "<button type=\"button\" class=\"btn btn-success\" onclick=\"generatePdf("+ listaEstudiantes[x].id +")\">Generar Pdf</button>" +
                "</div></td></tr>";
        }



        table += "</tbody>";

        table += "</table>";

        $( "#dvEstudiantes" ).append( table );

        $( "#estudiantes input:text.nota" ).on('keyup', function(e) {


            var tecla = e.keyCode || e.which;

            //Tecla de retroceso para borrar, siempre la permite
            if ( tecla==8 || tecla == 13 || tecla == 9 ){
                return true;
            }

            //Valida que no se pueda ingresar valor menores a 0 y mayores a 5

            var max		= 5;
            var min		= 0;
            var valor 	= parseFloat(this.value);

            if(valor < min || valor > 5 ){

                swal({
                    text: "El Valor debe ser mayor a 0 y menor a 5",
                    icon: "warning",
                    button: "Cerrar",
                });

                if( valor > 5)
                    this.value = max;

                if( valor < 0 )
                    this.value = min;
            }

        }).keypress(function(e){

            //Solo se permite números decimales

            var tecla = e.keyCode || e.which;

            // Patron de entrada, en este caso solo acepta numeros
            var patron=  /^[0-9]*\.?[0-9]*$/
            tecla_final = String.fromCharCode(tecla);
            // return patron.test(tecla_final);
            return (patron.test(tecla_final) || tecla == 9 || tecla == 8);
        });

        //a faltas solo se le puede ingresar numeros enteros
        $( "#estudiantes input:text.falta" ).keypress(function(e){


            var tecla = e.keyCode || e.which;

            //Tecla de retroceso para borrar, siempre la permite
            if ( tecla==8 || tecla == 13 || tecla == 9 ){
                return true;
            }

            // Patron de entrada, en este caso solo acepta numeros
            var patron=  /^[0-9]+$/
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
        });
    }

    idDocente =	$("#selDocentes").val();
    idParalelo = $("#selGrupo").val();
    idAsignatura = $("#selMateria").val();

    // Se deja en blanco los campo  requeridos cada vez que se cambie la materia
    $("#thSaber").html('').data( 'id', '' );
    $("#thHacer").html('').data( 'id', '' );
    $("#thSer").html('').data( 'id', '' );
    $("#thPers").html('').data( 'id', '' );
    $("#thSoci").html('').data( 'id', '' );
    $("#thAE").html('').data( 'id', '' );


    //llenar indicadores desempeño
    $.get( "index.php?r=calificaciones/listar-i&idDocente="+idDocente+"&idParalelo="+idParalelo+"&idAsignatura="+idAsignatura,
        function( data )
        {
            datosTitulosIndicadores = obtenerDatosEncabezado();
            addIndicadores( datosTitulosIndicadores.indicadores, data );


            //Variable que contiene todos los indicadores en el orden en que so pintados
            var indicadoresOrdenados = [];

            //Se agrega las celdas correspondientes a los codigos e ids de indicadores
            for( var x in datosTitulosIndicadores.indicadores )
            {
                //x es uno de los valores conocer, hacer, ser, personal, social, ae
                //Por cada x agrego las celdas correspondiente
                if( data && data[x] ){
                    for( var y in data[x] ){

                        indicadoresOrdenados.push( data[x][y] );	//Agrego el indicador pintado

                        datosTitulosIndicadores.titulos[3].push({
                            html 		: data[x][y].codigo,
                            atributos	: "data-id="+data[x][y].id,
                            colspan 	: 1,	//son celdas individuales por lo tanto siempre es uno
                            rowspan 	: 1,	//son celdas individuales por lo tanto siempre es uno
                        })
                    }
                }
            }

            pintarTabla( datosTitulosIndicadores, listaEstudiantes, indicadoresOrdenados );

            cargarCalificacionAEstudiantes( indicadoresOrdenados );

            consultarInasistencias();
        },
        "json");
});

function generatePdf(id_estudiante) {

    idDocente =	$("#selDocentes").val();
    idParalelo   =	$("#selGrupo").val();
    idAsignaturas = $("#selMateria").val();

    console.log(id_estudiante);

    data = {
        docente : idDocente,
        paralelo : idParalelo,
        estudiante : id_estudiante,
        materias : $('#selMateria option').map(function() { return parseInt($(this).val()); }).get(),
        institucionSede: $("#InstitucionSede").text()
    };

    //console.log(data);

    $.post( "index.php?r=calificaciones/generate-pdf", data, function( data ) {
		console.log(data)
        window.open(data, 'Download');
        //window.location.assign('prueba.pdf');
        $( ".result" ).html( data );
    });
}

