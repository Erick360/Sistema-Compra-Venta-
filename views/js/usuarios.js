var tabla;
  //esta funcion se ejecuta al inicio
  function init(){
    listar();
    $("#usuario_form").on("submit", function(e){
      guardaryeditar(e);
    })

    $("#add_button").click(function(){
      $(".modal-title").text("Agregar Usuario");
    });
  }

  function limpiar(){
    $("#cedula").val("");
    $("#nombre").val("");
    $("#apellido").val("");
    $("#cargo").val("");
    $("#usuario").val("");
    $("#password").val("");
    $("#password2").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#direccion").val("");
    $("#estado").val("");
    $("#id_usuario").val("");
  }

  function listar(){
    tabla = $("#usuario_data").dataTable({
        "aProcessing" : true,//Activamos el procesamiento del dataTables
        "aServerSide" : true,//Paginacion y filtrado Realizados por el servidor
        dom: "Bfrtip",//Definimos los elementos del control de tabla
    buttons : [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdf'
    ],

    "ajax" : {
      url : '../ajax/usuario.php?op=listar',
      type : "get",
      dataType : "json",
      error : function(e){
        console.log(e.responseText);
      }
    },

    "bDestroy" : true,
    "responsive" : true,
    "bInfo" : true,
    "iDisplayLength" : 10,//Por cada 10 registros se hace una Paginacion
    "order" : [[0, "desc" ]],//Ordena (columna , orden )


	    "language": {
			    "sProcessing":     "Procesando...",
			    "sLengthMenu":     "Mostrar _MENU_ registros",
			    "sZeroRecords":    "No se encontraron resultados",
			    "sEmptyTable":     "Ningún dato disponible en esta tabla",
			    "sInfo":           "Mostrando un total de _TOTAL_ registros",
			    "sInfoEmpty":      "Mostrando un total de 0 registros",
			    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			    "sInfoPostFix":    "",
			    "sSearch":         "Buscar:",
			    "sUrl":            "",
			    "sInfoThousands":  ",",
			    "sLoadingRecords": "Cargando...",

			    "oPaginate": {
			        "sFirst":    "Primero",
			        "sLast":     "Último",
			        "sNext":     "Siguiente",
			        "sPrevious": "Anterior"
			    },
          "oAria": {
			        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			    }
        }//Fin language
    }).DataTable();
  }

  //Mostrar datos del usuario en la ventana modal del formulario
  function mostrar(id_usuario){
        $.post("../ajax/usuario.php?op=mostrar", {id_usuario:id_usuario}, function(data , status){
          data = JSON.parse(data);
            $("#usuarioModal").modal("show");
            $("#cedula").val(data.cedula);
            $("#nombre").val(data.nombre);
            $("#apellido").val(data.apellido);
            $("#cargo").val(data.cargo);
            $("#usuario").val(data.usuario);
            $("#password").val(data.password);
            $("#password2").val(data.password2);
            $("#telefono").val(data.telefono);
            $("#email").val(data.email);
            $("#direccion").val(data.direccion);
            $("#estado").val(data.estado);
            $('.modal-title').text("Editar Usuario");
            $("#id_usuario").val(id_usuario);
            $("#action").val("Edit");
      });
  }//fin funcion Mostrar

//la funcion guardaryeditar
    function guardaryeditar(e){
      e.preventDefault();//No se activara la accion predeterminada del evento
      var formData = new FormData($("#usuario_form")[0]);
      var password = $("#password").val();
      var password2 = $("#password2").val();

      if (password == password2) {
        $.ajax({
          url : "../ajax/usuario.php?op=guardaryeditar",
          type : "POST",
          data : formData,
          contentType : false,
          processData : false,

          success : function(datos){
            console.log(datos);
            $('#usuario_form')[0].reset();
            $('#usuarioModal').modal('hide');
            $('#resultados_ajax').html(datos);
            $('#usuario_data').DataTable().ajax.reload();
            limpiar();
          }
        });
      }else {
        bootbox.alert("Las contraseñas no coinciden");
      }
    }//Fin de mi funcion guardaryeditar

    //Editar estado del usuario
    function cambiarEstado(id_usuario,est){
    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result){
  if(result)
  {
      $.ajax({
      url:"../ajax/usuario.php?op=activarydesactivar",
      method:"POST",
      data:{id_usuario:id_usuario, est:est},
      success: function(data){
          $('#usuario_data').DataTable().ajax.reload();
        }
      });
     }
   });//bootbox
  }

  init();
