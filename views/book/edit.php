<div class="container">
    <?php $data = View::$data; ?>
    <?php if(!empty($data) && !empty($data['book'])): ?>
    <?php if(empty($data['book']['id'])) $data['book']['id'] = $data['book']['book_id'] ;?>
            <div class="row">
            <form enctype="multipart/form-data" action="<?= URL . 'store/' . $data['book']['id'] ;?>" method="POST" id="edit-form" class="col-md-12">
                <div class="form-group">
                    <label for="title"><?= !empty($data['errors']['messages']['title'])? '<span class="valid-errors">' . $data['errors']['messages']['title'] . '</span>' : 'Title'; ?></label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="<?= $data['book']['title'] ;?>" value="<?= $data['book']['title'] ;?>" required>
                </div>
                <input type="hidden" name="book_id" id="book_id" value="<?= $data['book']['id'] ;?>">
                <div class="form-group">
                    <label for="author"><?= !empty($data['errors']['messages']['author'])? '<span class="valid-errors">' . $data['errors']['messages']['author'] . '</span>' : 'Author'; ?></label>
                    <select class="form-control" name="author" id="author" required>
                        <?php if(!empty($data['authors'])): ?>
                            <?php foreach ($data['authors'] as $author): ?>
                                <option value="<?= $author['id'] ;?>"><?= $author['name'] ;?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="genre"><?= !empty($data['errors']['messages']['genre'])? '<span class="valid-errors">' . $data['errors']['messages']['genre'] . '</span>' : 'Genre';?></label>
                    <select class="form-control" name="genre" id="genre" required>
                        <?php if(!empty($data['genres'])): ?>
                            <?php foreach ($data['genres'] as $genre): ?>
                                <option value="<?= $genre['id'] ;?>"><?= $genre['name'] ;?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lang"><?= !empty($data['errors']['messages']['lang'])? '<span class="valid-errors">' . $data['errors']['messages']['lang'] . '</span>' : 'Language';?></label>
                    <input type="text" name="lang" class="form-control" id="lang" placeholder="<?= !empty($data['book']['language'])? $data['book']['language'] : $data['book']['lang'] ;?>" value="<?= !empty($data['book']['language'])? $data['book']['language'] : $data['book']['lang'] ;?>" required>
                </div>
                <div class="form-group">
                    <label for="date"><?= !empty($data['errors']['messages']['date'])? '<span class="valid-errors">' . $data['errors']['messages']['date'] . '</span>' : 'Year';?></label>
                    <input type="text" name="date" class="form-control" id="date" placeholder="<?= !empty($data['book']['year'])? $data['book']['year'] : $data['book']['date'] ;?>" value="<?= !empty($data['book']['year'])? $data['book']['year'] : $data['book']['date'] ;?>" required>
                </div>
                <div class="form-group">
                    <label for="photo"><?= !empty($data['errors']['messages']['photo'])? '<span class="valid-errors">' . $data['errors']['messages']['photo'] . '</span>' : 'Photo';?></label>
                    <input type="file" name="photo" class="form-control-file" id="photo">
                </div>
                <div class="form-group">
                    <label for="isbn"><?= !empty($data['errors']['messages']['isbn'])? '<span class="valid-errors">' . $data['errors']['messages']['isbn'] . '</span>' : 'ISBN Code';?></label>
                    <input type="text" name="isbn" class="form-control" id="isbn" required placeholder="<?= !empty($data['book']['code'])? $data['book']['code'] : $data['book']['isbn'] ;?>"  value="<?= !empty($data['book']['code'])? $data['book']['code'] : $data['book']['isbn'] ;?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    <? else: ?>
        <?= 'Book not found.' ;?>
    <?php endif; ?>
</div>