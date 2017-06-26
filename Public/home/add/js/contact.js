function setIptChecked(index){
	var objVal = index + 1;
	
	document.getElementById('phonetype').value = objVal;
	var isChecked = document.getElementsByName('telephone')[index].checked;
	
	if(!isChecked){
		document.getElementsByName('telephone')[index].checked = true;
	}
}