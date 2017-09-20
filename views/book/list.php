    <div class="container">
        <div class="top-main">
            <div class="row">
                <div class="col-md-4">
                    <form action="<?= URL . 'book/search' ;?>" method="POST" id="search-form" class="input-group">
                        <input name="search" id="search" type="text" class="form-control" placeholder="Search for..." required>
                        <span class="input-group-btn">
                            <button id="search-sbt" class="btn btn-info text-uppercase" type="submit">Go!</button>
                        </span>
                    </form>
                </div>
                <div class="col-md-8">
                    <a class="add-btn btn btn-lg btn-success" href="<?=URL . 'create';?>" ><span class="glyphicon glyphicon-plus"></span></a>
                </div>
            </div>
        </div>
        <div class="bottom-main">
            <div class="row">
                <div class="col-md-12">
                    <?php $books = View::$data ;?>
                    <?php if(!empty($books)):?>
                        <table class="table table-striped list-table">
                            <thead>
                            <tr>
                                <th>
                                    Title
                                    <span id="up-btn" class="glyphicon glyphicon-triangle-bottom"></span>
                                    <span id="down-btn" style ="display:none;" class="glyphicon glyphicon-triangle-top"></span>
                                </th>
                                <th>Author</th>
                                <th>Genre</th>
                                <th>Language</th>
                                <th>Date</th>
                                <th>ISBN</th>
                            </tr>
                            </thead>
                            <tbody data-url="<?= URL ;?>">
                                <?php foreach($books as $k => $book): ?>
                                    <tr id="book-<?= $k ;?>"" data-img="<?= URL . $book['photo'] ;?>" class="book-row">
                                        <td class="td-title">
                                            <span class="book-content">
                                                <?php echo $book['title']; ?>
                                            </span>
<!--                                            <a class="detail-book" style="display: none;" href="--><?//=URL . 'detail/' . $book['id'];?><!--">-->
<!--                                                <span class="glyphicon glyphicon-zoom-in"></span>-->
<!--                                            </a>-->
                                            <a class="edit-book" style="display: none;" href="<?=URL . 'edit/' . $book['id'];?>">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                        </td>
                                        <td class="td-author">
                                            <span class="book-content"><?php echo $book['author']['name']; ?></span>
                                        </td>
                                        <td class="td-genre">
                                            <span class="book-content"><?php echo $book['genre']['name']; ?></span>
                                        </td>
                                        <td class="td-language">
                                            <span class="book-content"><?php echo $book['language']; ?></span>
                                        </td>
                                        <td class="td-year">
                                            <span class="book-content"><?php echo $book['year']; ?></span>
                                        </td>
                                        <td class="td-code">
                                            <span class="book-content"><?php echo $book['code']; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pagination-wrapper">
                            <ul class="pagination"></ul>
                        </div>
                    <? else: ?>
                        <?= '<h2>No books here.</h2>'; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <p class="tool-tip"><img src="" alt="tooltip"></p>