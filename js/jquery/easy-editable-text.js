$(document).ready(function(){
	
	$('.factorEdit').click(function(){
		$(this).hide();
		$(this).next().val($(this).html());
		$(this).next().show();
		$(this).next().select();
	});
	
/*	$('.factorEdit').keypress(function(){
		$(this).hide();
		$(this).next().val($(this).html());
		$(this).next().show();
		$(this).next().select();
	});
*/

//	$('.factorEdit').blur(function(){
//		$(this).next().select();
//	});
	
	$('.factorEdit').focus(function(){
//		$(this).hide();
//		$(this).next().val($(this).html());
//		$(this).next().show();
//		$(this).next().select();
//		$(this).hide();
//		$(this).next().val($(this).html());
//		$(this).next().show();
//		$(this).next().select();
		$(this).click();
	});	

	$('.textEdit').focus(function(){
		$(this).select();	
	});

	$('.textEdit').mouseup(function(e){
        	e.preventDefault();
	});
	
	$('.textEdit').blur(function() {  
	         if ( ($.trim(this.value) == '') ||   isNaN($.trim(this.value)) ){  
			 this.value = (this.defaultValue ? this.defaultValue : '0');  
			alert('You must enter a Number!');
		 }
		 else
		 {
			 $(this).prev().html(this.value);
		 }
		 
		 $(this).hide();
		 $(this).prev().show();
    		 recalculate();
	});
	  
	$('.textEdit').keypress(function(event) {
		if (event.keyCode == '13') {
			if ($.trim(this.value) == ''){  
				 this.value = (this.defaultValue ? this.defaultValue : '0');  
			 }
			 else
			 {
				 $(this).prev().html(this.value);
			 }
			 $(this).hide();
			 $(this).prev().show();
		 	//$(this).closest('tr').next('tr').find('.factorEdit').focus();
		 }
		if (event.keyCode == '40') {
			if( ($.trim(this.value) == '')  ||   isNaN($.trim(this.value)) ){  
				 this.value = (this.defaultValue ? this.defaultValue : '');  
			 }
			 else
			 {
				 $(this).prev().html(this.value);
			 }
			 $(this).hide();
			 $(this).prev().show();
		 	if($(this).closest('tr').next('tr').find('.factorEdit').html()==null)
		 	{
		 		$(this).closest('tr').next('tr').next('tr').find('.factorEdit').focus();		 	
		 	}
		 	else
		 	{
		 		$(this).closest('tr').next('tr').find('.factorEdit').focus();		 	
		 	}
			event.preventDefault();
		 }
		if (event.keyCode == '38') {
			if ($.trim(this.value) == ''){  
				 this.value = (this.defaultValue ? this.defaultValue : '');  
			 }
			 else
			 {
				 $(this).prev().html(this.value);
			 }
			 $(this).hide();
			 $(this).prev().show();
		 	if($(this).closest('tr').prev('tr').find('.factorEdit').html()==null)
		 	{
		 		$(this).closest('tr').prev('tr').prev('tr').find('.factorEdit').focus();		 	
		 	}
		 	else
		 	{
		 		$(this).closest('tr').prev('tr').find('.factorEdit').focus();	 	
		 	}

			event.preventDefault();
		 }
		 //alert($(this).parent().next().find('.factorEdit').html());
		 //alert($('tr').next().find('.factorEdit').html());
		 //alert($(this).parent('tr').next().find('.factorEdit').html());
		 //$('tr').next().find('.factorEdit').first().focus();
		 recalculate();
	  });
		  
});