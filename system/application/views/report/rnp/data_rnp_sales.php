<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
       
         <?php 
        $monthname = '';
        switch($month){
            case 1 :
                $monthname = 'January';
                break;
            case 2 :
                $monthname = 'February';
                break;
            case 3 :
                $monthname = 'Maret';
                break;
            case 4 :
                $monthname = 'April';
                break;
            case 5 :
                $monthname = 'May';
                break;
            case 6 : 
                $monthname = 'June';
                break;
            case 7 : 
                $monthname = 'July';
                break;
            case 8 :
                $monthname = 'August';
                break;
            case 9 :
                $monthname = 'September';
                break;
            case 10 :
                $monthname = 'October';
                break;
            case 11 :
                $monthname = 'November';
                break;
            case 12 :
                $monthname = 'December';
                break;
        }
        ?>
        <?php $totalpersales = array() ;
              $totalall = 0;
        ?>
        Month : <?= $monthname?>, Year : <?= $year;?>
        <table class="dashboard" style="width: 100%">
            <tr>
                <td class="kolom" style="text-align: center"><b>Date Production</b></td>
                <?php foreach($dt_sales->result() AS $row){
                    $totalpersales[$row->id] = 0; $totalroompersales[$row->id] = 0;
                    ?>
                <td class="kolom" style="text-align: center">
                    <?= $row->firstname?> <?= $row->lastname?>
                    
                </td>
                <td  class="kolom" style="text-align: center"></td>
                <?php }//endforeach?>
                <td class="kolom"  style="text-align: center">
                    <b>Total Revenue</b>
                </td>
            </tr>
            <?php 
            $jmlhari = date('t');
            $dt_dateproduction = $this->room_night_production_model->select_dateproduction_by_currentmonth_year($month,$year);
            
            //for($i=0;$i<$jmlhari;$i++){
            
            foreach($dt_dateproduction->result() AS $rowdp){
            ?>
            <tr>
                <td class="kolom"  style="text-align: center"><?php // date('d-m-Y',  strtotime(date('01-m-Y')."+$i day"))?><?= date('d-m-Y',strtotime($rowdp->date_production))?> </td>
                 <?php 
                    $totalrevperdate = 0;
                    foreach($dt_sales->result() AS $rowsales){
                     //$dt_rnp = $this->room_night_production_model->select_roomnightproduction_by_dateprod_sales(date('Y-m-d',  strtotime(date('01-m-Y')."+$i day")),$row->id);
                     $dt_rnp = $this->room_night_production_model->select_roomnightproduction_by_dateprod_sales($rowdp->date_production,$rowsales->id);
                     $qty_room = 0;
                     ?>
                <td class="kolom" style="text-align: center">
                    <?php if($dt_rnp->num_rows()>0){
                            $rowx = $dt_rnp->first_row();
                            $dt_rnpdetail = $this->room_night_production_model->select_rnpdetail_by_rnp($rowx->idroomnightproduction);
                            
                                $revenue = 0;
                            foreach($dt_rnpdetail->result() AS $rowdtl){
                                
                                $dt_confirmroom = $this->confirm_room_model->select_confirmroom_by_confirm($rowdtl->confirmnumber_FK);
                                $dt_roomeditmp = $this->confirm_mpackage_model->select_confirmmp_by_confirm2($rowdtl->confirmnumber_FK);
                                foreach($dt_confirmroom->result() AS $row){
                                    $qty_room += $row->qty_room;
                                    $revenue += $row->total * $row->night;
                                }
                                
                                foreach($dt_roomeditmp->result() As $row){
                                    $qty = 0;
                                    if ($row->idbedtype_FK == 1) {
                                        $qty = ceil($row->pax / 2);
                                    } elseif ($row->idbedtype_FK == 4) {
                                        $qty = ceil($row->pax / 3);
                                    } else {
                                        $qty = $row->pax;
                                    }
                                    $qty_room += $qty;
                                    $rev =  ($row->days) * $qty * $row->room_price;
                                    $revenue += $rev;
                                }
                                
                                $totalpersales[$rowsales->id] +=  $revenue;
                                     $totalroompersales[$rowsales->id] += $qty_room;
                            }//endforeach confirm
                            $totalrevperdate += $revenue;
                            $totalall += $totalrevperdate;
                            echo number_format($revenue,0,',','.');
                          }else{
                              echo 0;
                          } 
                     ?>
                </td>
                  <td  class="kolom" style="text-align: center"><?= $qty_room?></td>
                <?php }//endforeach?>
                <td class="kolom" style="text-align: right"><?= number_format($totalrevperdate,0,',','.')?></td>
            </tr>
            <?php }//endfor ?>
            <tr>
                <td class="kolom"></td>
                  <?php 
                    foreach($dt_sales->result() AS $row){
                        
                  ?>
                <td class="kolom" style="text-align: center">
                    <b><?= number_format($totalpersales[$row->id],0,',','.') ?></b>
                </td>
                  <td  class="kolom" style="text-align: center"><?= number_format($totalroompersales[$row->id],0,',','.') ?></td>
                <?php } ?>
                <td class="kolom" style="text-align: right"><b><?= number_format($totalall,0,',','.') ?></b></td>
            </tr>
        </table>
    </body>
</html>
