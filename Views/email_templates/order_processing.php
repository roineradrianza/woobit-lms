<body
    style='background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body'
        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);'>
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
                            <img src='https://full-learning.com/img/logo.png'
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
                                            La orden de pago por parte de <b
                                                style="color: #3d0235;font-weight: bold;"><?php echo $meta['first_name'] . ' ' . $meta['last_name'] ?></b>
                                            está pendiente por ser aprobada.
                                            <p style="text-align: center"><span
                                                    style="color: #3d0235;font-weight: bold;">Correo electrónico:</span>
                                                <?php echo $meta['user_email'] ?></p>

                                            <p style="text-align: center"><span
                                                    style="color: #3d0235;font-weight: bold;">Número de Télefono:</span>
                                                <?php echo $meta['telephone'] ?></p>

                                            <p style="text-align: center"><span
                                                    style="color: #3d0235;font-weight: bold;">Monto:</span>
                                                <?php echo '$' . $total_pay ?></p>

                                            <p style="text-align: center"><span
                                                    style="color: #3d0235;font-weight: bold;">Curso:</span>
                                                <?php echo $meta['course'] ?></p>

                                            <?php if ($payment_method == 'Bank Transfer(Bs)'): ?>

                                              <?php echo new Controller\Template('email_templates/order_processing/bs-bank-transfer', $data) ?>

                                            <?php endif ?>


                                            <?php if ($payment_method == 'PagoMovil'): ?>

                                              <?php echo new Controller\Template('email_templates/order_processing/pagomovil', $data) ?>

                                            <?php endif ?>

                                            <?php if ($payment_method == 'Zelle'): ?>

                                              <?php echo new Controller\Template('email_templates/order_processing/zelle', $data) ?>

                                            <?php endif ?>
                                            <a href="<?php echo SITE_URL . "/approve-checkout/?order_id=" . $order_id ?>"
                                                style="display: block; color: #ffffff; background-color: #003146; border: solid 1px #003146; margin-top:30px;border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 16px; font-weight: bold; margin: 0; border-color: #003146;">
                                                <p style='text-align: center;'>Aprobar Orden</p>
                                            </a>
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