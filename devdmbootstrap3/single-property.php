<?php
/*
Template Name: Teste Single Property
*/
?>
<?php ob_start();
 define('WP_USE_THEMES', true);
 require ('wp-load.php');
 include(locate_template('header.php'));
 $id = (isset($_GET['id'])) ? $_GET['id'] : null;
 $dbh = new PDO('mysql:host=' . DB_HOST . ';
dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
 $sql = "SELECT * FROM em_properties WHERE id = :id AND status = 'Ativo'";
 $sth = $dbh -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
 $sth -> execute(array(':id' => $id));
 $result = $sth -> fetchAll();
 if (empty($result)) { $url = home_url();
 echo <<<TEXT
	<script type="text/javascript">
	alert('Nada encontrado!');

	window.location.href = '$url';

	</script>
TEXT;
exit ;
 } else { $sql = 'SELECT * FROM em_photos WHERE property_id = :id ORDER BY principal ASC';
 $sth = $dbh -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
 $sth -> execute(array(':id' => $id));
 $result[0]['photos'] = $sth -> fetchAll();
 $sql = 'SELECT * FROM em_attributes WHERE property_id = :id';
 $sth = $dbh -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
 $sth -> execute(array(':id' => $id));
 $result[0]['attributes'] = $sth -> fetchAll();
 $sql = 'SELECT * FROM em_professionals WHERE property_id = :id';
 $sth = $dbh -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
 $sth -> execute(array(':id' => $id));
 $result[0]['professionals'] = $sth -> fetchAll();
 } 
?>


<?php get_template_part('template-part', 'head'); ?>


<?php get_template_part('template-part', 'topnav-new');
 
?>
<div class="clearfix"></div>
<!-- start content container -->
<div class="dmbs-content content">
<?php include(locate_template('template-part-topsearch-new.php')); ?>
		<div class="breadcrumbs breadcrumb--property" typeof="BreadcrumbList" vocab="http://schema.org/">
			<div class="container">
				<div class="row">
					<?php 
					if (function_exists('bcn_display')) { 
						bcn_display(); 
					} 
					?>
					&gt;
					<span property="itemListElement" typeof="ListItem">
						<span property="name"> 
							<?php echo utf8_encode(sprintf('%s em %s / %s', $result[0]['categoria_modelo_unidade_descricao'], $result[0]['bairro'], $result[0]['localidade'])) ?>
						</span>
						<meta property="position" content="2">
					</span>
				</div>
			</div>
		</div>
		<div class="single-property">
				<?php include (locate_template('template-part-property-new.php')); ?>
				<div class="feature-properties">
					<div class="container">
						<div class="row">
							<?php include (locate_template('template-part-featureproperties-new.php')); ?>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
<!-- end content container -->

<?php get_footer('new'); ?>


