<?php


class WeatherApi
{
    private $pdo;

    public function __construct( PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function read_single($id){
        // Clean input
        $id = htmlentities($id);

        // Make query
        $sql = 'SELECT * FROM taak WHERE taa_id = :taa_id';

        // Prepare statement
        $stmt = $this->pdo->prepare($sql);

        // Bind Parameter
        $stmt->bindParam(':taa_id', $id);

        // Execute Statement
        $stmt->execute();

        // Get row count
        $rowcount = $stmt->rowCount();

        if ($rowcount == 1 ) {
            // Fetch data from database
            $taak_arr = array();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            array_push($taak_arr, $row);

            // Encode data to JSON
            echo json_encode($taak_arr);
        } elseif ( $rowcount > 1 ) echo 'To many tasks found';
        else echo 'No task found';
    }

    public function read(){
        // Make query
        $sql = 'SELECT * FROM taak';

        // Prepare statement
        $stmt = $this->pdo->prepare($sql);

        // Execute statement
        $stmt->execute();

        // Get row count
        $rowcount = $stmt->rowCount();

        if ( $rowcount > 0 ) {
            // Fetch data from database
            $taak_arr = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($taak_arr, $row);
            }

            // Encode data to JSON
            echo json_encode($taak_arr);
        } else echo 'No task found';

    }

    public function create(){
        // Make query
        $sql = 'INSERT INTO taak SET taa_omschr = :taa_omschr, taa_datum = :taa_datum';

        // Get raw posted data
        $data = json_decode(file_get_contents('php://input'));

        // Prepare statement
        $stmt = $this->pdo->prepare( $sql );

        // Check if fields are all set
        if ( isset($data->taa_omschr) or isset($data->taa_datum) ) {
            $taa_omschr = htmlentities($data->taa_omschr);
            $taa_datum = htmlentities($data->taa_datum);
        } else {
            echo 'Fill in all the fields';
            die;
        }
        
        // Bind parameters
        $stmt->bindParam(':taa_omschr', $taa_omschr);
        $stmt->bindParam(':taa_datum', $taa_datum);
        
        // Create new task in database
        if ( $stmt->execute() ) echo 'Task created';
        else {
            echo 'Task not created';
            echo $stmt->errorInfo();
        }
    }

    public function update($id) {
        // Make query
        $sql = 'UPDATE taak SET 
                    taa_omschr = :taa_omschr, taa_datum = :taa_datum
                 WHERE taa_id = :taa_id';

        // Get raw posted data
        $data = json_decode(file_get_contents('php://input'));

        // Prepare statement
        $stmt = $this->pdo->prepare( $sql );

        // Clean userinput
        $taa_id = htmlentities($id);
        $taa_datum = htmlentities( $data->taa_datum );
        $taa_omschr = htmlentities( $data->taa_omschr );

        // Bind parameters
        $stmt->bindParam( ':taa_id', $taa_id );
        $stmt->bindParam( ':taa_datum', $taa_datum );
        $stmt->bindParam( ':taa_omschr', $taa_omschr );

        // Update task in database
        if ( $stmt->execute() ) echo 'Task updated';
        else {
            echo 'Task not updated';
            echo $stmt->errorInfo();
        }
    }

    public function delete( $id ){
        // Make query
        $sql = 'DELETE FROM taak WHERE taa_id = :taa_id';

        // Prepare statement
        $stmt = $this->pdo->prepare( $sql );

        // Clean userinput
        $taa_id = htmlentities($id);

        // Bind parameters
        $stmt->bindParam( ':taa_id', $taa_id);

        // Delete task from database
        if ( $stmt->execute( ) ) echo 'Task deleted';
        else {
            echo 'Task not deleted';
            echo $stmt->errorInfo();
        }
    }
}