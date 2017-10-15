<?php
	function validate_travel($value){
        $error= array();
        $valido = true;
		$filtro = array(
			'idviaje' => array(
				'filter'=>FILTER_VALIDATE_REGEXP,
				'options'=>array('regexp' => '/^([A-Z]{1}[0-9]{1,4})*$/')
			),

			'precio' => array(
				'filter'=>FILTER_VALIDATE_REGEXP,
				'options'=>array('regexp' => '/^([0-9]{2,4})*$/')
			),


			'f_sal' => array(
				'filter'=>FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => '/^(0?[1-9]|1[0-2])[-](0?[1-9]|[12]\d|3[01])[-](19|20)\d{2}$/')
			),


			'f_lleg' => array(
				'filter' => FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => '/^(0?[1-9]|1[0-2])[-](0?[1-9]|[12]\d|3[01])[-](19|20)\d{2}$/')
            ),
            
            'tipo' => array(
				'filter' => FILTER_CALLBACK,
				'options' => 'validate_tipo'
			),
					
		);
		
        $resultado=filter_var_array($value,$filtro);
        
        $resultado['oferta'] = $value['oferta'];
        $resultado['destino'] = $value['destino'];
        $resultado['destino_provincia'] = $value['destino_provincia'];
        $resultado['destino_ciudad'] = $value['destino_ciudad'];
        $resultado['tipo'] = $value['tipo'];

        if ($_POST['destino'] === 'Seleccione Pais') {
            $error['destino'] = "Debes elegir un pais";
            $valido = false;
        }


        if ($_POST['destino_provincia'] === 'Seleccione Provincia') {
            $error['destino_provincia'] = "Debes elegir una provincia";
            $valido = false;
        }


        if ($_POST['destino_ciudad'] === 'Seleccione Ciudad') {
            $error['destino_ciudad'] = "Debes elegir una ciudad";
            $valido = false;
        }

        if (!$resultado['tipo']) {
            $error['tipo'] = 'Debes seleccionar 1 tipo como minimo';
            $valido = false;
        }

        if ($resultado != null && $resultado) {

            if (!$resultado['idviaje']) {
                $error['idviaje'] = 'El ID debe tener 1 letra y entre 1 y 4 caracteres';
                $valido = false;
            }

            if (!$resultado['precio']) {
                $error['precio'] = 'El precio debe tener entre 2 y 4 cifras';
                $valido = false;
            }
           
            if (!$resultado['f_sal']) {
                if($_POST['f_sal'] == ""){
                    $error['f_sal'] = "Este campo no puede estar vacio";
                    $valido = false;  
             }else{
                    $error['f_sal'] = 'Error en el formato de la fecha (mm/dd/yyyy)';
                    $valido = false;
                }
            }

            if (!$resultado['f_lleg']) {
                if($_POST['f_lleg'] == ""){
                    $error['f_lleg'] = "Este campo no puede estar vacio";
                    $valido = false;  
                }else{
                    $error['f_lleg'] = 'Error en el formato de la fecha (mm/dd/yyyy)';
                    $valido = false;
                }
            }

        } else {
        $valido = false;
    };
    return $return = array('resultado' => $valido, 'error' => $error, 'datos' => $resultado);
}

	
function validate_tipo($texto){
    if(!isset($texto) || empty($texto)){
        return false;
    }else{
        return true;
    }
}
    
?>