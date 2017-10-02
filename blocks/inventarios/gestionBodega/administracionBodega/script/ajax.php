<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarDependencia";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar16, $enlace);

// URL definitiva
$urlFinal16 = $url . $cadena16;





// Variables
$cadenaACodificar30 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar30 .= "&procesarAjax=true";
$cadenaACodificar30 .= "&action=index.php";
$cadenaACodificar30 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar30 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar30 .= $cadenaACodificar30 . "&funcion=consultarDependencia2";
$cadenaACodificar30 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena30 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar30, $enlace);

// URL definitiva
$urlFinal30 = $url . $cadena30;
// echo $urlFinal;

// Variables
$cadenaACodificar4 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar4 .= "&procesarAjax=true";
$cadenaACodificar4 .= "&action=index.php";
$cadenaACodificar4 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar4 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar4 .= $cadenaACodificar4 . "&funcion=consultarUbicacion";
$cadenaACodificar4 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena4 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar4, $enlace);

// URL definitiva
$urlFinal4 = $url . $cadena4;

// Variables
$cadenaACodificar18 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar18 .= "&procesarAjax=true";
$cadenaACodificar18 .= "&action=index.php";
$cadenaACodificar18 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar18 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar18 .= $cadenaACodificar18 . "&funcion=consultarSede";
$cadenaACodificar18 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena18 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar18, $enlace);

// URL definitiva
$urlFinal18 = $url . $cadena18;

// Variables
$cadenaACodificarProveedor = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedor .= "&procesarAjax=true";
$cadenaACodificarProveedor .= "&action=index.php";
$cadenaACodificarProveedor .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedor .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedor .= "&funcion=consultaProveedor";
$cadenaACodificarProveedor .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedor, $enlace);

// URL definitiva
$urlFinalProveedor = $url . $cadena;
?>


<script type='text/javascript'>

//    var ventana_emergente = document.getElementsByClassName("ventanaEmergente3");



    $(document).ready(function () {
        var table = $('#tablaTitulos').DataTable();
        $('#botonesAD').hide();
        $('#tablaTitulos tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });
        $('#btConfirmar').click(function () {
            $("#confirmar").hide("fast");
            $('#botonesImprimir').hide();
            $('#botonesAD').show();
//            $("#ventanaEmergente2").dialog("open","aaa");
//            
            var objetoSPAN = document.getElementById('intro2');
            var cadena = [];
            var con = 0;

//          ventana_emergente.style.display = "block";
            campos = '';
            campos_elemento = '';
            campos_detalle = '';
            cantidad  = '';
            table.rows('.selected').every(function (rowIdx, tableLoop, rowLoop) {
                var data = this.data();

                var cantidad_asignada = table.cell({row: rowIdx, column: 9}).node();
               


                var texto = (data[2].toString()).toLowerCase() + ", " + data[3].toString().toLowerCase() + ", " + data[4].toString().toLowerCase() + ", " + data[5].toString().toLowerCase() + ", " + $('input', cantidad_asignada).val() + "<br>";

                cadena.push(texto);
                campos = campos + data[1] + ',';
                campos_elemento = campos_elemento + data[0] + ',';
                campos_detalle = campos_detalle + data[5] + ',';
                cantidad  =  cantidad + $('input', cantidad_asignada).val() + ',';

            });
            $("#<?php echo $this->campoSeguro('variablesCampo') ?>").val(campos);
            $("#<?php echo $this->campoSeguro('variablesCant') ?>").val(cantidad);
            $("#<?php echo $this->campoSeguro('elementosID') ?>").val(campos_elemento);
            $("#<?php echo $this->campoSeguro('elementosDetalle') ?>").val(campos_detalle);
            var mensaje = cadena.join(" ");
            objetoSPAN.innerHTML = "A los siguientes elementos se le haran salida de bodega:<br><br>" + "ENTRADA | NIT | PROVEEDOR | DESCRIPCION | CANTIDAD <br><br> "+ mensaje;
            $("#ventanaEmergente2").dialog("open");
        });


    });







    function marcar(obj) {
        elem = obj.elements;
        for (i = 0; i < elem.length; i++)
            if (elem[i].type == "checkbox")
                elem[i].checked = true;
    }

    function desmarcar(obj) {
        elem = obj.elements;
        for (i = 0; i < elem.length; i++)
            if (elem[i].type == "checkbox")
                elem[i].checked = false;
    }

    function consultarSede(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal18 ?>",
            dataType: "json",
            data: {funcionario: $("#<?php echo $this->campoSeguro('responsable') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('sede') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('sede') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].ESF_ID_SEDE + "'>" + data[ indice ].ESF_SEDE + "</option>").appendTo("#<?php echo $this->campoSeguro('sede') ?>");
                    });
                    $("#<?php echo $this->campoSeguro('sede') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('sede') ?>').width(270);
                    $("#<?php echo $this->campoSeguro('sede') ?>").select2();
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").val(null);
                    $('#<?php echo $this->campoSeguro('ubicacion') ?>').width(270);
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").attr('disabled', '');
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").select2();
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").val(null);
                    $('#<?php echo $this->campoSeguro('dependencia') ?>').width(270);
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").attr('disabled', '');
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").select2();
                }
            }
        });
    }
    ;
    function consultarDependencia2(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal30 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede2') ?>").val()},
            success: function (data) {


                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia2') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia2') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia2') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia2') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia2') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('dependencia2') ?>").select2();




                }



            }

        });
    }
    ;
    function consultarDependencia(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede') ?>").val(), funcionario: $("#<?php echo $this->campoSeguro('responsable') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia') ?>");
                    });
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('dependencia') ?>').width(270);
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").select2();
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").val(null);
                    $('#<?php echo $this->campoSeguro('ubicacion') ?>').width(270);
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").select2();
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").attr('disabled', '');
                }
            }
        });
    }
    ;
    function consultarEspacio(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal4 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('dependencia') ?>").val(),
                funcionario: $("#<?php echo $this->campoSeguro('responsable') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('ubicacion') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].ESF_ID_ESPACIO + "'>" + data[ indice ].ESF_NOMBRE_ESPACIO + "</option>").appendTo("#<?php echo $this->campoSeguro('ubicacion') ?>");
                    });
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('ubicacion') ?>').width(270);
                    $("#<?php echo $this->campoSeguro('ubicacion') ?>").select2();
                }
            }
        });
    }
    ;
    $(function () {
        $("#<?php echo $this->campoSeguro('numero_entrada') ?>").select2();
        $("#<?php echo $this->campoSeguro('proveedor') ?>").keyup(function () {
            $('#<?php echo $this->campoSeguro('proveedor') ?>').val($('#<?php echo $this->campoSeguro('proveedor') ?>').val().toUpperCase());
        });
        $("#<?php echo $this->campoSeguro('proveedor') ?>").autocomplete({
            minChars: 3,
            serviceUrl: '<?php echo $urlFinalProveedor; ?>',
            onSelect: function (suggestion) {
                $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            }
        });
        $("#<?php echo $this->campoSeguro('responsable') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('responsable') ?>").val() != '') {
                consultarSede();
            } else {
            }
        });
        $("#<?php echo $this->campoSeguro('sede') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('sede') ?>").val() != '') {
                consultarDependencia();
            } else {
                $("#<?php echo $this->campoSeguro('dependencia') ?>").select2();
                $("#<?php echo $this->campoSeguro('dependencia') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('ubicacion') ?>").select2();
                $("#<?php echo $this->campoSeguro('ubicacion') ?>").attr('disabled', '');
            }

        });
        $("#<?php echo $this->campoSeguro('sede2') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('sede2') ?>").val() != '') {
                consultarDependencia2();
            } else {
                $("#<?php echo $this->campoSeguro('dependencia2') ?>").select2();
                $("#<?php echo $this->campoSeguro('dependencia2') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('ubicacion') ?>").select2();
            }

        });

        $("#<?php echo $this->campoSeguro('dependencia') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('dependencia') ?>").val() != '') {
                consultarEspacio();
            } else {
                $("#<?php echo $this->campoSeguro('ubicacion') ?>").attr('disabled', '');
            }

        });
        $("#<?php echo $this->campoSeguro('selecc_registros') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('selecc_registros') ?>").val() == 1) {
                marcar(this.form);
            } else {
                desmarcar(this.form);
            }

        });
        $("#<?php echo $this->campoSeguro('funcionario_recibe') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('funcionario_recibe') ?>").val() != '') {
                $("#<?php echo $this->campoSeguro('contratista_recibe') ?>").val(null);
                    $("#<?php echo $this->campoSeguro('contratista_recibe') ?>").select2();
            } else {
            }
        });
        $("#<?php echo $this->campoSeguro('contratista_recibe') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('contratista_recibe') ?>").val() != '') {
                $("#<?php echo $this->campoSeguro('funcionario_recibe') ?>").val(null);
                    $("#<?php echo $this->campoSeguro('funcionario_recibe') ?>").select2();
            } else {
            }
        });
        
        
    });

</script>