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
        },
    });

    $.ajax({
        method: "get",
        url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/listproyectosuser') ?>",
        success : function(json) {
            JSON.parse(json).forEach(element => $("#proyectouser").append("<option value='"+element["idProyecto"]+"'> "+element["nombre"]+" "+element["descripcion"]+"</option>"));
        },
    });

});

function calcularnotafinal(){
    var vcorte1 = ($('#corte1').val() * ($('#materiacorte1').val()/100));
    var vcorte2 = ($('#corte2').val() * ($('#materiacorte2').val()/100));
    var vcorte3 = ($('#corte3').val() * ($('#materiacorte3').val()/100));
    $('#final').val(vcorte1+vcorte2+vcorte3);
}

function proyectoestudiante(idestudiante,proyecto,estudiante,action,anteriorproyecto){

    if (action == 0){
        $.ajax({
            method: "get",
            url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/updateproyectoestudiante') ?>",
            data: { proyecto: $("#proyecto1").val() ,
                estudiante: $("#estudiante1").val()  ,
            },
            success : function(json) {
                if (json == "ok"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Cambio de proyecto!',
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
    }
    if (action == 1){
        $("#estudiante1").children().remove();
        $("#estudiante1").append("<option value='"+idestudiante+"' selected> "+estudiante+"</option>");
        $("#proyectoafter").children().remove();
        $("#proyectoafter").append("<option value='"+anteriorproyecto+"' selected> "+anteriorproyecto+"</option>");
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
    $('#tablemodalmateriaprofe tr').each(function(index, fila) {
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
    console.log("aaaaaaaaaaaa")
    if (save){
        $.ajax({
            method: "get",
            url: "<?= Yii::$app->getUrlManager()->createUrl('materia/create') ?>",
            data: {
                id: $("#estudiantes").val(),
            },
            success: function (json) {

            },
        });
    }else{
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

}