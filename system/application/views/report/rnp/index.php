<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- Head -->
    <head>
        <?= $this->load->view('title');?>
        <?= $this->load->view('main_link'); ?>
        <link rel="stylesheet" href="<?= base_url(); ?>css/ui-lightness/jquery-ui-1.8.5.custom.css" type="text/css"  />
        <link rel="stylesheet" href="<?php echo base_url() ?>css/tab.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.5.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validator/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validator/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/iscroll.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jRoomnightproduction.js"></script>
         
    </head>
    <!-- // Head -->
    <!-- Body -->
    <body>
        <?= $this->load->view('main_header'); ?>
        <!-- Content wrapper -->
        <div class="content_wrap">
            <?= $this->load->view('report/submenu'); ?>
            <div class="box">
                <!-- Start Content Box -->
                <div class="content-box">
                    <div class="content-box-header">
                        <h3>Room Night Production</h3>
                        <ul class="content-box-tabs">
                            <li><a href="#tab1">View Data</a></li> <!-- href must be unique and match the id of target div -->
                            <li><a href="#tab2" class="default-tab">Add Data</a></li>
                        </ul>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content " id="tab1">
                            <?php 
                            $opt_month[''] = '- Select Month -';
                            foreach($dt_monthprod->result() AS $rowmonth){
                                $opt_month[$rowmonth->month] = $rowmonth->monthname;
                            }//endforeach
                            
                            $opt_year[''] = '- Select Year -';
                            foreach($dt_yearprod->result() AS $rowyear){
                                $opt_year[$rowyear->year] = $rowyear->year;
                            }
                            
                            ?>
                                
                            <?= form_open('room_night_production/print_pdf_rnp');?> 
                            Select Month : <?= form_dropdown('month',$opt_month,'','id="monthprint"');?>, Year : <?= form_dropdown('year',$opt_year,'','id="yearprint"');?> <input type="submit" value="PRINT PDF" id="btnsubmit"/><br/><br/>
                           
                            <?= form_close();?>
                            <div id="divcontainer" style="overflow: auto">
                                <div id="containerrnpsales">
                                
                                </div>
                           </div>
                        </div>
                        <!-- End #tab1 -->
                        <div class="tab-content default-tab" id="tab2">
                            <?= form_open('','id="formroomnightproduction"')?>
                            Date : <input type="text" size="10" id="dateproduction" name="dateproduction"/> Sales : <?= form_dropdown('sales',$opt_sales,'','id="sales"')?>
                            <input type="submit" value="GO" />
                            <?= form_close();?>
                            <br/> 
                            <div id="containerdatarnp">
                                
                            </div>
                        </div>
                        <!-- End #tab2 -->
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