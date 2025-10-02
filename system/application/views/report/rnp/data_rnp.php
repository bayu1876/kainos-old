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
            $(document).ready(function(){
                $("#formrnp").submit(function(){
                     $.ajax({
                type:"POST",
                url: site_url+"room_night_production/submit_roomnightproduction",
                
                data:$(this).serialize(),
                success: function(data){
                    $("#containerdatarnp").html(data);
                },
                beforeSend: function(){
                    $("#containerdatarnp").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
                    return false;
                })
            })
    </script>
    </head>
    <body>
        <?= form_open('','id="formrnp"');?>
        <input type="hidden" name="salesrnp" value="<?= $sales?>"/>
        <input type="hidden" name="daternp" value="<?= $dateproduction?>"/>
        <table class="dashboard">
            <tr>
                <th class="kolom" style="text-align: center">No.</th>
                <th class="kolom" style="text-align: center">Company</th>
                <th class="kolom" style="text-align: center">Contact</th>
                <th class="kolom" style="text-align: center">Confirm Number</th>
                <th class="kolom" style="text-align: center">Total Room</th>
                <th class="kolom" style="text-align: center">Revenue</th>
            </tr>
            <?php
                foreach($confirmnumber_rnp AS $key=>$val){
                $qty_room = 0;
                $revenue = 0;
                
                $dt_contact = $this->confirmaccounts_model->select_confirmcontact_by_confirm($val);
                $dt_confirmroom = $this->confirm_room_model->select_confirmroom_by_confirm($val);
                $dt_roomeditmp = $this->confirm_mpackage_model->select_confirmmp_by_confirm2($val);
                
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
            ?>
            <tr>
                <td class="kolom" style="text-align: center"><?= $key+1?></td>
                <td class="kolom"><?= $dt_contact->account_name?></td>
                <td class="kolom"><?= $dt_contact->salutation?> <?= $dt_contact->firstname?> <?= $dt_contact->lastname?></td>
                <td class="kolom"><?= $val?><input type="hidden" name="confirmnumber[]" value="<?=$val?>"/></td>
                <td class="kolom" style="text-align: center"><?= $qty_room?></td>
                <td class="kolom" style="text-align: right"><?= number_format($revenue,0,',','.')?></td>
            </tr>
            <?php }//endforeach ?>
            <tr>
                <td colspan="6" style="text-align: center"><input type="submit" value="Submit"/></td>
            </tr>
            </table>
            
        <?= form_close();?>
    </body>
</html>
