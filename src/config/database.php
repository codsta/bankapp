<?php
  class Database{
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $database = 'bank_db';


        public function connect()
        {

            $mysql_connect_str = "mysql:host=$this->host;dbname=$this->database;charset=UTF8";
            $dbConnection = new PDO($mysql_connect_str, $this->username, $this->password);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }

        public function fetch_bankdetails_ifsc($ifsc='')
        {
          try
          {
              $conn = $this->connect();
              $stmt = $conn->prepare("SELECT `bank_id`, `bank_name`, `bank_ifsc`, `bank_branch`, `bank_address`, `bank_city`, `bank_district`, `bank_state` FROM `bank_details` WHERE bank_ifsc = :ifsc");
              $stmt->bindParam(':ifsc', $ifsc,PDO::PARAM_STR);
              $stmt->execute();
              $bank_details = $stmt->fetchAll(PDO::FETCH_OBJ);
              echo json_encode($bank_details,JSON_PRETTY_PRINT);
          }
          catch(PDOException $e)
          {
              echo '{"error": {"message": '.$e->getMessage().'}';
          }
        }

        public function fetch_bankdetails_bank_city($bank_name='',$city='')
        {
          try
          {
              $conn = $this->connect();
                $stmt = $conn->prepare("SELECT `bank_id`, `bank_name`, `bank_ifsc`, `bank_branch`, `bank_address`, `bank_city`, `bank_district`, `bank_state` FROM `bank_details` WHERE bank_name = :bank_name AND bank_city = :city");
                $stmt->bindParam(':bank_name', $bank_name,PDO::PARAM_STR);
                $stmt->bindParam(':city', $city,PDO::PARAM_STR);
                $stmt->execute();
                $bank_details = $stmt->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($bank_details,JSON_PRETTY_PRINT);

          }
          catch(PDOException $e)
          {
              echo '{"error": {"message": '.$e->getMessage().'}';
          }

        }


  }
