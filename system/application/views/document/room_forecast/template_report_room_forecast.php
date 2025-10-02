 <?php $numdays = $dt_forecast->num_rows();?>   
<h3 style="text-align: center">ROOM FORECAST <?=$month;?> <?= $year?></h3>
<table width="100%" border="1" class="dashboard">
                                    <tr>
                                        <td rowspan="2" class="kolom" style="width: 150px;vertical-align:bottom;text-align: center"><b>REMARK</b></td>
                                        <td class="kolom" colspan="<?= $numdays ?>"> </td>
                                        <td rowspan="2" class="kolom"  style="width: 100px"><b>Total</b></td>
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
                                            <td class="kolom" style="text-align: center"><b><?= $totalavailable;?></b></td>
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
                                            <td class="kolom" style="text-align: center"><b><?= $ttlrsv;?></b></td>
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
                                      <td class="kolom" style="text-align: center"><b><?= $ttlsamedayrsv;?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlocchand;?></b></td>
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
                                        <td class="kolom" style="text-align: center"><?= $ttlexparr;?></td>
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
                                                  $ttlforecast +=  $dt_tf->TotalForecast;
                                                 ?>
                                            </td>
                                        <?php } ?>
                                       <td class="kolom" style="text-align: center"><b><?= $ttlforecast;?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlcheckinbyrsv?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlwalkin?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlextend?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttldayuse;?></b></td>
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
                                            <b><?= $ttlcompliment;?></b>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlhouse;?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlcancel;?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="kolom">No Show</td>
                                        <?php 
                                        $ttlnoshow =0;
                                        foreach ($dt_forecast->result() AS $row) { 
                                            $ttlnoshow += $row->no_show;
                                            ?>
                                            <td class="kolom"><div id="<?= $row->roomforecastid ?>" class="editNoShow"><?= (int) ($row->no_show) ?></div> </td>
                                        <?php } ?>
                                        <td class="kolom" style="text-align: center"><b><?= $ttlnoshow;?></b></td>
                                    </tr>
                                    <tr>
                                        <td class="kolom">Total Room</td>
                                        <?php 
                                        $ttlroom = 0;
                                        foreach ($dt_forecast->result() AS $row) { 
                                          
                                            ?>
                                            <td class="kolom">
                                                <?php $dt_tr = $this->room_forecast_model->select_totalroom_by_roomforecastid($row->roomforecastid);
                                                      echo $dt_tr->TotalRoom;
                                                        $ttlroom += $dt_tr->TotalRoom;
                                                ?>
                                                
                                            </td>
                                        <?php } ?>
                                        <td class="kolom" style="text-align: center"><b><?= $ttlroom?></b></td>
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
                                        <td class="kolom" style="text-align: center"><b><?= $ttlpax?></b></td>
                                    </tr>
                                </table>