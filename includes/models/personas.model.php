<?php

class Personas {
	
	public $id;
	public $nombre;
	public $direccion;
	public $fechaCreacion;
	
	public static function getBySql($sql) {
		
		// Open database connection
		$database = new Database();
		
		// Execute database query
		$result = $database->query($sql);
		
		// Initialize object array
		$objects = array();
		
		// Fetch objects from database cursor
		while ($object = $result->fetch_object()) {
			$objects[] = $object;
		}
		
		// Close database connection
		$database->close();

		// Return objects
		return $objects;	
	}
	
	
	public static function getAll() {

		// Build database query
		$sql = 'select * from datos';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getInstance($object) {		
		$instance = new self();
		
		if(isset($object->nombre) && isset($object->direccion)) 
		{
			$instance->nombre = $object->nombre;
			$instance->direccion = $object->direccion;
			return $instance;
		} else {
			throw new Exception('Error al crear la instancia');
		}
	}

	public function setId($id) {
		$this->id = $id;
	}

	public static function getInfoUpdate($id) {
		$sql = "SELECT id, nombre, direccion from datos where id = " . $id;
		
		$database = new Database();
		$statement = $database->stmt_init();
		
		if ($statement->prepare($sql)) {
			$statement->execute();
			$statement->bind_result($id, $nombre, $direccion);
			$statement->fetch();
			$statement->close();
		}
		$database->close();

		$object = (object) array('idPersona' => $id, 'nombre' => $nombre, 'direccion' => $direccion);
		return $object;
	}

	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from datos where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('i', $id);
			
			// Execute statement
			$statement->execute();
			
			// Bind variable to prepared statement
			$statement->bind_result($id, $nombre, $direccion, $fechaCreacion);
			
			// Populate bind variables
			$statement->fetch();
		
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();
		
		// Build new object
		$object = new self;
		$object->id = $id;
		$object->nombre = $nombre;
		$object->direccion = $direccion;
		$object->fechaCreacion = $fechaCreacion;
		return $object;
	}
	
	public function insert() {
		
		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "insert into datos (nombre, direccion) values (?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ss', $this->nombre, $this->direccion);
			
			// Execute statement
			$statement->execute();
			
			// Get affected rows
			$affected_rows = $database->affected_rows;
				
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();

		// Return affected rows
		return $affected_rows;			
	}

	public function update() {
	
		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "update datos set nombre = ?, direccion = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssi', $this->nombre, $this->direccion, $this->id);
			
			// Execute statement
			$statement->execute();
			
			// Get affected rows
			$affected_rows = $database->affected_rows;
				
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();

		// Return affected rows
		return $affected_rows;			

	}

	public function delete() {

		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "delete datos where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('i', $this->id);
			
			// Execute statement
			$statement->execute();
			
			// Get affected rows
			$affected_rows = $database->affected_rows;
				
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();

		// Return affected rows
		return $affected_rows;			
	
	}
	
	public function save() {
	
		// Check object for id
		if (isset($this->id)) {	
		
			// Return update when id exists
			return $this->update();
			
		} else {
		
			// Return insert when id does not exists
			return $this->insert();
		}
	}	
}