<p style="text-align: center;color: #3d0235;font-weight: bold;">Información del pago realizado al PagoMóvil:</p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Carte de identitate:</span>
    <?php echo $meta['document'] ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Titular:</span>
    <?php echo $meta['owner'] ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Banco:</span> <?php echo $meta['bank'] ?>
</p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Número de Teléfono:</span>
    <?php echo $meta['telephone'] ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Suma Total:</span>
    <?php echo $total_pay_bs_formatted ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">N° de Referencia:</span>
    <?php echo $meta['ref'] ?></p>