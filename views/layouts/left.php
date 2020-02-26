<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['nombres']; ?></p>

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
				    [
                                'label' => 'Instituciones',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    [
                                        'label' => 'Académico',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Institución educativa',
											'icon' => 'circle-o',
											'url' => '#',
											'items' => [
												['label' => 'Matricular Estudiante', 'icon' => 'circle-o', 'url' => ['estudiantes/index'],],
												['label' => 'Pruebas saber','icon' => 'circle-o','url' => '#',],
												['label' => 'Infraestructura Educativa','icon' => 'circle-o','url' => [ 'infraestructura-educativa/index'],],
												['label' => 'Rangos calificación','icon' => 'circle-o','url' => ['rangos-calificacion/index'],],
												['label' => 'Ponderación resultados','icon' => 'circle-o','url' => ['ponderacion-resultados/index'],],
												['label' => 'Estadisticas','icon' => 'circle-o','url' => '#',],
												['label' => 'Reportes', 'icon' => '', 'url' =>  ['reportes/index'],],
												['label' => 'Recursos', 
												'icon' => 'circle-o',
												'url' => '#',
												'items' => [
																 ['label' => 'Infraestructra física', 'icon' => 'circle-o', 'url' => ['recursos-infraestructura-fisica/index'],],
																 ['label' => 'Infraestructra pedagógica', 'icon' => 'circle-o', 'url' => ['recurso-infraestructura-pedagogica/index'],],
																
															],
												
												],
												['label' => 'Cobertura', 'icon' => '', 'url' =>  ['cobertura/index'],],
												['label' => 'Persona-Institución', 'icon' => '', 'url' =>  ['perfiles-personas-institucion/index'],],
												['label' => 'Docentes-Institución', 'icon' => '', 'url' =>  ['docente-institucion/index'],],
												['label' => 'Sanciones', 'icon' => '', 'url' =>  ['sanciones-estudiantes/index'],],
												['label' => 'Investigación', 
												'icon' => 'circle-o',
												'url' => '#',
												'items' => [
																['label' => 'Convocatorias', 'icon' => '', 'url' =>  ['convocatorias/index'],],
																['label' => 'Proyectos-aula', 'icon' => '', 'url' =>  ['proyecto-aula/index'],],
																['label' => 'Proyectos-pedagagógicos', 'icon' => '', 'url' =>  ['proyectos-pedagogicos-transversales/index'],],
																
															],
												
												],
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
																['label' => 'Proyectos tansversales', 'icon' => '', 'url' =>  ['proyectos-pedagogicos-transversales/index'],],
																['label' => 'Convocatorias', 'icon' => '', 'url' =>  ['convocatorias/index'],],
																['label' => 'Proyecto aula', 'icon' => '', 'url' =>  ['proyecto-aula/index'],],
															],
												
												],
												
												
											],						
											
											
											], // 
                                        ],//
                                    ],
									 [
                                        'label' => 'Servicios',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Transporte', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Alimentación', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Soporte Académico', 'icon' => '', 'url' =>  ['grupos-soporte/index'],],
                                            ['label' => 'Participantes', 'icon' => '', 'url' =>  ['participantes-grupos-soporte/index'],],
											['label' => 'Apoyo Académico', 'icon' => '', 'url' =>  ['apoyo-academico/index'],],
                                        ],
                                    ],
									[
                                        'label' => 'Administrativo',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                         'items' => [
                                            ['label' => 'Institución educativa',
											'icon' => 'circle-o',
											'url' => '',
											'items' => [
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
												['label' => 'Áreas enseñanza','icon' => 'circle-o','url' => ['sedes-areas-ensenanza/index'],],
												['label' => 'Niveles','icon' => 'circle-o','url' => ['niveles/index'],],
												['label' => 'Bloques por sede','icon' => 'circle-o','url' => ['sedes-bloques/index'],],
												['label' => 'Grupos por nivel','icon' => 'circle-o','url' => ['paralelos/index'],],
												['label' => 'Distribución académica', 'icon' => '', 'url' => ['distribuciones-academicas/index'],],
												['label' => 'Asignatura niveles', 'icon' => '', 'url' => ['asignaturas-niveles-sedes/index'],],
										        ['label' => 'Director de grupo', 'icon' => '', 'url' => ['director-paralelo/index'],],
										        ['label' => 'Carga Masiva', 'icon' => '', 'url' => ['poblar-tabla/index'],],
												// ['label' => 'Docente de grupo', 'icon' => '', 'url' => '#',], //esta en la distribucion academica
												
													
												
											],						
											
											
											], // 
                                        ],//
                                    ],
									[
                                        'label' => 'Participación en proyectos',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Por institución', 'icon' => 'circle-o', 'url' => ['participacion-proyectos-i-e/index'],],
                                            ['label' => 'Por maestro o directivo', 'icon' => 'circle-o', 'url' => ['participacion-proyectos-maestro/index'],],
                                            ['label' => 'Proyectos jornada compleentaria', 'icon' => 'circle-o', 'url' => ['participacion-proyectos-jornada/index'],],
                                        ],
                                    ],
                                ],
                            ],
							

                   [
						'label' => 'Personas',
						'icon' => 'circle-o',
						'url' => '#',
						'items' => [
							[
                                        'label' => 'Personas',
                                        'icon' => 'circle-o',
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
							'icon' => 'circle-o',
							'url' => '#',
							 'items' => [
                                            ['label' => 'Docentes', 'icon' => 'circle-o', 'url' => ['docentes/index'],],
                                            ['label' => 'Docentes areas trabajo', 'icon' => 'circle-o', 'url' => ['docentes-x-areas-trabajos/index'],],
											['label' => 'Evaluación', 'icon' => 'circle-o', 'url' => ['evaluacion-docentes/index'],],
											['label' => 'Vinculación', 'icon' => 'circle-o', 'url' => ['vinculacion-docentes/index'],],
											['label' => 'Horario', 'icon' => 'circle-o', 'url' => ['horario-docente/index'],],
											['label' => 'Indicadores desempeño', 'icon' => 'circle-o', 'url' => ['indicador-desempeno/index'],],
											['label' => 'Plan de aula', 'icon' => 'circle-o', 'url' => ['plan-de-aula/index'],],
											['label' => 'Distribución-indicador', 'icon' => 'circle-o', 'url' => ['distribuciones-indicador-desempeno/index'],],
											['label' => 'Calificaciones', 'icon' => 'circle-o', 'url' => ['calificaciones/index'],],
											['label' => 'Asistencias', 'icon' => 'circle-o', 'url' => ['inasistencias/index'],],
											['label' => 'Listado Estudiantes', 'icon' => 'circle-o', 'url' => ['listar-estudiantes/index'],],
											['label' => 'Documentos Interés', 'icon' => 'circle-o', 'url' => ['documentos/index'],],
                                            
                                            
                                            
                                            
                                        ],
							],
							
							
							['label' => 'Estudiantes',
							'icon' => 'circle-o',
							'url' => '#',
							 'items' => [
                                            ['label' => 'Estudiantes', 'icon' => 'circle-o', 'url' => ['representantes-legales/index'],],
											['label' => 'Horario', 'icon' => 'circle-o', 'url' => ['horario-estudiante/index'],],
											//['label' => 'Hoja de vida', 'icon' => 'circle-o', 'url' => ['hoja-vida-estudiante/index'],],
                                        ],
							
							],
						],
					],
					
					
					
                    // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                        // 'label' => 'Some tools',
                        // 'icon' => 'share',
                        // 'url' => '#',
                        // 'items' => [
                            // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            // [
                                // 'label' => 'Level One',
                                // 'icon' => 'circle-o',
                                // 'url' => '#',
                                // 'items' => [
                                    // ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    // [
                                        // 'label' => 'Level Two',
                                        // 'icon' => 'circle-o',
                                        // 'url' => '#',
                                        // 'items' => [
                                            // ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            // ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        // ],
                                    // ],
                                // ],
                            // ],
                        // ],
                    // ],
                ],
            ]
        ) ?>

    </section>

</aside>
