<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- Head -->
    <head>
        <?= $this->load->view('title');?>
        <?= $this->load->view('main_link'); ?>
           <link rel="stylesheet" type="text/css" href="<?= base_url();?>css/ui-lightness/jquery-ui-1.7.2.custom.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>css/tab.css" type="text/css" media="screen" />
      <script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validator/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validator/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/autocomplete/jquery.ajaxQueue.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/autocomplete/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jRoomnightproductionmanual.js"></script>
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
                        <h3>Room Night Production Manual</h3>
                        <ul class="content-box-tabs">
                            <li><a href="#tab1">View Data</a></li> <!-- href must be unique and match the id of target div -->
                            <li><a href="#tab2" class="default-tab">Add Data</a></li>
                        </ul>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content " id="tab1">
                            
                        </div>
                        <!-- End #tab1 -->
                        <div class="tab-content default-tab" id="tab2">
                            <table style="padding: 10px">
                                <tr>
                                    <td style="width: 100px;padding: 10px">Date Production</td>
                                    <td><input type="text" id="dateproduction" name="dateproduction"/></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding: 10px">Sales</td>
                                    <td><?= form_dropdown('sales',$opt_sales,'','id="sales" style="width:145px"')?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding: 10px">Company</td>
                                    <td><input type="text" id="company" name="company" class="company"/></td>
                                </tr>
                                 <tr>
                                    <td style="width: 100px;padding: 10px">Contact</td>
                                    <td><div id="containercontact" class="containercontact">Please select company first</div></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding: 10px">Total Room</td>
                                    <td><input type="text" name="totalroom" id="totalroom" class="totalroom"/> </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding: 10px">Revenue</td>
                                    <td><input type="text" name="revenue" id="revenue" class="revenue"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center"><input type="submit" name="submit" value="ADD"/></td>
                                </tr>
                            </table>
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