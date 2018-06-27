var animating = false;
function overlay(ele_id){
	if(!animating){		
		animating = true;
		if(ele_id){		
			$("#sign-in, #sign-up, #become-an-instructor").hide();
			$("#" + ele_id).show();
			$("#overlay").fadeIn(300, () => {
				toggle_height("#overlay-box", () => {
					animating = false;
				});
			});
		}
		else{
			toggle_height("#overlay-box", () => {
				$("#overlay").fadeOut(300, () => {
					animating = false;
				});
			});
		}
	}
}

$(window).scroll(() => {
	parallax('section1-wrap', 800);
	parallax('section4-wrap', 1601);
	
	scroll_effect("effect1");
});
$(document).ready(() => {
	parallax('section1-wrap', 800);
	parallax('section4-wrap', 1601);
	
	scroll_effect("effect1");
});