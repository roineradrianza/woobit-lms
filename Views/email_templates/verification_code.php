<body
    style='; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body'
        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; '>
        <tr>
            <td style='font-size: 16px; vertical-align: top;'>&nbsp;</td>
            <td class='container'
                style='font-size: 16px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
                <div class='content'
                    style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

                    <!-- START CENTERED WHITE CONTAINER -->
                    <table class='main'
                        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;'>
                        <td style="display: flex;">
                            <img src='https://woobit.ro/img/woobit-logo.png'
                                style="width:35%; max-width: 200px; margin:auto;"></img>
                        </td>
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper'
                                style=' font-size: 16px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
                                <table border='0' cellpadding='0' cellspacing='0'
                                    style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                                    <tr>
                                        <td style='font-size: 16px; vertical-align: top;'>
                                            <p>Bine ați venit la Woobit! Pentru a finaliza înregistrarea, avem nevoie de
                                                verificați-vă adresa de e-mail, puteți continua prin următoarele link <a
                                                    href="<?= SITE_URL ?>/password-reset/?code=<?= $data['verification_code'] ?>"
                                                    style="color: #3d0235;"><?= SITE_URL ?>/verify-account?code=<?= $data['verification_code'] ?></a>.
                                                <br>
                                                <br>
                                                <span style="text-align: center;">
                                                    Dacă nu v-ați înregistrat, puteți ignora acest e-mail. e-mail
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
        </tr>
    </table>
</body>