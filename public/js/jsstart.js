			$(function(){

			
			  	$('#tabs').tabs();
                                
				// Dialog
				$('#dialog').dialog({
					autoOpen: false,
					modal:true,
					width: 600,
					buttons: {
						"Ok": function() {
							$(this).dialog("close");
						},
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});

				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});


				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
				//CSS MENU
		   $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)   
      
			 $("ul.topnav li span").click(function() { //When trigger is clicked...   
           
       //Following events are applied to the subnav itself (moving subnav up and down)   
       $(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click   
  
       $(this).parent().hover(function() {   
        }, function(){     
            $(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up   
        });   
  
        //Following events are applied to the trigger (Hover events for the trigger)   
        }).hover(function() {    
      	  $(this).addClass("subhover"); //On hover over, add class "subhover"   
        }, function(){  //On Hover Out   
            $(this).removeClass("subhover"); //On hover out, remove class "subhover"   
    });   
  

				//CSS Menu Ende

			});
			
	
