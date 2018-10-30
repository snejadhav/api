<?php
  class Category {
    // DB Stuff
    private $conn;
    private $table = 'myinput';

    // Properties
    public $id;
    public $todos;
    public $date;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categories
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        todos,
        date
      FROM
        ' . $this->table ;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Category
  /*public function read_single(){
    // Create query
    $query = 'SELECT
          id,
          name
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->name = $row['name'];
  }*/

  // Create Category
  function create(){


    $query = "INSERT INTO
                " . $this->table . "
            SET
                todos=:todos, date=:date";
  //$query = "INSERT INTO $this->table_name (todos, date) VALUES ('$data', now() )";
  //$query = "INSERT INTO myinput(todos, date) VALUES ('$data', now() )";  
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->todos=htmlspecialchars(strip_tags($this->todos));
    
    $this->date=htmlspecialchars(strip_tags($this->date));
 
    // bind values
    $stmt->bindParam(":todos", $this->todos);
   
    $stmt->bindParam(":date", $this->date);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
  // Update Category
  public function update() {
    // Create Query
    $query = "UPDATE ' .
      $this->table . '
    SET
      todos = :todos,
      date =date,
      WHERE
      id = :id";

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->todos = htmlspecialchars(strip_tags($this->todos));
  $this->date = htmlspecialchars(strip_tags($this->date));
  $this->id = htmlspecialchars(strip_tags($this->id));

  // Bind data
  $stmt-> bindParam(':todos', $this->todos);
  $stmt-> bindParam(':date', $this->date);
  $stmt-> bindParam(':id', $this->id);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Delete Category
  public function delete() {
    // Create query
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(1, $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
