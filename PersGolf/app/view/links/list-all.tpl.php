<i><h2><?=$title?></h2></i>

<table style="width:80%">
  <?php foreach ($links as $link) : ?>
    <tr>
      <td width="10%">
          <?= $link->Id ?>
      </td>
      <td width="30%">
          <?= $link->Link ?>
      </td>
      <td width="50%">
          <?= $link->Description ?>
      </td>
      <td width="10%" align="right">
          <b><a href="<?= $this->url->create('links/update/')?> "title="Ändra" class="id">Ändra</a></b>
        </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
</br>
