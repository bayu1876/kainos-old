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
        <script type="text/javascript" src="<?php echo base_url()?>js/jRoomforecastreport.js"></script>
        <style>
           .iStyleText{
                
               padding: 3px;
               border: 1px solid #ccc;
               -moz-border-radius: 5px;
               -webkit-border-radius: 5px;
           }
           .iStyleForm fieldset {
               padding: 10px;
               border: 1px solid #b4b4b4;
               -moz-border-radius: 10px;
               -webkit-border-radius: 10px;
           }
                
           .iStyleForm legend {
               padding: 5px 20px 5px 20px;
               color: #030303;
               -moz-border-radius: 6px;
               -webkit-border-radius: 6px;
               border: 1px solid #b4b4b4;
           }
           .iStyleForm fieldset {
               background-image: -moz-linear-gradient(top, #f7f7f7, #eae8e8); /* FF3.6 */
               background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #e5e5e5),color-stop(1, #f7f7f7)); /* Saf4+, Chrome */
           }
           .iStyleForm legend {
               background-image: -moz-linear-gradient(top, #f7f7f7, #fbfafa); /* FF3.6 */
               background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #e5e5e5),color-stop(1, #f7f7f7)); /* Saf4+, Chrome */
           }
                
           .iStyleSubmit {
               padding: 3px;
               width: 80px;
               color: #f3f3f3;
                 border: 1px ridge #a7a6a6;
               -moz-border-radius: 6px;
               -webkit-border-radius: 6px;
               background-image: -moz-linear-gradient(top, #a7a6a6, #cbcaca); /* FF3.6 */
                    
           }
                
          input.iStyleSubmit:hover {    
                          border: 1px ridge #3b5998;
                           color: #f3f3f3;
                           }
        </style>
    </head>
    <!-- // Head -->

    <!-- Body -->
    <body>
        <?= $this->load->view('main_header'); ?>
        <!-- Content wrapper -->
        <div class="content_wrap">
            
            <div class="box">
                <!-- Start Content Box -->
                <div class="content-box" style="width:960px;">
                    <div class="content-box-header">
                        <h3>Room Forecast</h3>
                        <ul class="content-box-tabs">
                            <li><a href="#tab1" class="default-tab">View Data</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content default-tab" id="tab1">
                            <div id="containerforecast">
                               <?php $numdays = $dt_forecast->num_rows();?>
                                 <?php 
                                            $opt_month_sel = '- Select Month -';
                                            $opt_month[''] = '- Select Month -';
                                            for ($i = 1; $i <= 12; $i++) {
                                                $opt_month[$i] = date('F', strtotime(date("d-$i-Y")));
                                            }
                                            $opt_year_sel = '- Select Year -';
                                            $opt_year[''] = '- Select Year -';
                                            foreach($year_period AS $row){
                                                $opt_year[$row->year] = $row->year;
                                            }
                                        ?>
                                <form id="formfilterforcast" method="post" class="iStyleForm">
                                    <fieldset>
                                        <legend>Filter By Month and Year</legend>
                                        Month : <?= form_dropdown('month',$opt_month,'','');?> Year : <?= form_dropdown('year',$opt_year,'','');?>
                                     
                                        <input type="submit" value="SUBMIT"   style="" id="btnShowing"/>   
                                    </fieldset>
                                </form>
                               <div id="containerdata" style="margin-top: 15px;padding-bottom: 20px;width: 100%; height: 100%; overflow:scroll;  scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888;overflow-y: hidden">
                                 
                                <h3 style="text-align: center">ROOM FORECAST <?= date('F'); ?> <?= date('Y') ?></h3>
                                    <table width="100%" border="1" class="dashboard">
                                        <tr>
                                            <td rowspan="2" class="kolom" style="width: 120px;vertical-align:bottom;text-align: center"><b>REMARK</b></td>
                                            <td class="kolom" colspan="<?= $numdays ?>"> </td>
                                            <td rowspan="2" class="kolom"  style="width: 50px;vertical-align:bottom;text-align: center"><b>Total</b></td>
                                        </tr>
                                        <tr>
                                            <?php foreach ($dt_forecast->result() AS $row) { ?>
                                                <td class="kolom"><?= date('d', strtotime($row->date_period)) ?></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="kolom"><b>FORECAST</b></td>
                                            <td class="kolom" colspan="<?= $numdays ?>"> </td>
                                            <td class="kolom"></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Total Available</td>
                                            <?php
                                            $totalavailable = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $totalavailable += $row->total_available;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editTotalAvailable"><?= (int) ($row->total_available) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $totalavailable; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom" colspan="<?= $numdays + 2 ?>"> </td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Reservation (on hand)</td>
                                            <?php
                                            $ttlrsv = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlrsv += $row->reservation_on_hand;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editReservationOnHand"><?= (int) ($row->reservation_on_hand) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlrsv; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Same day reservation</td>
                                            <?php
                                            $ttlsamedayrsv = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlsamedayrsv += $row->same_day_reservation;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editSameDayReservation"><?= (int) ($row->same_day_reservation) ?></div></td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlsamedayrsv; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Occupancy on hand</td>
                                            <?php
                                            $ttlocchand = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlocchand += $row->occupancy_on_hand;
                                                ?>
                                                <td class="kolom">
                                                    <div id="<?= $row->roomforecastid ?>" class="editOccupancyOnHand"><?= (int) ($row->occupancy_on_hand) ?></div>
                                                </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlocchand; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Exp. Arr W/I</td>
                                            <?php
                                            $ttlexparr = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlexparr += $row->exp_arr_w_i;
                                                ?>
                                                <td class="kolom">
                                                    <div id="<?= $row->roomforecastid ?>" class="editExpArr"><?= (int) ($row->exp_arr_w_i) ?></div> 
                                                </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><?= $ttlexparr; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Total Forecast</td>
                                            <?php
                                            $ttlforecast = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                ?>
                                                <td class="kolom">
                                                    <?php
                                                    $dt_tf = $this->room_forecast_model->select_totalforecast_by_roomforecastid($row->roomforecastid);
                                                    echo $dt_tf->TotalForecast;
                                                    $ttlforecast += $dt_tf->TotalForecast;
                                                    ?>
                                                </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlforecast; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom" colspan="<?= $numdays + 2 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom"><b>CURRENT</b></td>
                                            <td class="kolom" colspan="<?= $numdays + 1 ?>"> </td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Check in by Rsv</td>
                                            <?php
                                            $ttlcheckinbyrsv = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlcheckinbyrsv += $row->checkin_by_rsv;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editCheckinByReservation"><?= (int) ($row->checkin_by_rsv) ?></div>
                                                </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlcheckinbyrsv ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Walk In</td>
                                            <?php
                                            $ttlwalkin = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlwalkin += $row->walk_in;
                                                ?>
                                                <td class="kolom">
                                                    <div id="<?= $row->roomforecastid ?>" class="editWalkIn"><?= (int) ($row->walk_in) ?></div>
                                                </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlwalkin ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Extend</td>
                                            <?php
                                            $ttlextend = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlextend += $row->extend;
                                                ?>
                                                <td class="kolom">
                                                    <div id="<?= $row->roomforecastid ?>" class="editExtend"><?= (int) ($row->extend) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlextend ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Day Use</td>
                                            <?php
                                            $ttldayuse = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttldayuse += $row->day_use;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editDayUse"><?= (int) ($row->day_use) ?></div>  </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttldayuse; ?></b></td>
                                        </tr>
                                            
                                        <tr>
                                            <td class="kolom">Compliment</td>
                                            <?php
                                            $ttlcompliment = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlcompliment += $row->compliment;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editCompliment"><?= (int) ($row->compliment) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center">
                                                <b><?= $ttlcompliment; ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">House Use</td>
                                            <?php
                                            $ttlhouse = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlhouse += $row->house_use;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editHouseUse"><?= (int) ($row->house_use) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlhouse; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Cancel</td>
                                            <?php
                                            $ttlcancel = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlcancel += $row->cancel;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editCancel"><?= (int) ($row->cancel) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlcancel; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">No Show</td>
                                            <?php
                                            $ttlnoshow = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlnoshow += $row->no_show;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editNoShow"><?= (int) ($row->no_show) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlnoshow; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Total Room</td>
                                            <?php
                                            $ttlroom = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                ?>
                                                <td class="kolom">
                                                <?php
                                                $dt_tr = $this->room_forecast_model->select_totalroom_by_roomforecastid($row->roomforecastid);
                                                echo $dt_tr->TotalRoom;
                                                $ttlroom += $dt_tr->TotalRoom;
                                                ?>
                                                        
                                                </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlroom ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="kolom">Total Pax</td>
                                            <?php
                                            $ttlpax = 0;
                                            foreach ($dt_forecast->result() AS $row) {
                                                $ttlpax += $row->total_pax;
                                                ?>
                                                <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editTotalPax"><?= (int) ($row->total_pax) ?></div> </td>
                                            <?php } ?>
                                            <td class="kolom" style="text-align: center"><b><?= $ttlpax ?></b></td>
                                        </tr>
                                    </table>
                                </div>
                                </div>
                               
                            </div>
                        </div>
                        <!-- End #tab1 -->
                  </div> <!-- End .content-box-content -->
                </div>
                <!-- End .content-box -->
            </div>
             <!-- End box -->
<!--
        </div>
-->    
<!-- // END Content wrapper -->


        <?= $this->load->view('main_footer'); ?>



    </body>
</html>