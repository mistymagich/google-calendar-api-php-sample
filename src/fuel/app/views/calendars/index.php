<div class="page-header">
    <h2>View</h2>
</div>

<table class="table table-hover">
    <tbody>
        <?php foreach ($calendars as $calendar): ?>
        <tr>
            <td><a href="<?php echo Uri::create("calendars/{$calendar->id}/");  ?>"><?php echo $calendar->summary; ?></a></td>
            <td><?php echo $calendar->description; ?></td>
            <td><?php echo Form::open("calendars/remove/{$calendar->id}/"); ?>  <button type="submit" class="btn btn-danger">削除</button></form></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div class="page-header">
    <h2>Create</h2>
</div>

<?php echo Form::open('calendars/create/'); ?>
  <div class="form-group">
    <label for="inputSummary">Summary</label>
    <input type="text" class="form-control" id="inputSummary" name="summary" placeholder="カレンダー名">
  </div>
  <div class="form-group">
    <label for="inputDescription">Description</label>
    <input type="text" class="form-control" id="inputDescription" name="description" placeholder="カレンダー説明">
  </div>
  <button type="submit" class="btn btn-primary">登録</button>
</form>
