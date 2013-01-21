Array.prototype.in_array = function ( elem ) {
	
	var i, listed = false;
	
	for (i = 0; i < this.length; i++) {
		
		if ( this[i] == elem ) {
			
			listed = true;
			break;
			
		}
		
	}
	
	return listed;
	
};

Array.prototype.getIndex = function ( elem ) {
	
	var i, index = -1;
	
	for (i = 0; i < this.length; i++) {
		
		if ( this[i] == elem ) {
			
			index = i;
			break;
			
		}
		
	}
	
	return index;
	
};

function trim(str, chars) {
	
    return ltrim(rtrim(str, chars), chars);   
	
}

function ltrim(str, chars) {   
	
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
	
}

function rtrim(str, chars) {   
	
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
	
}