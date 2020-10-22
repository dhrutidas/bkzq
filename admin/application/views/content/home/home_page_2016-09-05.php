<script type="text/javascript" src="<?php echo base_url("assets/js/highcharts.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/exporting.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/highchart_data.js"); ?>"></script>

<div class="row">

<div class="col-md-12">

    <div class="panel panel-default">
        <div class="panel-heading text-left">Welcome, <b><?php echo $this->sData['s_emp_name']; ?></b>
            <div class="pull-right">
            <span>
                <select id='region' class="form-control input-group-sm">
                    <option value="ALL">ALL INDIA</option>
                    <option value="EAST">EAST</option>
                    <option value="WEST">WEST</option>
                    <option value="NORTH">NORTH</option>
                    <option value="SOUTH">SOUTH</option>
                </select>
            </span>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Status Summary</b>
                        </div>
                        <div class="panel-body">
                            <div id="container_all"></div>
                            <table class="table" >
                                <thead> <tr> <th>Status</th> <th>Number</th><th>Percentage</th></tr> </thead>
                                <tbody><?php $total = $CLOSED + $OPEN + $RESOLVED + $CANCELLED; ?>
                                    <tr> 
                                        <td>Closed</td> 
                                        <td id='closed_num'><?php echo $CLOSED; ?></td>
                                        <td id='closed_per'><?php echo round((($CLOSED / $total) * 100)) . '%'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Open</td>
                                        <td id='open_num'><?php echo $OPEN; ?></td>
                                        <td id='open_per'><?php echo round((($OPEN / $total) * 100), 2) . '%'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Resolved</td>
                                        <td id='resolved_num'><?php echo $RESOLVED; ?></td>
                                        <td id='resolved_per'><?php echo round((($RESOLVED / $total) * 100), 2) . '%'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b> Complaint Type - Status Summary</b>
                        </div>
                        <div class="panel-body">
                            <div id="container"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
            <div class="col-md-12">
                
            <ul class="nav nav-tabs" id="nav_tabs">
                <li class="active">
                    <a data-toggle="pill" href="#Category" id="href_category">Category Analysis</a>
                </li>
                <li>
                    <a data-toggle="pill" href="#Product" id="href_product">Product Analysis</a>
                </li>
                <li>
                    <a data-toggle="pill" href="#Channel" id="href_channel">Channel Analysis</a>
                </li>
                <li>
                    <a data-toggle="pill" href="#TAT" id="href_tat">TAT Analysis</a>
                </li>
            </ul>
            <!--Tab Content-->
            <div class="tab-content">
                
                <div id="Category" class="row tab-pane fade in active">
                    <!--Category Analysis -->

                    <div class="col-md-6">
                        <div class="panel panel-default top-buffer-xl">
                            <div class="panel-heading">
                                <b>Category</b>
                                <div class="pull-right">
                                    <select id='cmp_type_selection' class="form-control" >
                                        <?php foreach ($complaint_data as $ctype): ?>
                                            <option value="<?php echo $ctype['complaint_type_code']; ?>">
                                                <?php echo $ctype['complaint_type_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <div id="cmp_type_product"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default top-buffer-xl">
                            <div class="panel-heading">
                                <b>Complaint Type</b>
                                <div class="pull-right">
                                    <select id='category_selection' class="form-control" >
                                        <?php foreach ($categoryArr as $ccat): ?>
                                            <option value="<?php echo $ccat['category_code']; ?>" <?php echo ($ccat['category_code'] =="C006") ? "selected": ""; ?>>
                                                <?php echo $ccat['category_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <div id="product_cmp_type"></div>
                            </div>
                        </div>
                    </div>
                        
                    <!--end of category analysis -->
                </div>               

                <div id="Product" class="row tab-pane fade">
                    
                <div class="col-md-12">
                    
                    <div class="panel panel-default top-buffer-xl">
                        <div class="panel-heading">
                            <b>Product - Complaint Status</b>
                            <div class="pull-right">
                                <select id='cmp_status' class="form-control" >
                                    <option value="OPEN">OPEN</option>
                                    <option value="CLOSED">CLOSED</option>
                                    <option value="RESOLVED">RESOLVED</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="container_sub_cat"></div>
                        </div>
                    </div>
                    
                </div>
                
                </div>
                
                
                <div id="Channel" class="row tab-pane fade">
                    
                <div class="col-md-12">
                    
                    <div class="panel panel-default top-buffer-xl">
                        <div class="panel-heading">
                            <b>Channel - Product Category</b>
                        </div>
                        <div class="panel-body">
                            <div id="container_channel"></div>
                        </div>
                    </div>
                    
                </div>
                
                </div>

                <!-- TAT Analysis START @shrikant mavlankar #08092915 -->
                <div id="TAT" class="row tab-pane fade">
                    
                <div class="col-md-4">
                    <div class="panel panel-default top-buffer-xl">
                    <div class="panel-heading">
                        <b>Complaint Type</b>
                        <div class="pull-right">
                            <select id="select_tat_complaint_type" class="form-control">

                                <?php foreach ($complaint_data as $ctype): ?>

                                        <option value="<?php echo $ctype['complaint_type_code']; ?>">
                                            <?php echo $ctype['complaint_type_name']; ?>
                                        </option>

                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div id="container_tat_complaint_type"></div>
                    </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default top-buffer-xl">
                    <div class="panel-heading">
                        <b>Product Category</b>
                        <div class="pull-right">
                            <select id="select_tat_product_cat" class="form-control">
                                <?php foreach ($categoryArr as $ccat): ?>
                                    <option value="<?php echo $ccat['category_code']; ?>">
                                        <?php echo $ccat['category_name']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div id="container_tat_product_cat"></div>
                    </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default top-buffer-xl">
                    <div class="panel-heading">
                        <b>Channel</b>
                        <div class="pull-right">
                        <select class="form-control" id="select_tat_channel" name="inputChannel">
                            <?php foreach( $ChannelArr as $cChannel  ): ?>

                                <option value="<?php echo $cChannel['channel_code']; ?>">
                                    <?php echo $cChannel['channel_name']; ?>
                                </option>

                            <?php endforeach; ?>
                        </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div id="container_tat_channel"></div>
                    </div>
                    </div>
                </div>

                </div>
                <!-- TAT Analysis END -->
            </div>                    
            </div>
            </div>


            <!--Tab Content-->
        </div>
    </div>
</div>

</div>
