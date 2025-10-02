/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $("#formcontactgroup").validationEngine();
});

$(document).ready(function(){
    $("#formcontactgroup1").validationEngine();
});

$(document).ready(function(){
    $("#formcontactgroup2").validationEngine();
});

$(document).ready(function(){
//allfromgroupsales contactsofsales
            $("#allfromgroupsales").hide();
            $("#contactsofsales").hide();
            $("#individual").hide();
            $("#industri").hide();

    $("#all").change(function(){
        var ischecked = $(this).attr('checked');
        if(ischecked){
            $("#individual").hide("slow");
            $("#industri").hide("slow");
            $("#allfromgroupsales").show("slow");
            $("#contactsofsales").hide("slow");
        }
    })

    $("#mycontacts").change(function(){
        var ischecked = $(this).attr('checked');
        if(ischecked){
            $("#individual").hide("slow");
            $("#industri").hide("slow");
            $("#allfromgroupsales").hide("slow");
            $("#contactsofsales").show("slow");
        }
    })

    $("#distindiv").change(function(){
        var ischecked = $(this).attr('checked');
        if(ischecked){
            $("#individual").show("slow");
            $("#industri").hide("slow");
            $("#allfromgroupsales").hide("slow");
            $("#contactsofsales").hide("slow");
        }
    })

    $("#distindus").change(function(){
        var ischecked = $(this).attr('checked');
        if(ischecked){
            $("#individual").hide("slow");
            $("#industri").show("slow");
            $("#allfromgroupsales").hide("slow");
            $("#contactsofsales").hide("slow");
        }
    })

});

//typedist

$(document).ready(function(){
    $("#btnClear").click(function(){
        $("#namecontact").val('');
    })
})

// check all
$(document).ready(function(){
        
	$('.checkall').click(function () {
		//$(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
                $("INPUT[type='checkbox']").attr('checked', $('.checkall').is(':checked'));
	});
});