<div id="sidebar150px">
    <div class="box">

        <div class="content150px">
            <?php
                $akses = $this->session->userdata('userlevel');
            ?>
            <ul>
                <?php if(in_array("Group Confirm", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/group.png" alt="">&nbsp; <?= anchor('report','Business Result' ); ?> </li>
                <?php } ?>
                <?php if(in_array("Business Cancel", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/group.png" alt="">&nbsp; <?= anchor('report/business_cancel','Business Cancel' ); ?> </li>
                <?php } ?>
                <?php if(in_array("Sales Segment", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/recur.png" alt="">&nbsp; <?= anchor('report/sales_segment','Sales By Group' ); ?></li>
                <?php } ?>
                
                <?php if(in_array("Sales Person", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/admin.png" alt="">&nbsp; <?= anchor('report/sales','Sales By Individual' ); ?></li>
                <?php } ?>

                 <?php if(in_array("Company", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/icon_home.gif" alt="">&nbsp; <?= anchor('report/account','Sales By Company' ); ?></li>
                <?php } ?>

                <?php if(in_array("Hotel", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/property2.png" alt="">&nbsp; <?= anchor('report/hotel','Sales By Hotel' ); ?></li>
                <?php } ?>
                 <?php if(in_array("Sales Activities", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/icon_user.gif" alt="">&nbsp; <?= anchor('report_activities','Sales Activities' ); ?></li>
                <?php } ?>

                 <?php if(in_array("Sales Performance", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/sales-target.png" alt="">&nbsp; <?= anchor('sales_performance','Sales Performance' ); ?></li>
                <?php } ?>
                
                 <?php if(in_array("Room Forecast Report", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/event-type.png" alt="">&nbsp; <?= anchor('room_forecast/report_room_forecast','Room Forecast' ); ?></li>
                <?php } ?>

                <?php if(in_array("Banquet Activity", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/property2.png" alt="">&nbsp; <?= anchor('report_activities/banquet_activity','Banquet Activities' ); ?></li>
                <?php } ?>

                <?php if(in_array("Package", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/box.png" alt="">&nbsp; <?= anchor('package_report','Package' ); ?></li>
                <?php } ?>
                 <?php if(in_array("Room Night Production", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/box.png" alt="">&nbsp; <?= anchor('room_night_production','RNP' ); ?></li>
                <?php } ?>
                <?php if(in_array("Room Night Production Manual", $akses)){?>
                <li><img src="<?=base_url()?>/images/icon/box.png" alt="">&nbsp; <?= anchor('room_night_production_manual','RNP Manual' ); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div> 
</div>