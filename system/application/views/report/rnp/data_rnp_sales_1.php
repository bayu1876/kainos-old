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
        
        Month : <?= $month?> 
        <table class="dashboard" style="width: 100%">
            <tr>
                <td class="kolom" style="text-align: center"><b>No.</b></td>
                <td class="kolom" style="text-align: center"><b>Date Production</b></td>
                <?php foreach($dt_sales AS $row){?>
                <td>
                    <?= $row->firstname?> <?= $row->lastname?>
                </td>
                <?php }//endforeach?>
                
            </tr>
            <?php 
            $no = 1;
            foreach($dt_rnpsales AS $row){
                $dt_confirm = $this->room_night_production_model->select_rnpdetail_by_rnp($row->idroomnightproduction);
                $revenue = 0;
                foreach($dt_confirm->result() AS $rowcl){
                    $dt_revroommeeting = $this->confirm_view_model->select_roommeetingrevenue_perconfirm($rowcl->confirmnumber_FK);
                    $dt_revroom = $this->confirm_view_model->select_roomonlyrevenue_perconfirm($rowcl->confirmnumber_FK);
                    if($dt_revroommeeting != NULL){
                        $revenue += $dt_revroommeeting->RevRoomMeeting;
                    }
                    if($dt_revroom != NULL){
                        $revenue += $dt_revroom->RevRoomOnly;
                    }
                }
            ?>
            <tr>
                <td class="kolom"  style="text-align: center"><?= $no++?></td>
                <td class="kolom"  style="text-align: center"><?= format_waktu2($row->date_production)?></td>
                <td class="kolom"><?= $row->firstname?> <?= $row->lastname?></td>
                <td class="kolom"  style="text-align: right"> 
                    <?= number_format($revenue,0,',','.')?>
                </td>
            </tr>
            <?php }// ?>
        </table>
    </body>
</html>
