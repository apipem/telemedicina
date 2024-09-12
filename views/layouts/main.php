<?php
use app\assets\AppAsset;

/** @var yii\web\View $this */
/** @var string $content */

AppAsset::register($this);

$session = Yii::$app->session;
if ($session->isActive && isset(Yii::$app->user->identity->id)) {
    $this->beginPage();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Otros elementos head -->
        <?php
        $randomIconUrl = 'https://favicongrabber.com/api/grab/' . urlencode('https://example.com'); // Cambia 'https://example.com' por la URL del sitio del que deseas obtener el favicon
        ?>
        <link rel="icon" type="image/x-icon" href="<?= $randomIconUrl ?>" />

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telemedicina</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->createUrl('css/all.min.css') ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->createUrl('css/adminlte.min.css') ?>">
        <!-- Bootstrap CSS -->
        <!-- Importar Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->createUrl('css/main.css') ?>">
    </head>

    <body class="">
    <?php echo $this->render("_sidebar-left") ?>
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <?php echo $this->render("_header") ?>
                </div><!-- /.container-fluid -->
            </div><!-- /.content-header -->

            <?php $this->beginBody(); ?>

            <!-- Main content -->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <?php echo $content ?>
                    </div>
                </div>
            </div>

            <?php $this->endBody(); ?>
        </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->

    <?= $this->render("_footer"); ?>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= Yii::$app->getUrlManager()->createUrl('js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= Yii::$app->getUrlManager()->createUrl('js/adminlte.min.js') ?>"></script>
    <!-- Custom Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Importar Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <script>
        $(document).ready(function(){

            $('#deletemateria').submit(function(e) {
                e.preventDefault(); // Evita que el formulario se envíe de forma predeterminada

                // Envía los datos del formulario mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: '/classroom/web/materia/create', // Ruta del controlador
                    data: $(this).serialize(), // Serializa los datos del formulario
                    success: function(response) {
                        // Si la respuesta es 'ok', muestra una alerta de éxito
                        if (response === 'ok') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado exitosamente',
                                showConfirmButton: true
                            }).then(function() {
                                // Recarga la página después de hacer clic en el botón "OK"
                                location.reload();
                            });
                        } else {
                            // Si la respuesta no es 'ok', muestra una alerta de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al guardar',
                                text: 'Ha ocurrido un error al intentar guardar los datos',
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Si hay un error en la petición AJAX, muestra una alerta de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ha ocurrido un error en la solicitud AJAX',
                            showConfirmButton: true
                        });
                    }
                });
            });

            var currentUrl = window.location.href;

            $(".nav-link").each(function() {
                var linkUrl = $(this).attr("href");
                if (currentUrl.includes(linkUrl)) {
                    $(this).addClass("active");
                    $(this).parents(".nav-item").addClass("menu-open");
                }
            });

            $('#corte1').change(function() {
                calcularnotafinal();
            });

            $('#corte2').change(function() {
                calcularnotafinal();
            });

            $('#corte3').change(function() {
                calcularnotafinal();
            });

            $('#proyectouser').change(function() {
                var valorProyecto = $(this).val();

                if (valorProyecto !== "") {
                    $('#materiasuser').val("0");
                }
            });

            $('#materiasuser').change(function() {
                var valorMateria = $(this).val();

                if (valorMateria !== "") {
                    $('#proyectouser').val("0");
                }
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listestudiantes') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#estudiantes").append("<option value='"+element["idUsuario"]+"'> "+element["nombre"]+" "+element["apellido"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listprofesores') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#profesores").append("<option value='"+element["idUsuario"]+"'> "+element["nombre"]+" "+element["apellido"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listmaterias') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#materias").append("<option value='"+element["idmateria"]+"'> "+element["nombre"]+" "+element["codigo"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listmaterias') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#materias1").append("<option value='"+element["idmateria"]+"'> "+element["nombre"]+" "+element["codigo"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listproyectos') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#proyecto").append("<option value='"+element["idProyecto"]+"'> "+element["nombre"]+" "+element["descripcion"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listproyectos') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#proyecto1").append("<option value='"+element["idProyecto"]+"'> "+element["nombre"]+" "+element["descripcion"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listmateriasuser') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#materiasuser").append("<option value='"+element["idmateria"]+"'> "+element["nombre"]+" "+element["codigo"]+"</option>"));
                    JSON.parse(json).forEach(element => $("#materiasusercreate").append("<option value='"+element["idmateria"]+"'> "+element["nombre"]+" "+element["codigo"]+"</option>"));
                    JSON.parse(json).forEach(element => $(".materiasuserupdate").append("<option value='"+element["idmateria"]+"'> "+element["nombre"]+" "+element["codigo"]+"</option>"));
                },
            });

            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listproyectosuser') ?>",
                success : function(json) {
                    JSON.parse(json).forEach(element => $("#proyectouser").append("<option value='"+element["idProyecto"]+"'> "+element["nombre"]+" "+element["descripcion"]+"</option>"));
                    JSON.parse(json).forEach(element => $("#proyectousercreate").append("<option value='"+element["idProyecto"]+"'> "+element["nombre"]+" "+element["descripcion"]+"</option>"));
                    JSON.parse(json).forEach(element => $(".proyectouserupdate").append("<option value='"+element["idProyecto"]+"'> "+element["nombre"]+" "+element["descripcion"]+"</option>"));
                },
            });

            // Evento click para el botón "Modificar"
            $('.btn-editar').click(function() {
                var contenido = $(this).closest('tr').find('td:nth-child(1)').text().trim().replace('Descargar', '').trim();
                var descripcion = $(this).closest('tr').find('td:nth-child(5)').text().trim();
                var materia = $(this).closest('tr').find('td:nth-child(3) input').val().trim();
                var proyecto = $(this).closest('tr').find('td:nth-child(2) input').val().trim();
                // Obtener el idcontenido del botón "Modificar"
                var idcontenido = $(this).closest('td').find('input[type="hidden"]').val().trim();


                $('#idcontenido1').val(idcontenido);
                $('#contenido').val(contenido);
                $('#descripcion').val(descripcion);
                $('.materiasuserupdate').val(materia);
                $('.proyectouserupdate').val(proyecto);
                $('#modalEditar').modal('show');
            });

            $('#formularioEditar').submit(function(event) {
                event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

                $.ajax({
                    method: "post",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('contenido/update') ?>",
                    data: {
                        idcontenido: $("#idcontenido1").val(),
                        descripcion: $("#descripcion").val(),
                        materia: $(".materiasuserupdate").val(),
                        proyecto: $(".proyectouserupdate").val(),
                        _csrf: $("#_csrf").val(),
                    },
                    success: function (json) {
                        if (json == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Recurso Modificado!',
                                text: 'Registro Actualizado!',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire(
                                'Oh no!',
                                'Algo salio mal!',
                                'error'
                            )
                        }
                    },
                });
            });

        });

        function calcularnotafinal(){
            var vcorte1 = ($('#corte1').val() * ($('#materiacorte1').val()/100));
            var vcorte2 = ($('#corte2').val() * ($('#materiacorte2').val()/100));
            var vcorte3 = ($('#corte3').val() * ($('#materiacorte3').val()/100));
            $('#final').val(vcorte1+vcorte2+vcorte3);
        }

        function proyectoestudiante(idestudiante, proyecto, estudiante, action, anteriorproyecto) {
            $(".estudiante").children().remove();
            $(".proyecto").children().remove();
            $(".estudiante").append("<option value='" + $("#estudiantes option:selected").text() + "' selected> " + $("#estudiantes option:selected").text() + "</option>");
            $(".proyecto").append("<option value='" + $("#proyecto option:selected").text() + "' selected> " + $("#proyecto option:selected").text() + "</option>");

            console.log(idestudiante);
            console.log(proyecto);
            console.log(estudiante);
            console.log(action);
            console.log(anteriorproyecto);

            if (action == 0) {
                $.ajax({
                    method: "POST",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/updateproyectoestudiante') ?>",
                    data: {
                        idproyecto: $("#proyecto1").val(),
                        idestudiante: $("#idestudianteante").val(),
                        _csrf: $("#_csrf").val(),
                    },
                    success: function(json) {
                        if (json == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cambio de proyecto!',
                                text: 'Registro Actualizado!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire(
                                'Oh no!',
                                'Algo salió mal!',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al realizar la solicitud.',
                            'error'
                        );
                    }
                });
            }
            if (action == 1) {
                $(".estudiante").children().remove();
                $(".estudiante").append("<option value='" + idestudiante + "' selected> " + estudiante + "</option>");
                $(".proyecto").children().remove();
                $(".proyecto").append("<option value='" + anteriorproyecto + "' selected> " + anteriorproyecto + "</option>");
                $("#idestudianteante").val(idestudiante);
            }
        }

        function preupdatenotas(data,update){
            if (update){
                $.ajax({
                    method: "get",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/registronotas') ?>",
                    data: { proyectonotas: $("#proyectonotas").val() ,
                        materiasnotas: $("#materiasnotas").val()  ,
                        estudiantenotas: $("#estudiantenotas").val()  ,
                        corte1: $("#corte1").val()  ,
                        corte2: $("#corte2").val()  ,
                        corte3: $("#corte3").val()  ,
                        final: $("#final").val()  ,
                        idnotas: $("#idnotas").val()  ,
                        idcurso: $("#idcurso").val()  ,
                    },
                    success : function(json) {
                        if (json == "ok"){
                            Swal.fire({
                                icon: 'success',
                                title: 'notas Actualizadas!',
                                text: 'Registro Actualizado!',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }else{
                            Swal.fire(
                                'Oh no!',
                                'Algo salio mal!',
                                'error'
                            )
                        }
                    },
                });
            }else{
                $.ajax({
                    method: "get",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('notas/cargueupdate') ?>",
                    data: { data: data ,
                    },
                    success : function(json) {
                        json = JSON.parse(json);
                        $("#proyectonotas").children().remove();
                        $("#materiasnotas").children().remove();
                        $("#estudiantenotas").children().remove();
                        $("#proyectonotas").append("<option value='"+json[0]["nombre_proyecto"]+"'> "+json[0]["nombre_proyecto"]+"</option>");
                        $("#materiasnotas").append("<option value='"+json[0]["nombre_materia"]+"'> "+json[0]["nombre_materia"]+"</option>");
                        $("#estudiantenotas").append("<option value='"+json[0]["nombre_estudiante"]+"'> "+json[0]["nombre_estudiante"]+"</option>");
                        $("#corte1").val(json[0]["corte1"]) ;
                        $("#corte2").val(json[0]["corte2"]);
                        $("#corte3").val(json[0]["corte3"]);
                        $("#materiacorte1").val(json[0]["vcorte1"]) ;
                        $("#materiacorte2").val(json[0]["vcorte2"]);
                        $("#materiacorte3").val(json[0]["vcorte3"]);
                        $("#final").val(json[0]["nota"]);
                        $("#idcurso").val(json[0]["idcurso"]);
                        $("#idnotas").val(json[0]["idnotas"]);
                    },
                });
            }
        }

        function enviargrupos(){
            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/registro') ?>",
                data: { estudiante: $("#estudiantes").val() ,
                    profesor: $("#profesores").val()  ,
                    materia: $("#materias").val()  ,
                    proyecto: $("#proyecto").val()  ,
                },
                success : function(json) {
                    if (json == "ok"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Inscrito!',
                            text: 'Registro completo!',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }else{
                        Swal.fire(
                            'Oh no!',
                            'Algo salio mal!',
                            'error'
                        )
                    }
                },
            });
        }

        function materiaprofesor() {
            $("#tablemodalmaterias").children(0).remove();
            var materias = $("#materias").val();

            $(".estudiante").children().remove();
            $(".proyecto").children().remove();
            $(".estudiante").append("<option value='"+$("#estudiantes option:selected").text()+"' selected> "+$("#estudiantes option:selected").text()+"</option>");
            $(".proyecto").append("<option value='"+$("#proyecto option:selected").text()+"' selected> "+$("#proyecto option:selected").text()+"</option>");

            if (Array.isArray(materias)) {
                materias.forEach(function (materia, indice) {
                    if (materia != "Selecciona las Materias") {
                        $.ajax({
                            method: "get",
                            url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listprofesoreselect') ?>",
                            data: {
                            },
                            success: function (html) {
                                $.ajax({
                                    method: "get",
                                    url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/materiaid') ?>",
                                    data: {
                                        id: materia,
                                    },
                                    success: function (json) {
                                        var a = JSON.parse(json);
                                        $("#tablemodalmaterias").append("<tr><td><input class='valmateria' hidden value='" + materia + "' id='materiaid" + indice + "'>" + a[0]["nombre"] + " </td><td>"+html+" </td></tr>");
                                    },
                                });
                            },
                        });
                    }
                });
            }
        }

        function sendata() {

            var matprof = [];
            $('#tablemodalmaterias tr').each(function(index, fila) {
                // Obtener el valor seleccionado del select en la segunda columna
                var valorSelect = $(fila).find('td:eq(1) select').val();
                var valorInput = $(fila).find('.valmateria').val();
                var parValores = [valorSelect, valorInput];
                matprof.push(parValores);
            });
            $.ajax({
                method: "get",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/materiaprofe') ?>",
                data: {
                    estudiante: $("#estudiantes").val(),
                    matprof: matprof,
                    proyecto: $("#proyecto").val(),
                },
                success: function (json) {
                    if (json == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Inscrito!',
                            text: 'Registro completo!',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'Oh no!',
                            'Algo salio mal!',
                            'error'
                        )
                    }
                },
            });
        }

        function materiasave(id,save) {
            if (save){
                $.ajax({
                    method: "get",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('materia/create') ?>",
                    data: {
                        id: id,
                    },
                    success: function (json) {
                        var data = JSON.parse(json);

                        $("#materia-0").val(data.idmateria);
                        $("#materia-1").val(data.nombre);
                        $("#materia-2").val(data.codigo);
                        $("#materia-3").val(data.vcorte1);
                        $("#materia-4").val(data.vcorte2);
                        $("#materia-5").val(data.vcorte3);
                    },
                });
            }else{
                $.ajax({
                    method: "POST",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('materia/create') ?>",
                    data: {
                        id: $("#materia-0").val(),
                        nombre: $("#materia-1").val(),
                        codigo: $("#materia-2").val(),
                        vcorte1: $("#materia-3").val(),
                        vcorte2: $("#materia-4").val(),
                        vcorte3: $("#materia-5").val(),
                        _csrf: $("#token").val(),
                    },
                    success: function (json) {
                        if (json == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Materia Actualizada!',
                                text: 'Registro completo!',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire(
                                'Oh no!',
                                'Algo salio mal!',
                                'error'
                            )
                        }
                    },
                });
            }

        }

        function materiaguardar() {
            $.ajax({
                method: "POST",
                url: "<?= Yii::$app->getUrlManager()->createUrl('materia/create') ?>",
                data: {
                    nombre: $("#materia-nombre").val(),
                    codigo: $("#materia-codigo").val(),
                    vcorte1: $("#materia-vcorte1").val(),
                    vcorte2: $("#materia-vcorte2").val(),
                    vcorte3: $("#materia-vcorte3").val(),
                    _csrf: $("#token").val(),
                },
                success: function (json) {
                    if (json == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Materia Registrada!',
                            text: 'Registro completo!',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'Oh no!',
                            'Algo salio mal!',
                            'error'
                        )
                    }
                },
            });
        }

        function proyectosave() {
            $.ajax({
                method: "POST",
                url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/proyecto') ?>",
                data: {
                    nombre: $("#nombre").val(),
                    descripcion: $("#descripcion").val(),
                    finicio: $("#finicio").val(),
                    ffin: $("#ffin").val(),
                    _csrf: $("#token").val(),
                },
                success: function (json) {
                    if (json == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Proyecto Registrado!',
                            text: 'Registro completo!',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    } else {
                        Swal.fire(
                            'Oh no!',
                            'Algo salio mal!',
                            'error'
                        )
                    }
                },
            });
        }

        function proyectoguardar(id,save) {
            if (save){
                $.ajax({
                    method: "get",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('proyecto/edicion') ?>",
                    data: {
                        id: id,
                    },
                    success: function (json) {
                        var data = JSON.parse(json);

                        $("#idproyecto1").val(data.idProyecto);
                        $("#nombre1").val(data.nombre);
                        $("#descripcion1").val(data.descripcion);
                        $("#finicio1").val(data.fechaIncio);
                        $("#ffin1").val(data.fechaFin);
                    },
                });

            }else{
                $.ajax({
                    method: "POST",
                    url: "<?= Yii::$app->getUrlManager()->createUrl('proyecto/edicion') ?>",
                    data: {
                        idproyecto1: $("#idproyecto1").val(),
                        nombre: $("#nombre1").val(),
                        descripcion: $("#descripcion1").val(),
                        finicio: $("#finicio1").val(),
                        ffin: $("#ffin1").val(),
                        _csrf: $("#token").val(),
                    },
                    success: function (json) {
                        if (json == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Proyecto Actualizado!',
                                text: 'Registro completo!',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire(
                                'Oh no!',
                                'Algo salio mal!',
                                'error'
                            )
                        }
                    },
                });
            }

        }
    </script>
    </html>

    <?php
    $this->endPage();
} else {
    $this->beginPage();
    ?>

    <?php $this->beginBody(); ?>
    <?php echo $this->render("index"); ?>
    <?php $this->endPage(); } ?>
