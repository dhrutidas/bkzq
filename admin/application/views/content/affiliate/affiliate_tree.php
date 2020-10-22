<script src="<?php echo base_url("assets/js/getorgchart.js"); ?>"></script>
<link href="<?php echo base_url("assets/css/getorgchart.css"); ?>" rel="stylesheet" />
<?php $userDetails = $this->session->userdata('user_details');

if($userDetails['role_id'] == 1){
    ?>
    <div>
    <?php echo form_open('affiliate-tree'); ?>        
    <select id="affiliateusr" name="affiliateusr" required> 
        <option value=''>Select</option>
        <?php foreach($allaffiliates as $user ) { ?>
<option value="<?php echo $user['userID']; ?>" <?php echo ($affiliateUsr == $user['userID'])? 'selected': ''; ?>><?php echo $user['fName']; ?></option>
         <?php   }?>
    </select>

    <button type="submit" id="generateTree" />Generate tree</button>
        <?php echo form_close(); ?>
        </div>
    <?php
}
?>
<div id="people"></div>
<div class="loading" style="text-align:center"><img src="<?php echo base_url('assets/images/loader.gif')?>"></div>

<script type="text/javascript">
$('.loading').show();
    var url = '<?php echo base_url('Affiliate/displayTree/'.$affiliateUsr); ?>';
        $.getJSON(url, function (source) {
            $('.loading').hide();
            var peopleElement = document.getElementById("people");
            var orgChart = new getOrgChart(peopleElement, {
                theme: "deborah",
                primaryFields: ["name", "lName"],
                photoFields: ["pic"],
                orientation: getOrgChart.RO_TOP,
            enableZoom: false,
            enableDetailsView: false,
            enableEdit: false,
            enableSearch: false,
            enableMove: true,
                linkType: "M",    
                expandToLevel: 100,            
                dataSource: source,
                enableExportToImage:true,
                boxSizeInPercentage: {
            minBoxSize: {
                width: 5,
                height: 5
            },
            boxSize: {
                width: 20,
                height: 20
            },
            maxBoxSize: {
                width: 100,
                height: 100
            }
        } 
            });
        });
        
    </script>