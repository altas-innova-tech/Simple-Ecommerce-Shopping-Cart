<?php

namespace App\Core\Base\Builders\Mail;

use App\Core\Constants\Constants;
use App\Features\Template\Services\TemplateService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailBuilder {

    private PHPMailer $mail;
    private array     $tags = [];

    //==================================================================================================================
    // Builder Constructor
    //==================================================================================================================
    public function __construct() {
        $this->mail = new PHPMailer(true);

        // 1. Use SMTP
        $this->mail->isSMTP();

        // 2. IMPORTANT: Use 127.0.0.1 instead of "mailpit"
        $this->mail->Host = '127.0.0.1';
        $this->mail->Port = 1025;

        // 3. Disable Auth/Security for Mailpit
        $this->mail->SMTPAuth = false;
        $this->mail->SMTPSecure = false;
        $this->mail->SMTPAutoTLS = false;

        $this->mail->CharSet = "UTF-8";
        $this->mail->isHTML(true);
    }

    //==================================================================================================================
    // Static Initialization using "new"
    //==================================================================================================================
    public static function new() : static {
        return new static();
    }


    //==================================================================================================================
    // Set From Address, Name
    //==================================================================================================================
    public function set_from(string $email, string $name) : self {
        $this->mail->setFrom($email, $name);

        return $this;
    }

    //==================================================================================================================
    // Set From Address, Name
    //==================================================================================================================
    public function set_from_owner() : self {
        $this->mail->setFrom(config('mail.from.address'), config('mail.from.name'));

        return $this;
    }



    //==================================================================================================================
    // Recipient
    //==================================================================================================================
    public function recipient(string $email, string $name) : self {
        $this->mail->addAddress($email, $name);

        return $this;
    }


    //==================================================================================================================
    // Recipients
    //==================================================================================================================
    public function recipients(array $recipients) : self {
        foreach ($recipients as $recipient) {
            if (isset($recipient[Constants::email], $recipient[Constants::name])) {
                $this->recipient($recipient[Constants::email], $recipient[Constants::name]);
            }
        }

        return $this;
    }


    //==================================================================================================================
    // Subject
    //==================================================================================================================
    public function subject(string $subject) : self {
        $this->mail->Subject = $subject;

        return $this;
    }


    //==================================================================================================================
    // Structure
    //==================================================================================================================
    public function template(string $template) : self {
        $html_template    = TemplateService::render_template_with_tags($template, $this->tags);
        $this->mail->Body = $html_template;

        return $this;
    }


    //==================================================================================================================
    // Set Tag for Structure
    //==================================================================================================================
    public function tag(string $name, string $value) : self {
        $new_tag = [
            $name => $value,
        ];

        $this->tags[] = $new_tag;

        return $this;
    }


    //==================================================================================================================
    // Set Tags for Structure
    //==================================================================================================================
    public function tags(array $tags) : self {
        $this->tags = $tags;

        return $this;
    }


    //==================================================================================================================
    // Send Email
    //==================================================================================================================
    public function send() : bool {
        if (!$this->mail->send()) {
            logger("MailBuilder::send() failed : " . $this->mail->ErrorInfo);

            return false;
        }


        return true;
    }
}
