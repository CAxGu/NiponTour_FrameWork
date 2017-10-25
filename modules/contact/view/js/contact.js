$(document).ready(function () {
    $('#submit_contact').click(function () {
        validate_contact();
    });

    //Control de seguridad para evitar que al volver atrás nos imprima los datos
    $.post("../../contact/view_contact/",
    function (response) {
        //alert(response.user);
        if (response.contact === "") {
            $("#inputName").val('');
            $("#inutSUbject").val('Info relativa a tu viaje');
            $("#inputEmail").val(''); //'Seleccione Provincia'
            $("#inputMessage").val('');

            //siempre que creemos un plugin debemos llamarlo, sino no funcionará
            $(this).fill_or_clean();
        } else {

            $("#inputName").val(response.contact.name);
            $("#inutSubject").val(response.contact.subject);
            $("#inputEmail").val(response.contact.email); //'Seleccione Provincia'
            $("#inputMessage").val(response.contact.message);
        }
    }, "json");

    //Utilizamos las expresiones regulares para las funciones de  fadeout
    var name_reg = /^[0-9a-zA-Z]{2,20}$/;
    var email_reg = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/;


    //realizamos funciones para que sea más práctico nuestro formulario
    
    $("#inputName").keyup(function () {
        if ($(this).val() != "" && name_reg.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#inputEmail").keyup(function () {
        if ($(this).val() != "" && email_reg.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });


    function validate_contact() {
        var result = true;
    
        var name = document.getElementById('inputName').value;
        var email = document.getElementById('inputEmail').value;
        var subject = document.getElementById('inputSubject').value;
        var message = document.getElementById('inputMessage').value;

        //Utilizamos las expresiones regulares para la validación de errores JS
        var name_reg = /^[0-9a-zA-Z]{2,20}$/;
        var email_reg = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/;
    
        $(".error").remove();
        
        if ($("#inputName").val() == "" || $("#inputName").val() == "Name") {
            $("#inputName").focus().after("<span class='error'>Introduce your name</span>");
            result = false;
            return false;
        } else if (!name_reg.test($("#inputName").val())) {
            $("#inputName").focus().after("<span class='error'>The Name cant have any special character</span>");
            result = false;
            return false;
        }
    
        if ($("#inputEmail").val() == "" || $("#inputEmail").val() == "Email *") {
            $("#inputEmail").focus().after("<span class='error'>Introduce your email</span>");
            result = false;
            return false;
        } else if (!email_reg.test($("#inputEmail").val())) {
            $("#inputEmail").focus().after("<span class='error'>email ex: email@email.com </span>");
            result = false;
            return false;
        }

        if ($("#inputMessage").val() == "" || $("#inputMessage").val() == "Message *") {
            $("#inputMessage").focus().after("<span class='error'>Introduce your Message</span>");
            result = false;
            return false;
        }
        

        //Si ha ido todo bien, se envian los datos al servidor
        if (result) {
    
            var email = {"inputName": name, "inputEmail": email, "inputSubject":subject, "inputMessage":message};
                
            var datos_contact_JSON = JSON.stringify(email);
    
           $.post('../sendContact/',{email_contact:datos_contact_JSON}
                ).success(function() {              
                        alert("Sending OK");
                        location.reload();
                }).fail(function() {                  
                        console.log('Server error. Try later...');
                }) 

        }
    }
});