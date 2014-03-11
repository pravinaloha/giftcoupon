<html>
	<head></head>
	<body>
		<form action="" method="post">
			<input type="text" name="ids">Enter (,) separated ids.
			<input type="submit">
			<input type="reset">
		</form> 
	</body>
</html>

<?php
//phpinfo();
ini_set('display_errors',1);

require_once('app/Mage.php');

umask(0);
Mage::app ()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

//$idArray = array(11,12,13,14,15,16,17,18,19,20,21);
ini_set('max_execution_time', 36000);
$idArray = explode(',', isset($_REQUEST['ids'])?$_REQUEST['ids']:array());
$model = Mage::getModel('bloyalMaster/execution');
/*
if(count($idArray)){
	foreach ($idArray as $key => $id) {
	    try {
		$model->setId($id)->delete();
		echo $id. " - Data deleted successfully.<br>"; 
	    } catch (Exception $e){
		echo $e->getMessage();
	    }
	}
}
*/
for($i=1; $i<=1000; $i++){

	    try {
		$model->setId($i)->delete();
		echo $i. " - Data deleted successfully.<br>"; 
	    } catch (Exception $e){
		echo $e->getMessage();
	    }

}


?>
