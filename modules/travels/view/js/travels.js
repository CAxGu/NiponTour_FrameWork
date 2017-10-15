//Function to validate data user
function validate_country(country) {
    if (country == null) {
        return false;
    }
    if (country.length == 0) {
        return false;
    }
    if (country === 'Select Country') {
        return false;
    }
    if (country.length > 0) {
        var regexp = /^[a-zA-Z_]*$/;
        return regexp.test(country);
    }
    return false;
}
function validate_province(province) {
    if (province == null) {
        return 'default_province';
    }
    if (province.length == 0) {
        return 'default_province';
    }
    if (province === 'Select Province') {
        return false;
    }
    if (province.length > 0) {
        var regexp = /^[a-zA-Z0-9, ]*$/;
        return regexp.test(province);
    }
    return false;
}
function validate_town(town) {
    if (town == null) {
        return 'default_town';
    }
    if (town.length == 0) {
        return 'default_town';
    }
    if (town === 'Select Town') {
        //return 'default_poblacion';
        return false;
    }
    if (town.length > 0) {
        var regexp = /^[a-zA-Z/, -'()]*$/;
        return regexp.test(town);
    }
    return false;
}


//Crear un plugin
jQuery.fn.fill_or_clean = function () {
    this.each(function () {
        if ($("#idviaje").val() == "") {
            $("#idviaje").val("Introduce ID");
            $("#idviaje").focus(function () {
                if ($("#idviaje").val() == "Introduce ID") {
                    $("#idviaje").val('');
                }
            });
        }
        $("#idviaje").blur(function () { //Onblur se activa cuando el usuario retira el foco
            if ($("#idviaje").val() == "") {
                $("#idviaje").val("Introduce ID");
            }
        });

        if ($("#precio").val() == "") {
            $("#precio").val("0");
            $("#precio").focus(function () {
                if ($("#precio").val() == "0") {
                    $("#precio").val('');
                }
            });
        }
        $("#precio").blur(function () {
            if ($("#precio").val() == "") {
                $("#precio").val("0");
            }
        });
        if ($("#f_sal").val()== "") {
            $("#f_sal").val("Introduce fecha de salida");
            $("#f_sal").focus(function () {
                if ($("#f_sal").val() == "Introduce fecha de salida") {
                    $("#f_sal").val('');
                }
            });
        }
        $("#f_sal").blur(function () {
            if ($("#f_sal").val() == "") {
                $("#f_sal").val("Introduce fecha de salida");
            }
        });
        if ($("#f_lleg").val() == "") {
            $("#f_lleg").val( "Introduce fecha de llegada");
            $("#f_lleg").focus(function () {
                if ($("#f_lleg").val() == "Introduce fecha de llegada") {
                    $("#f_lleg").val('');
                }
            });
        }
        $("#f_lleg").blur(function () {
            if ($("#f_lleg").val() == "") {
                $("#f_lleg").val( "Introduce fecha de llegada");
            }
        });
    });//each
    return this;
};//function

//Solution to : "Uncaught Error: Dropzone already attached."
Dropzone.autoDiscover = false;
$(document).ready(function () {

    //Datepicker///////////////////////////
    $( function() {
        $( "#f_sal" ).datepicker({
        minDate: '0Y',
        maxDate: '+3Y',
        dateFormat: 'mm-dd-yy',
        changeMonth: true,
        changeYear: true,
        //En este onselect comprobamos que la fecha de vueta sea siempre posterior a la de salida.
        onSelect: function (date) {
            var f_lleg = $('#f_lleg');
            var startDate = $(this).datepicker('getDate');
            var minDate = $(this).datepicker('getDate');
            f_lleg.datepicker('option', 'minDate', minDate);
        }
    });
    $('#f_lleg').datepicker({
        dateFormat: "mm-dd-yy"
    });

    } );
 
    //Valida users /////////////////////////
    $('#submit_travel').click(function () {
        validate_travel();
    });

    //Control de seguridad para evitar que al volver atrás de la pantalla results a create, no nos imprima los datos
    $.post("../../travels/load_data_travels/",{'load_data':true},
            function (response) {
                //alert(response.user);
                if (response.travel === "") {
                    $("#idviaje").val('');
                    $("#destino").val('');
                    $("#destino_provincia").val(''); //'Seleccione Provincia'
                    $("#destino_ciudad").val('');
                    $("#precio").val('');
                    $("#f_sal").val('');
                    $("#f_lleg").val('');
                    var inputElements = document.getElementsByClassName('messageCheckbox');
                    for (var i = 0; i < inputElements.length; i++) {
                        if (inputElements[i].checked) {
                            inputElements[i].checked = false;
                        }
                    }
                    //siempre que creemos un plugin debemos llamarlo, sino no funcionará
    $(this).fill_or_clean();
                } else {
                    $("#idviaje").val(response.travel.idviaje);
                    $("#destino").val(response.travel.destino);
                    $("#destino_provincia").val(response.travel.destino_provincia);
                    $("#destino_ciudad").val(response.travel.destino_ciudad);
                    $("#precio").val(response.travel.precio);
                    $("#f_sal").val(response.travel.f_sal);
                    $("#f_lleg").val(response.travel.f_lleg);
                    var tipo = response.travel.tipo;
                    var inputElements = document.getElementsByClassName('messageCheckbox');
                    for (var i = 0; i < inputElements.length; i++) { //////////////////////////////////////
                        for (var j = 0; j < inputElements.length; j++) {
                            if(tipo[i] ===inputElements[j] )
                                inputElements[j].checked = true;
                        }
                    }
                }
            }, "json");
    //Dropzone function //////////////////////////////////
    $("#dropzone").dropzone({
        url: "../../travels/upload_travels/",
        params:{'upload':true},
        addRemoveLinks: true,
        maxFileSize: 1000,
        dictResponseError: "Ha ocurrido un error en el server",
        acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.rar,application/pdf,.psd',
        init: function () {
            this.on("success", function (file, response) {
                //alert(response);
                $("#progress").show();
                $("#bar").width('100%');
                $("#percent").html('100%');
                $('.msg').text('').removeClass('msg_error');
                $('.msg').text('Success Upload image!!').addClass('msg_ok').animate({'right': '300px'}, 300);
            });
        },
        complete: function (file) {
            //if(file.status == "success"){
            //alert("El archivo se ha subido correctamente: " + file.name);
            //}
        },
        error: function (file) {
            //alert("Error subiendo el archivo " + file.name);
        },
        removedfile: function (file, serverFileName) {
            var name = file.name;
            $.ajax({
                type: "POST",
                url: "../../travels/delete_travels/",
                data: {"filename":name,"delete":true},
                success: function (data) {
                    $("#progress").hide();
                    $('.msg').text('').removeClass('msg_ok');
                    $('.msg').text('').removeClass('msg_error');
                    $("#e_avatar").html("");

                    var json = JSON.parse(data);
                    if (json.res === true) {
                        var element;
                        if ((element = file.previewElement) != null) {
                            element.parentNode.removeChild(file.previewElement);
                            //alert("Imagen eliminada: " + name);
                        } else {
                            false;
                        }
                    } else { //json.res == false, elimino la imagen también
                        var element;
                        if ((element = file.previewElement) != null) {
                            element.parentNode.removeChild(file.previewElement);
                        } else {
                            false;
                        }
                    }
                }
            });
        }
    });

    //Utilizamos las expresiones regulares para las funciones de  fadeout
    var date_reg = /^(0?[1-9]|1[0-2])[-](0?[1-9]|[12]\d|3[01])[-](19|20)\d{2}$/;
    var precio_ref = /^([0-9]{2,4})*$/;
    var viaje_reg = /^([A-Z]{1}[0-9]{1,4})*$/;

    //realizamos funciones para que sea más práctico nuestro formulario
    
    $("#idviaje").keyup(function () {
        if ($(this).val() != "" && precio_ref.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#destino").click(function () {
        if (validate_country($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#destino").click(function () {
        if (validate_country($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#destino_provincia").click(function () {
        if (validate_province($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });


    $("#destino_ciudad").click(function () {
        if (validate_province($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });


    $("#precio").keyup(function () {
        if ($(this).val() != "" && precio_ref.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });


    $("#f_sal, #f_lleg").click(function () {
        if ($(this).val() != "" && date_reg.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });

     //Dependent combos //////////////////////////////////
     
     load_countries_v1();
     $("#destino_provincia").empty();
     $("#destino_provincia").append('<option value="" selected="selected">Seleccione Provincia</option>');
     $("#destino_provincia").prop('disabled', true);
     $("#destino_ciudad").empty();
     $("#destino_ciudad").append('<option value="" selected="selected">Seleccione Ciudad</option>');
     $("#destino_ciudad").prop('disabled', true);
 
     $("#destino").change(function() {
         var destino = $(this).val();
         var destino_provincia = $("#destino_provincia");
         var destino_ciudad = $("#destino_ciudad");
 
         if(destino !== 'ES'){
            destino_provincia.prop('disabled', true);
            destino_ciudad.prop('disabled', true);
              $("#destino_provincia").empty();
              $("#destino_ciudad").empty();
         }else{
            destino_provincia.prop('disabled', false);
            destino_ciudad.prop('disabled', false);
              load_provinces_v1();
         }//fi else
     });
 
     $("#destino_provincia").change(function() {
         var prov = $(this).val();
         if(prov > 0){
             load_cities_v1(prov);
         }else{
             $("#destino_ciudad").prop('disabled', false);
         }
     });

});

function validate_travel() {
    var result = true;

    var idviaje = document.getElementById('idviaje').value;
    var destino = document.getElementById('destino').value;
    var destino_provincia = document.getElementById('destino_provincia').value;
    var destino_ciudad = document.getElementById('destino_ciudad').value;
    var precio = document.getElementById('precio').value;
    var oferta = document.getElementById('oferta').value;
    var f_sal = document.getElementById('f_sal').value;
    var f_lleg = document.getElementById('f_lleg').value;

    
    var tipo = [];
    var inputElements = document.getElementsByClassName('messageCheckbox');
    var j = 0;
    for (var i = 0; i < inputElements.length; i++) {
        if (inputElements[i].checked) {
            tipo[j] = inputElements[i].value;
            j++;
        }
    }

    //Utilizamos las expresiones regulares para la validación de errores JS
    var date_reg = /^(0?[1-9]|1[0-2])[-](0?[1-9]|[12]\d|3[01])[-](19|20)\d{2}$/;
    var precio_ref = /^([0-9]{2,4})*$/;
    var viaje_reg = /^([A-Z]{1}[0-9]{1,4})*$/;

    $(".error").remove();
    
    if ($("#idviaje").val() == "" || $("#idviaje").val() == "Introduce ID") {
        $("#idviaje").focus().after("<span class='error'>Introduce un ID</span>");
        result = false;
        return false;
    } else if (!viaje_reg.test($("#idviaje").val())) {
        $("#idviaje").focus().after("<span class='error'>*El ID debe tener 1 letra mayus y 3 numeros</span>");
        result = false;
        return false;
    }


    if ($("#destino").val() === "" || $("#destino").val() === "Selecciona Pais" || $("#destino").val() === null) {
        $("#destino").focus().after("<span class='error'>Seleccione un Pais</span>");
        return false;
    }

    else if ($("#destino_provincia").val() === "" || $("#destino_provincia").val() === "Seleccione Provincia" || $("#country").val() === null) {
        $("#destino_provincia").focus().after("<span class='error'>Debe seleccionar una provincia</span>");
        return false;
    }

    else if ($("#destino_ciudad").val() === "" || $("#destino_ciudad").val() === "Seleccione Ciudad") {
        $("#destino_ciudad").focus().after("<span class='error'>Debe seleccionar una ciudad</span>");
        return false;
    }

    else if ($("#precio").val() == "" || $("#precio").val() == "0") {
        $("#precio").focus().after("<span class='error'>Introduce un precio</span>");
        result = false;
        return false;
    } else if (!precio_ref.test($("#precio").val())) {
        $("#precio").focus().after("<span class='error'>El precio debe estar entre 70 y 4000</span>");
        result = false;
        return false;
    }

    else if ($("#f_sal").val() == "" || $("#f_sal").val() == "Introduce fecha de salida") {
        $("#f_sal").focus().after("<span class='error'>Introduce una fecha de salida</span>");
        result = false;
        return false;
    } else if (!date_reg.test($("#f_sal").val())) {
        $("#f_sal").focus().after("<span class='error'>error en el formato (mm/dd/yyyy)</span>");
        result = false;
        return false;
    }

    else if ($("#f_lleg").val() == "" || $("#f_lleg").val() == "Introduce fecha de llegada") {
        $("#f_lleg").focus().after("<span class='error'>Introduce una fecha de llegada</span>");
        result = false;
        return false;
    } else if (!date_reg.test($("#f_lleg").val())) {
        $("#f_lleg").focus().after("<span class='error'>error en el formato (mm/dd/yyyy)</span>");
        result = false;
        return false;
    }

    //Si ha ido todo bien, se envian los datos al servidor
    if (result) {

        if (destino_provincia === null) {
            destino_provincia = 'default_province';
        }else if (destino_provincia.length === 0) {
            destino_provincia = 'default_province';
        }else if (destino_provincia === 'Seleccione Provincia') {
            return 'default_province';
        }

        if (destino_ciudad === null) {
            destino_ciudad = 'default_city';
        }else if (destino_ciudad.length === 0) {
            destino_ciudad = 'default_city';
        }else if (destino_ciudad === 'Seleccione Ciudad') {
            return 'default_city';
        }

        var data = {"idviaje": idviaje, "destino": destino, "destino_provincia":destino_provincia, "destino_ciudad":destino_ciudad, "precio": precio, "oferta": oferta, "tipo": tipo, "f_sal": f_sal, "f_lleg": f_lleg};
            
        var data_travels_JSON = JSON.stringify(data);
        //console.log(data_travels_JSON);
        $.post('../../travels/alta_travels/',
                {alta_travels_json:data_travels_JSON},
        function (response) {
           // console.log("0"+ response);
            if (response.success) {
                window.location.href = response.redirect;
            }
          
            //alert(response);  //para debuguear
            //}); //para debuguear
        //}, "json").fail(function (xhr) {
        
        }, "json").fail(function (xhr, textStatus, errorThrown ) {
            console.log("1 "+xhr.responseText);
            console.log("2 "+xhr.responseJSON);
            
            if (xhr.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (xhr.status == 404) {
                alert('Requested page not found [404]');
            } else if (xhr.status == 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + xhr.responseText);
            }
            
            if (xhr.responseJSON == 'undefined' && xhr.responseJSON == null )
                xhr.responseJSON = JSON.parse(xhr.responseText);
            
            if (xhr.responseJSON.error.idviaje)
                $("#idviaje").focus().after("<span  class='error1'>" + xhr.responseJSON.error.idviaje + "</span>");

            if (xhr.responseJSON.error.destino)
                $("#destino").focus().after("<span  class='error1'>" + xhr.responseJSON.error.destino + "</span>");

            if (xhr.responseJSON.error.provincia)
                $("#destino_provincia").focus().after("<span  class='error1'>" + xhr.responseJSON.error.provincia + "</span>");

            if (xhr.responseJSON.error.ciudad)
                $("#destino_ciudad").focus().after("<span  class='error1'>" + xhr.responseJSON.error.ciudad + "</span>");

            if (xhr.responseJSON.error.precio)
                $("#destino").focus().after("<span  class='error1'>" + xhr.responseJSON.error.destino + "</span>");

            if (xhr.responseJSON.error.oferta)
                $("#oferta").focus().after("<span  class='error1'>" + xhr.responseJSON.error.oferta + "</span>");

            if (xhr.responseJSON.error.tipo)
                $("#tipo").focus().after("<span  class='error1'>" + xhr.responseJSON.error.tipo + "</span>");

            if (xhr.responseJSON.error.f_sal)
                $("#f_sal").focus().after("<span  class='error1'>" + xhr.responseJSON.error.f_sal + "</span>");

            if (xhr.responseJSON.error.f_lleg)
                $("#f_lleg").focus().after("<span  class='error1'>" + xhr.responseJSON.error.f_lleg + "</span>");

            if (xhr.responseJSON.error_avatar)
                $("#dropzone").focus().after("<span  class='error1'>" + xhr.responseJSON.error_avatar + "</span>");

            if (xhr.responseJSON.success1) {
                if (xhr.responseJSON.img_avatar !== "/NiponTour/media/default-avatar.png") {
                    //$("#progress").show();
                    //$("#bar").width('100%');
                    //$("#percent").html('100%');
                    //$('.msg').text('').removeClass('msg_error');
                    //$('.msg').text('Success Upload image!!').addClass('msg_ok').animate({ 'right' : '300px' }, 300);
                }
            } else {
                $("#progress").hide();
                $('.msg').text('').removeClass('msg_ok');
                $('.msg').text('Error Upload image!!').addClass('msg_error').animate({'right': '300px'}, 300);
            }
        });
    }
}


function load_countries_v2(cad, post_data) {
    $.post( cad,post_data, function(data) {
      $("#destino").empty();
      $("#destino").append('<option value="" selected="selected">Seleccione Pais</option>');

      $.each(data, function (i, valor) {
        $("#destino").append("<option value='" + valor.sISOCode + "'>" + valor.sName + "</option>");
      });
    },"json")
    .fail(function() {
        alert( "error load_countries" );
    });
}

function load_countries_v1() {
    $.post("/../../travels/load_countries_travels/",{'load_country':true},
        function( response ) {
           // console.log(response);
            if(response === 'error'){
                load_countries_v2("../../resources/ListOfCountryNamesByName.json");
            }else{            
                load_countries_v2("../../travels/load_countries_travels/",{'load_country':true}); //oorsprong.org
            }
    })
    .fail(function(response) {
        load_countries_v2("../../resources/ListOfCountryNamesByName.json");
    });
}

function load_provinces_v2() {
    $.get("../../resources/provinciasypoblaciones.xml", function (xml) {
	    $("#destino_provincia").empty();
	    $("#destino_provincia").append('<option value="" selected="selected">Select province</option>');

        $(xml).find("provincia").each(function () {
            var id = $(this).attr('id');
            var name = $(this).find('nombre').text();
            $("#destino_provincia").append("<option value='" + id + "'>" + name + "</option>");
        });
    })
    .fail(function() {
        alert( "error load_provinces" );
    });
}

function load_provinces_v1() { //provinciasypoblaciones.xml - xpath
    $.post( "../../travels/load_provinces_travels/",{'load_provinces':true},
        function( response ) {
          $("#destino_provincia").empty();
	        $("#destino_provincia").append('<option value="" selected="selected">Seleccione Provincia</option>');

            //alert(response);
        var json = JSON.parse(response);
		    var provinces=json.provinces;
		    //alert(provinces);
		    //console.log(provinces);

		    //alert(provinces[0].id);
		    //alert(provinces[0].nombre);

            if(provinces === 'error'){
                load_provinces_v2();
            }else{
                for (var i = 0; i < provinces.length; i++) {
        		    $("#destino_provincia").append("<option value='" + provinces[i].id + "'>" + provinces[i].nombre + "</option>");
    		    }
            }
    })
    .fail(function(response) {
        load_provinces_v2();
    });
}

function load_cities_v2(prov) {
    $.get("../../resources/provinciasypoblaciones.xml", function (xml) {
		$("#destino_ciudad").empty();
	    $("#destino_ciudad").append('<option value="" selected="selected">Select city</option>');

		$(xml).find('provincia[id=' + prov + ']').each(function(){
    		$(this).find('localidad').each(function(){
    			 $("#destino_ciudad").append("<option value='" + $(this).text() + "'>" + $(this).text() + "</option>");
    		});
        });
	})
	.fail(function() {
        alert( "error load_cities" );
    });
}

function load_cities_v1(prov) { //provinciasypoblaciones.xml - xpath
    var datos = { idPoblac : prov  };
	$.post("../../travels/load_towns_travels/", datos, function(response) {
	    //alert(response);
        var json = JSON.parse(response);
		var cities=json.cities;
		//alert(poblaciones);
		//console.log(poblaciones);
		//alert(poblaciones[0].poblacion);

		$("#destino_ciudad").empty();
	    $("#destino_ciudad").append('<option value="" selected="selected">Select city</option>');

        if(cities === 'error'){
            load_cities_v2(prov);
        }else{
            for (var i = 0; i < cities.length; i++) {
        		$("#destino_ciudad").append("<option value='" + cities[i].poblacion + "'>" + cities[i].poblacion + "</option>");
    		}
        }
	})
	.fail(function() {
        load_cities_v2(prov);
    });
}


/*function url_amigable(link) {
    var url="";

    link= link.replace("?", "");
    link=link.split("&");

    for (var i=0;i<link.length,i++;){
        var aux = link[i].split("=");
        url += "/"+aux[1];
    }

    var root = "http://localhost/2ndoDAW"
return root + url;
}*/

