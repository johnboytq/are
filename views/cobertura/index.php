<?php
if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

/**********
Versión: 001
Fecha: 10-04-2018
Edwin Molina Grisales
COBERTURA
---------------------------------------
**********/

$this->title = 'Cobertura';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    
    table {
		width:90%;
		border-top:1px solid #e5eff8;
		border-right:1px solid #e5eff8;
		margin:1em auto;
		border-collapse:collapse;
    }
	
    td {
		color:#678197;
		border: 1px solid #000;
		padding:.3em 1em;
		text-align:left;
    }
	
	thead > tr > th {
		text-align: center;
		background-color: #ccc;
		border: 1px solid #ddd;
	}
	
	tfoot > tr > td {
		font-weight: bold;
		text-align: left;
		background-color: #ddd;
		border: 1px solid #ddd;
	}

</style>

<div class="estados-index">

	<table>
	
		<thead>
			
			<tr>
				<th rowspan='3' colspan='1'>Categorías</th>
				<th rowspan='3' colspan='1'>Sub-Categoría</th>
				<th rowspan='3' colspan='1'>Temas</th>
				<th rowspan='1' colspan='6'>CANTIDAD</th>
			</tr>
			
			<tr>
				<th rowspan='1' colspan='2'>INSTITUCIÓN EDUCATIVA LA PAZ-SAAVEDRA GALINDO</th>
				<th rowspan='1' colspan='2'>SEDE VILLA DEL ROSARIO</th>
				<th rowspan='1' colspan='2'>SEDE JORGE ROBLEDO</th>
			</tr>
			
			<tr>
				<th>Niños</th>
				<th>Niñas</th>
				<th>Niños</th>
				<th>Niñas</th>
				<th>Niños</th>
				<th>Niñas</th>
			</tr>
			
		</thead>
		
		<tbody>
			
			<!-- 1 -->
			<tr>
				<td rowspan='35' colspan='1'>Cobertura Matriculo(Acceso)</td>
				<td rowspan='24' colspan='1'>1.Matricula: # de Estudiantes</td>
				<td rowspan='1' colspan='1'>0</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>36</td>
				<td rowspan='1' colspan='1'>32</td>
				<td rowspan='1' colspan='1'>19</td>
				<td rowspan='1' colspan='1'>14</td>
			</tr>
				
			<!-- 2 -->	
			<tr>				
				<td rowspan='1' colspan='1'>1</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>32</td>
				<td rowspan='1' colspan='1'>37</td>
				<td rowspan='1' colspan='1'>34</td>
				<td rowspan='1' colspan='1'>27</td>
			</tr>
			
			<!-- 3 -->	
			<tr>				
				<td rowspan='1' colspan='1'>2</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>44</td>
				<td rowspan='1' colspan='1'>34</td>
				<td rowspan='1' colspan='1'>35</td>
				<td rowspan='1' colspan='1'>25</td>
			</tr>
			
			<!-- 4 -->	
			<tr>				
				<td rowspan='1' colspan='1'>3</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>40</td>
				<td rowspan='1' colspan='1'>55</td>
				<td rowspan='1' colspan='1'>27</td>
				<td rowspan='1' colspan='1'>31</td>
			</tr>
			
			<!-- 5 -->	
			<tr>				
				<td rowspan='1' colspan='1'>4</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>46</td>
				<td rowspan='1' colspan='1'>27</td>
				<td rowspan='1' colspan='1'>36</td>
				<td rowspan='1' colspan='1'>28</td>
			</tr>
			
			<!-- 6 -->	
			<tr>				
				<td rowspan='1' colspan='1'>5</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>62</td>
				<td rowspan='1' colspan='1'>76</td>
			</tr>
			
			<!-- 7 -->	
			<tr>				
				<td rowspan='1' colspan='1'>6</td>
				<td rowspan='1' colspan='1'>74</td>
				<td rowspan='1' colspan='1'>88</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 8 -->	
			<tr>				
				<td rowspan='1' colspan='1'>7</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 9 -->	
			<tr>				
				<td rowspan='1' colspan='1'>8</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 10 -->	
			<tr>				
				<td rowspan='1' colspan='1'>9</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 11 -->	
			<tr>				
				<td rowspan='1' colspan='1'>10</td>
				<td rowspan='1' colspan='1'>38</td>
				<td rowspan='1' colspan='1'>56</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 12 -->	
			<tr>				
				<td rowspan='1' colspan='1'>11</td>
				<td rowspan='1' colspan='1'>52</td>
				<td rowspan='1' colspan='1'>53</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 13 -->	
			<tr>				
				<td rowspan='1' colspan='1'>12</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'>36</td>
				<td rowspan='1' colspan='1'>32</td>
				<td rowspan='1' colspan='1'>19</td>
				<td rowspan='1' colspan='1'>14</td>
			</tr>
			
			<!-- 14 -->	
			<tr>				
				<td rowspan='1' colspan='1'>13</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 15 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Programas de foramci&oacute;n</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 16 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Modelos flexibles</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 17 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Escuela nueva</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 18 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Aceleraci&oacute;n del aprendizaje</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 19 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Posprimaria</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 20 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Telesecundaria</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 21 -->	
			<tr>				
				<td rowspan='1' colspan='1'>Cafam</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 22 -->	
			<tr>				
				<td rowspan='1' colspan='1'>MEMA</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 23 -->	
			<tr>				
				<td rowspan='1' colspan='1'>SER</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 24 -->	
			<tr>				
				<td rowspan='1' colspan='1'>SAT</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 25 -->	
			<tr>				
				<td rowspan='7' colspan='1'>1.1 Poblaciones: # de Estudiantes</td>
				<td rowspan='1' colspan='1'>Desmovilizados</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 26 -->	
			<tr>
				<td rowspan='1' colspan='1'>Desvinculados</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 27 -->	
			<tr>
				<td rowspan='1' colspan='1'>Hijos de desmovilizados</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 28 -->	
			<tr>
				<td rowspan='1' colspan='1'>Hijos de desplazados</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 29 -->	
			<tr>
				<td rowspan='1' colspan='1'>Afrodescendientes</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 30 -->	
			<tr>
				<td rowspan='1' colspan='1'>Etnias</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 31 -->	
			<tr>
				<td rowspan='1' colspan='1'>NEE</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 32 -->	
			<tr>
				<td rowspan='4' colspan='1'>2. Eficiencia interna: tasas</td>
				<td rowspan='1' colspan='1'>Aprobaci&oacute;n</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 33 -->	
			<tr>
				<td rowspan='1' colspan='1'>Deserci&oacute;n</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 34 -->	
			<tr>
				<td rowspan='1' colspan='1'>Promoci&oacute;n</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 35 -->	
			<tr>
				<td rowspan='1' colspan='1'>Reprobaci&oacute;n</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
			
			<!-- 36 -->	
			<tr>
				<td rowspan='4' colspan='1'>Permanencia</td>
				<td rowspan='4' colspan='1'>3. Servicios Complementarios: Porcentaje de estudiantes beneficiados</td>
				<td rowspan='1' colspan='1'>Transporte</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 37 -->	
			<tr>
				<td rowspan='1' colspan='1'>Alimentaci&oacute;n</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 38 -->	
			<tr>
				<td rowspan='1' colspan='1'>Uniformes</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			<!-- 39 -->	
			<tr>
				<td rowspan='1' colspan='1'>Otros</td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
				<td rowspan='1' colspan='1'></td>
			</tr>
				
			
			<tfoot>
				<tr>				
					<td rowspan='1' colspan='9'>Observaciones</td>
				</tr>
				<tr>				
					<td rowspan='1' colspan='9'><textarea style='width:100%'></textarea></td>
				</tr>
			</tfoot>
			
		</tbody>
	</table>
    
</div>
