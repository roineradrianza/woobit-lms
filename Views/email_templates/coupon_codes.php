
<body style='; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body'
        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: linear-gradient(to right, #13adff 0%, #0976c2 100%);'>
      <tr>
        <td style='font-size: 16px; vertical-align: top;'>&nbsp;</td>
        <td class='container' style='font-size: 16px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

            <!-- START CENTERED WHITE CONTAINER -->
            <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;'>Aprovecha de este cupón de descuento, <?= $data['full_name']?>!</span>
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
                        <?= $data['content'] ?>

                        <p style="text-align: center;">
                          Debajo de este texto, encontrarás el código del cupón de descuento del <b><?= $data['coupon_discount'] ?></b>, ingresalo en el curso <a href="<?= SITE_URL ?>/courses/<?= $data['course']['slug'] ?>" style="color: #3d0235;"><b>"<?= $data['course']['title'] ?>"</b></a>
                        </p>
                        <div style="color: #ffffff; background-color: #003146; border: solid 1px #003146; margin-top:30px;border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 16px; font-weight: bold; margin: 0; border-color: #003146;">
                          <p style='text-align: center;'><?= $data['coupon_code'] ?></p>
                        </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <?php if (!empty($data['course_sponsors'])): ?>
              <tr>
                <td style="display: flex;">
                  <img src='<?= $data['course_sponsors']['course_meta_val'] ?>' style="width:100%; max-width: 95%; margin:auto"></img>
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