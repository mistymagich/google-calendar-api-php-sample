<ul class="nav nav-pills">
    <li><?php echo Html::anchor('calendars/index', '&laquo; Back'); ?></li>
</ul>

<div class="page-header">
    <h2>View Share User</h2>
</div>

<table class="table table-hover">
    <tbody>
        <?php foreach ($calendar->users as $user): ?>
        <tr>
            <td><?php echo $user; ?></td>
            <td><?php echo Form::open("/calendars/{$calendar->id}/remove_share/{$user}/"); ?>  <button type="submit" class="btn btn-danger">削除</button></form></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div class="page-header">
    <h2>Add Share User</h2>
</div>

<?php echo Form::open("/calendars/{$calendar->id}/add_share/"); ?>
  <div class="form-group">
    <label for="inputGAID">Google Account ID</label>
    <input type="email" class="form-control" id="inputGAID" name="google_account_id" placeholder="hogehoge@gmail.com">
  </div>
  <button type="submit" class="btn btn-primary">登録</button>
</form>
