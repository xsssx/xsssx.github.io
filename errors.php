<?php  if (count($errors) > 0) : ?>
  <div class="errors">
  	<?php foreach ($errors as $error) : ?>
  	  <a><?php echo $error ?></a>
  	<?php endforeach ?>
  </div>
<?php  endif ?>