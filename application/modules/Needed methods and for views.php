	</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
} );

</script>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
</html>

<?php

	SessionExist();	
	$this->currentuser = $this->session->userdata("currentuser");

?>