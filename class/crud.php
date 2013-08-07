<?php
require realpath(dirname(__FILE__)).'\database.php';

class crud extends database
{
	public function save($table=false,$data=false)
	{	  
	  try{
		  $conn = new database();	
		  if($data)
		  {	
			foreach($data as $keys=> $values)
			{ 
			  $new_data[':'.$keys] = $values;
			  $updatefields[] = $keys .' = :'.$keys;
			}
		  }
		  
		  $fields             = implode(', ',array_keys($data));
		  $values             = implode(', ',array_keys($new_data));
		  $updatefields       = implode(', ',$updatefields);
  
		  $sql = ("INSERT INTO `".$table."` (" . $fields .') VALUES (' . $values . ') ON DUPLICATE KEY UPDATE ' . $updatefields);
	  
		  $conn->beginTransaction();
		  $stmt = $conn->prepare($sql);
		 
		  if($data)
		  {	
			foreach($data as $keys=> $values)
			{ 
				$stmt->bindValue(':'.$keys, $values);
			}	
		  }
		  
		  $stmt->execute();
		  $id = $conn->lastInsertId();
		  $conn->commit();
		  
		  if($id)
		  {
			return "Insert ".$id;	
		  }	
				  
	  }catch(PDOException $e){
		  $conn->rollback();
		  echo 'Error: '.$e->getMessage();
	  }
	  
	}
	
	public function delete($table=false,$data=false)
	{	
		try {
			$conn = new database();
			if($data)
			{
			  foreach($data as $keys=> $values)
			  { 
				$conditions[] = $keys .' = :'.$keys;
			  }	
			  $conditions     = implode(' && ',$conditions);
			}
			$sql = ("DELETE FROM `".$table."` WHERE ".$conditions);
	
			$conn->beginTransaction();
		  	$stmt = $conn->prepare($sql);
			
			if($data)
			{				
			  foreach($data as $keys=> $values)
			  { 
				$stmt->bindValue(':'.$keys, $values);
			  }	
			}
			$stmt->execute();	
			$rows = $stmt->rowCount();		
			$conn->commit();
			
			
			return "Deleted ".$rows." rows";
			
		}
		catch(PDOException $e) {
			$conn->rollback();
			echo 'Error: '.$e->getMessage();
		}

	}
}