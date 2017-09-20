<div class="container">
    <div class="row">
        <?php $data = View::$data; $book = !empty($data['book'])? $data['book'] : false; ?>
        <form enctype="multipart/form-data" action="<?= URL . 'store' ;?>" method="POST" id="create-form" class="col-md-12">
            <div class="form-group">
                <label for="title"><?= !empty($data['errors']['messages']['title'])? '<span class="valid-errors">' . $data['errors']['title'] . '</span>' : 'Title'; ?></label>
                <input type="text" name="title" class="form-control" id="title" placeholder="<?= !empty($book['title'])?  $book['title'] : 'Enter title' ;?>" value="<?php if(!empty($book['title'])): echo $book['title']; endif;?>" required>
            </div>
            <div class="form-group">
                <label for="author"><?= !empty($data['errors']['messages']['author'])? '<span class="valid-errors">' . $data['errors']['author'] . '</span>' : 'Author'; ?></label>
                <select class="form-control" name="author" id="author" required>
                    <?php if(!empty($data['authors'])): ?>
                        <?php foreach ($data['authors'] as $author): ?>
                            <option value="<?= $author['id'] ;?>"><?= $author['name'] ;?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="genre"><?= !empty($data['errors']['messages']['genre'])? '<span class="valid-errors">' . $data['errors']['genre'] . '</span>' : 'Genre'; ?></label>
                <select class="form-control" name="genre" id="genre" required>
                    <?php if(!empty($data['genres'])): ?>
                        <?php foreach ($data['genres'] as $genre): ?>
                            <option value="<?= $genre['id'] ;?>"><?= $genre['name'] ;?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="lang"><?= !empty($data['errors']['messages']['lang'])? '<span class="valid-errors">' . $data['errors']['messages']['lang'] . '</span>' : 'Language'; ?></label>
                <input type="text" name="lang" class="form-control" id="lang" placeholder="<?= !empty($book['lang'])?  $book['lang'] : 'Enter language' ;?>" value="<?php if(!empty($book['lang'])): echo  $book['lang']; endif;?>" required>
            </div>
            <div class="form-group">
                <label for="date"><?= !empty($data['errors']['messages']['date'])? '<span class="valid-errors">' . $data['errors']['messages']['date'] . '</span>' : 'Year'; ?></label>
                <input type="text" name="date" class="form-control" id="date" placeholder="<?= !empty($book['date'])?  $book['date'] : '****' ;?>" value="<?php if(!empty($book['date'])): echo  $book['date']; endif;?>" required>
            </div>
            <div class="form-group">
                <label for="photo"><?= !empty($data['errors']['messages']['photo'])? '<span class="valid-errors">' . $data['errors']['messages']['photo'] . '</span>' : 'Photo'; ?></label>
                <input type="file" name="photo" class="form-control-file" id="photo" required>
            </div>
            <div class="form-group">
                <label for="isbn"><?= !empty($data['errors']['messages']['isbn'])? '<span class="valid-errors">' . $data['errors']['messages']['isbn'] . '</span>' : 'ISBN code'; ?></label>
                <input type="text" name="isbn" class="form-control" id="isbn" placeholder="<?= !empty($book['isbn'])?  $book['isbn'] : '' ;?>"  value="<?php if(!empty($book['isbn'])): echo  $book['isbn']; endif;?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save!</button>
        </form>
    </div>
</div>