<p style="text-align: center;color: #3d0235;font-weight: bold;">Información del pago a la cuenta de bancaria:</p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Carte de identitate:</span>
    <?= $meta['document'] ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Titular:</span>
    <?= $meta['owner'] ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Banco:</span> <?= $meta['bank'] ?>
</p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Cuenta Bancaria:</span>
    <?= $meta['bank_account'] ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">Suma Total:</span>
    <?= $total_pay_bs_formatted ?></p>

<p style="text-align: center"><span style="color: #3d0235;font-weight: bold;">N° de Referencia:</span>
    <?= $meta['ref'] ?></p>