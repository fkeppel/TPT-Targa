<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MailController extends BaseController {
    private $mailer_config;
    private $mail;
    public function __construct() {
        $this->mailer_config = Config::get('app.mailer');
        $this->mail = new PHPMailer(true); // Passing `true` enables exceptions
        //cpcDebug::cpc_debug(print_r($this->mailer_config,1),'TESThandleFiles');
    }
    private function getMitarbeiterLanguage($mailAdr){
        $lang = 'DE';
        if ($mailAdr != null) {
            $m = PPMitarbeiter::where('PPMitarbeiter_email', $mailAdr)->get()->first();
            if ($m) {
                $lang = $m->PPMitarbeiter_Language;
            }
        }
        return $lang;
    }
    public function sendMail ($to, $cc, $subject, $body, $attachment=null, $attachmentname = 'Testfile.xlsx'){
        //cpcdebug::cpc_debug($this->mailer_config);
        //cpcdebug::cpc_debug($attachment);
        try {
            //Server settings
            $this->mail->CharSet   = 'UTF-8';
            $this->mail->Encoding  = 'base64';
            //$this->mail->SMTPDebug = 0; 
            $this->mail->isSMTP();                                          // Set mailer to use SMTP
            $this->mail->Host = $this->mailer_config['mailer_Host'];              // Specify main and backup SMTP servers
            $this->mail->SMTPAuth = $this->mailer_config['mailer_SMTPAuth'];       // Enable SMTP authentication
            $this->mail->Username = $this->mailer_config['mailer_Username'];      // SMTP username
            $this->mail->Password = $this->mailer_config['mailer_Password'];      // SMTP password
            $this->mail->SMTPSecure = $this->mailer_config['mailer_SMTPSecure'];  // Enable SSL encryption, TLS also accepted with port 465
            $this->mail->Port = $this->mailer_config['mailer_Port'];              // TCP port to connect to
            $this->mail->Port = 465;   
            //Recipients
            //$this->mail->setFrom($this->mailer_config['mailer_FromEMail'], $this->mailer_config['mailer_FromName']); 
            $this->mail->setFrom($this->mailer_config['mailer_FromEMail'], $this->mailer_config['mailer_FromName']); 
                     //This is the email your form sends From
            $this->mail->addAddress($to);                                   // Add a recipient address
            //$this->mail->addAddress('contact@example.com');               // Name is optional
            //$this->mail->addReplyTo('info@example.com', 'Information');
            if (is_array($cc)){
                //cpcDebug::cpc_debug("CC Array:",'@MailDL');
                //cpcDebug::cpc_debug($cc,'@MailDL');
                foreach($cc as $mailadr){
                    if (strlen($mailadr) > 6){
                        //cpcDebug::cpc_debug('Arary:'.$mailadr,'MailDL');
                        $this->mail->addCC($mailadr);
                    }
                }
            } else {
                if (strlen($cc) > 6){
                    //cpcDebug::cpc_debug('CC:'.$cc,'MailDL');
                    $this->mail->addCC($cc);
                }
            }
            //$this->mail->addCC('cc@example.com');
            //$this->mail->addBCC('bcc@example.com');
            //Attachments
            //echo("Att: $attachment");exit;
            if (!is_null($attachment)){
                //cpcDebug::cpc_debug($attachment,'TESThandleFiles');
                if (is_array($attachment)){
                    //cpcDebug::cpc_debug("Multiple File attachment:",'TESThandleFiles');
                    foreach ($attachment as $key =>  $att){
                        //cpcDebug::cpc_debug("attach: $att",'TESThandleFiles');
                        if ( ! $this->mail->addAttachment($att)){
                            echo ('Mail-Anhang konnte nicht angehängt werden');
                            exit;
                        }           // Add attachments
                    }
                } else {
                    //cpcDebug::cpc_debug("File attachment: $attachment ",'TESThandleFiles');
                    if ( ! $this->mail->addAttachment($attachment, $attachmentname)){
                        echo ('Mail-Anhang konnte nicht angehängt werden');
                        exit;
                    }           // Add attachments
                }
            } else {
                //cpcDebug::cpc_debug("No Attachment ",'TESThandleFiles');
            }
            //Content
            $this->mail->isHTML(true);                                      // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $this->mail->send();
        } catch (Exception $e) {
            return true;
        }
        return true;
    }
}
