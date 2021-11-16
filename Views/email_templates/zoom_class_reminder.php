
<body style='background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);'>
      <tr>
        <td style='font-size: 16px; vertical-align: top;'>&nbsp;</td>
        <td class='container' style='font-size: 16px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

            <!-- START CENTERED WHITE CONTAINER -->
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
                        <p>Estimado/a <?php echo $student['first_name'] .' ' . $student['last_name'] ?></p>
						            <p>Hoy continuamos con <b style="color: #3d0235"><?php echo $course['title'] . ' - ' . $section['section_name']?></b>.</p>
						            <p>Clase: <b style="color: #3d0235"><?php echo $lesson['lesson_name'] ?></b></p>
						            <p>Hora: <b style="color: #3d0235"><?php echo $lesson['meta']['zoom_date'] . ' ' . $lesson['meta']['zoom_time'] . ' ' . $lesson['meta']['zoom_timezone'] ?></b></p>
						            <p>Puede ingresar directamente a la clase a través del siguiente link: <a href="<?php echo SITE_URL ?>/courses/<?php echo $course['slug'] ?>/<?php echo $lesson['lesson_id'] ?>" style="color: #3d0235"><?php echo SITE_URL ?>/courses/<?php echo $course['slug'] ?>/<?php echo $lesson['lesson_id'] ?></a></p>
						            <p>PARA ENTRAR DESDE FULL LEARNING:</p>
						            <ol>
					                <li>Ingrese en <a href='<?php echo SITE_URL ?>' target='_blank' style="color: #3d0235"><?php echo SITE_URL ?></a></li>
					                <li>Inicie sesión con su usuario y contraseña</li>
					                <li>Busque <b style="color: #3d0235">"<?php echo $course['title'] ?>"</b></li>
					                <li>Haga click en <span style="color: #3d0235"><b>"Entrar a clase"</b></span></li>
					                <li>Seleccione la clase de hoy: <b style="color: #3d0235"><?php echo $lesson['lesson_name'] ?></b></li>
					                <li>Haga click en el botón de <b style="color: #3d0235">"Entrar a la clase"</b></li>
						            </ol>
						            <h3><b>NOTA: Es necesario que descargue la app Zoom en su computador o dispositivo móvil.</b></h3>
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