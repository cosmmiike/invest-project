<p>Main page</p>

<?php foreach ($news as $item) {?>
  <h3><?php echo $item['title']; ?></h3>
  <p><?php echo $item['description']; ?></p>
  <hr>
<?php }?>
