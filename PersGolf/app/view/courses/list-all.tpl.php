<i><h2><?=$title?></h2></i>

<table style="width:80%">
  <?php foreach ($courses as $course) : ?>
    <tr>
      <td width="10%">
          <?= $course->Id ?>
      </td>
      <td width="30%">
          <?= $course->Date ?>
      </td>
      <td width="20%">
          <?= $course->Course ?>
      </td>
      <td width="30%">
          <?= $course->Information ?>
      </td>
      <td width="10%" align="right">
          <b><a href="<?= $this->url->create('course/update/')?> "title="Ändra" class="id">Ändra</a></b>
        </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
</br>
