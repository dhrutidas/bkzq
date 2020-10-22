
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
	 $(function () {
        $('#datetimepicker1').datetimepicker({
        	viewMode: 'years',
            format: 'MM-YYYY'
        });
    });
    $(function () {
        $('#datetimepicker2').datetimepicker({
        	viewMode: 'years',
            format: 'MM-YYYY'
        });
    })
    function get_rank(){
    	window.location.href='profile?from='+$('.from_date').val()+'&to='+$('.to_date').val();
	};
</script>