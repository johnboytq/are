//se calcula la taza Taza de cobertura bruta para transcision
$("#tcbtranscision").keyup(function() 
{
  mn  = $("#transcision").html()*1;
  pen = $("#tcbtranscision").val()*1;
  
  valor = calcularTCB(mn,pen);
  $("#tdtcbtranscision").html(valor);
});


//se calcula la taza Taza de cobertura bruta para primaria
$("#tcbprimaria").keyup(function() 
{
	
  mn = $("#primaria").html()*1;
  pen  = $("#tcbprimaria").val()*1;

  valor = calcularTCB(mn,pen);
  $("#tdtcbprimaria").html(valor);
});

//se calcula la taza Taza de cobertura bruta para secundaria
$("#tcbsecundaria").keyup(function() 
{
	
  mn = $("#secundaria").html()*1;
  pen  = $("#tcbsecundaria").val()*1;

  valor = calcularTCB(mn,pen);
  $("#tdtcbsecundaria").html(valor);
});


//se calcula la taza Taza de cobertura bruta para media
$("#tcbmedia").keyup(function() 
{
	
  mn = $("#media").html()*1;
  pen  = $("#tcbmedia").val()*1;

  valor = calcularTCB(mn,pen);
  $("#tdtcbmedia").html(valor);
});



function calcularTCB(mn,pen)
{
	if(isNaN(mn/pen) || (mn/pen) == Infinity )
	{
		return "N/A"
	}
	return (mn/pen)*100;
}