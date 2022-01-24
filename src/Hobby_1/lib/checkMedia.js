function getMedia(){
	if(window.matchMedia && window.matchMedia('(max-device-width: 640px)').matches){
		return "SmartPhone";
	}else if(window.matchMedia && window.matchMedia('(max-device-width: 800px)').matches){
		if(window.matchMedia && window.matchMedia('(max-device-height: 640px)').matches){
			return "SmartPhone";
		}
		return "TabletPC";
	}
    return "PC"
}