<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- Head -->
    <head>
        <?= $this->load->view('title');?>
        <?= $this->load->view('main_link'); ?>
         <link rel="stylesheet" href="<?= base_url(); ?>css/ui-lightness/jquery-ui-1.8.5.custom.css" type="text/css"  />
        <link rel="stylesheet" href="<?php echo base_url()?>css/tab.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/validator/validationEngine.jquery.css" />
        <script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui-1.8.5.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/validator/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/validator/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/jRoomforecast.js"></script>
    </head>
    <!-- // Head -->

    <!-- Body -->
    <body>
        <?= $this->load->view('main_header'); ?>
        <!-- Content wrapper -->
        <div class="content_wrap">
             
            <div class="box">
                <!-- Start Content Box -->
                <div class="content-box" style="width:980px;">
                    <div class="content-box-header">
                        <h3>Room Forecast</h3>
                        <ul class="content-box-tabs">
                            <li><a href="#tab1" class="default-tab">Add Data</a></li>
                            <li><a href="#tab2">Add Period</a></li>
                           <!-- <li><a href="#tab3">View Data Master</a></li>
                            <li><a href="#tab4">Add Data Master</a></li>
                           -->
                           </ul>
                        <div class="clear"></div>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content default-tab" id="tab1">
                             <?= form_open('','id="formroomforecast"');?>
                            <table >
                                    <tr>
                                        <td style="text-align: right;width:60px;padding: 5px; ">Month</td>
                                        <td>
                                            <?php 
                                                #$opt_monthforecast_sel = '- Select Month -';
                                                $opt_monthforecast[''] = '- Select Month -';
                                                foreach($dt_monthforecast AS $rowmonth){
                                                    //$opt_monthforecast[$rowmonth->month] = date('F', strtotime(date("d-$rowmonth->month-Y"))); 
                                                    $opt_monthforecast[$rowmonth->month] = $rowmonth->mname; 
                                                }
                                                #$opt_yearforecast_sel = '- Select Year -';
                                                $opt_yearforecast[''] = '- Select Year -';
                                                foreach($dt_yearforecast AS $rowyear){
                                                     $opt_yearforecast[$rowyear->year] = $rowyear->year;
                                                }
                                                echo form_dropdown('monthroomforecast', $opt_monthforecast,'', 'id="month"');
                                            ?>
                                        </td>
                                        <td style="text-align: right;width: 60px;padding: 5px">Year</td>
                                        <td><?php  echo form_dropdown('yearroomforecast',$opt_yearforecast,'','id="year"');?></td>
                                        <td style="text-align: center;width: 60px;padding: 5px" colspan="2"> 
                                            <input type="submit" name="submitforecast" value="GO" id="btnSubmitforecast"  /> 
                                        </td>
                                        <td style="text-align: right;width: 500px"><input type="submit" name="btnPage1_filter" value="Page1" id="btnPage1_filter"  /> <input type="submit" name="btnPage2_filter" value="Page2" id="btnPage2_filter"  /> </td>
                                    </tr>
                                </table>
                            <input type="hidden" name="page" value="1" id="page"  />
                                <?= form_close()?>
                            <div id="containerforecast">
                            </div>
                           
                            <br/>
                            <div id="container_remarkforecast">
                            </div>
                            <div id="container_remarkforecast_alert">
                            </div>
                            
                        </div>
                        <!-- End #tab1 -->
                        <div class="tab-content" id="tab2">
                             <?= form_open('room_forecast/add_roomforecast_period','id="formforecastperiod"');?>
                            <table >
                                    <tr>
                                        <td style="text-align: right;width:60px;padding: 5px; ">Month</td>
                                        <td>
                                            <?php 
                                                $opt_month_sel = '- Select Month -';
                                                $opt_month[''] = '- Select Month -';
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $opt_month[$i] = date('F', strtotime(date("d-$i-Y")));
                                                }
                                                $opt_year_sel = '- Select Year -';
                                                $opt_year[''] = '- Select Year -';
                                                $opt_year[date('Y')] = date('Y');
                                                $opt_year[date('Y') + 1] = date('Y') + 1;
                                                $opt_year[date('Y') + 2] = date('Y') + 2;
                                                echo form_dropdown('month', $opt_month,'', 'id="month"');
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 60px;padding: 5px">Year</td>
                                        <td><?php  echo form_dropdown('year',$opt_year,'','id="year"');?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;width: 60px;padding: 5px" colspan="2"> 
                                            <input type="submit" name="submit" value="Submit" id="btnSubmit1"  /> 
                                        </td>
                                    </tr>
                                </table>
                                <?= form_close()?>
                                <div id="processing" ></div>
                                
                                <div id="containerperiod">
                                    
                                </div>
                        </div>
                        <!-- End #tab2 -->
                        <!--
                        <div class="tab-content" id="tab3">
                              
                        </div>
                        -->
                        <!-- End #tab3 -->
                         <!--
                        <div class="tab-content" id="tab4">
                            <p>
                                <div id="processingx" >
                                        
                                </div>
                            </p>
                        </div>
                        -->
                        <!-- End #tab4 -->
                   </div> <!-- End .content-box-content -->
                </div>
                <!-- End .content-box -->
            </div>
             <!-- End box -->

        </div>
        <!-- // END Content wrapper -->


        <?= $this->load->view('main_footer'); ?>



    </body>
</html>