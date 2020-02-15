<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['nombres']?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
					['label' => 'Inicio', 'options' => ['class' => 'header']],
					//menu mcee
					[
                                
                                        'label' => 'Hoja de Vida',
                                        'icon' => 'building-o',
                                        'url' => '#',
                                        'items' => 
										[
                                            [
												'label' => 'Información General',
												'icon' => 'folder',
												'url' => '#',
												'items' => 
												[
														
														['label' => 'Instituciones','icon' => 'circle-o','url' => ['instituciones/index'],],
														['label' => 'Documentos Institucionales','icon' => 'circle-o','url' => ['documentos-instancias-institucionales/index'],],
														['label' => 'Documentos Oficiales','icon' => 'circle-o','url' => ['documentos-oficiales/index'],],
														['label' => 'Sedes','icon' => 'circle-o','url' => ['sedes/index'],],
														['label' => 'Aulas','icon' => 'circle-o','url' => ['aulas/index'],],
														['label' => 'Jornadas','icon' => 'circle-o','url' => ['jornadas/index'],],
														['label' => 'Sedes - Jornadas','icon' => 'circle-o','url' => ['sedes-jornadas/index'],],
														['label' => 'Sedes - Niveles','icon' => 'circle-o','url' => ['sedes-niveles/index'],],
														['label' => 'Periodos','icon' => 'circle-o','url' => ['periodos/index'],],
														['label' => 'Asignaturas','icon' => 'circle-o','url' =>  ['asignaturas/index'],],
														['label' => 'Especialidades','icon' => 'circle-o','url' => ['sedes-areas-ensenanza/index'],],
														['label' => 'Niveles','icon' => 'circle-o','url' => ['niveles/index'],],
														['label' => 'Bloques por sede','icon' => 'circle-o','url' => ['sedes-bloques/index'],],
														['label' => 'Grupos por nivel','icon' => 'circle-o','url' => ['paralelos/index'],],
														['label' => 'Distribución académica', 'icon' => '', 'url' => ['distribuciones-academicas/index'],],
														['label' => 'Asignatura niveles', 'icon' => '', 'url' => ['asignaturas-niveles-sedes/index'],],
														['label' => 'Director de grupo', 'icon' => '', 'url' => ['director-paralelo/index'],],
														['label' => 'Carga Masiva', 'icon' => '', 'url' => ['poblar-tabla/index'],],
														
														['label' => 'Matricular Estudiante', 'icon' => 'circle-o', 'url' => ['estudiantes/index'],],
														['label' => 'Resultados','icon' => 'circle-o','url' => '#',],
														['label' => 'Infraestructura Educativa','icon' => 'circle-o','url' => ['infraestructura-educativa/index'],],
														['label' => 'Rangos calificación','icon' => 'circle-o','url' => ['rangos-calificacion/index'],],
														['label' => 'Ponderación resultados','icon' => 'circle-o','url' => ['ponderacion-resultados/index'],],
														['label' => 'Estadisticas','icon' => 'circle-o','url' => '#',],
														['label' => 'Reportes', 'icon' => '', 'url' =>  ['reportes/index'],],
														['label' => 'Recursos', 
														'icon' => 'circle-o',
														'url' => '#',
														'items' => [
																		 ['label' => 'Humanos', 'icon' => '', 'url' =>  ['perfiles-personas-institucion/index'],],
																		 ['label' => 'Infraestructra física', 'icon' => 'circle-o', 'url' => ['recursos-infraestructura-fisica/index'],],
																		 ['label' => 'Infraestructra pedagógica', 'icon' => 'circle-o', 'url' => ['recurso-infraestructura-pedagogica/index'],],
																		
																	],
														
														],
														['label' => 'Cobertura', 'icon' => '', 'url' =>  ['cobertura/index'],],
														['label' => 'Soporte Académico', 'icon' => '', 'url' =>  ['grupos-soporte/index'],],
														['label' => 'Apoyo Académico', 'icon' => '', 'url' =>  ['apoyo-academico/index'],],
														['label' => 'Docentes-Institución', 'icon' => '', 'url' =>  ['docente-institucion/index'],],
														['label' => 'Sanciones', 'icon' => '', 'url' =>  ['sanciones-estudiantes/index'],],
														
														['label' => 'Resultados', 
														'icon' => 'circle-o',
														'url' => '#',
														'items' => [
																		['label' => 'Institución', 'icon' => '', 'url' =>  ['resultados-pruebas-saber-ie/index'],],
																		['label' => 'Cali', 'icon' => '', 'url' =>  ['resultados-pruebas-saber-cali/index'],],
																		['label' => 'PMI', 'icon' => '', 'url' =>  ['pmi/index'],],
																		['label' => 'Sem', 'icon' => '', 'url' =>  ['resultados-sem/index'],],
																		['label' => 'Evaluación Docente', 'icon' => '', 'url' =>  ['resultados-evaluacion/index'],],
																		['label' => 'Pruebas externas', 'icon' => '', 'url' =>  ['resultados-pruebas-externas/index'],],
																		['label' => 'Resultados', 'icon' => '', 'url' =>  ['resultados/index'],],
																		
																	],
														
														],
														['label' => 'Investigación', 
														'icon' => 'circle-o',
														'url' => '#',
														'items' => [
																		['label' => 'Proyectos transversales', 'icon' => '', 'url' =>  ['proyectos-pedagogicos-transversales/index'],],
																		['label' => 'Convocatorias', 'icon' => '', 'url' =>  ['convocatorias/index'],],
																		['label' => 'Proyecto aula', 'icon' => '', 'url' =>  ['proyecto-aula/index'],],
																	],
														
														],
												],//
											],
											[
												'label' => 'Gestión Directiva',
												'icon' => 'sitemap',
												'url' => '#',
													['label' => 'Documentos Institucionales', 'icon' => 'circle-o', 'url' => '#',],
													['label' => 'Instancias', 'icon' => 'circle-o', 'url' => '#',],
													['label' => 'Proyectos',
													'icon' => 'circle-o',
													'url' => '#',
														'items' => [
															['label' => 'Por institución', 'icon' => 'circle-o', 'url' => ['participacion-proyectos-i-e/index'],],
															['label' => 'Por maestro o directivo', 'icon' => 'circle-o', 'url' => ['participacion-proyectos-maestro/index'],],
															['label' => 'Proyectos jornada complementaria', 'icon' => 'circle-o', 'url' => ['participacion-proyectos-jornada/index'],],
															],
													],
											],
											[
												'label' => 'Gestión Académica',
												'icon' => 'mortar-board',
												'url' => '#',
												 'items' => [
													
													['label' => 'Curriculum de la IEO','icon' => 'circle-o','url' => ['instituciones/index'],],
													['label' => 'Jornada Escolar','icon' => 'circle-o','url' => ['documentos-instancias-institucionales/index'],],
													['label' => 'Materiales Educativos','icon' => 'circle-o','url' => ['documentos-oficiales/index'],],
													['label' => 'Seguimiento Egresados','icon' => 'circle-o','url' => ['sedes/index'],],
														
														
												],//
											],
											[
												'label' => 'Gestión Administrativa',
												'icon' => 'institution',
												'url' => '#',
												'items' => [
													['label' => 'Matrícula', 'icon' => 'circle-o', 'url' => '#'],
													['label' => 'Talento Humano', 'icon' => 'circle-o', 'url' => '#'],
													['label' => 'Presupuesto', 'icon' => 'circle-o', 'url' => '#'],
													['label' => 'Infraestructra', 'icon' => 'circle-o', 'url' => '#'],
													['label' => 'Estrategia Adecuación', 'icon' => 'circle-o', 'url' => '#'],
													['label' => 'Seguimiento', 'icon' => 'circle-o', 'url' => '#'],
												],
											],
											['label' => 'Gestión Comunitaria',
											'icon' => 'users',
											'url' => '#',
											'items' => [
														['label' => 'Servicio Social', 'icon' => 'circle-o', 'url' => '#'],
														['label' => 'Escuela Familias', 'icon' => 'circle-o', 'url' => '#'],
														['label' => 'Comité Gestión Riesgo', 'icon' => 'circle-o', 'url' => '#'],
														['label' => 'PGIR', 'icon' => 'circle-o', 'url' => '#'],
														['label' => 'Aliados', 'icon' => 'circle-o', 'url' => '#'],
														['label' => 'Actividades Vinulación', 'icon' => 'circle-o', 'url' => '#'],
														['label' => 'Relaciones Sector', 'icon' => 'circle-o', 'url' => '#'],
														
														],
											],
                                        ],// Hoja de vida
                                   
                    ],
					['label' => 'GERMAN', 
									'icon' => 'book',
									'url' => '#',
									'items' => [
													['label' => 'Mejoramiento Aprendizajes', 
													'icon' => 'arrow-right', 
													'url' => '#',
													'items' => [
														['label' => 'Semilleros tic', 
														'icon' => 'circle-o', 
														'url' => '#',
														'items' => [
																['label' => 'Población estudiantes', 'icon' => 'circle-o', 'url' => ['instrumento-poblacion-estudiantes/create'],],
																['label' => 'Población docentes', 'icon' => 'circle-o', 'url' => ['instrumento-poblacion-docentes/create'],],
																['label' => 'Estudiantes operativo', 'icon' => 'circle-o', 'url' => ['estudiantes-operativo/create'],],
														
														],
													],
														['label' => 'Práctica Aula', 'icon' => 'circle-o', 'url' => '#',],
														['label' => 'Formación', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Acuerdos curriculares', 'icon' => 'circle-o', 'url' => '#',],
														[
														'label' => 'Gestión Curricular',
														'icon' => 'circle-o',
														'url' => '#',
														'items' => [
															['label' => 'Bitácora Visitas', 'icon' => 'circle-o', 'url' => ['gestion-curricular-bitacoras-visitas-ieo/index'],],
															['label' => 'Evaluación docente tutor', 'icon' => 'circle-o', 'url' => ['dimension-opciones-seguimiento-docente/index'],],
															['label' =>' Autoevaluación docente tutor', 'icon' => 'circle-o', 'url' => ['dimension-opciones-autoevaluacion-docentes/index'],],
															['label' => 'Instrumento seguimiento', 'icon' => 'circle-o', 'url' => ['dimension-opciones-instrumento-seguimiento/index'],],
															['label' => 'Seguimiento Directivos', 'icon' => 'circle-o', 'url' => ['dimension-opciones-seguimiento-directivos/index'],],
														
														],
													],
														],
													],
													['label' => 'Pedagogías para la Vida', 
													'icon' => 'arrow-right', 
													'url' => '#',
													'items' => [
														['label' => 'PPT', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Articulación Familiar', 'icon' => 'circle-o','url' => '#',],
														['label' => 'PSSE', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Competencias Básicas', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Iniciación Deportiva', 'icon' => 'circle-o','url' => '#',],
														
														],
													],
													['label' => 'E + C', 
													'icon' => 'arrow-right', 
													'url' => '#',
													'items' => [
														['label' => 'Articulación Familiar', 'icon' => 'circle-o','url' => '#',],
														['label' => 'ASSC', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Semilleros para Paz', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Vinculo C+E', 'icon' => 'circle-o','url' => '#',],
														['label' => 'Competencias Lúdicas', 'icon' => 'circle-o','url' => '#',],
														
														],
													],
													
												],
					],
					['label' => 'Poblaciones',
						'icon' => 'user-circle',
						'url' => '#',
						'items' => [
										[
											'label' => 'Personas',
											'icon' => 'user-circle-o',
											'url' => '#',
											'items' => [
												['label' => 'Datos generales', 'icon' => 'circle-o', 'url' => ['personas/index'],],
												['label' => 'Formaciones', 'icon' => 'circle-o', 'url' => ['personas-formaciones/index'],],
												['label' => 'Discapacidades', 'icon' => 'circle-o', 'url' => ['personas-discapacidades/index'],],
												['label' => 'Escolaridades', 'icon' => 'circle-o', 'url' => ['personas-escolaridades/index'],],
												['label' => 'Reconocimientos', 'icon' => 'circle-o', 'url' => ['reconocimientos/index'],],
											],
										],
										['label' => 'Docentes', 
										'icon' => 'vcard-o',
										'url' => '#',
										 'items' => [
														['label' => 'Docentes', 'icon' => 'circle-o', 'url' => ['docentes/index'],],
														['label' => 'Docentes areas trabajo', 'icon' => 'circle-o', 'url' => ['docentes-x-areas-trabajos/index'],],
														['label' => 'Evaluación', 'icon' => 'circle-o', 'url' => ['evaluacion-docentes/index'],],
														['label' => 'Vinulación', 'icon' => 'circle-o', 'url' => ['vinculacion-docentes/index'],],
														['label' => 'Horario', 'icon' => 'circle-o', 'url' => '#',],
														['label' => 'Indicadores desempeño', 'icon' => 'circle-o', 'url' => ['indicador-desempeno/index'],],
														['label' => 'Plan de aula', 'icon' => 'circle-o', 'url' => ['plan-de-aula/index'],],
														['label' => 'Distribución-indicador', 'icon' => 'circle-o', 'url' => ['distribuciones-indicador-desempeno/index'],],
														['label' => 'Calificaciones', 'icon' => 'circle-o', 'url' => ['calificaciones/index'],],
														['label' => 'Asistencias', 'icon' => 'circle-o', 'url' => ['inasistencias/index'],],
														['label' => 'Documentos Interés', 'icon' => 'circle-o', 'url' => ['documentos/index'],],
														
														
														
													],
										],
										['label' => 'Estudiantes',
										'icon' => 'male',
										'url' => '#',
										 'items' => [
														['label' => 'Estudiantes', 'icon' => 'circle-o', 'url' => ['representantes-legales/index'],],
														['label' => 'Horario', 'icon' => 'circle-o', 'url' => ['horario-estudiante/index'],],
														['label' => 'Hoja de vida', 'icon' => 'circle-o', 'url' => ['hoja-vida-estudiante/index'],],
													],
										
										],
										
									],
						
					],
					['label' => 'Indicadores',
						'icon' => 'line-chart',
						'url' => '#',
						'items' => [
										['label' => 'Clima Escolar', 'icon' => 'thermometer-0', 'url' => ['instrumento-poblacion-estudiantes/create'],],
										['label' => 'Sistema de Monitoreo', 'icon' => 'desktop', 'url' => ['instrumento-poblacion-estudiantes/create'],],
									],
					],
									
									
                ],
            ]
        ) ?>

    </section>

</aside>
