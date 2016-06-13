<i><h2><?=$title?></h2></i>

<table style="width:50%">
  <tr>
    <td>
      Namn: <?=$user->Username?></br>
      Golfklubb: <?=$user->Golfclub?></br>
      Handikapp: <?=$user->Handicap?></br>
    </td>
    <td>
      <img src=<?="http://www.gravatar.com/avatar/"?> alt="" />
    </td>
  </tr>
  <tr>
    <td>
      <b><a href="<?= $this->url->create('user/update/')?> "title="Uppdatera användare" class="id">Uppdatera profil</a></b>      
    </td>
  </tr>
</table>
