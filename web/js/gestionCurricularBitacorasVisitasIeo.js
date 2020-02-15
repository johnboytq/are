$(document).ready(function(){
   numeroSemana=1;

   $('a:contains("Semana No. xxxxxxxx")').click(function()
	{
		$(this).parent().parent().parent().remove();
    });
	
});

eliminarAcordeones();
//para eliminar los acordeones que no se debe llenar
function eliminarAcordeones()
{
 if (idVisitasIeo > 0)
	{	
		//mostrar el segundo acordeon
		i=3;
		// i = 7 solo para pruebas
		i=7;
    }
	else
	{
		//mostrar el primer acordeon i =2
		i=2;
	}
	
	//Cuantos acordeones son
	cantidadAcordeones = $("[href^='#w1-collapse']").length
		$("[href^='#w1-collapse']").each(function( index ) {
	});
	 //elimina los acordeones
	for (i ; i <= cantidadAcordeones; i++) { 
		$("[href='#w1-collapse"+i+"']").parent().parent().parent().remove()
	}
}  

//Sirve para poner el dia de la semana
$("#gestioncurricularsemanas-descripcion").change(function()
{ 
	textoSemana = $("#gestioncurricularsemanas-descripcion  option:selected");
	$('a:contains("semana '+numeroSemana+'")').html(function(buscayreemplaza, reemplaza) {
		return reemplaza.replace('semana '+numeroSemana, 'semana '+textoSemana.val());
	});
		
	$('a:contains("No. '+numeroSemana+'")').html(function(buscayreemplaza, reemplaza) {
		return reemplaza.replace('No. '+numeroSemana, 'No. '+textoSemana.val());
	});
		
	$('label:contains("'+numeroSemana+'")').html(function(buscayreemplaza, reemplaza) {
		return reemplaza.replace(numeroSemana, textoSemana.val());
	});
	numeroSemana = textoSemana.val();
});

//agrega campos cuando se le da en el boton agregar
$("[name='agregarCampos']").click(function(){ //Once add button is clicked
    
    var fieldHTML = '<div>Titulo<input type="text" class="form-control">Descripcion<textarea class="form-control"></textarea><a href="javascript:void(0);" onclick="removeCampos(this);" title="Eliminar"><img src="../web/images/borrar.png" height="30" width="30"/></a></div>'; //New input field html
	$(this).parent('div').append(fieldHTML); // Add field html
 });

 activo1="";
 activo2="";
 activo3="";
 //saber si el radio no esta cheked
function radioSeleccionado1(numero)
{
	if (numero ==1)
	{
		//si esta esta no se pone en uno
		activo1 =1;
	}
	else
	{
		activo1 =0;
	}
	
	activarCampo()
}

function radioSeleccionado2(numero)
{
	if (numero ==1)
	{
		activo2 =1;
	}
	else
	{
		activo2 =0;
	}
	
	activarCampo()
}

function radioSeleccionado3(numero)
{
	if (numero ==1)
	{
		activo3 =1;
	}
	else
	{
		activo3 =0;
	}
	
	activarCampo()
}

//si algun radio estan en no se inactiva el textarea
function activarCampo()
{
	if(activo1 == 1 || activo2 ==1 || activo3 ==1 )
	{
		$("#gestioncurricularvisitasacompanamiento-estado").attr("disabled",false);
	}
	
	if (activo1 == 0 && activo2 == 0 && activo3 == 0 )
	{
		$("#gestioncurricularvisitasacompanamiento-estado").attr("disabled","disabled");
	}
}

//remover los campos agregeados
function removeCampos(obj)
{
	swal({
	  title: '¿Esta seguro?',
	  text: "Esta acción no se puede revertir",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Borrar'
	}).then((result) => {
	  if (result.value) 
	  {
		$(obj).parent('div').remove();
	  }
	})
	
	
} 

	
//saber si uno o varios checkbox esta seleccionado
cont =0;
// $("#checkboxMomento1Semana1 input[type='checkbox']").click(function()
// {
	// alert();
	// $(this).each( arr, function( i, val ) {
	// alert();
	// });
	
// });

$(".btn btn-success").click(function()
{

	if(cont >0)
	{}
	else
	{
		confirm("Debe seleccionar almenos un objetivo");
		return false;
	}
	
});

$("#checkboxMomento1Semana1, #nivelesAvance").click(function()
{

	Semaforizacion();
	  
});
	
	
function Semaforizacion()
{
	$("#checkboxMomento1Semana1 input[type='checkbox']:checked").each(function() {
             // alert($(this).val());
        });
		
	$("#nivelesAvance input[type='radio']:checked").each(function() {
             // alert($(this).val());
        });	
}


//si seleccionan no o parcialmente se abilita la text area de la justificacion
$("#gestioncurricularactividadesejecutadas-se_realizo").change(function()
{
	// si el valor es 1 = si entonces se desabilita la caja de texto
	if($(this).val() == 1)
	{
		$("#gestioncurricularactividadesejecutadas-justificacion").attr("disabled","disabled");
	}
	else
	{
		$("#gestioncurricularactividadesejecutadas-justificacion").attr("disabled",false);
	}
	  
});