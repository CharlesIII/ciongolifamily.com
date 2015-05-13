<?php
$body .= "</td>
      </tr>
      <tr>
        <td style='color: #666666; padding: 20px;' valign='top' bgcolor='#FFFFFF'>";
   $image = 'emailsig.png';
   $src = $message->embed(Swift_Image::fromPath("$starpath"."$image"));
   $body .="<a href='http://webrecipemanager.com'><img src='$src'></a>";
   $body .= "</td>
      </tr>
    </tbody>
  </table>
<br><br>
</div>";
?>