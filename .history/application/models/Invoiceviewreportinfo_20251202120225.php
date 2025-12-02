<tr>
    <th style="text-align: left;vertical-align: top;">Email</th>
    <td style="text-align: left;vertical-align: top;">:</td>
    <td style="vertical-align: top;">'.$email.'</td>
</tr>
<tr>
    <th style="text-align: left;vertical-align: top;">Contact</th>
    <td style="text-align: left;vertical-align: top;">:</td>
    <td style="vertical-align: top;">'.$contact.'</td>
</tr>
</table>
</td>
</tr>
</table>

<br>

<table width="100%" style="border-collapse: collapse; font-size: 13px;">
    <thead>
        <tr>
            <th style="text-align:center; border:1px solid; padding:5px;">NO</th>
            <th style="text-align:left; border:1px solid; padding:5px;">DESCRIPTION</th>
            <th style="text-align:center; border:1px solid; padding:5px;">WEIGHT</th>
            <th style="text-align:center; border:1px solid; padding:5px;">UNIT PRICE</th>
            <th style="text-align:center; border:1px solid; padding:5px;">QTY</th>
            <th style="text-align:right; border:1px solid; padding:5px;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        '.$tblinvoice.'
    </tbody>
</table>

<br><br>

<table width="100%" style="font-size:14px;">
    <tr>
        <td width="60%" style="vertical-align: top;">

            <b>Amount in Words:</b><br>
            <span style="font-size:13px; text-transform:capitalize;">
                '.ucfirst($amountInWords).' Only.
            </span>

        </td>

        <td width="40%" style="vertical-align: top;">
            <table width="100%" style="font-size: 14px;">
                <tr>
                    <th style="text-align:left;">Gross Total</th>
                    <td style="text-align:right;">'.number_format($total,2).'</td>
                </tr>
                <tr>
                    <th style="text-align:left;">Discount</th>
                    <td style="text-align:right;">'.number_format($discount,2).'</td>
                </tr>
                <tr>
                    <th style="text-align:left;">Net Total</th>
                    <td style="text-align:right;"><b>'.number_format($nettotal,2).'</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br><br>

<table width="100%" style="font-size: 14px; text-align:center;">
    <tr>
        <td>
            ----------------------------------------- <br>
            <b>Authorized Signature</b>
        </td>
    </tr>
</table>

</main>

</body>
</html>
';

return $html;

}
}
?>
