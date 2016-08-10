<i class="fa fa-external-link"></i>
<b><?=$title?></b>

<table style="width:80%">
  <?php foreach ($links as $link) : ?>
    <tr>
      <td width="10%">
          <?= $link->Id ?>
      </td>
      <td width="30%">
          <?= $link->Link ?>
      </td>
      <td width="60%">
          <?= $link->Description ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
