<?php 
  function isEven($value) {
    return ($value%2 == 0);
  }


 ?>

<?php if (!$isAjax) {?>
<div id="reviews">
<?php } ?>

  <?php
  $count_post = $offset;
  
  foreach($data->posts as $post) {
    $count_post += 1;

   ?>
    <div class="reviews <?php if (!isEven($count_post)) {echo "gray-bg";} ?>">
      <div class="container wow fadeIn">
        <div class="row">
          <div class="col-md-3">
            <div class="reviews-img">
              <img src="<?=get_field('photo', $post->ID)['url']?>" alt="<?=$post->post_title?>">
            </div>
            <h4 class="reviews-name"><?=get_field('имя', $post->ID)?></h4>
            <a class="reviews-link" href="<?=get_field('гиперссылка', $post->ID); ?>" class="reviews-link" target="_blank">LinkedIn</a>
            <p class="reviews-post"><?=get_field('должность_и_место_работы', $post->ID); ?></p>
          </div>
          <div class="col-md-9 lin-h18">
            <p class="reviews-info">
              <?=get_field('текст_или_видео', $post->ID); ?>
            </p>
          </div>
        </div>
      </div>  
    </div>
  <? } ?>

<?php if (!$isAjax) {?>
</div>
<?php } ?>

<?php if (!$isAjax) {?>
  <div class="text-center">
    <a id="reviews-btn" class="reviews-btn">показать еще</a>
  </div>

  <script>
    var current_page = "<?php echo $page ?>";
    var max_pages = "<?php echo $total ?>";
  </script>

  <script>
    jQuery(function($) {
      var $reviews = $('#reviews');
      var $reviewsBtn = $('#reviews-btn');
      
      $reviewsBtn.click(function(){
        $(this).text('Загружаю...'); // изменяем текст кнопки, вы также можете добавить прелоадер
        var data = {
          'action': 'load_reviews',
          // 'query': true_posts,
          'page' : current_page
        };
        $.ajax({
          url: '/wp-admin/admin-ajax.php', // обработчик
          data: data, // данные
          type:'POST', // тип запроса
          success:function(html) {
            if( html ) {
              $reviews.append(html);
              $reviewsBtn.text('Загрузить ещё');//.before(data); // вставляем новые посты
              current_page++; // увеличиваем номер страницы на единицу
              if (current_page == max_pages) $reviewsBtn.remove(); // если последняя страница, удаляем кнопку
            } else {
              $reviewsBtn.remove(); // если мы дошли до последней страницы постов, скроем кнопку
            }
          }
        });
      });
    });
  </script>
<?php } ?>