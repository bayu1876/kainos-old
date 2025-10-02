<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
         <script type="text/javascript">
         $(document).ready(function() {
            //$("#container_remarkforecast").hide();

            $("#form_editforecast_remark").submit(function(){
               
                var id = $("#roomforecastremarkid").val();
                var monthroomforecast = $("#month").val();
                var yearroomforecast = $("#year").val();
                var remark = $("#remark_forecast").val();

                // if not, set current date
                if(monthroomforecast == '' && yearroomforecast == '') {
                    var d = new Date();
                    monthroomforecast = d.getMonth()+1;
                    yearroomforecast = d.getFullYear();
                }

                $.ajax({
                    type:"POST",
                    url: site_url+"room_forecast/edit_roomforecast_remark",
                    data:({id:id,remark:remark,monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
                    success: function(data){
                        $("#container_remarkforecast_alert").html(data);
                    },
                    beforeSend: function(){
                        $("#container_remarkforecast_alert").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                    }
                });
                return false;
            })


            $("#form_newforecast_remark").submit(function(){

                var monthroomforecast = $("#month").val();
                var yearroomforecast = $("#year").val();
                var remark = $("#remark_forecast").val();

                // if not, set current date
                if(monthroomforecast == '' && yearroomforecast == '') {
                    var d = new Date();
                    monthroomforecast = d.getMonth()+1;
                    yearroomforecast = d.getFullYear();
                }

                $.ajax({
                    type:"POST",
                    url: site_url+"room_forecast/new_roomforecast_remark",
                    data:({remark:remark,monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
                    success: function(data){
                        //$("#container_remarkforecast").hide();
                        $("#container_remarkforecast_alert").html(data);
                    },
                    beforeSend: function(){
                        $("#container_remarkforecast_alert").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                    }
                });

                $.ajax({
                        type:"POST",
                        url: site_url+"room_forecast/load_roomforecastremark_filter",
                        cache: true,
                        data:({monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
                        success: function(data){
                            $("#container_remarkforecast").html(data);
                        },
                        beforeSend: function(){
                            $("#container_remarkforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                        }
                });

                return false;
            })


         });
          
         </script>
    </head>
    <body>
        <b>Remark</b>
        <?php 
        if(empty($dt_forecastremark->roomforecastremarkid)){
        ?>
        <form action="" method="post" id="form_newforecast_remark" >
        <table width="100%" border="1" class="dashboard">
            <tr>
                <td class="kolom"><textarea rows="5" cols="250" name="remark_forecast" id="remark_forecast" style="width: 920px"></textarea>
                <br/><input type="submit" value="Submit" id="btnSubmit"/>
                <td/>
            <tr/>
        </table>
        </form>
        <?php
        } else{
        ?>
        <form action="" method="post" id="form_editforecast_remark" >
        <table width="100%" border="1" class="dashboard">
            <tr>
                <td class="kolom"><textarea rows="5" cols="250" name="remark_forecast" id="remark_forecast" style="width: 920px"><?=$dt_forecastremark->remark?></textarea>
                <br/><input type="hidden" value="<?= $dt_forecastremark->roomforecastremarkid?>" id="roomforecastremarkid"/>
                <input type="submit" value="Submit" id="btnSubmit"/>
                <td/>
            </tr>
        </table>
        </form>
        <?php }?>
    </body>
</html>
