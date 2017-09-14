/**
HOW IT WORKS? 

1> FOR ADDDMORE BUTTON USE ANY HTML ELEMENT AND 
   USE:: [.. onclick="addmore('add_more_pass_');"]
	WHERE 
	"add_more_pass_" IS THE ID OF THE CONTAINER
2> the container to be repeated must have some id with suffix starting from 0. 
   ex- <div id="add_more_pass_0" > 

3> The delete row button must hsve id="add_more_remove" and rel="add_more_pass_" 
   ex-  <input type="button" class="add_more_remove" id="add_more_remove" rel="add_more_pass_" value="Delete" />

4> Initializing posted or default values within the add more section
**/
/*


*/

var add_more_values;
var add_more_remove_callback=function(){};//for additional function required at removing an row

var add_more_after_remove_callback=function(){};//for additional function required after removing an row
var add_more_after_add_callback=function(){};//for additional function required after adding an row

jQuery(function($){
$(document).ready(function(){

	/////////initializing the addmore button////
	jQuery("#add_more_add[rel^='add_more_']").each(function(i){
		
		$(this).on("click",function(){
			$(this).attr('disabled',true);	
			addmore($(this).attr('rel'));
			$(this).attr('disabled',false);			
		});


		///Init for check box and radios///
		var jq_id_part=$(this).attr('rel');
		jQuery("[id^='"+jq_id_part+"']").find("input[type='radio'],input[type='checkbox']").each(function(km){
			
			var $firstobj=$(this);
			var old_id=jQuery(this).attr("id");

			if( !$firstobj.next().is("[type='hidden']") )
			{
		 	$firstobj.after('<input type="hidden" id="'+old_id+'" name="'+old_id+'[]" value=""/>');
		 	$firstobj.attr("id",old_id+"0");
		 	//$firstobj.attr("name",old_id+"0"+'[]');		
			$firstobj.attr("name","");
			
			if( jQuery(this).is(":checked") )
		 		jQuery(this).next().attr("value", jQuery(this).attr("value") );
			else
				jQuery(this).next().attr("value","" );

		

		 	$firstobj.off("click").on("click",function(){
		 	if( jQuery(this).is(":checked") )
		 		jQuery(this).next().attr("value", jQuery(this).attr("value") );
			else
				jQuery(this).next().attr("value","" );

			}); 		
			}			
			
		});	

	});
	/////////initializing delete button//////
	var container_part="";
	jQuery("#add_more_remove[rel^='add_more_']").each(function(i){
		 if(container_part!=$(this).attr("rel"))
		 {
			container_part= $(this).attr("rel");	
			/////removing container using container specific buttons/////
			jQuery("#add_more_remove[rel='"+container_part+"']").each(function(m){
                
				/*$(this).click(function(){
					remove_addmore($(this).attr("rel")+m,$(this).attr("rel"));
                    return false;
				});*/
                
                $(this).on("click",function(){
                   remove_addmore($(this).attr("rel")+m,$(this).attr("rel"));
                    return false;
                });                
                
                
			});
		 }
	});	
	
	
 });
});


	function addLeadingZeros (n, length)
	{
		var str = (n > 0 ? n : -n) + "";
		var zeros = "";
		for (var i = length - str.length; i > 0; i--)
			zeros += "0";
		zeros += str;
		return n >= 0 ? zeros : "-" + zeros;
	}
	
/**
*@parm, jq_id_part=> 'add_more_pickup_' 
*
* There must be atleast one row exists 
* for cloning.
*/

function addmore(jq_id_part)
{	
	//alert(jQuery("[id^='"+jq_id_part+"']:first").length);
	var $cln= jQuery("[id^='"+jq_id_part+"']:first").clone();
	//var idx=jQuery("[id^='"+jq_id_part+"']").length;
	var idx=0;
	if(jQuery("[id^='"+jq_id_part+"']:first").prev().is("input[name='addmore_lastindex']")){
		idx = jQuery("[id^='"+jq_id_part+"']:first").prev("input[name='addmore_lastindex']").attr("value");
		idx = parseInt(idx)+1;
	} else {
		idx = jQuery("[id^='"+jq_id_part+"']").length;
		jQuery("[id^='"+jq_id_part+"']:first").before('<input type="hidden" name="addmore_lastindex" value="'+idx+'"/>');
	}
	
	var new_id=jq_id_part+idx;
	add_more_counter = idx;
	$cln.attr("id",new_id);
	jQuery("[id^='"+jq_id_part+"']:first").prev("input[name='addmore_lastindex']").attr("value",idx);
	/////cloning the input fields/////
	$cln.find("input").each(function(i){
        if(!jQuery(this).is("#add_more_remove")
	 	&& ( jQuery(this).is("[type='text']") || jQuery(this).is("[type='hidden']") )	
	 )
	{
		jQuery(this).attr("value","");
	}
	else if(jQuery(this).is("[type='radio']") || jQuery(this).is("[type='checkbox']"))
	{
		var old_id=jQuery(this).attr("id");
		
		///checking if the hidden field is already assigned///
		if( jQuery(this).next().is("[type='hidden']") )
		{
			jQuery(this).attr("id",old_id+idx);
			//jQuery(this).attr("name",old_id+idx+'[]');
			//jQuery(this).attr("name","");

			
			jQuery(this).attr("checked",false);

			jQuery(this).off("click").on("click",function(){
				if(jQuery(this).is(":checked"))
					jQuery(this).next().attr("value",jQuery(this).attr("value") );
				else
					jQuery(this).next().attr("value","" );

			}); 
		}
		else
		{
			jQuery(this).after('<input type="hidden" id="'+old_id+'" name="'+old_id+'[]" value=""/>');
		
			jQuery(this).attr("id",old_id+idx);
			//jQuery(this).attr("name",old_id+idx+'[]');
			//jQuery(this).attr("name","");


			jQuery(this).attr("checked",false);	

			jQuery(this).off("click").on("click",function(){
				if( jQuery(this).is(":checked") )
					jQuery(this).next().attr("value", jQuery(this).attr("value") );
				else
					jQuery(this).next().attr("value","" );

			}); 				
		}
	}
		    
	});
	
	/////cloning the radio, checkbox fields/////
	/*$cln.find("input[type='radio'], input[type='checkbox']").each(function(i){
		//jQuery(this).attr("value","");
		jQuery(this).removeAttr("checked");
	});*/	
	

	/////cloning the textarea fields/////
	$cln.find("textarea").each(function(i){
//		jQuery(this).value("");
	});	
	
	
	/////cloning the remove fields/////
	if($cln.find("#add_more_remove").is("input"))
	{
		//$cln.find("#add_more_remove").attr("value","Delete");//working
		$cln.find("#add_more_remove").off("click");
		$cln.find("#add_more_remove").on("click",function(){
            remove_addmore(new_id,jq_id_part);
            return false;
        });
	}
	else if($cln.find("#add_more_remove").is("a"))
	{
        $cln.find("#add_more_remove").off("click");
        $cln.find("#add_more_remove").on("click",function(){
            remove_addmore(new_id,jq_id_part);
            return false;
        });        
	}
	//console.log($cln.find("#add_more_remove").is("input"));
	////appending new row///
	//console.log($cln.html());
	jQuery("[id^='"+jq_id_part+"']:last").after($cln);
	

	//console.log($cln);
	
    /**
     * addmore callback,
     * It may be required to call some 
     * process like js function after adding 
     * a row.
     */
     add_more_after_add_callback($cln);

}
function remove_addmore(jq_id,jq_id_part)
{
	var $addmore_obj=jQuery(jq_id);
	//console.log(jq_id+"::"+jq_id_part);
    /**
    * Remove row callback,
    * After removing the row
    * we can also able to perform additional 
    * callbacks.
    * we need to call it here because, later it is going to be removed
    */
    add_more_remove_callback(jQuery("#"+jq_id));    
    
    
	if(jQuery("[id^='"+jq_id_part+"']").length > 1) {
			jQuery("#"+jq_id).remove();
	}  else {
	
			jQuery("#"+jq_id).find("input").each(function(i){
				if( ! $(this).is("#add_more_remove") )
					$(this).attr("value","");
			});
			/////cloning the select fields/////
			jQuery("#"+jq_id).find("select").each(function(i){
				$(this).find("option:first").attr("selected","selected");
			});	
			
			/////cloning the textarea fields/////
			jQuery("#"+jq_id).find("textarea").each(function(i){
				$(this).find("textarea").text("");
			});	
	}
    
    /**
    * This is a stand alone callback function.
    * We may use it to trigger some process 
    * imediately after the row is removed.
    * So, we do not need the removed row any more.
    * @see, views/admin/order/insert_order_byphone.tpl.php
    */
    add_more_after_remove_callback();
    
}
