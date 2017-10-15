function load_travel() {
    var jqxhr = $.post("../../products/details_product/",{'idtravel':true},function (data) {
        var json = JSON.parse(data);
        console.log(json);
        pintar_travel(json,0);
        //alert( "success" );
    }).done(function () {
        //alert( "second success" );
    }).fail(function () {
        //alert( "error" );
    }).always(function () {
        //alert( "finished" );
    });
    jqxhr.always(function () {
        //alert( "second finished" );
    });
}

$(document).ready(function () {
    load_travel ();
});


function pintar_travel(data,i) {
    //alert(data.user.avatar);
    
    var travelEl = document.getElementById("details_travel");        

          var divEl = document.createElement("div");
          divEl.setAttribute('id',data[i].referencia);

          
          var avatarEL = document.createElement("div");
          var html = '<img src="../../' + data[i].avatar + '" height=350 width="550"> ';
          avatarEL.innerHTML = html;
          divEl.appendChild(avatarEL);


          var idEl = document.createElement("h2");
          var idtext = document.createTextNode(data[i].referencia);
          idEl.innerHTML = 'Ref: ';
          idEl.appendChild(idtext);
          divEl.appendChild(idEl);

          var ciudadEl = document.createElement("h3");
          var ciudadtext = document.createTextNode(data[i].pais+ "," + data[i].ciudad);
          ciudadEl.innerHTML = '<strong>'+'Lugar:  '+' </strong>';
          ciudadEl.appendChild(ciudadtext);
          divEl.appendChild(ciudadEl);


          var f_salEl = document.createElement("h3");
          var f_saltext = document.createTextNode(data[i].f_sal);
          f_salEl.innerHTML = '<strong>'+'Fecha de Salida:  '+' </strong>';
          f_salEl.appendChild(f_saltext);
          divEl.appendChild(f_salEl);

          var f_llegEl = document.createElement("h3");
          var f_llegtext = document.createTextNode(data[i].f_sal);
          f_llegEl.innerHTML = '<strong>'+'Fecha de Vuelta:  '+' </strong>';
          f_llegEl.appendChild(f_llegtext);
          divEl.appendChild(f_llegEl);
          
          var priceEl = document.createElement("h2");
          var pricetext = document.createTextNode(data[i].precio);
          priceEl.innerHTML = 'Precio: ';
          priceEl.appendChild(pricetext);
          divEl.appendChild(priceEl);


        travelEl.appendChild(divEl);

        var buttonEL = document.createElement("div");
        var backEl = document.createElement("button");
        var backtext = document.createTextNode('Back to List');
        backEl.appendChild(backtext);
        backEl.addEventListener("click", function() {
          window.location.href = 'index.php?module=products&view=list_products';
       });
       buttonEL.appendChild(backEl);
       travelEl.appendChild(buttonEL);
}
