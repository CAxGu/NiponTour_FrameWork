<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.js"></script>
<script type="text/javascript" src="<?php echo CONTACT_JS_PATH ?>contact.js"></script>
<link href="<?php echo CONTACT_CSS_PATH; ?>custom.css" rel="stylesheet">

<div class="container">
    <br>
    <form id="contact_form" name="contact_form" class="form-contact">
    <h2 class="form-contact-heading">Contact Us</h2>
    
    <div class="control-group">
    <label for="sel1">Name</label>
        <input type="text" id="inputName" name="inputName" placeholder="Name" class="form-control" dir="auto" maxlength="100">
    </div>
    <div class="control-group">
    <label for="sel1">Email</label>
        <input type="text" id="inputEmail" name="inputEmail" placeholder="Email *" class="form-control" maxlength="100">
    </div>
    <div class="control-group">
        <label for="sel1">Asunto</label>
        <select class="form-control" id="inputSubject" name="inputSubject" title="Choose subject">
            <option value="compra">Info relativa a tu viaje</option>
            <option value="programacion">Contacta con nuestro dpto de programacion</option>
            <option value="Trabaja">Trabaja con nosotros</option>
            <option value="proyectos">Deseas proponernos proyectos</option>
            <option value="sugerencias">Haznos sugerencias</option>
            <option value="reclamaciones">Atendemos tus reclamaciones</option>
            <option value="club">Club Nipon</option>
            <option value="sociales">Proyectos sociales</option>
            <option value="festivos">Apertura de festivos</option>
            <option value="novedades">Te avisamos de nuestras novedades</option>
            <option value="diferente">Otros</option>
        </select>
    </div>
    <br>
    <div class="control-group">
          <textarea class="form-control" rows="4" id="inputMessage" name="inputMessage" placeholder="Message *" style="max-width: 100%;" dir="auto"></textarea> 
    </div>
        <button type="button" id="submit_contact" name="submit_contact" class="btn btn-primary btn-lg" value="submit">Send</button>
    </form>
</div> <!-- /container -->
