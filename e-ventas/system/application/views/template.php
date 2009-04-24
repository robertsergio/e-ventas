<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//ES">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href=" <?= base_url();?>css/default.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="<?= base_url();?>js/prototype.js"></script>
		<script type="text/javascript" src="<?= base_url();?>js/effects.js"></script>
		<script type="text/javascript" src="<?= base_url();?>js/controls.js"></script>
		<script type="text/javascript" language="javascript">
        	baseUrl = "<?=base_url(); //Importante variable?>";
        </script>
		<script type="text/javascript" src="<?= base_url();?>js/funciones.js"></script>
        <title></title>
    </head>
    <body>
       <div id="wrapper">
       		<div id="login_logout">
					<?=anchor('inicio/logout','Logout')?>
			</div>
       		<div id="header">
                <?php $this->load->view('header'); ?>
            </div>
         	<div id="nav">
                <?php $this->load->view('navigation'); ?>
            </div>
            
            <div id="main">
                
					<?php if($mensaje=$this->session->flashdata('mensaje'))
					{
						echo '<div id="mensaje">';
								echo $mensaje; 
						echo'</div>';
					}
					
					
					?>
				
                <?php $this->load->view($main); ?>
            </div>
            <div id="footer">
                <?php $this->load->view('footer'); ?>
            </div>
       </div>
    </body>
</html>
