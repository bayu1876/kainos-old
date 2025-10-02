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
        <h3 style="text-align: center">ROOM NIGHT PRODUCTION MANUAL</h3>
        <table class="dashboard">
            <tr><td class="kolom" style="text-align: center"><b>No.</b></td>
                <td class="kolom" style="text-align: center"><b>Date</b></td>
                <?php foreach ($dt_sales->result() AS $row) { 
                    $totalrevpersales[$row->idsales_FK] = 0;
                    $totalroompersales[$row->idsales_FK] = 0;
                    ?>
                    <td class="kolom" style="text-align: center">
                        <b><?= $row->firstname ?></b>
                        
                    </td>
                    <td class="kolom"></td>

                <?php }//endforeach nama sales?>
                <td class="kolom" style="text-align: center"><b>Total Revenue</b></td>
                 <td class="kolom"></td>
            </tr>
            <?php 
            $totalallrev = 0;
            $totalallroom = 0;
            $no = 1;
            foreach ($dt_dateproduction->result() AS $rowdp) { ?>
                <tr><td class="kolom" style="text-align: center"><?= $no++?></td>
                    <td class="kolom" style="text-align: center"><?= date_mysql_to_php($rowdp->date_production) ?></td>
                    <?php 
                    $totalrevperdate = 0;
                    $totalroomperdate = 0;
                    foreach ($dt_sales->result() AS $row) { ?>
                        <td class="kolom" style="text-align: right">
                            <?php
                            $dt_rnpsales = $this->room_night_production_model->select_salesrnpmanualrevenue_per_date_sales($rowdp->date_production, $row->idsales_FK);
                            if ($dt_rnpsales != NULL) {
                                echo number_format($dt_rnpsales->revenue, 0, ',', '.');
                                $totalrevperdate += $dt_rnpsales->revenue;
                                $totalrevpersales[$row->idsales_FK] += $dt_rnpsales->revenue;
                            }
                            ?>
                        </td>
                        <td class="kolom" style="text-align: center"><?php
                    if ($dt_rnpsales != NULL) {
                        echo $dt_rnpsales->total_room;
                        $totalroomperdate +=$dt_rnpsales->total_room; 
                             $totalroompersales[$row->idsales_FK] += $dt_rnpsales->total_room;
                    }
                    ?>
                        </td>
                <?php } //endforeasch sales?>
                        <td class="kolom" style="text-align: right"><?= number_format($totalrevperdate, 0, ',', '.'); ?></td>
                        <td class="kolom"  style="text-align: center"><?= number_format($totalroomperdate, 0, ',', '.'); ?></td>
                </tr>
        <?php 
        $totalallrev += $totalrevperdate;
            $totalallroom += $totalroomperdate;
        }//endforeach date prod. ?>
                <tr>
                    <td class="kolom"></td>
                    <td class="kolom"></td>
                    <?php foreach ($dt_sales->result() AS $row) { ?>
                        <td class="kolom" style="text-align: right">
                            <b><?= number_format($totalrevpersales[$row->idsales_FK], 0, ',', '.') ?></b>
                        </td>
                        <td class="kolom" style="text-align: center"><b><?= number_format($totalroompersales[$row->idsales_FK], 0, ',', '.') ?></b></td>
                    <?php }//endforeach nama sales?>
                    <td class="kolom" style="text-align: right"><b><?= number_format($totalallrev, 0, ',', '.'); ?></b></td>
                    <td class="kolom" style="text-align: center"><b><?= number_format($totalallroom, 0, ',', '.'); ?></b></td>
                </tr>
        </table>
    </body>
</html>
