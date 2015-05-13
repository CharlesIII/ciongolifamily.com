<?php 
        $body = "<div>
                <br>
                <table style='font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #ffffff; width: 600px;' border='0' cellspacing='0' cellpadding='0' align='left'>
                 <tbody>
                   <tr>
                     <td style='height:30px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 50%, rgba(0, 0, 0, 0.02) 51%);
                 background-repeat: no-repeat;
                 background-size: 100% auto;
                 border: medium none;
                 box-shadow: 0 5px 0 0 rgba(0, 0, 0, 0.01), 0 4px 0 0 rgba(0, 0, 0, 0.02), 0 3px 0 0 rgba(0, 0, 0, 0.04), 0 2px 0 0 rgba(0, 0, 0, 0.06), 0 1px 0 0 rgba(0, 0, 0, 0.08), 0 1px 0 0 rgba(255, 255, 255, 0.1) inset, 1px 0 0 0 rgba(255, 255, 255, 0.1) inset, -1px 0 0 0 rgba(255, 255, 255, 0.1) inset, 0 -1px 0 0 rgba(0, 0, 0, 0.1) inset;
                 left: auto;
                 right: auto;
                 width: 100%;background-color: #A15883;'>";
        $himage = 'slidebars-logo@2x.png';
        $src = $message->embed(Swift_Image::fromPath("$starpath"."$himage"));
        $body .="<img style='padding-top:5px;padding-left:15px;width:300px;height:20px' src='$src'></td>
                </tr>
                <tr>
                  <td style='color: #666666; padding: 20px;' valign='top'>";
?>