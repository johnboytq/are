<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            @page {
                margin: 15px;
            }
            html{

                padding: 10px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }

            .info_calificacion tr,td {
                text-align: left;
                padding: 10px;
                border-bottom: 1px solid #7a7a7a;
                border-top: 1px solid #7a7a7a;
            }

            .calificacion tr,
            .calificacion td{
                text-align: left;
                padding: 8px;
                border: 1.5px solid black;
            }
        </style>
    </head>
    <body>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title panel-title-lender">Institucion Educativa: <?= $institucion ?></h3>
                <!--<h3 class="panel-title panel-title-lender">Sede:</h3>-->
            </div>
            <div class="table-responsive">
                <table class="table table-striped info_calificacion">
                    <thead>
                    <tr>
                        <th colspan = 3 >Estudiante: <span><?= $estudiante ?></span></th>
                        <th>Grupo: <span><?= $paralelo ?></span></th>
                    </tr>
                    <tr>
                        <th colspan = 3 >Dir Grupo: <span><?= $docente ?></span></th>
                        <th>Fecha: <span><?= $hoy = date("d-m-Y");  ?></span></th>
                    </tr>
                    <tr>
                        <th colspan = 3 >Calificación</th>
                        <th>Val- Desempeño</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($asignaturas AS $key => $asignaturas): ?>
                        <?php $nombreM = \app\models\Asignaturas::findOne($asignaturas->id_asignatura); ?>
                        <?php $periodo = \app\models\Periodos::findOne($asignaturas["id_periodo"]); ?>
                        <tr>
                            <td>
                                <?= $nombreM->descripcion.' '.$periodo->descripcion ?>
                                <br>
                                Doncente de asignatura: <?= $docente ?>

                            </td>
                            <td><!--FA: 2 -- IHS: 4 -- 3.0 - Basico--></td>
                        </tr>
                        <?php //if( empty( $observacion_calificacion[$nombreM->descripcion] ) ) continue; ?>
                        <tr>
                            <td colspan = 3>Saber Conocer</td>
                            <td><?= $observacion_calificacion[$nombreM->descripcion][$asignaturas["id_periodo"]][0]?></td>
                        </tr>
                        <tr>
                            <td colspan = 4>+ <?= $asignaturas->observacion_conocer ?></td>
                        </tr>
                        <tr>
                            <td colspan = 3>Saber Hacer</td>
                            <td><?= $observacion_calificacion[$nombreM->descripcion][$asignaturas["id_periodo"]][1]?></td>
                        </tr>
                        <tr>
                            <td colspan = 4>+ <?= $asignaturas->observacion_hacer ?></td>
                        </tr>
                        <tr>
                            <td colspan = 3>Saber Ser</td>
                            <td><?= $observacion_calificacion[$nombreM->descripcion][$asignaturas["id_periodo"]][2]?></td>
                        </tr>
                        <tr>
                            <td colspan = 4>+ <?= $asignaturas->observacion_saber ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>


                <table class="calificacion">
                    <tbody>
                    <tr>
                        <td rowspan="2">AREA / ASIGNATURA</td>
                        <td rowspan="2">IHS</td>
                        <td colspan = "2">P1</td>
                        <td colspan = "2">P2</td>
                        <td colspan = "2">P3</td>
						<td colspan = "2">P4</td>
                        <td rowspan="2">FA / RE</td>
                        <td rowspan="2">DEF</td>
                    </tr>
                    <tr>
                        <td>VAL</td>
                        <td>SUP</td>
                        <td>VAL</td>
                        <td>SUP</td>
                        <td>VAL</td>
                        <td>SUP</td>
						<td>VAL</td>
                        <td>SUP</td>
                    </tr>

                    <?php $materia = ''?>
					
                    <?php 
					$cont=0;
					$cont2 = 0;					
					$notaFinal=0;
					foreach ($materia_calificacion AS $key => $calificaciones): ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td>0</td>
                            <?php 
							
							foreach ($calificaciones AS $key_c => $calificacion):
								$cont++;
								$cont2 +=2;
							?>
                                <td><?php 
								
								$nota= substr( $calificacion['calificacion'] , 0, 4);
								$notaFinal += $nota;
								echo $nota;
								?></td>
                                <td>0</td>
                            <?php endforeach; ?>
							<?php 
								for($i = $cont2;$i <= 8;$i++)
								{
									echo "<td>0</td>";
								}
                           ?>
                            
                            
                           
                            <td><?=number_format($notaFinal/$cont, 2, '.', ',') ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </body>
</html>