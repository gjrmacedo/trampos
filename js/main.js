function ValidaObrigatorios()
{
	var arrayRequired = document.querySelectorAll('[requiredfield]'),
		msgRequired = "";
		
	for (var indexElement in arrayRequired){
		if (!arrayRequired[indexElement].type){
			continue;
		}
				
		if (arrayRequired[indexElement].value == "") {
			if (msgRequired != "") {
				msgRequired = msgRequired + "\n";
			}
			
			msgRequired = msgRequired + arrayRequired[indexElement].name;
		}
	}	
	
	if (msgRequired != "") {
		msgRequired = "Os campos listados abaixo são obrigatórios:\n" + msgRequired;
		alert(msgRequired);
		return false;
	}
	
	return true;
}