<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php $book = View::$data; $book = $book['book'] ;?>
            <?php if(!empty($book)): ?>
                <div class="jumbotron">
                    <figure>
                        <img src="<?= URL . $book['photo'] ;?>" alt="">
                    </figure>

                    <hr>
                    <h3><span>Title: </span><?= $book['title'] ;?></h3>
                    <h4><span>Author: </span><?= $book['author']['name'] ;?></h4>
                    <p><span>date: </span>&copy; <?= $book['year'] ;?></p>
                    <p><span>isbn-code: </span><?= $book['code'] ;?></p>
                    <hr>

                    <button class="btn btn-success" onclick="window.history.back();">Go Back</button>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>