
<body style='background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);'>
      <tr>
        <td style='font-size: 16px; vertical-align: top;'>&nbsp;</td>
        <td class='container' style='font-size: 16px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

            <!-- START CENTERED WHITE CONTAINER -->
            <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;'><?php echo $data['content'] ?></span>
            <table class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;'>
              <td style="display: flex;">
                <img src='https://full-learning.com/img/logo.png' style="width:35%; max-width: 200px; margin:auto;"></img>                
              </td>
              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class='wrapper' style=' font-size: 16px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
                  <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                    <tr>
                      <td style='font-size: 16px; vertical-align: top;'>
                        <?php echo $data['content'] ?>
                        <p>
                        Felicidades por haber aprobado <b style="color: #3d0235"><?php echo $data['course']['title'] ?>!</b>  
                        </p>
                        <?php if ($data['recent_registered']): ?>
                        <p>
                          Para iniciar sesión en <a href ="<?php echo SITE_URL ?>"><?php echo SITE_URL ?></a>, utiliza las siguientes credenciales: <br>
                          <span><b>Email:</b><?php echo $data['email'] ?></span>
                          <br>
                          <span><b>Contraseña:</b><?php echo $data['password'] ?></span>
                          <br>
                          <br>
                          <span>Puedes cambiar tu contraseña al iniciar sesión e ir al perfil.</span>   
                        </p>
                        <?php endif ?>
                        <p style="text-align: center;">Presiona en el siguiente botón para obtener tu certificado</p>
                        <div style="color: #ffffff; background-color: #003146; border: solid 1px #003146; margin-top:30px;border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 16px; font-weight: bold; margin: auto; border-color: #003146; max-width:60%;">
                          <a href="<?php echo $data['certified_url'] ?>" style="text-decoration: none; color:white" download>
                            <p style='text-align: center;'>
                              Obtener certificado
                            </p>
                          </a>
                        </div>
                        <p style="text-align: center;"><b>Ante cualquier inconveniente, puede responder a este correo.</b></p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <?php if (!empty($data['course_sponsors'])): ?>
              <tr>
                <td style="display: flex;">
                  <img src='<?php echo $data['course_sponsors']['course_meta_val'] ?>' style="width:100%; max-width: 95%; margin:auto"></img>
                </td>
              </tr>
              <?php endif ?>
            <!-- END MAIN CONTENT AREA -->
            </table>

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
      </tr>
  </table>
</body>