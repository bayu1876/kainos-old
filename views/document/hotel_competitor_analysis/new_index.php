<html>
    <head>
        <?= $this->load->view('title');?>
        <?= $this->load->view('main_link'); ?>
       <link rel="stylesheet" href="<?php echo base_url() ?>css/tab.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?= base_url(); ?>css/validator/validationEngine.jquery.css" type="text/css"  />
        <link rel="stylesheet" href="<?= base_url(); ?>css/ui-lightness/jquery-ui-1.8.5.custom.css" type="text/css"  />

        <script type="text/javascript" src="<?php echo base_url() ?>js/validator/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validator/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.5.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jHotelCompetitorAnalysis.js"></script>
        <script type="text/javascript" src="<?= base_url();?>/assets/js/json/json2.js"></script>
        <script type="text/javascript" src="<?= base_url();?>/assets/js/swfobject.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                function findSWF(movieName) {
                    if (navigator.appName.indexOf("Microsoft")!= -1) {
                        return window[movieName];
                    } else {
                        return document[movieName];
                    }
                }

                 swfobject.embedSWF(
                "<?= base_url(); ?>/assets/swf/open-flash-chart.swf", "grafik_occ_se",
                "100%", "35%",
                "9.0.0", "expressInstall.swf",
                {"data-file":"<?= urlencode(site_url('hotel_competitor_analysis/chart_analysis_occ_from_to/33')) ?>","loading":"loading..."},{wmode:"opaque"}
                );

                swfobject.embedSWF(
                "<?= base_url(); ?>/assets/swf/open-flash-chart.swf", "grafik_arr_se",
                "100%", "35%",
                "9.0.0", "expressInstall.swf",
                {"data-file":"<?= urlencode(site_url('hotel_competitor_analysis/chart_analysis_arr_from_to/33')) ?>","loading":"loading..."},{wmode:"opaque"}
                );

                swfobject.embedSWF(
                "<?= base_url(); ?>/assets/swf/open-flash-chart.swf", "grafik_revpar_se",
                "100%", "35%",
                "9.0.0", "expressInstall.swf",
                {"data-file":"<?= urlencode(site_url('hotel_competitor_analysis/chart_analysis_revpar_from_to/33')) ?>","loading":"loading..."},{wmode:"opaque"}
                );


                 var datese = $( "#fromse, #tose" ).datepicker({
                    //defaultDate: "+1w",
                    changeMonth: false,
                    dateFormat: 'dd-mm-yy',
                    onSelect: function( selectedDate ) {
                        var option = this.id == "fromse" ? "minDate" : "maxDate",instance = $( this ).data( "datepicker" );
                        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate , instance.settings );
                        datese.not( this ).datepicker( "option", option, date );
                    },
                    onClose:function(dateText, inst) {
                        //                            $.validationEngine.closePrompt('#checkin');
                        //                            $.validationEngine.closePrompt('#checkout');
                    }
                });


             


                var datetop = $( "#fromtop, #totop" ).datepicker({
                    //defaultDate: "+1w",
                    changeMonth: false,
                    dateFormat: 'dd-mm-yy',
                    onSelect: function( selectedDate ) {
                        var option = this.id == "fromtop" ? "minDate" : "maxDate",instance = $( this ).data( "datepicker" );
                        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate , instance.settings );
                        datetop.not( this ).datepicker( "option", option, date );
                    },
                    onClose:function(dateText, inst) {
                        //                            $.validationEngine.closePrompt('#checkin');
                        //                            $.validationEngine.closePrompt('#checkout');
                    }
                });


                var datetopkagum = $( "#fromtopkagum, #totopkagum" ).datepicker({
                    //defaultDate: "+1w",
                    changeMonth: false,
                    dateFormat: 'dd-mm-yy',
                    onSelect: function( selectedDate ) {
                        var option = this.id == "fromtopkagum" ? "minDate" : "maxDate",instance = $( this ).data( "datepicker" );
                        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate , instance.settings );
                        datetopkagum.not( this ).datepicker( "option", option, date );
                    },
                    onClose:function(dateText, inst) {
                        //                            $.validationEngine.closePrompt('#checkin');
                        //                            $.validationEngine.closePrompt('#checkout');
                    }
                });



                $("#btntop").click(function(){
                    var from = $("#fromtop").val();
                    var to = $("#totop").val();
                  $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/get_top_market_group_bandung",
                        data:({from:from,to:to}),
                        dataType:'html',
                        success: function(data){
                            $("#divtopmarketgroupbandung").html(data);
                        },
                        beforeSend: function(){
                            $("#divtopmarketgroupbandung").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                })




                $("#btntopkagum").click(function(){
                    var from = $("#fromtopkagum").val();
                    var to = $("#totopkagum").val();
                  $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/get_top_market_group_kagum",
                        data:({from:from,to:to}),
                        dataType:'html',
                        success: function(data){
                            $("#divtopmarketgroupkagum").html(data);
                        },
                        beforeSend: function(){
                            $("#divtopmarketgroupkagum").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                })



                
                $( "#tabs_chart" ).tabs({ selected:0 ,  spinner: 'Retrieving data...',cache: false,
                    select: function(event, ui) {
                        var from = $("#fromdefault").val();
                        var to = $("#todefault").val();
                        
                        var t =  ui.index ;
                        var idrefhotelcompetitor  = 33;
                    
                        if(t == 0){//serela selected
                            idrefhotelcompetitor  = 33;//sunan hotel
                            $("#fromse").val('');
                            $("#tose").val('');
                            swfobject.embedSWF(
                            "<?= base_url(); ?>/assets/swf/open-flash-chart.swf", "grafik_occ_se",
                            "100%", "35%",
                            "9.0.0", "expressInstall.swf",
                            {"data-file":"<?= urlencode(site_url('hotel_competitor_analysis/chart_analysis_occ_from_to/33')) ?>","loading":"loading..."},{wmode:"opaque"}
                            );
                            $.ajax({
                                type:"POST",
                                url: site_url+"hotel_competitor_analysis/table_analysis_occ_from_to/"+idrefhotelcompetitor,
                                data:({from:from,to:to}),
                                dataType:'html',
                                success: function(data){
                                    $("#divoccse").html(data);
                                },
                                beforeSend: function(){
                                    $("#divoccse").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                                }
                            });

                            swfobject.embedSWF(
                            "<?= base_url(); ?>/assets/swf/open-flash-chart.swf", "grafik_arr_se",
                            "100%", "35%",
                            "9.0.0", "expressInstall.swf",
                            {"data-file":"<?= urlencode(site_url('hotel_competitor_analysis/chart_analysis_arr_from_to/33')) ?>","loading":"loading..."},{wmode:"opaque"}
                            ); 

                            $.ajax({
                                type:"POST",
                                url: site_url+"hotel_competitor_analysis/table_analysis_arr_from_to/"+idrefhotelcompetitor,
                                data:({from:from,to:to}),
                                dataType:'html',
                                success: function(data){
                                    $("#divarrse").html(data);
                                },
                                beforeSend: function(){
                                    $("#divarrse").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                                }
                            });

                            swfobject.embedSWF(
                            "<?= base_url(); ?>/assets/swf/open-flash-chart.swf", "grafik_revpar_se",
                            "100%", "35%",
                            "9.0.0", "expressInstall.swf",
                            {"data-file":"<?= urlencode(site_url('hotel_competitor_analysis/chart_analysis_revpar_from_to/33')) ?>","loading":"loading..."},{wmode:"opaque"}
                            ); 

                            $.ajax({
                                type:"POST",
                                url: site_url+"hotel_competitor_analysis/table_analysis_revpar_from_to/"+idrefhotelcompetitor,
                                data:({from:from,to:to}),
                                dataType:'html',
                                success: function(data){
                                    $("#divrevparse").html(data);
                                },
                                beforeSend: function(){
                                    $("#divrevparse").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                                }
                            });
                            //end serela
                        } 
                       
                        
                    }
                });
                
                
                $("#btngo_se").click(function(){
                    var from = $("#fromse").val();
                    var to = $("#tose").val();
                    var divgraphoccserela = findSWF("grafik_occ_se");
                    var divgrapharrserela = findSWF("grafik_arr_se");
                    var divgraphrevparserela = findSWF("grafik_revpar_se");
                    var idrefhotelcompetitor  = 33;//serela
                    
                    $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/chart_analysis_occ_from_to/"+idrefhotelcompetitor,
                        data:({from:from,to:to}),
                        dataType:'json',
                        success: function(data){
                            divgraphoccserela.load( JSON.stringify(data) );
                        },
                        beforeSend: function(){
                            $("#grafik_occ_se").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/table_analysis_occ_from_to/"+idrefhotelcompetitor,
                        data:({from:from,to:to}),
                        dataType:'html',
                        success: function(data){
                            $("#divoccse").html(data);
                        },
                        beforeSend: function(){
                            $("#divoccse").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/chart_analysis_arr_from_to/"+idrefhotelcompetitor,
                        data:({from:from,to:to}),
                        dataType:'json',
                        success: function(data){
                            divgrapharrserela.load( JSON.stringify(data) );
                        },
                        beforeSend: function(){
                            $("#grafik_arr_se").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/table_analysis_arr_from_to/"+idrefhotelcompetitor,
                        data:({from:from,to:to}),
                        dataType:'html',
                        success: function(data){
                            $("#divarrse").html(data);
                        },
                        beforeSend: function(){
                            $("#divarrse").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/chart_analysis_revpar_from_to/"+idrefhotelcompetitor,
                        data:({from:from,to:to}),
                        dataType:'json',
                        success: function(data){
                            divgraphrevparserela.load( JSON.stringify(data) );
                        },
                        beforeSend: function(){
                            $("#grafik_revpar_se").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    $.ajax({
                        type:"POST",
                        url: site_url+"hotel_competitor_analysis/table_analysis_revpar_from_to/"+idrefhotelcompetitor,
                        data:({from:from,to:to}),
                        dataType:'html',
                        success: function(data){
                            $("#divrevparse").html(data);
                        },
                        beforeSend: function(){
                            $("#divrevparse").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    return false;
                })


                   
            })
        </script>
        <style type="text/css">
            .kolompadding{
                padding-top: 5px;
                padding-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <?= $this->load->view('main_header'); ?>
        
         <div class="content_wrap">
               
            <div class="box">
                <!-- Start Content Box -->
                <div class="content-box" style="width: 1250px">
                    <div class="content-box-header">
                       <h3>Hotel Competitor Analysis </h3>
                        <ul class="content-box-tabs">
                            <li><a href="#tab9">View Chart</a></li>
                            <li><a href="#tab1" class="default-tab">View Data</a></li> <!-- href must be unique and match the id of target div -->
                            <?php
                            $seriticolor = "#ccffff";
                            $serelacolor = "#00ccff";
                            $bananacolor = "#00ff00";
                            $goldencolor = "#ffcc00";
                            $carrcadincolor = "#ffcccc";
                            //Keterangan
                            //idjabatan 9 = FO Manager
                            //idjabatan 36 = Managing Director
                            //End Keterangan
                          ?>
                            <li><a href="#tab2">Add Data</a></li>
                            <!--<li><a href="#tab8">Add Data Per Hotel</a></li>-->
                            <li><a href="#tab3">Add Init. Bal.</a></li>
                            <li><a href="#tab4">Add Group</a></li>
                            <li><a href="#tab5">Add Target Prop.</a></li>
                            <li><a href="#tab6">View Target Prop.</a></li>
                            <li><a href="#tab7">Add Forecast</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content" id="tab9">
                          <div id="tabs_chart" >
                          <ul>
                              <li><a href="#tabs-1">Sunan Hotel</a></li>
                              <li><a href="#tabs-6">Top Market Group Solo</a></li>
                              <li><a href="#tabs-7">Market Group Sunan Hotel</a></li>
                          </ul>
                              <div id="tabs-1">
                                  Showing data from <input type="text" id="fromse" size="10"/> to <input type="text" id="tose"  size="10"/> <input type="submit" value="GO" id="btngo_se"/>
                                  <br/><br/>
                                  <div id="grafik_occ_se">
                                  </div>
                                  <br/><br/><br/>
                                  <div id="divoccse">
                                      <table style="border:1px solid black;width: 100%" >
                                          <tr>
                                              <td style="width: 100px">
                                              </td>
                                              <?php $idrefhotel_serela = 33; ?>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                      <?php
                                                      $day = date('D ', strtotime(date('0-m-Y') . "+$i day"));
                                                      if ($i == date('d')) {
                                                          echo '<b>' . $day . '</b>';
                                                      } else {
                                                          echo $day;
                                                      }
                                                      ?>
                                                  </td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black" ><!-- Occupancy(%) -->
                                              <td style="border:1px solid black;width: 100px" rowspan="2"><b>Occupancy(%)</b></td>
                                              <td colspan="<?= date('t') ?>">
                                                <?= date('F'); ?>
                                              </td>
                                          </tr>
                                          <tr>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                      <?php
                                                      if ($i == date('d')) {
                                                          echo '<b>' . $i . '</b>';
                                                      } else {
                                                          echo $i;
                                                      }
                                                      ?>
                                                  </td>
                                                  <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">My Property</td>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">   
                                                      <?php
                                                      $occ = $this->hca->get_occ_hotel_per_day($idrefhotel_serela, date("Y-m-$i"));
                                                      echo number_format($occ, 2, ',', '');
                                                      ?>
                                                  </td>
                                                    <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set</td>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                      <?php
                                                      $occcompset = $this->hca->get_occ_comp3stars_set_per_day(date("Y-m-$i"));
                                                      echo number_format($occcompset, 2, ',', '');
                                                      ?>
                                                  </td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">SubMarket Class</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr >
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set Rank</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr>
                                              <td colspan="<?= date('t') + 1 ?>">
                                                  &nbsp;<!-- spacer -->
                                              </td>
                                          </tr>
                                          <tr style="border:1px solid black"><!-- Occ % Chg -->
                                              <td style=" width: 100px"><b>Occ % Chg</b></td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">My Property</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">   </td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">SubMarket Class</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr >
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set Rank</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr>
                                              <td colspan="<?= date('t') + 1 ?>">
                                                  &nbsp;
                                              </td>
                                          </tr>
                                          <tr style="border:1px solid black"><!-- Occ Index -->
                                              <td style=" width: 100px"><b>Occ Index</b></td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black; ">
                                              <td style="border:1px solid black;width: 100px">Index (Comp Set)</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Index % Change</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                      </table>
                                  </div>
                                  <br/>
                                  <div id="grafik_arr_se">
                                  </div>
                                  <br/><br/><br/>
                                  <div id="divarrse">
                                      <table style="border:1px solid black;width: 100%" >
                                          <tr>
                                              <td></td>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                      <?php
                                                      $day = date('D ', strtotime(date('0-m-Y') . "+$i day"));
                                                      if ($i == date('d')) {
                                                          echo '<b>' . $day . '</b>';
                                                      } else {
                                                          echo $day;
                                                      }
                                                      ?>
                                                  </td>
                                                  <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black" ><!-- ARR -->
                                              <td style="border:1px solid black;width: 100px" rowspan="2"><b>ARR</b></td>
                                              <td>
                                              <?= date('F'); ?>
                                              </td>
                                          </tr>
                                          <tr>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                      <?php
                                                      if ($i == date('d')) {
                                                          echo '<b>' . $i . '</b>';
                                                      } else {
                                                          echo $i;
                                                      }
                                                      ?>
                                                  </td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">My Property</td>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">   
                                                  <?php
                                                  $arr = $this->hca->get_arr_hotel_per_day($idrefhotel_serela, date("Y-m-$i"));
                                                  echo number_format($arr, 0, ',', ',');
                                                  ?>
                                                  </td>
                                                  <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">   
                                                    <?php
                                                    $compset_arr = $this->hca->get_arr_comp3stars_set_per_day(date("Y-m-$i"));
                                                    echo number_format($compset_arr, 0, ',', ',');
                                                    ?>
                                                  </td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">SubMarket Class</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr >
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set Rank</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr>
                                              <td colspan="<?= date('t') + 1 ?>">
                                                  &nbsp;
                                              </td>
                                          </tr>
                                          <tr style="border:1px solid black"><!-- ADR % Chg -->
                                              <td style=" width: 100px"><b>ADR % Chg</b></td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">My Property</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">   </td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">SubMarket Class</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr >
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set Rank</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr>
                                              <td colspan="<?= date('t') + 1 ?>">
                                                  &nbsp;
                                              </td>
                                          </tr>
                                          <tr style="border:1px solid black"><!-- ADR Index -->
                                              <td style=" width: 100px"><b>ADR Index</b></td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black; ">
                                              <td style="border:1px solid black;width: 100px">Index (Comp Set)</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Index % Change</td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                      </table>
                                  </div>
                                  <br/>
                                  <div id="grafik_revpar_se">
                                  </div>
                                  <br/><br/><br/>
                                  <div id="divrevparse"  >
                                      <table style="border:1px solid black;width: 100%" >
                                          <tr>
                                              <td></td>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                      <?php
                                                      $day = date('D ', strtotime(date('0-m-Y') . "+$i day"));
                                                      if ($i == date('d')) {
                                                          echo '<b>' . $day . '</b>';
                                                      } else {
                                                          echo $day;
                                                      }
                                                      ?>
                                                  </td>
                                                  <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black" ><!-- RevPAR -->
                                              <td style="border:1px solid black;width: 100px" rowspan="2"><b>RevPAR</b></td>
                                              <td>
                                                  <?= date('F'); ?>
                                              </td>
                                          </tr>
                                          <tr>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">
                                                  <?php
                                                  if ($i == date('d')) {
                                                      echo '<b>' . $i . '</b>';
                                                  } else {
                                                      echo $i;
                                                  }
                                                  ?>
                                                  </td>
                                                  <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">My Property</td>
                                                  <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center;font-size: 7pt">   
                                                  <?php
                                                  $trr = $this->hca->get_revpar_hotel_per_day($idrefhotel_serela, date("Y-m-$i"));
                                                  echo number_format($trr, 0, ',', '.');
                                                  ?>
                                                  </td>
                                                  <?php }// ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center;font-size: 7pt">   
                                                  <?php
                                                  $totaltrr = $this->hca->get_revpar_comp3stars_set_per_day(date("Y-m-$i"));
                                                  echo number_format($totaltrr, 0, ',', '.');
                                                  ?>
                                                  </td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">SubMarket Class</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr >
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set Rank</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr>
                                          <tr>
                                              <td colspan="<?= date('t') + 1 ?>">
                                                  &nbsp;
                                              </td>
                                          </tr>
                                          <tr style="border:1px solid black"><!-- RevPAR % Chg -->
                                              <td style=" width: 100px"><b>RevPAR % Chg</b></td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">My Property</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center">   </td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black">
                                              <td style="border:1px solid black;width: 100px">SubMarket Class</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr >
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Comp Set Rank</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }// ?>
                                          </tr>
                                          <tr>
                                              <td colspan="<?= date('t') + 1 ?>">
                                                  &nbsp;
                                              </td>
                                          </tr>
                                          <tr style="border:1px solid black"><!-- RevPAR Index -->
                                              <td style=" width: 100px"><b>RevPAR Index</b></td>
                                                <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                                <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black; ">
                                              <td style="border:1px solid black;width: 100px">Index (Comp Set)</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                          <tr style="border:1px solid black;background-color: #dff8fc">
                                              <td style="border:1px solid black;width: 100px">Index % Change</td>
                                              <?php for ($i = 1; $i <= date('t'); $i++) { ?>
                                                  <td style=" width: 20px;text-align: center"></td>
                                              <?php }//  ?>
                                          </tr>
                                      </table>
                                  </div><!-- END Serela -->
                              </div>
                     
                              <div id="tabs-6">
                                  Showing data from <input type="text" size="10" name="fromtop" id="fromtop"/> to <input type="text" size="10" name="totop" id="totop"/> <input type="submit" value="GO" id="btntop"/>
                                  <div id="divtopmarketgroupbandung">
                                      
                                  </div>
                              </div>
                              <div id="tabs-7">
                                   Showing data from <input type="text" size="10" name="fromtopkagum" id="fromtopkagum"/> to <input type="text" size="10" name="totopkagum" id="totopkagum"/> <input type="submit" value="GO" id="btntopkagum"/>
                                  <div id="divtopmarketgroupkagum">
                                      
                                  </div>
                              </div>
                      </div>
                            
                        </div> <!-- #tab9 -->
                     
                        <div class="tab-content" id="tab8">
                            <?= form_open('hotel_competitor_analysis/add_hotelcompanalysis_perhotel','id="formadd_hotelcompanalysis_perhotel"');?>
                            <table class="dashboard">
                                <tr>
                                    <td class="kolom10">Date</td>
                                    <td><input type="text" name="dateperhotel" value="" id="dateperhotel" class="validate[required]"/></td>
                                </tr>
                                <tr  style="margin-bottom: 5px">
                                    <td>Hotel Competitor</td>
                                    <td>
                                        <?php
                                            foreach($dt_hotelcompetitor AS $rowhc)
                                            {
                                                $opt_hotel[$rowhc->idhotelcompetitor] = $rowhc->hotelcompetitor_name;
                                            }
                                            echo form_dropdown('hotelcompperhotel',$opt_hotel,'','id="hotelcompperhotel"');
                                        ?>
                                    </td>
                                </tr>
                                <tr  style="margin-bottom: 5px">
                                    <td>Room Sold</td>
                                    <td><input type="text" name="roomsoldperhotel" id="roomsoldperhotel" class="validate[required,custom[onlyNumber]]"/></td>
                                </tr>
                                <tr  style="margin-bottom: 5px">
                                    <td>Average Room Rate</td>
                                    <td><input type="text" name="arrperhotel" id="arrperhotel" class="validate[required,custom[onlyNumber]]"/></td>
                                </tr>
                                <tr  style="margin-bottom: 5px">
                                    <td>Group Last Night</td>
                                    <td>
                                        <input type="hidden" value="" id="idaccountperhotel1" class="idaccountperhotel" size="5px"/>
                                        <input type="text" value="" id="accountperhotel1" class="accountperhotel1" title="type group's name here" size="30px"/>
                                        <div id="containergroupperhotel1" class="containergroupperhotel1">
                                            <input type="hidden"  id="totalitemperhotel1" value="0" size="3"/>
                                            <ul></ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" value="Submit"/></td>
                                </tr>
                            </table>
                            <?= form_close();?>
                        </div>
                       
                        <div class="tab-content default-tab" id="tab1">
                            <div id="datahca">
                                <?= form_open('hotel_competitor_analysis/generate_pdf_analysis');?>
                                <table style="font-size: 7pt">
                                    <tr>
                                        <td style="text-align: right">TODAY</td>
                                        <td>&nbsp;&nbsp;<?= date('D, d F Y')?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">END OF MONTH</td>
                                        <td>&nbsp;&nbsp;<?= date('D, d F Y', mktime(0, 0, 0, (date('m') + 1), 0, date('Y')));?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">DAYS LEFT </td>
                                        <td>&nbsp;&nbsp;<?= date('t') - date('d');?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">SHOWING DATA PER</td>
                                        <td>&nbsp;&nbsp;<input type="text" id="tglhca" name="tglhca" size="10" style="height: 16px"/> <input type="submit" name="printall" value="Print ALL" id="btnSubmit1" style="height: 20px" /> <input type="submit" name="printytd" value="Print YTD" id="btnSubmit2" style="height: 20px" /> <input type="submit" name="printmtd" value="Print MTD" id="btnSubmit3" style="height: 20px" /></td>
                                    </tr>
                                </table>
                                <br/>
                                <?= form_close()?>
                                <div id="containerdata" style="width: 100%; height: 100%; overflow: scroll;  scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">
                                <table class="dashboard" width="100%" style="font-size: 7pt">
                                    <tr>
                                        <td class="kolom" rowspan="2" style="vertical-align: middle;text-align: center"><b>Hotel Name</b></td>
                                        <td class="kolom" rowspan="2" style="vertical-align: middle; text-align: center"><b>R. Inv.</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Room Sold</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>OCCUPANCY</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>ARR</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Total Room Revenue</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Fair Market Share</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Actual Market Share</b></td>
                                        <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>MPI</b></td>
                                        <td class="kolom" rowspan="2" style="vertical-align: middle;text-align: center"><b>GROUP LAST NIGHT </b></td>
                                    </tr>
                                    <tr>
                                        <td class="kolom" title="Today">Today</td>
                                        <td class="kolom" title="Month to Date">MTD</td>
                                        <td class="kolom" title="Year to Date">YTD</td>
                                        <!-- End Room Sold-->
                                        <td class="kolom" title="Today">Today(%)</td>
                                        <td class="kolom" title="Month to Date">MTD(%)</td>
                                        <td class="kolom" title="Year to Date">YTD(%)</td>
                                        <!-- End Occupancy -->
                                        <td class="kolom" title="Today">Today</td>
                                        <td class="kolom" title="Month to Date">MTD</td>
                                        <td class="kolom" title="Year to Date">YTD</td>
                                        <!-- End ARR -->
                                        <td class="kolom" title="Today">Today</td>
                                        <td class="kolom" title="Month to Date">MTD</td>
                                        <td class="kolom" title="Year to Date">YTD</td>
                                        <!-- End Total Room Revenue -->
                                        <td class="kolom" title="Today">Today</td>
                                        <td class="kolom" title="Month to Date">MTD</td>
                                        <td class="kolom" title="Year to Date">YTD</td>
                                        <!-- End Fair Market Share-->
                                        <td class="kolom" title="Today">Today</td>
                                        <td class="kolom" title="Month to Date">MTD</td>
                                        <td class="kolom" title="Year to Date">YTD</td>
                                        <!-- End Actual Market Share -->
                                        <td class="kolom" title="Today">Today</td>
                                        <td class="kolom" title="Month to Date">MTD</td>
                                        <td class="kolom" title="Year to Date">YTD</td>
                                        <!-- End MPI -->
                                    </tr>
                                    <?php if($dt_hotelcomp4allproperty != NULL){?>
                                    <tr>
                                        <td colspan="23" style="text-align: left"><b>4 STARS HOTEL ****</b></td>
                                    </tr>
                                    <?php }//endif 4stars ?>
                                    <?php

                                    $oddrow = 0;
                                    $total_arr_today = 0;
                                    $total_arr_mtd = 0;
                                    $total_arr_ytd = 0;

                                    $total_ri_today = 0;
                                    $total_ri_mtd = 0;
                                    $total_ri_ytd = 0;
                                    $total_rs_today = 0;
                                    $total_rs_mtd = 0;
                                    $total_rs_ytd = 0;

                                    $total_occ_today = 0;
                                    $total_occ_mtd = 0;
                                    $total_occ_ytd = 0;

                                    $total_trr_today = 0;
                                    $total_trr_mtd = 0;
                                    $total_trr_ytd = 0;

                                    $total_fms_today = 0;
                                    $total_fms_mtd = 0;
                                    $total_fms_ytd = 0;

                                    $total_ams_today = 0;
                                    $total_ams_mtd = 0;
                                    $total_ams_ytd = 0;

                                    $total_mpi_today = 0;
                                    $total_mpi_mtd = 0;
                                    $total_mpi_ytd = 0;

                                    foreach($dt_hotelcomp4allproperty AS $rowhtl)
                                    {
                                        /////////////////////////////
                                        $ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
                                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;
                                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                                        /////////////////////////////

                                        $initbalroomsold_mtd = 0;$initbalroomsold_ytd = 0;
                                        $initbaltrr_mtd = 0;$initbaltrr_ytd = 0;
                                        $initbaldate = 0;

                                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel(date('m'),$rowhtl->idhotelcompetitor);
                                        if($dt_initbal != NULL)
                                        {
                                            $initbalroomsold_mtd = $dt_initbal->mtd_rs;
//                                            $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                            $initbaltrr_mtd = $dt_initbal->mtd_trr;
//                                            $initbaltrr_ytd = $dt_initbal->ytd_trr;
                                            $initbaldate = $dt_initbal->per_date;
                                        }

                                        $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_initbalytd != NULL)
                                        {
                                              $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                                              $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                                        }

                                        $rs_mtd += $initbalroomsold_mtd;
                                        $rs_ytd += $initbalroomsold_ytd;

                                        $ri_today = $rowhtl->room_inventory;
                                        $ri_mtd = $rowhtl->room_inventory * date('d');
                                        ///////////////////////////////////////////////////
                                        $openingdate = strtotime($rowhtl->opening_date);
                                        $hotelopendate = $rowhtl->opening_date;
                                        $now = strtotime(date('Y-01-01'));
                                        $is_opendt = false;
                                        if ($openingdate > $now) {
                                            $is_opendt = true;
                                            $startdate = strtotime($hotelopendate);
                                            $enddate = strtotime(date('Y-m-d'));
                                            $diff = $enddate - $startdate;
                                            $ttldays = round($diff / 86400) + 1;
                                        } else {
                                            $ttldays = (date('z') + 1);
                                        }
                                        if ($is_opendt) {
                                            $ri_ytd = ceil($rowhtl->room_inventory * $ttldays);
                                        } else {
                                            $ri_ytd = ceil($rowhtl->room_inventory * (date('z') + 1));
                                        }
                                        ///////////////////////////////////////////////////////

                                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysistoday_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_analystoday != NULL){
                                            $rs_today = $dt_analystoday->room_sold;
                                            $arr_today = $dt_analystoday->arr;
                                        }
                                        //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,date('Y-m-d'),$initbaldate);
                                        $startdate_mtd = date('Y-m-01');
                                        $enddate_mtd = date('Y-m-d');
                                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                                        if($dt_rsmtd != NULL)
                                        {
                                            $rs_mtd += $dt_rsmtd->RS_MTD;
                                        }

                                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldytd_wodateinitbal_perhotel($rowhtl->idhotelcompetitor,$initbaldate);
                                        $startdate_ytd = date('Y-01-01');
                                        $enddate_ytd = date('Y-m-d');

                                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);

                                        if($dt_rsytd != NULL)
                                        {
                                            $rs_ytd += $dt_rsytd->RS_YTD;
                                        }

                                        $trr_today = $rs_today * $arr_today;
                                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrmtd != NULL)
                                        {
                                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                                        }

                                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrytd != NULL)
                                        {
                                             $trr_ytd = $dt_trrytd->TRR_YTD;
                                        }
                                         $trr_ytd += $initbaltrr_ytd  ;

                                        if($rs_mtd != 0 ){
                                            $arr_mtd = $trr_mtd / $rs_mtd;
                                          
                                        }
                                        
                                        if($rs_ytd != 0){
                                              $arr_ytd = $trr_ytd /$rs_ytd;
                                        }

                                        $total_rs_today += $rs_today;
                                        $total_rs_mtd += $rs_mtd;
                                        $total_rs_ytd += $rs_ytd;

                                        $total_arr_today += $arr_today;
                                        $total_arr_mtd += $arr_mtd;
                                        $total_arr_ytd += $arr_ytd;

                                        $total_trr_today += $trr_today;
                                        $total_trr_mtd += $trr_mtd;
                                        $total_trr_ytd += $trr_ytd;

                                        $total_ri_today += $rowhtl->room_inventory;
                                        $total_ri_mtd += $rowhtl->room_inventory * date('d');
                                        $total_ri_ytd += $rowhtl->room_inventory * (date('z') + 1);
                                    }

                                    foreach($dt_hotelcomp4allproperty AS $rowhtl)
                                    {
                                        $oddrow++;
                                        /////////////////////////////
                                        $ri_today =0;$ri_mtd = 0;$ri_ytd = 0;
                                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;
                                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                                        /////////////////////////////

                                        $initbalroomsold_mtd = 0;$initbalroomsold_ytd = 0;
                                        $initbaltrr_mtd = 0;$initbaltrr_ytd = 0;
                                        $initbaldate = 0;

                                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel(date('m'),$rowhtl->idhotelcompetitor);
                                        if($dt_initbal != NULL)
                                        {
                                            $initbalroomsold_mtd = $dt_initbal->mtd_rs;
//                                            $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                            $initbaltrr_mtd = $dt_initbal->mtd_trr;
//                                            $initbaltrr_ytd = $dt_initbal->ytd_trr;
                                            $initbaldate = $dt_initbal->per_date;
                                        }
                                        $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_initbalytd != NULL)
                                        {
                                              $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                                              $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                                        }

                                        $rs_mtd += $initbalroomsold_mtd;
                                        $rs_ytd += $initbalroomsold_ytd;

                                        $ri_today = $rowhtl->room_inventory;
                                        $ri_mtd = $rowhtl->room_inventory * date('d');

                                        ///////////////////////////////////////////////////
                                        $openingdate = strtotime($rowhtl->opening_date);
                                        $hotelopendate = $rowhtl->opening_date;
                                        $now = strtotime(date('Y-01-01'));
                                        $is_opendt = false;
                                        if ($openingdate > $now) {
                                            $is_opendt = true;
                                            $startdate = strtotime($hotelopendate);
                                            $enddate = strtotime(date('Y-m-d'));
                                            $diff = $enddate - $startdate;
                                            $ttldays = round($diff / 86400) + 1;
                                        } else {
                                            $ttldays = (date('z') + 1);
                                        }
                                        if ($is_opendt) {
                                            $ri_ytd = ceil($rowhtl->room_inventory * $ttldays);
                                        } else {
                                            $ri_ytd = ceil($rowhtl->room_inventory * (date('z') + 1));
                                        }
                                        ///////////////////////////////////////////////////////

                                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysistoday_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_analystoday != NULL){
                                            $rs_today = $dt_analystoday->room_sold;
                                            $arr_today = $dt_analystoday->arr;
                                        }
                                        //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,date('Y-m-d'),$initbaldate);
                                        $startdate_mtd = date('Y-m-01');
                                        $enddate_mtd = date('Y-m-d');
                                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);

                                        if($dt_rsmtd != NULL)
                                        {
                                            $rs_mtd += $dt_rsmtd->RS_MTD;
                                        }

                                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldytd_wodateinitbal_perhotel($rowhtl->idhotelcompetitor,$initbaldate);
                                        $startdate_ytd = date('Y-01-01');
                                        $enddate_ytd = date('Y-m-d');
                                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                                        if($dt_rsytd != NULL)
                                        {
                                            $rs_ytd += $dt_rsytd->RS_YTD;
                                        }


                                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrmtd != NULL)
                                        {
                                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                                        }

                                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrytd != NULL)
                                        {
                                             $trr_ytd = $dt_trrytd->TRR_YTD;
                                        }
                                        $trr_today = $rs_today * $arr_today;
                                       // $trr_mtd += $initbaltrr_mtd + ($totaltrrtoday);
                                        $trr_ytd += $initbaltrr_ytd  ;

                                        if($rs_mtd != 0){
                                            $arr_mtd = $trr_mtd / $rs_mtd;
                                          
                                        }
                                        
                                        if($rs_ytd != 0)
                                        {
                                              $arr_ytd = $trr_ytd /$rs_ytd;
                                        }

                                        if($rs_today != 0 && $ri_today !=0){
                                            $occ_today = ($rs_today / $ri_today) * 100;
                                        }
                                        if($rs_mtd != 0 && $ri_mtd != 0)
                                        {
                                            $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                                        }
                                        if($rs_ytd != 0 && $ri_ytd != 0)
                                        {
                                            $occ_ytd = ($rs_ytd / $ri_ytd) * 100;
                                        }

                                        $fms_today = $ri_today/$total_ri_today;
                                        $fms_mtd = $ri_mtd/$total_ri_mtd;
                                        $fms_ytd = $ri_ytd/$total_ri_ytd;

                                        if($rs_today != 0 && $total_rs_today != 0){
                                            $ams_today = $rs_today / $total_rs_today;
                                        }
                                        if ($rs_mtd != 0 && $total_rs_mtd != 0) {
                                            $ams_mtd = $rs_mtd / $total_rs_mtd;
                                        }
                                        if ($rs_ytd != 0 && $total_rs_ytd != 0) {
                                            $ams_ytd = $rs_ytd / $total_rs_ytd;
                                        }
                                        if ($ams_today != 0 && $fms_today != 0) {
                                            $mpi_today = $ams_today / $fms_today;
                                        }
                                        if ($ams_mtd != 0 && $fms_mtd != 0) {
                                            $mpi_mtd = $ams_mtd / $fms_mtd;
                                        }
                                        if ($ams_ytd != 0 && $fms_ytd != 0) {
                                            $mpi_ytd = $ams_ytd / $fms_ytd;
                                        }


                                        $total_occ_today = ($total_rs_today / $total_ri_today) * 100;
                                        $total_occ_mtd = ($total_rs_mtd / $total_ri_mtd) * 100;
                                        $total_occ_ytd = ($total_rs_ytd / $total_ri_ytd) * 100;

                                        $total_fms_today += $fms_today;
                                        $total_fms_mtd += $fms_mtd;
                                        $total_fms_ytd += $fms_ytd;

                                        $total_ams_today += $ams_today;
                                        $total_ams_mtd += $ams_mtd;
                                        $total_ams_ytd += $ams_ytd;

                                        $total_mpi_today = $total_ams_today / $total_fms_today;
                                        $total_mpi_mtd = $total_ams_mtd / $total_fms_mtd;
                                        $total_mpi_ytd = $total_ams_ytd / $total_fms_ytd;

                                        if($total_trr_today != 0 || $total_rs_today != 0){
                                            $total_arr_today = $total_trr_today / $total_rs_today;
                                        }
                                        if($total_trr_mtd != 0 || $total_rs_mtd != 0){
                                            $total_arr_mtd = $total_trr_mtd  / $total_rs_mtd;
                                        }
                                        if($total_trr_ytd != 0 || $total_rs_ytd != 0){
                                            $total_arr_ytd = $total_trr_ytd / $total_rs_ytd;
                                        }

                                        ?>
                                        <?php
                                            if(($oddrow % 2) != 0){
                                                $class = "style='background-color: #dbeafd'";
                                            }else{
                                                $class = '';
                                            }
                                        ?>

                                           
                                            <?php  if (strtolower($rowhtl->hotelcompetitor_name) == "the sunan hotel solo"){ ?>
                                                <tr style="background-color: <?= $goldencolor?>">
                                            <?php //endif  ?>
                                          <?php }else  { ?>
                                                <tr>
                                            <?php }//endif  ?>

                                        <td class="kolom kolom10">
                                            <?= $rowhtl->hotelcompetitor_name;?>
                                        </td>
                                        <td class="kolom" style="text-align: center">
                                            <?= $rowhtl->room_inventory;?>
                                        </td>
                                        <td class="kolom" style="text-align: center" title="Today"><?= $rs_today ?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= $rs_mtd;?>  </td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= $rs_ytd?>  </td>
                                        <!-- End Room Sold-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($occ_today,1,',','.'); ?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($occ_mtd,1,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($occ_ytd,1,',','.');?></td>
                                        <!-- End Occupancy-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($arr_today,0,',',',')?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($arr_mtd,0,',',',');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($arr_ytd,0,',',',');?></td>
                                        <!-- End ARR-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($trr_today,0,',','.')?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($trr_mtd,0,',','.')?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($trr_ytd,0,',','.')?></td>
                                        <!-- End Total Room Revenue-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($fms_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($fms_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($fms_ytd,2,',','.');?></td>
                                        <!-- End Fair Market Share-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($ams_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($ams_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($ams_ytd,2,',','.');?></td>
                                        <!-- End Actual Market Share-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($mpi_today,3,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($mpi_mtd,3,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($mpi_ytd,3,',','.');?></td>
                                        <!-- End MPI -->
                                        <td class="kolom">
                                            <?php
                                                $dt_grouphotel = $this->hotel_competitor_analysis_model->select_grouptoday_perhotel($rowhtl->idhotelcompetitor);
                                                $row = 1;
                                                $ttlrowgh = $dt_grouphotel->num_rows();
                                                foreach($dt_grouphotel->result() AS $rowgh)
                                                {
                                                    $row++;
                                                    echo $rowgh->account_name .'(<span style="color:red">'.$rowgh->rno.'</span>)';
                                                    if($row < $ttlrowgh)
                                                    {
                                                        echo '<b>;</b> ';
                                                    }
                                                }
                                                ?>
                                        </td>
                                    </tr>
                                   <?php } ?>
                                   <tr>
                                        <td class="kolom" style="text-align: right"><b>Total</b></td>
                                        <td class="kolom" style="text-align: center"><?= $total_ri_today;?></td>
                                        <td class="kolom" style="text-align: center"><?= $total_rs_today;?></td>
                                        <td class="kolom" style="text-align: center"><?= $total_rs_mtd;?></td>
                                        <td class="kolom" style="text-align: center"><?= $total_rs_ytd;?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_occ_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_occ_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_occ_ytd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_arr_today,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_arr_mtd,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_arr_ytd,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_trr_today,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_trr_mtd,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_trr_ytd,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_fms_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_fms_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_fms_ytd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_ams_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_ams_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_ams_ytd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_mpi_today  ,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_mpi_mtd   ,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_mpi_ytd ,2,',','.');?></td>
                                        <td class="kolom"> </td>
                                    </tr>
                                   <?php if($dt_hotelcomp3allproperty  != NULL){?>
                                   <tr>
                                       <td colspan="23" style="text-align: left"><b>3 STARS HOTEL ***</b></td>
                                    </tr>
                                    <?php } ?>
                                    <?php
                                    $total_arr_today3 = 0;
                                    $total_arr_mtd3 = 0;
                                    $total_arr_ytd3 = 0;

                                    $total_ri_today3 = 0;
                                    $total_ri_mtd3 = 0;
                                    $total_ri_ytd3 = 0;
                                    $total_rs_today3 = 0;
                                    $total_rs_mtd3 = 0;
                                    $total_rs_ytd3 = 0;

                                    $total_occ_today3 = 0;
                                    $total_occ_mtd3 = 0;
                                    $total_occ_ytd3 = 0;

                                    $total_trr_today3 = 0;
                                    $total_trr_mtd3 = 0;
                                    $total_trr_ytd3 = 0;

                                    $total_fms_today3 = 0;
                                    $total_fms_mtd3 = 0;
                                    $total_fms_ytd3 = 0;

                                    $total_ams_today3 = 0;
                                    $total_ams_mtd3 = 0;
                                    $total_ams_ytd3 = 0;

                                    $total_mpi_today3 = 0;
                                    $total_mpi_mtd3 = 0;
                                    $total_mpi_ytd3 = 0;

                                   foreach($dt_hotelcomp3allproperty AS $rowhtl)
                                   {
                                        /////////////////////////////
                                        $ri_today =0;$ri_mtd = 0;$ri_ytd = 0;
                                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;
                                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                                        /////////////////////////////

                                        $initbalroomsold_mtd = 0;$initbalroomsold_ytd = 0;
                                        $initbaltrr_mtd = 0;$initbaltrr_ytd = 0;
                                        $initbaldate = 0;

                                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel(date('m'),$rowhtl->idhotelcompetitor);
                                        if($dt_initbal != NULL)
                                        {
                                            $initbalroomsold_mtd = $dt_initbal->mtd_rs;
//                                            $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                            $initbaltrr_mtd = $dt_initbal->mtd_trr;
//                                            $initbaltrr_ytd = $dt_initbal->ytd_trr;
                                            $initbaldate = $dt_initbal->per_date;
                                        }
                                        $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_initbalytd != NULL)
                                        {
                                              $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                                              $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                                        }

                                        $rs_mtd += $initbalroomsold_mtd;
                                        $rs_ytd += $initbalroomsold_ytd;

                                        $ri_today = $rowhtl->room_inventory;
                                        $ri_mtd = $rowhtl->room_inventory * date('d');
                                        ///////////////////////////////////////////////////
                                        $openingdate = strtotime($rowhtl->opening_date);
                                        $hotelopendate = $rowhtl->opening_date;
                                        $now = strtotime(date('Y-01-01'));
                                        $is_opendt = false;
                                        if ($openingdate > $now) {
                                            $is_opendt = true;
                                            $startdate = strtotime($hotelopendate);
                                            $enddate = strtotime(date('Y-m-d'));
                                            $diff = $enddate - $startdate;
                                            $ttldays = round($diff / 86400) + 1;
                                        } else {
                                            $ttldays = (date('z') + 1);
                                        }
                                        if ($is_opendt) {
                                            $ri_ytd = ceil($rowhtl->room_inventory * $ttldays);
                                        } else {
                                            $ri_ytd = ceil($rowhtl->room_inventory * (date('z') + 1));
                                        }
                                        ///////////////////////////////////////////////////////

                                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysistoday_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_analystoday != NULL){
                                            $rs_today = $dt_analystoday->room_sold;
                                            $arr_today = $dt_analystoday->arr;
                                        }
                                        //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,date('Y-m-d'),$initbaldate);
                                        $startdate_mtd = date('Y-m-01');
                                        $enddate_mtd = date('Y-m-d');
                                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);

                                        if($dt_rsmtd != NULL)
                                        {
                                            $rs_mtd += $dt_rsmtd->RS_MTD;
                                        }

                                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldytd_wodateinitbal_perhotel($rowhtl->idhotelcompetitor,$initbaldate);
                                       $startdate_ytd = date('Y-01-01');
                                        $enddate_ytd = date('Y-m-d');

                                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);

                                        if($dt_rsytd != NULL)
                                        {
                                            $rs_ytd += $dt_rsytd->RS_YTD;
                                        }

                                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrmtd != NULL)
                                        {
                                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                                        }

                                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrytd != NULL)
                                        {
                                             $trr_ytd = $dt_trrytd->TRR_YTD;
                                        }

                                        $trr_today = $rs_today * $arr_today;
                                      //  $trr_mtd += $initbaltrr_mtd + ($totaltrrtoday);
                                        $trr_ytd += $initbaltrr_ytd;// + ($totaltrrtoday);

                                        if($rs_mtd != 0 ){
                                            $arr_mtd = $trr_mtd / $rs_mtd;
                                          
                                        }
                                        
                                        
                                          if( $rs_ytd != 0){
                                           
                                            $arr_ytd = $trr_ytd /$rs_ytd;
                                        }


                                        $total_rs_today3 += $rs_today;
                                        $total_rs_mtd3 += $rs_mtd;
                                        $total_rs_ytd3 += $rs_ytd;

                                        $total_arr_today3 += $arr_today;
                                        $total_arr_mtd3 += $arr_mtd;
                                        $total_arr_ytd3 += $arr_ytd;

                                        $total_trr_today3 += $trr_today;
                                        $total_trr_mtd3 += $trr_mtd;
                                        $total_trr_ytd3 += $trr_ytd;

                                        $total_ri_today3 += $rowhtl->room_inventory;
                                        $total_ri_mtd3 += $rowhtl->room_inventory * date('d');
                                        $total_ri_ytd3 += $rowhtl->room_inventory * (date('z') + 1);
                                   }


                                    foreach($dt_hotelcomp3allproperty AS $rowhtl)
                                    {
                                        $oddrow++;
                                        /////////////////////////////
                                        $ri_today =0;$ri_mtd = 0;$ri_ytd = 0;
                                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;
                                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                                        /////////////////////////////

                                        $initbalroomsold_mtd = 0;$initbalroomsold_ytd = 0;
                                        $initbaltrr_mtd = 0;$initbaltrr_ytd = 0;
                                        $initbaldate = 0;

                                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel(date('m'),$rowhtl->idhotelcompetitor);
                                        if($dt_initbal != NULL)
                                        {
                                            $initbalroomsold_mtd = $dt_initbal->mtd_rs;
//                                            $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                            $initbaltrr_mtd = $dt_initbal->mtd_trr;
//                                            $initbaltrr_ytd = $dt_initbal->ytd_trr;
                                            $initbaldate = $dt_initbal->per_date;
                                        }

                                         $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_initbalytd != NULL)
                                        {
                                              $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                                              $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                                        }

                                        $rs_mtd += $initbalroomsold_mtd;
                                        $rs_ytd += $initbalroomsold_ytd;

                                        $ri_today = $rowhtl->room_inventory;
                                        $ri_mtd = $rowhtl->room_inventory * date('d');
                                        ///////////////////////////////////////////////////
                                        $openingdate = strtotime($rowhtl->opening_date);
                                        $hotelopendate = $rowhtl->opening_date;
                                        $now = strtotime(date('Y-01-01'));
                                        $is_opendt = false;
                                        if ($openingdate > $now) {
                                            $is_opendt = true;
                                            $startdate = strtotime($hotelopendate);
                                            $enddate = strtotime(date('Y-m-d'));
                                            $diff = $enddate - $startdate;
                                            $ttldays = round($diff / 86400) + 1;
                                        } else {
                                            $ttldays = (date('z') + 1);
                                        }
                                        if ($is_opendt) {
                                            $ri_ytd = ceil($rowhtl->room_inventory * $ttldays);
                                        } else {
                                            $ri_ytd = ceil($rowhtl->room_inventory * (date('z') + 1));
                                        }
                                        ///////////////////////////////////////////////////////

                                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysistoday_perhotel($rowhtl->idhotelcompetitor);
                                        if($dt_analystoday != NULL){
                                            $rs_today = $dt_analystoday->room_sold;
                                            $arr_today = $dt_analystoday->arr;
                                        }
                                        //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,date('Y-m-d'),$initbaldate);
                                        $startdate_mtd = date('Y-m-01');
                                        $enddate_mtd = date('Y-m-d');
                                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);

                                        if($dt_rsmtd != NULL)
                                        {
                                            $rs_mtd += $dt_rsmtd->RS_MTD;
                                        }

                                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldytd_wodateinitbal_perhotel($rowhtl->idhotelcompetitor,$initbaldate);
                                        $startdate_ytd = date('Y-01-01');
                                        $enddate_ytd = date('Y-m-d');

                                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                                        if($dt_rsytd != NULL)
                                        {
                                            $rs_ytd += $dt_rsytd->RS_YTD;
                                        }



                                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrmtd != NULL)
                                        {
                                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                                        }

                                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                                        if($dt_trrytd != NULL)
                                        {
                                             $trr_ytd = $dt_trrytd->TRR_YTD;
                                        }

                                        $trr_today = $rs_today * $arr_today;
                                        //$trr_mtd += $initbaltrr_mtd + ($totaltrrtoday);
                                        $trr_ytd += $initbaltrr_ytd;//+ ($totaltrrtoday);

                                        if($rs_mtd != 0 ){
                                            $arr_mtd = $trr_mtd / $rs_mtd;
                                           
                                        }
                                        
                                        if( $rs_ytd != 0){
                                          
                                            $arr_ytd = $trr_ytd /$rs_ytd;
                                        }

                                        if($rs_today != 0 && $ri_today !=0){
                                            $occ_today = ($rs_today / $ri_today) * 100;
                                        }
                                        if($rs_mtd != 0 && $ri_mtd != 0)
                                        {
                                            $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                                        }
                                        if($rs_ytd != 0 && $ri_ytd != 0)
                                        {
                                            $occ_ytd = ($rs_ytd / $ri_ytd) * 100;
                                        }

                                        $fms_today = $ri_today/$total_ri_today3;
                                        $fms_mtd = $ri_mtd/$total_ri_mtd3;
                                        $fms_ytd = $ri_ytd/$total_ri_ytd3;

                                        if($rs_today != 0 && $total_rs_today3 != 0){
                                            $ams_today = $rs_today / $total_rs_today3;
                                        }
                                        if ($rs_mtd != 0 && $total_rs_mtd3 != 0) {
                                            $ams_mtd = $rs_mtd / $total_rs_mtd3;
                                        }
                                        if ($rs_ytd != 0 && $total_rs_ytd3 != 0) {
                                            $ams_ytd = $rs_ytd / $total_rs_ytd3;
                                        }
                                        if ($ams_today != 0 && $fms_today != 0) {
                                            $mpi_today = $ams_today / $fms_today;
                                        }
                                        if ($ams_mtd != 0 && $fms_mtd != 0) {
                                            $mpi_mtd = $ams_mtd / $fms_mtd;
                                        }
                                        if ($ams_ytd != 0 && $fms_ytd != 0) {
                                            $mpi_ytd = $ams_ytd / $fms_ytd;
                                        }

                                        $total_occ_today3 = ($total_rs_today3 / $total_ri_today3) * 100;
                                        $total_occ_mtd3 = ($total_rs_mtd3 / $total_ri_mtd3) * 100;
                                        $total_occ_ytd3 = ($total_rs_ytd3 / $total_ri_ytd3) * 100;

                                        $total_fms_today3 += $fms_today;
                                        $total_fms_mtd3 += $fms_mtd;
                                        $total_fms_ytd3 += $fms_ytd;

                                        $total_ams_today3 += $ams_today;
                                        $total_ams_mtd3 += $ams_mtd;
                                        $total_ams_ytd3 += $ams_ytd;

                                        $total_mpi_today3 = $total_ams_today3 / $total_fms_today3;
                                        $total_mpi_mtd3 = $total_ams_mtd3 / $total_fms_mtd3;
                                        $total_mpi_ytd3 = $total_ams_ytd3 / $total_fms_ytd3;


                                          if($total_trr_today3 != 0 || $total_rs_today3 != 0){
                                            $total_arr_today3 = $total_trr_today3 / $total_rs_today3;
                                        }
                                        if($total_trr_mtd3 != 0 || $total_rs_mtd3 != 0){
                                            $total_arr_mtd3 = $total_trr_mtd3  / $total_rs_mtd3;
                                        }
                                        if($total_trr_ytd3 != 0 || $total_rs_ytd3 != 0){
                                            $total_arr_ytd3 = $total_trr_ytd3 / $total_rs_ytd3;
                                        }

                                        ?>

                                     <?php
                                            if(($oddrow % 2) != 0){
                                                $class = "style='background-color: #dbeafd'";
                                            }else{
                                                $class = '';
                                            }
                                            ?>


                                          
                                       <tr>
                                        <td class="kolom">
                                            <?= $rowhtl->hotelcompetitor_name;?>
                                        </td>
                                        <td class="kolom" style="text-align: center">
                                            <?= $rowhtl->room_inventory;?>
                                        </td>
                                        <td class="kolom" style="text-align: center" title="Today"><?= $rs_today ?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= $rs_mtd; ?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= $rs_ytd?></td>
                                        <!-- End Room Sold-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($occ_today,1,',','.'); ?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($occ_mtd,1,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($occ_ytd,1,',','.');?></td>
                                        <!-- End Occupancy-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($arr_today,0,',',',')?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($arr_mtd,0,',',',');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($arr_ytd,0,',',',');?></td>
                                        <!-- End ARR-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($trr_today,0,',','.')?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($trr_mtd,0,',','.')?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($trr_ytd,0,',','.')?></td>
                                        <!-- End Total Room Revenue-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($fms_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($fms_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($fms_ytd,2,',','.');?></td>
                                        <!-- End Fair Market Share-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($ams_today,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($ams_mtd,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($ams_ytd,2,',','.');?></td>
                                        <!-- End Actual Market Share-->
                                        <td class="kolom" style="text-align: center" title="Today"><?= number_format($mpi_today,3,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Month to Date"><?= number_format($mpi_mtd,3,',','.');?></td>
                                        <td class="kolom" style="text-align: center" title="Year to Date"><?= number_format($mpi_ytd,3,',','.');?></td>
                                        <!-- End MPI -->
                                        <td class="kolom">
                                             <?php
                                                $dt_grouphotel = $this->hotel_competitor_analysis_model->select_grouptoday_perhotel($rowhtl->idhotelcompetitor);
                                                $row = 1;
                                                $ttlrowgh = $dt_grouphotel->num_rows();
                                                foreach($dt_grouphotel->result() AS $rowgh)
                                                {
                                                    $row++;
                                                    echo $rowgh->account_name .'(<span style="color:red">'.$rowgh->rno.'</span>)';
                                                    if($row < $ttlrowgh)
                                                    {
                                                        echo '<b>;</b> ';
                                                    }
                                                }
                                                ?>
                                        </td>
                                    </tr>

                                   <?php } ?>
                                     <?php if($dt_hotelcomp3allproperty  != NULL){?>
                                    <tr>
                                        <td class="kolom" style="text-align: right"><b>Total</b></td>
                                        <td class="kolom" style="text-align: center"><?= $total_ri_today3;?></td>
                                        <td class="kolom" style="text-align: center"><?= $total_rs_today3;?></td>
                                        <td class="kolom" style="text-align: center"><?= $total_rs_mtd3;?></td>
                                        <td class="kolom" style="text-align: center"><?= $total_rs_ytd3;?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_occ_today3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_occ_mtd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_occ_ytd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_arr_today3,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_arr_mtd3,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_arr_ytd3,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_trr_today3,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_trr_mtd3,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_trr_ytd3,0,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_fms_today3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_fms_mtd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_fms_ytd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_ams_today3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_ams_mtd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_ams_ytd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_mpi_today3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_mpi_mtd3,2,',','.');?></td>
                                        <td class="kolom" style="text-align: center"><?= number_format($total_mpi_ytd3,2,',','.');?></td>
                                        <td class="kolom">
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                    <!-- TargetPROPERTY -->
                                    <div style="width: 1500px; ">
                                    <div id="containerbudget" style="float: left;width: 600px" >
                                    <table class="dashboard"   style="margin-top: 20px;margin-bottom:  20px;width: 600px;font-size: 7pt">
                                        <tr>
                                            <th colspan="5" class="kolom"><span style="background-color:#ff99ff;padding: 5px ">TARGET <?=date('F Y');?></span>, Days in month : <span style="background-color:#ccffff "><?= date('t')?></span></th>
                                            <th colspan="2" class="kolom">REQUIRED TO MEET BUDGET</th>
                                        </tr>
                                        <tr class="oddRow">
                                            <th style="text-align: center" class="kolom">Hotels </th>
                                            <th style="text-align: center">Rnts</th>
                                            <th style="text-align: center">Occ %</th>
                                            <th style="text-align: center">Arr</th>
                                            <th style="text-align: center">RRev</th>
                                            <th style="text-align: center"><b>Rnts</b></th>
                                            <th style="text-align: center"><b>RRev</b></th>
                                        </tr>

                                        <?php foreach($dt_budgetproperty AS $rowpr){
                                            ////////////////////////////////
                                            ////////////////////////////////
                                            $rs_mtd = 0;
                                            $trr_mtd = 0;
                                            /////////////////////////////
                                            $initbalroomsold_mtd = 0;
                                            $initbaltrr_mtd = 0;
                                            $initbaldate = 0;

                                            $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel(date('m'),$rowpr->idhotelcompetitor_FK);
                                            if($dt_initbal != NULL)
                                            {
                                                $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                                                $initbaltrr_mtd = $dt_initbal->mtd_trr;
                                                $initbaldate = $dt_initbal->per_date;
                                            }
                                            $rs_mtd += $initbalroomsold_mtd;
                                           // $dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowpr->idhotelcompetitor_FK,$initbaldate,date('Y-m-d'),$initbaldate);
                                            $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowpr->idhotelcompetitor_FK);
                                            if ($dt_rsmtd != NULL) {
                                                $rs_mtd += $dt_rsmtd->RS_MTD;
                                            }


                                            $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowpr->idhotelcompetitor_FK);
                                            if($dt_trrmtd != NULL)
                                            {
                                                $trr_mtd = $dt_trrmtd->TRR_MTD;
                                            }
                                            ////////////////////////////////
                                            ////////////////////////////////

                                            $rm_inventory = $rowpr->room_inventory;
                                            $daysinmonth = date('t');
                                            $occ = $rowpr->room_night / ($rm_inventory * $daysinmonth);
                                            $rrev = $rowpr->room_night * $rowpr->arr;
                                            $rmnight_req = $rs_mtd -  $rowpr->room_night;
                                            $rrev_req = $trr_mtd - $rrev;
                                        ?>
                                        <tr >
                                            <td class="kolom" ><?= $rowpr->hotelcompetitor_name;?></td>
                                            <td style="text-align: center" class="kolom"><?= $rowpr->room_night?></td>
                                            <td style="text-align: center;background-color: #ccffff" class="kolom"><?= number_format($occ * 100,1,',','.'); ?>%</td>
                                            <td style="text-align: right" class="kolom"><?= number_format($rowpr->arr,0,',','.');?></td>
                                            <td class="kolom" style="text-align: right;background-color: #ccffff"><?= number_format($rrev,0,',','.')?></td>
                                            <td class="kolom" style="text-align: center"><?= number_format($rmnight_req,0,',','.')?></td>
                                            <td class="kolom" style="text-align: right"><?= number_format($rrev_req,0,',','.')?></td>
                                        </tr>
                                        <?php }//endforeach property ?>
                                    </table>
                                    <!-- END BUDGET PROPERTY -->
                                    </div>
                                    <div id="containerforecast" style="float: left;margin-left: 10px;width: 800px; ">
                                        <table class="dashboard" border="1"  style="margin-top: 20px;margin-bottom:  20px; width: 100%;font-size: 7pt">
                                            <tr>
                                                <th colspan="17" class="kolom">FORECAST - EXPECTED CLOSING</th>
                                            </tr>
                                            <tr>
                                                <td class="kolom"><div style="width: 100px"></div></td>
                                                <?php for($i=0;$i<8;$i++){?>
                                                <td class="kolom" colspan="2" style=" text-align: center">
                                                    <b> <?=(date('d-M', strtotime(date('Y-m-d') . "+ $i day")))?></b>
                                                </td>
                                                <?php }//endfor ?>
                                            </tr>
                                            <?php

                                            foreach($dt_hotelprop AS $row)
                                            {
                                                if(strtolower($row->hotelcompetitor_name) == "the sunan hotel solo"  ){
                                                 ?>
                                            <?php if(strtolower($row->hotelcompetitor_name) == "the sunan hotel solo"){?>
                                                <tr style="background-color: <?= $carrcadincolor?>">
                                            <?php } ?>
                                                <td class="kolom" > <?= $row->hotelcompetitor_name;?> </td>
                                                  <?php for($i=0;$i<8;$i++){
                                                        $perdate = (date('Y-m-d', strtotime(date('Y-m-d') . "+ $i day")));
                                                        $dt_forecast = $this->property_forecast_model->select_propertyforecast_by_hoteldate($row->idhotelcompetitor,$perdate);
                                                        $roomnight = 0;
                                                        $roominv = $row->room_inventory;
                                                        if($dt_forecast != NULL)
                                                        {
                                                            $roomnight = $dt_forecast->roomnights;
                                                        }
                                                 ?>
                                                <td class="kolom"  style="text-align: center">
                                                    <?php
                                                            echo $roomnight;
                                                    ?>
                                                </td>
                                                <td class="kolom" style="width: 50px;text-align: center"  >
                                                    <?php $occ = $roomnight / $roominv ;
                                                            echo number_format($occ * 100,1,'.',',');
                                                    ?> %
                                                </td>
                                                <?php }//endfor ?>

                                            </tr>
                                            <?php  }//endif
                                            }//endforeach
                                            ?>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End #tab1 -->
                        <div class="tab-content" id="tab2">
                            <?= form_open('hotel_competitor_analysis/add_hotelcompanalysis','id="form_htl_comp_analysis" ');?>
                            Date :  <input type="text" value="<?= (date('d-m-Y', strtotime(date('Y-m-d') . "-1 day")))?>" id="perdate" name="perdate" class="validate[required]" readonly/>
                                <table width="100%" class="dashboard" id="tblcompetitor">
                                    <tr class="oddRow">
                                        <th>NO.</th>
                                        <th>COMPETITOR HOTEL</th>
                                        <th>ROOM SOLD</th>
                                        <th>AVERAGE ROOM RATE</th>
                                        <th>GROUP LAST NIGHT </th>
                                    </tr>
                                    <tbody>
                                    <?php
                                    $idx = 1;
                                       $index = 1;
                                    if($dt_hca == NULL){
                                    echo '<tr><td colspan=5><b>4 Stars Hotel****</b></td></tr>';
                                    foreach($dt_hotelcomp4 AS $row){
                                    $idx++;
                                    ?>
                                        <tr class="additionRow">
                                            <td style="vertical-align: top"><?= $index++;?></td>
                                            <td style="vertical-align: top"><?= $row->hotelcompetitor_name;?><input type="hidden" id="htlcomp<?= $idx?>" value="<?= $row->idhotelcompetitor?>" name="idhotel[]"/></td>
                                            <td style="vertical-align: top"><?= form_input('roomsold[]','','class="validate[required,custom[onlyNumber]]" id="roomsold'.$idx.'"');?></td>
                                            <td style="vertical-align: top"><?= form_input('arr[]','','class="validate[required,custom[onlyNumber]]" id="arr'.$idx.'"');?></td>
                                            <td style="vertical-align: top">
                                                <input type="hidden" value="" id="idaccount<?= $idx?>" class="idaccount" size="5px"/>
                                                <input type="text" value="" id="account<?= $idx?>" class="account" title="type group's name here" size="30px"/>
                                                <?php anchor('account/search_account','Add','class="add" id="add'.$idx.'"  ');?>
                                                <div id="containergroup<?= $idx?>" class="containergroup">
                                                    <input type="hidden"  id="totalitem<?= $idx?>" value="0" size="3"/>
                                                    <ul></ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }//endforeach ?>
                                        <!--
                                    <?php
                                     echo '<tr><td colspan=5><b>3 Stars Hotel***</b></td></tr>';
                                     $index3 = 1;
                                    foreach($dt_hotelcomp3 AS $row){
                                    $idx++;
                                    ?>
                                        <tr class="additionRow">
                                            <td style="vertical-align: top"><?= $index3++;?></td>
                                            <td style="vertical-align: top"><?= $row->hotelcompetitor_name;?><input type="hidden" id="htlcomp<?= $idx?>" value="<?= $row->idhotelcompetitor?>" name="idhotel[]"/></td>
                                            <td style="vertical-align: top"><?= form_input('roomsold[]','','class="validate[required,custom[onlyNumber]]" id="roomsold'.$idx.'"');?></td>
                                            <td style="vertical-align: top"><?= form_input('arr[]','','class="validate[required,custom[onlyNumber]]" id="arr'.$idx.'"');?></td>
                                            <td style="vertical-align: top">
                                                <input type="hidden" value="" id="idaccount<?= $idx?>" class="idaccount" size="5px"/><input type="text" value="" id="account<?= $idx?>" class="account" title="type group's name here" size="30px"/> <?php anchor('account/search_account','Add','class="add" id="add'.$idx.'"  ');?>
                                                <div id="containergroup<?= $idx?>" class="containergroup">
                                                    <input type="hidden"  id="totalitem<?= $idx?>" value="0" size="3"/>
                                                    <ul></ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }//endforeach?>
                                        -->
                                     <tr>
                                        <td colspan="5" style="text-align: center"><?= form_submit('Submit','Submit');?></td>
                                    </tr>
                                    <?php

                                    }else{
                                        foreach($dt_hca AS $rowhca){
                                    ?>
                                    <tr class="additionRow">
                                        <td><?= $index++;?></td>
                                        <td><?= $rowhca->hotelcompetitor_name; ?></td>
                                        <td><?= $rowhca->room_sold;?></td>
                                        <td><?= number_format($rowhca->arr,0,',','.')?></td>
                                        <td>
                                            <?php $dt_group = $this->hotel_competitor_analysis_model->select_group_perhcatoday($rowhca->idhotelcompanalysis);
                                                $qtygroup = $dt_group->num_rows();
                                                $row = 1;
                                                foreach($dt_group->result() AS $rowg){
                                                    $row++;
                                                    echo $rowg->account_name;
                                                    if($row < $qtygroup){
                                                    echo ', ';
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }//endforeach hca?>
                                    <?php }//endif dt_hca ?>

                                    </tbody>

                                </table>

                                    <div id="processing"></div>
                                
                             <?= form_close();?>
                        </div>
                        <!-- End #tab2 -->
                        <div class="tab-content " id="tab3">
                            <?php if($dt_woinitbal4 != NULL || $dt_woinitbal3 != NULL){?>
                            <?= form_open('hotel_competitor_analysis/add_initial_balance','id="form_initial_balance" ');?>
                             Per : <?= date('F Y');?> <input type="hidden" value="<?= date('Y-m-d')?>" name="permonth"/>
                             <table width="100%" class="dashboard" id="tblcompetitor">
                                     <tr class="oddRow">
                                         <td class="kolom" rowspan="2" style="text-align: center;vertical-align: middle"><b>NO.</b></td>
                                         <td class="kolom" rowspan="2" style="text-align: center;vertical-align: middle"><b>COMPETITOR HOTEL</b></td>
                                         <td class="kolom" colspan="2" style="text-align: center;vertical-align: middle"><b>ROOM SOLD</b></td>
                                         <!--<td class="kolom" colspan="2" style="text-align: center;vertical-align: middle"><b>ARR</b></td>-->
                                         <td class="kolom" colspan="2" style="text-align: center;vertical-align: middle"><b>TRR</b></td>
                                     </tr>
                                     <tr>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             MTD
                                         </td>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             YTD
                                         </td>
                                     
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             MTD
                                         </td>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             YTD
                                         </td>
                                     </tr>
                                     <tbody>
                                         <tr><td colspan=4><b>4 Stars Hotel****</b></td></tr>
                                     <?php
                                     $no = 1;
                                     $ibindex = 1;
                                     foreach ($dt_woinitbal4 AS $row) {
                                     $ibindex++;
                                     ?>
                                         <tr class="additionRow">
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= $no++; ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: left"><?= $row->hotelcompetitor_name; ?><input type="hidden" id="htlcomp<?= $ibindex ?>" value="<?= $row->idhotelcompetitor ?>" name="idhotelcomp[]"/></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_mtd[]', '', 'class="validate[required,custom[onlyNumber]]" id="rs_mtd' . $ibindex . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_ytd[]', '', 'class="validate[required,custom[onlyNumber]]" id="rs_ytd' . $ibindex . '" size="10px"'); ?></td>
                                            
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_mtd[]', '', 'class="validate[required,custom[onlyNumber]]" id="trr_mtd' . $ibindex . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_ytd[]', '', 'class="validate[required,custom[onlyNumber]]" id="trr_ytd' . $ibindex . '" size="10px"'); ?></td>
                                         </tr>
                                     <?php }//endforeach?>
                                         <tr><td colspan=6><b>3 Stars Hotel***</b></td></tr>
                                     <?php
                                     $nox = 1;
                                     foreach ($dt_woinitbal3 AS $row) {
                                         $ibindex++;
                                     ?>
                                         <tr class="additionRow">
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= $nox++; ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: left"><?= $row->hotelcompetitor_name; ?><input type="hidden" id="htlcomp<?= $idx ?>" value="<?= $row->idhotelcompetitor ?>" name="idhotelcomp[]"/></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_mtd[]', '', 'class="validate[required,custom[onlyNumber]]" id="rs_mtd' . $ibindex . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_ytd[]', '', 'class="validate[required,custom[onlyNumber]]" id="rs_ytd' . $ibindex . '" size="10px"'); ?></td>
                                             
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_mtd[]', '', 'class="validate[required,custom[onlyNumber]]" id="trr_mtd' . $ibindex . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_ytd[]', '', 'class="validate[required,custom[onlyNumber]]" id="trr_ytd' . $ibindex . '" size="10px"'); ?></td>
                                         </tr>
                                     <?php }//endforeach?>
                                     <tr>
                                         <td colspan="6" style="text-align: center"><?= form_submit('Submit', 'Submit'); ?></td>
                                     </tr>
                                 </tbody>
                             </table>
                              <?= form_close();?>
                             <?php }else{ ?>
                            <!-- Initial Balance Per : <?= date('F Y');?> <input type="hidden" value="<?= date('Y-m-d')?>" name="permonth"/>-->
                             <table width="100%" class="dashboard" id="tblcompetitor">
                                     <tr class="oddRow">
                                         <td class="kolom" rowspan="2" style="text-align: center;vertical-align: middle"><b>NO.</b></td>
                                         <td class="kolom" rowspan="2" style="text-align: center;vertical-align: middle"><b>COMPETITOR HOTEL</b></td>
                                         <td class="kolom" rowspan="2" style="text-align: center;vertical-align: middle"><b>Date</b></td>
                                         <td class="kolom" colspan="2" style="text-align: center;vertical-align: middle"><b>ROOM SOLD</b></td>
                                         <!--<td class="kolom" colspan="2" style="text-align: center;vertical-align: middle"><b>ARR</b></td>-->
                                         <td class="kolom" colspan="2" style="text-align: center;vertical-align: middle"><b>TRR</b></td>
                                     </tr>
                                     <tr>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             MTD
                                         </td>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             YTD
                                         </td>
                                         <!--
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             MTD
                                         </td>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             YTD
                                         </td>
                                         -->
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             MTD
                                         </td>
                                         <td class="kolom" style="text-align: center;vertical-align: middle">
                                             YTD
                                         </td>
                                     </tr>
                                     <tbody>
                                         <?php if($dt_initbal4 != NULL){?>
                                         <tr><td colspan=4><b>4 Stars Hotel****</b></td></tr>
                                         <?php
                                         $noxx = 1;
                                         foreach($dt_initbal4 AS $rowib){?>
                                         <tr class="additionRow">
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= $noxx++; ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: left"><?= $rowib->hotelcompetitor_name; ?><input type="hidden" id="htlcomp<?= $idx ?>" value="<?= $rowib->idhotelcompetitor ?>" name="idhotelcomp[]"/></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= format_waktu2($rowib->per_date); ?><input type="hidden" id="htlcomp<?= $idx ?>" value="<?= $rowib->idhotelcompetitor ?>" name="idhotelcomp[]"/></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_mtd[]', $rowib->mtd_rs, 'readonly class="validate[required,custom[onlyNumber]]" id="rs_mtd' . $idx . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_ytd[]', $rowib->ytd_rs, 'readonly class="validate[required,custom[onlyNumber]]" id="rs_ytd' . $idx . '" size="10px"'); ?></td>
                                             <!--
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('arr_mtd[]', $rowib->mtd_arr, 'readonly class="validate[required,custom[onlyNumber]]" id="arr_mtd' . $idx . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('arr_ytd[]', $rowib->ytd_arr, 'readonly class="validate[required,custom[onlyNumber]]" id="arr_ytd' . $idx . '" size="10px"'); ?></td>
                                             -->
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_mtd[]', $rowib->mtd_trr, 'readonly class="validate[required,custom[onlyNumber]]" id="trr_mtd' . $idx . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_ytd[]', $rowib->ytd_trr, 'readonly class="validate[required,custom[onlyNumber]]" id="trr_ytd' . $idx . '" size="10px"'); ?></td>
                                         </tr>
                                         <?php }//endforeach ?>
                                         <?php }//endif initbalance 4 ?>

                                         <?php if($dt_initbal3 != NULL){?>
                                         <tr><td colspan=6><b>3 Stars Hotel***</b></td></tr>
                                         <?php
                                         $noxx = 1;
                                         foreach($dt_initbal3 AS $rowib){?>
                                         <tr class="additionRow">
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= $noxx++; ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: left"><?= $rowib->hotelcompetitor_name; ?><input type="hidden" id="htlcomp<?= $idx ?>" value="<?= $rowib->idhotelcompetitor ?>" name="idhotelcomp[]"/></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= format_waktu2($rowib->per_date); ?><input type="hidden" id="htlcomp<?= $idx ?>" value="<?= $rowib->idhotelcompetitor ?>" name="idhotelcomp[]"/></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_mtd[]', $rowib->mtd_rs, 'readonly class="validate[required,custom[onlyNumber]]" id="rs_mtd' . $idx . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('rs_ytd[]', $rowib->ytd_rs, 'readonly class="validate[required,custom[onlyNumber]]" id="rs_ytd' . $idx . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_mtd[]', $rowib->mtd_trr, 'readonly class="validate[required,custom[onlyNumber]]" id="trr_mtd' . $idx . '" size="10px"'); ?></td>
                                             <td class="kolom" style="vertical-align: top;text-align: center"><?= form_input('trr_ytd[]', $rowib->ytd_trr, 'readonly class="validate[required,custom[onlyNumber]]" id="trr_ytd' . $idx . '" size="10px"'); ?></td>
                                         </tr>
                                         <?php }//endforeach ?>
                                         <?php }//endif initbalance 3 ?>
                                     </tbody>
                                 </table>
                             <?php }//endif ?>
                        </div>
                        <!-- End #tab3 -->
                        <div class="tab-content " id="tab4">
                            <form action="" method="post" id="form_account" >
                                <table width="100%" class="dashboard">
                                    <tr class="oddRow">
                                        <td colspan="4"><b>Group Infomation</b></td>
                                    </tr>
                                    <tr>
                                        <td>Company Name</td>
                                        <td><?= form_input('companyname','','id="companyname" size="37" class="validate[required,length[0,200],ajax[ajaxCompanyName]] text-input"'); ?></td>
                                        <td>Phone Office</td>
                                        <td><?= form_input('telp','','id="telp" size="37" class="validate[required,length[0,100]] text-input"'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Website</td>
                                        <td>http://&nbsp;<?= form_input('website','','id="website" size="31" class=""'); ?></td>
                                        <td>Phone Fax</td>
                                        <td><?= form_input('fax','','id="fax" size="37" class="validate[required,length[0,100]] text-input"'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Member Of</td>
                                        <td><?= form_input('member','','id="member" size="28" class=" "'); ?> <input id="idparent" value="" type="hidden" name="idparent"/><input type="submit" id="reset" value="reset" style="border: 1px ridge black"/> </td>
                                        <td>Other Phone</td>
                                        <td><?= form_input('otherphone','','id="otherphone" size="37" class="validate[length[0,100]] text-input"'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Industri</td>
                                        <td>
                                            <?php $option_industri_selected =  '-- Choose --';
                                            $option_industri[''] = "-- Choose --";
                                            if($dt_industri != NULL) {
                                                foreach($dt_industri as $row) {
                                                    $option_industri[$row->idindustri] = $row->industri_name;
                                                }
                                            }else {
                                                $option_industri_selected = 'Data Not Available';
                                                $option_industri['null'] = 'Data Not Available';
                                            }
                                            echo form_dropdown('industri',$option_industri,$option_industri_selected,'id="industri" style="width:250px" class="validate[required]"');
                                            ?>
                                        </td>
                                        <td><!-- Email--></td>
                                        <td><!--<?= form_input('email','','id="email" size="37" class="validate[length[0,100]] text-input"'); ?>--></td>
                                    </tr>
                                    <tr>
                                        <td>Segment</td>
                                        <td>
                                            <?php $option_segment_selected =  '-- Choose --';
                                            $option_segment[''] = "-- Choose --";
                                            if($dt_account_segment != NULL) {
                                                foreach($dt_account_segment as $row) {
                                                    $option_segment[$row->idcomseg] = $row->nama_segment;
                                                }
                                            }else {
                                                $option_segment_selected = 'Data Not Available';
                                                $option_segment['null'] = 'Data Not Available';
                                            }
                                            echo form_dropdown('segment',$option_segment,$option_segment_selected,'id="segment" style="width:250px" class="validate[required]"');
                                            ?>
                                        </td>
                                        <td>Company's Birthday </td>
                                        <td><?= form_input('birthday','','id="birthday" size="37"');?></td>
                                    </tr>
                                    <tr>
                                        <td>Sales</td>
                                        <td>
                                            <?php
                                            $leveluser = $this->session->userdata('level');
                                            $idstaff = $this->session->userdata('idstaff');
                                            switch ($leveluser) {
                                                case 'Admin':
                                                    $option_sales_selected =  '-- Choose --';
                                                    $option_sales[''] = "-- Choose --";
                                                    if($dt_sales != NULL) {
                                                        foreach($dt_sales as $row) {
                                                            $option_sales[$row->id] = $row->firstname.' '.$row->lastname;
                                                        }
                                                    }else {
                                                        $option_sales_selected = 'Data Not Available';
                                                        $option_sales['null'] = 'Data Not Available';
                                                    }
                                                    echo form_dropdown('salescreated',$option_sales,$option_sales_selected,'id="sales" style="width:250px;" title="choose sales name for the contact" class="validate[required]"');
                                                    break;
                                                    
                                                    
                                                    case 'Manager':
                                                    $option_sales_selected =  '-- Choose --';
                                                    $option_sales[''] = "-- Choose --";
                                                    if($dt_sales != NULL) {
                                                        foreach($dt_sales as $row) {
                                                            $option_sales[$row->id] = $row->firstname.' '.$row->lastname;
                                                        }
                                                    }else {
                                                        $option_sales_selected = 'Data Not Available';
                                                        $option_sales['null'] = 'Data Not Available';
                                                    }
                                                    echo form_dropdown('salescreated',$option_sales,$option_sales_selected,'id="sales" style="width:250px;" title="choose sales name for the contact" class="validate[required]"');
                                                    break;

                                                case 'Sales' :
                                                    $option_sales_selected =  $idstaff;
                                                    $option_sales[''] = "-- Choose --";
                                                    if($dt_sales != NULL) {
                                                        foreach($dt_sales as $row) {
                                                            if($idstaff == $row->id) {
                                                                $option_salesx[$row->id] = $row->firstname.' '.$row->lastname;
                                                            }
                                                            $option_sales[$row->id] = $row->firstname.' '.$row->lastname;
                                                        }
                                                    }else {
                                                        $option_sales_selected = 'Data Not Available';
                                                        $option_sales['null'] = 'Data Not Available';
                                                    }
                                                    echo form_dropdown('salescreated',$option_salesx,$option_sales_selected,'id="sales" style="width:250px;" title="choose sales name for the contact" class="validate[required]"');
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr class="oddRow">
                                        <td colspan="4"><b>Address Infomation</b></td>
                                    </tr>
                                    <tr>
                                        <td>Primary Address</td>
                                        <td><?= form_input('alamat','','id="alamat" size="37" class="validate[required,length[0,100]] text-input"'); ?></td>
                                        <td>Postal Code</td>
                                        <td><?= form_input('kode_pos','','id="kode_pos" size="37" text-input"'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td>
                                            <?php $option_country_selected =  'id';
                                            $option_country[''] = "-- Choose --";
                                            if($dt_countries != NULL) {
                                                foreach($dt_countries as $row) {
                                                    $option_country[$row->countriescode] = $row->countriesname;
                                                }
                                            }else {
                                                $option_country_selected = 'Data Not Available';
                                                $option_country['null'] = 'Data Not Available';
                                            }
                                            echo form_dropdown('country',$option_country,$option_country_selected,'id="country" style="width:250px" class="validate[required]"');
                                            ?>
                                        </td>
                                        <td>Province</td>
                                        <td>
                                            <div id="containerprovince">
                                            <?php $option_propinsi_selected =  '-- Choose --';
                                            $option_propinsi[''] = "-- Choose --";
                                            if($dt_propinsi != NULL) {
                                                foreach($dt_propinsi as $row) {
                                                    $option_propinsi[$row->KODE_PROP] = $row->NAMA_PROP;
                                                }
                                            }else {
                                                $option_propinsi_selected = 'Data Not Available';
                                                $option_propinsi[''] = 'Data Not Available';
                                            }
                                            echo form_dropdown('propinsi',$option_propinsi,$option_propinsi_selected,'id="propinsi" style="width:250px" class="validate[required]"');
                                            ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                        <td>

                                        </td>
                                        <td>District/City</td>
                                        <td>
                                            <div id="divcity"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr class="oddRow">
                                        <td colspan="4"><b>Description Information</b></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Description</td>
                                        <td colspan="3"><textarea cols="45" rows="3" name="deskripsi"></textarea></td>
                                    </tr>
                                </table>

                                    <div id="processing2"></div>
                               
                                <p align="center">
                                    <input class="submit" align="center"  type="submit"  value="Submit" />
                                </p>
                            </form>
                        </div>
                        <!-- End #tab4 -->
                        <div class="tab-content " id="tab5">
                            <?= form_open('property','id="formbudgetproperty"');?>
                            <table  width="500px">
                                <tr>
                                    <td class="kolompadding">
                                        Property :
                                    </td>
                                    <td class="kolompadding" colspan="2">
                                       <?php
                                            $option_prop_sel = '-- Choose --';
                                            $option_prop[''] = '-- Choose --';
                                            foreach($dt_hotelprop AS $row)
                                            {
                                                if(strtolower($row->hotelcompetitor_name) == "the sunan hotel solo"  ){
                                                    
                                                   $option_prop[$row->idhotelcompetitor] = $row->hotelcompetitor_name;
                                                }
                                            }
                                            echo form_dropdown('property',$option_prop,$option_prop_sel,'class="validate[required]" id="property"');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                     <td class="kolompadding">Year</td>
                                     <td class="kolompadding" colspan="2">
                                         <?php $opt_yearpb_sel = '-- Choose --';
                                               $opt_yearpb[''] = '-- Choose --';
                                               $opt_yearpb[date('Y')] = date('Y');
                                               $opt_yearpb[date('Y') + 1] = date('Y') + 1;
                                               $opt_yearpb[date('Y') + 2] = date('Y') + 2;
                                               $opt_yearpb[date('Y') + 3] = date('Y') + 3;
                                               echo form_dropdown('yearpb',$opt_yearpb,$opt_yearpb_sel,'style="width:100px" class="validate[required]" id="yearpropbudget');
                                         ?>
                                     </td>
                                 </tr>
                                <tr>
                                    <td class="kolompadding" ><b>MONTH</b></td>
                                    <td class="kolompadding" ><b>ROOM NIGHT</b></td>
                                    <td class="kolompadding" ><b>AVERAGE ROOM RATES</b></td>
                                </tr>
                                     <tr>
                                         <td class="kolompadding">January</td>
                                         <td class="kolompadding"><?= form_input('roomnight1',0,'class="validate[required] roomnight"  id="roomnight1"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr1',0,'class="validate[required] arr"  id="arr1"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">February</td>
                                         <td class="kolompadding"><?= form_input('roomnight2',0,'class="validate[required] roomnight"  id="roomnight2"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr2',0,'class="validate[required] arr"  id="arr2"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">March</td>
                                         <td class="kolompadding"><?= form_input('roomnight3',0,'class="validate[required] roomnight"  id="roomnight3"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr3',0,'class="validate[required] arr"  id="arr3"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">April</td>
                                         <td class="kolompadding"><?= form_input('roomnight4',0,'class="validate[required] roomnight"  id="roomnight4"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr4',0,'class="validate[required] arr"  id="arr4"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">May</td>
                                         <td class="kolompadding"><?= form_input('roomnight5',0,'class="validate[required] roomnight"  id="roomnight5"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr5',0,'class="validate[required] arr"  id="arr5"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">June</td>
                                         <td class="kolompadding"><?= form_input('roomnight6',0,'class="validate[required] roomnight" id="roomnight6"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr6',0,'class="validate[required] arr"  id="arr6"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">July</td>
                                         <td class="kolompadding"><?= form_input('roomnight7',0,'class="validate[required] roomnight"  id="roomnight7"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr7',0,'class="validate[required] arr"  id="arr7"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">August</td>
                                         <td class="kolompadding"><?= form_input('roomnight8',0,'class="validate[required] roomnight"  id="roomnight8"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr8',0,'class="validate[required] arr"  id="arr8"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">September</td>
                                         <td class="kolompadding"><?= form_input('roomnight9',0,'class="validate[required] roomnight" id="roomnight9"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr9',0,'class="validate[required] arr"  id="arr9"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">October</td>
                                         <td class="kolompadding"><?= form_input('roomnight10',0,'class="validate[required] roomnight" id="roomnight10"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr10',0,'class="validate[required] arr"  id="arr10"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">November</td>
                                         <td class="kolompadding"><?= form_input('roomnight11',0,'class="validate[required] roomnight" id="roomnight11"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr11',0,'class="validate[required] arr"  id="arr11"'); ?></td>
                                     </tr>
                                     <tr>
                                         <td class="kolompadding">December</td>
                                         <td class="kolompadding"><?= form_input('roomnight12',0,'class="validate[required] roomnight" id="roomnight12"'); ?></td>
                                         <td class="kolompadding"><?= form_input('arr12',0,'class="validate[required] arr"  id="arr12"'); ?></td>
                                     </tr>
                                    <tr>
                                        <td class="kolompadding" colspan="3" style="text-align: center">
                                            <input type="submit" value="SUBMIT" id="btnSubmit"/>
                                        </td>
                                    </tr>
                            </table>
                            <div id="resultbudgetprop"></div>
                            <?= form_close(); ?>
                        </div>
                        <!-- End #tab5 -->
                        <div class="tab-content " id="tab7">
                            <?= form_open('','id="formforecast"'); ?>
                              <table  width="500px">
                                <tr>
                                    <td class="kolompadding">
                                        Property :
                                    </td>
                                    <td class="kolompadding" colspan="2">
                                       <?php
                                            $option_prop_sel = '-- Choose --';
                                            $option_prop1[''] = '-- Choose --';
                                            foreach($dt_hotelprop AS $row)
                                            {
                                                $hotelname = strtolower($row->hotelcompetitor_name);
                                                if($hotelname == "the sunan hotel solo"){
                                                     
                                                          $option_prop1[$row->idhotelcompetitor] = $row->hotelcompetitor_name;
                                                   

                                                }
                                            }
                                            echo form_dropdown('property',$option_prop1,$option_prop_sel,'class="validate[required]" id="property"');
                                        ?>
                                    </td>
                                </tr>
                                  <tr>
                                      <td><b>Date</b></td>
                                      <td><b>Room Nights</b></td>
                                  </tr>
                                  <?php for($i=1;$i<9;$i++){?>
                                  <tr>
                                      <td><?= (date('d', strtotime(date('Y-m-d') . "+ $i day")))?> <?= (date('F', strtotime(date('Y-m-d') . "+ $i day"))); ?> <?= (date('Y', strtotime(date('Y-m-d') . "+ $i day")));?><input type="hidden" name="forecastdate[]" id="dateforecast<?= $i?>" value="<?= (date('Y-m-d', strtotime(date('Y-m-d') . "+ $i day")))?>"/></td>
                                      <td  class="kolompadding"><?= form_input('roomnights[]','','class="validate[required,custom[onlyNumber]]" id="roomnights'.$i.'"');?></td>
                                  </tr>
                                  <?php }//endfor ?>
                                  <tr>
                                      <td colspan="2" style="text-align: center"><input type="submit" value="Submit"/></td>
                                  </tr>
                              </table>
                            <div id="resultforecast"></div>
                              <?= form_close();?>
                        </div>
                         <!-- End #tab7 -->
                        <div class="tab-content " id="tab6">
                        Filter by Property : <?php
                                                $opt_propbudget_sel = "ALL";
                                                $opt_propbudget[''] = "ALL";
                                                foreach ($dt_hotelprop AS $rowpr) {
                                                    if (strtolower($rowpr->hotelcompetitor_name) == "the sunan hotel solo"  ) {
                                                        $opt_propbudget[$rowpr->idhotelcompetitor] = $rowpr->hotelcompetitor_name;
                                                    }
                                                }
                                                echo form_dropdown('prop',$opt_propbudget,$opt_propbudget_sel,'id="budgetbyprop"');
                                            ?>, Year : <?php
                                                            $opt_year_sel = "-- Choose --";
                                                            $opt_year[''] = "-- Choose --";
                                                            foreach($dt_yearbudget AS $rowyear)
                                                            {
                                                                $opt_year[$rowyear->year] = $rowyear->year;
                                                            }
                                                            echo form_dropdown('year',$opt_year,$opt_year_sel,'id="budgetbyyear"');
                                                        ?>
                                            <br/><br/>
                         <div id="containerdatabudget">
                             <table class="dashboard" style="width: 500px">
                                 <tr class="oddRow">
                                    <td style="width: 100px;text-align: center" class="kolom">MONTH PERIOD</td>
                                    <td style="width: 200px;text-align: center" class="kolom">ARR</td>
                                    <td style="width: 200px;text-align: center" class="kolom">ROOM NIGHT</td>
                                    <td style="width: 100px;text-align: center" class="kolom">STATUS</td>
                                </tr>
                                <?php foreach($dt_property AS $rowp){?>
                                <tr>
                                    <td class="kolom" colspan="3" style="text-align: center"><?= $rowp->nama_prop; ?></td>
                                </tr>
                                <?php
                                    $dt_budgetact = $this->hca_property_budget_model->select_budgetproperty_active_by_property($rowp->idproperty);
                                    if($dt_budgetact->result() != NULL){
                                    foreach($dt_budgetact->result() AS $rowba){
                                ?>
                                    <tr>
                                        <td class="kolom"><?= format_waktu2($rowba->budget_period); ?></td>
                                        <td class="kolom"><?= $rowba->arr; ?></td>
                                        <td class="kolom"><?= $rowba->room_night; ?></td>
                                        <td class="kolom"><?= $rowba->budget_status; ?></td>
                                    </tr>
                            <?php }//endforeach budget
                                    }else{
                                        echo '<tr><td  style="text-align: center" colspan=3><b>Target Not Available</b></td></tr>';
                                    }
                                    ?>
                                <?php }//endoforeach property?>
                            </table>
                        </div>
                    </div>
                        <!-- End #tab6 -->
                    </div> <!-- End .content-box-content -->
                </div>
                <!-- End .content-box -->
            </div>
            <!-- End box -->
        </div>
        <?= $this->load->view('main_footer'); ?>
    </body>
</html>