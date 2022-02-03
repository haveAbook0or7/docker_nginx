function getMedia(){
	if(window.matchMedia && window.matchMedia('(max-device-width: 500px)').matches){
		return "SmartPhoneH";
	}else if(window.matchMedia && window.matchMedia('(max-device-width: 800px)').matches){
		if(window.matchMedia && window.matchMedia('(max-device-height: 430px)').matches){
			return "SmartPhoneW";
		}
		return "TabletPCH";
	}
    return "PCH"
}