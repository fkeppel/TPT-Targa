<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';



class TPTMailer {


    private $db;
    private $user;
    private $passwd;
    private $database;

    private $Host = 'sslout.de';                  // Specify main and backup SMTP servers
    private $SMTPAuth = true;                               // Enable SMTP authentication
    private $Username = 'tpt@twoffice.de';             // SMTP username
    private $Password = 'Hallo12345#';                           // SMTP password
    private $SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    private $Port = 465;                                    // TCP port to connect to

    private $from = 'tpt@twoffice.de';
    private $fromname = 'Targa Projekt Tool';       


    public function __construct()
    {
        
        $this->db = require_once  "../app/config/database.php";
        $this->user = $this->db['connections'][$this->db['default']]['username'];
        $this->passwd = $this->db['connections'][$this->db['default']]['password'];
        $this->database = $this->db['connections'][$this->db['default']]['database'];

    }

    private function sendMail ($to = 'f.keppel@compecon.de', $subject="Hallo", $body="das ist die Nachricht!"){

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->Host; //  = 'sslout.de';                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = $this->SMTPAuth; //  = true;                               // Enable SMTP authentication
            $mail->Username = $this->Username; //  = 'tpt@twoffice.de';             // SMTP username
            $mail->Password = $this->Password; //  = 'Hallo12345#';                           // SMTP password
            $mail->SMTPSecure = $this->SMTPSecure; //  = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
            $mail->Port = $this->Port; //  = 465;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom($this->from, $this->fromname);          //This is the email your form sends From
            $mail->addAddress($to); // Add a recipient address
            //$mail->addAddress('contact@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
    
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
           // echo 'Message could not be sent.';
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    
    }
    
    
    private function getStartAndEndDate($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
      }

     public function start (){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
          $mysqli = new mysqli("localhost", $this->user, $this->passwd, $this->database);
          $mysqli->set_charset("utf8mb4");
        } catch(Exception $e) {
          error_log($e->getMessage());
          exit('Error con');
        }
    
        $result = $mysqli->query("SELECT * FROM v_PPProduktpass_PPTermine  where PPStati_OKStatus = 0 ORDER BY PPTermine_MAZustaendigkeit, PPTermine_DatumStart ASC");
        $mail_array = array();
    
        while ($row = $result->fetch_object()){
    
            $now = new DateTime();
    

            if (substr($row->PPTermine_DatumStart,0,10) != "0000-00-00"){
                echo("Einen gefunden: $row->PPTermine_DatumStart  \r\n");
                $solltermin = new DateTime ($row->PPTermine_DatumStart);
            } else {
                $cw = $this->getStartAndEndDate($row->PPProduktpass_Liefertermin,$row->PPProduktpass_LieferterminJahr );
                $solltermin = new DateTime($cw['week_end']);
                $solltermin->modify($row->PPBoardSpalte_Rot. ' days');
            }


            //$solltermin->modify('+1 days');
            //var_dump($solltermin->format("d.m.Y"));
            //var_dump($now->format("d.m.Y"));
    
            if ($solltermin > $now ){
               // echo("Noch zeit\r\n");
               //$mail_array[$row->PPMitarbeiter_email][$row->PPProduktpass_IAN] = array('Solltermin' => $solltermin->format("d.m.Y"), 'Meilenstein' => $row->PPBoardSpalte_Bezeichnung );
            } else {
                $mail_array[$row->PPMitarbeiter_email][$row->PPProduktpass_IAN] = array('Solltermin' => $solltermin->format("d.m.Y"), 'Meilenstein' => $row->PPBoardSpalte_Bezeichnung );
            }
    
    
        
            //echo('IAN: '.$row->PPProduktpass_IAN . ' LT: '. $row->PPProduktpass_Liefertermin."/". $row->PPProduktpass_LieferterminJahr." Start: ". $row->PPTermine_DatumStart." MA: [" . $row->PPTermine_MAZustaendigkeit. "] => " .$row->PPMitarbeiter_Kuerzel." Email: ".$row->PPMitarbeiter_email. " OK Status: " . $row->PPStati_OKStatus  ."\r\n");
        }
    
        //sendMail();
    

        foreach ($mail_array as $adr => $ians) {
            echo(" Mail To:  ".$adr);
            foreach ($ians as $ian => $milestones) {
              
                echo(" IAN:  ".$ian);
                echo(" Solltermin:  ".$milestones['Solltermin']);
                echo(" Meilenstein:  ".$milestones['Meilenstein']);
                echo("   "."\r\n");
                
            }


        }


      }
        


}


$tpt = new TPTMailer ();

$tpt->start();

  ?>
