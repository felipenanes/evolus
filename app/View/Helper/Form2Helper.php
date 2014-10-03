<?php  
class Form2Helper extends FormHelper 
{ 
    function input($fieldName, $options = array()) { 
        $this->setEntity($fieldName); 
         
        $modelKey = $this->model(); 
        $fieldKey = $this->field(); 
		
        if(!isset($this->fieldset[$modelKey])){ 
            $this->_introspectModel($modelKey); 
        } 

        if((!isset($options["type"]) || $options["type"] == "select") && !isset($options["options"])) { 
            if(isset($this->fieldset[$modelKey]["fields"][$fieldKey])){
                $type = $this->fieldset[$modelKey]["fields"][$fieldKey]["type"]; 
                $default = $this->fieldset[$modelKey]["fields"][$fieldKey]["default"]; 
                if(substr($type, 0, 4) == "enum"){
                    $options["options"]["empty"] = "Selecione uma opção";
                    $arr = explode('\'', $type); 
                    $enumValues = array();
                    foreach($arr as $value){ 
                        if($value != "enum(" && $value != "," && $value != ")"){ 
                            $options["options"][$value] = __($value, true); 
                        }
                    } 
                }
                if(isset($this->fieldset[$modelKey]["fields"][$fieldKey]["comment"])){
                    if($this->fieldset[$modelKey]["fields"][$fieldKey]["comment"] == "set"){
    				    $options["options"]["empty"] = "Selecione uma opção";
                        $arr = explode(",", $default);
                        foreach($arr as $value){
                            $options["options"][$value] = __($value, true); 
                        }
                        $options["multiple"] = "checkbox";
                    }
                }
                
            } 
        } 
         
        return parent::input($fieldName, $options); 
    } 
} 
?>