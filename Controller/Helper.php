<?php
namespace Controller;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 *
 */
class Helper
{
    public function __construct()
    {

    }

    public static function remove_accents($string)
    {
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string);

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string);

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string);

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string);

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $string
        );
        return $string;
    }

    public static function video_resolution()
    {
        $video_resolution = [
            [
                'name' => '240p',
                'bitrate' => 350,
                'order' => 0,
            ],
            [
                'name' => '360p',
                'bitrate' => 700,
                'order' => 1,
            ],
            [
                'name' => '480p',
                'bitrate' => 1200,
                'order' => 2,
            ],
            [
                'name' => '720p',
                'bitrate' => 2500,
                'order' => 3,
            ],
            [
                'name' => '1080p',
                'bitrate' => 5000,
                'order' => 4,
            ],
        ];
        return $video_resolution;
    }

    public static function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }

    public static function response_message($title = '', $message = '', $status = 'success', $data = '')
    {
        $res = [
            'title' => $title,
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ];
        echo json_encode($res);
        die();
    }

    public static function date_formated($date_parts = ['year' => '', 'mon' => '', 'mday' => ''])
    {
        $date = getdate();
        $current_date = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
        return $current_date;
    }

    public static function generate_pdf($template = '', $file_name = '', $folder = '/')
    {
        set_time_limit(3600);
        $file_name = empty($file_name) ? time() : $file_name;
        $mpdf = new \Mpdf\Mpdf(
            [
                'mode' => 'utf-8',
                'format' => 'A4',
                'fontdata' => [
                    'arial' => [
                        'R' => 'ArialCE.ttf',
                        'B' => 'ArialCEBold.ttf',
                    ],
                    'constantia' => [
                        'R' => 'constantia.ttf',
                    ],
                    'greatvibes' => [
                        'R' => 'GreatVibes.ttf',
                    ],
                ],
                'default_font' => 'constantia',
            ]
        );
        $mpdf->WriteHTML($template, 0);
        $file_name = $file_name . ".pdf";
        $folder = DIRECTORY . "/public/course-certifieds/";
        $temp_dir = $folder . $file_name;
        $mpdf->Output($temp_dir, \Mpdf\Output\Destination::FILE);
    }

    public static function convert_slug($text)
    {
        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-',
        );

        // -- Remove duplicated spaces
        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $text);

        // -- Returns the slug
        return strtolower(strtr($text, $table));
    }

    public static function send_mail($subject = '', $recipients = [], $message = '', $files = [])
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = EMAIL_HOST; // Set the SMTP server to send through
            $mail->SMTPAuth = EMAIL_HOST == 'localhost' ? false : true; // Enable SMTP authentication
            if (EMAIL_HOST == 'localhost') {
                $mail->SMTPAutoTLS = false;
            } else {
                $mail->Username = EMAIL_ACCOUNT; // SMTP username
                $mail->Password = EMAIL_PASSWORD; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            }
            $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->setFrom(EMAIL_ACCOUNT, 'Full Learning');

            //Recipients
            foreach ($recipients as $recipient) {
                $mail->addAddress($recipient['email'], utf8_decode($recipient['full_name']));
            }
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = utf8_decode($subject); // Set Subject
            $mail->Body = utf8_decode($message); // Set body message

            foreach ($files as $attachment) {
                if ($attachment['name'] != '') {
                    $mail->addAttachment($attachment['url'], $attachment['name']);
                } else {
                    $mail->addAttachment($attachment['url']);
                }
            }
            $mail->send();
            return true;
        } catch (Exception $e) {
            return "No se pudo enviar el mensaje. Error generado: {$mail->ErrorInfo}";
        }
        return $mail;
    }

    public static function rand_string($length = 16)
    {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    public static function encrypt($string = '')
    {
        if (empty($string)) {
            return $string;
        }

        $key = Key::loadFromAsciiSafeString(ENCRYPT_KEY);
        return Crypto::encrypt($string, $key);
    }

    public static function decrypt($string = '')
    {
        if (empty($string)) {
            return $string;
        }

        $key = Key::loadFromAsciiSafeString(ENCRYPT_KEY);
        return Crypto::decrypt($string, $key);
    }
}
