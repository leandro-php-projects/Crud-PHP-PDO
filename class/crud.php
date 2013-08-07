<?php
require realpath(dirname(__FILE__)).'\database.php';

class crud extends database
{
	public function save($table=false,$data=false)
	{
	  $conn = new database();	
	  
	  try{			
		  foreach($data as $keys=> $values)
		  { 
			$new_data[':'.$keys] = $values;
			$updatefields[] = $keys .' = :'.$keys;
		  }
		  
		  $fields             = implode(', ',array_keys($data));
		  $values             = implode(', ',array_keys($new_data));
		  $updatefields       = implode(', ',$updatefields);
  
		  $sql = ("INSERT INTO `".$table."` (" . $fields .') VALUES (' . $values . ') ON DUPLICATE KEY UPDATE ' . $updatefields);
	  
		  $conn->beginTransaction();
		  $stmt = $conn->prepare($sql);
		  
		  foreach($data as $keys=> $values)
		  { 
			  $stmt->bindValue(':'.$keys, $values);
		  }	
		  
		  $stmt->execute();
		  $id = $conn->lastInsertId();
		  $conn->commit();
		  
		  if($id)
		  {
			return $id;	
		  }	
				  
	  }catch(PDOException $e){
		  $conn->rollback();
		  echo 'Error: '.$e->getMessage();
	  }
	  
	}
	
	public function delete($table=false)
	{
		try {		
		$sql = "DELETE FROM `".$table."` WHERE `category` IN('education', 'programming')";
		$count = $conn->exec($sql);
		
		$conn = null;
		}
		catch(PDOException $e) {
			echo 'Error: '.$e->getMessage();
		}

	}
}