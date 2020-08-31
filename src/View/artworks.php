<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">한지공예대전</div>
        <div class="fx-7 text-white">참가작품</div>
    </div>
</div>

<div class="container py-5">
    <form class="p-3 border bg-gray d-center">
        <div id="search-area" data-name="search" class="w-100">
            
        </div>
        <button id="btn-search" class="icon text-red ml-4 p-0">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
<script>
    let search = new HashModule("#search-area", <?= json_encode($tags) ?>);
    search.tags = <?= json_encode($search) ?>;
    search.update();
</script>

<?php if(user()):?>
<div class="container py-5">
    <hr>
    <div class="title">등록한 작품</div>
    <div class="mt-3 pt-3 border-top">
        <div class="row">
            <?php foreach($myList as $artwork) :?>
            <div class="col-lg-3">
                <div class="border bg-white" onclick="location.href='/artworks/<?=$artwork->id?>'" <?= $artwork->rm_reason ? "disabled" :"" ?>>
                    <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-contain hx-200">
                    <div class="p-3 border-top">
                        <div class="fx-3"><?= enc($artwork->title) ?></div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">제작자</span>
                            <span class="fx-n1 ml-2"><?= enc($artwork->user_name) ?></span>
                            <span class="badge badge-primary"><?= $artwork->type == 'company' ? "기업" : "일반"  ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">제작일자</span>
                            <span class="fx-n1 ml-2"><?= dt($artwork->created_at) ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">평점</span>
                            <span class="fx-n1 ml-2"><?= $artwork->score ?></span>
                        </div>
                        <div class="mt-2 text-muted fx-n2">
                            <?php foreach($artwork->hash_tags as $tag):?>
                                <span>#<?=$tag?></span>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <?php if($artwork->rm_reason):?>
                        <div class="p-3 border-top">
                            <span class="fx-2">삭제 사유</span>
                            <p><?= enc($artwork->rm_reason) ?></p>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>

<div class="container py-5">
    <hr>
    <div class="title">우수 작품</div>
    <div class="mt-3 pt-3 border-top">
        <div class="row">
            <?php foreach($rankers as $artwork) :?>
            <div class="col-lg-3">
                <div class="border bg-white" onclick="location.href='/artworks/<?=$artwork->id?>'">
                    <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-contain hx-200">
                    <div class="p-3 border-top">
                        <div>
                            <span class="fx-3"><?= enc($artwork->title) ?></span>
                            <span class="badge badge-danger">우수작품</span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">제작자</span>
                            <span class="fx-n1 ml-2"><?= enc($artwork->user_name) ?></span>
                            <span class="badge badge-primary"><?= $artwork->type == 'company' ? "기업" : "일반"  ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">제작일자</span>
                            <span class="fx-n1 ml-2"><?= dt($artwork->created_at) ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">평점</span>
                            <span class="fx-n1 ml-2"><?= $artwork->score ?></span>
                        </div>
                        <div class="mt-2 text-muted fx-n2 d-flex flex-wrap">
                            <?php foreach($artwork->hash_tags as $tag):?>
                                <span class="m-1">#<?=$tag?></span>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div class="container py-5">
    <hr>
    <div class="title">모든 작품</div>
    <div class="mt-3 pt-3 border-top">
        <div class="row">
            <?php foreach($artworks->data as $artwork) :?>
            <div class="col-lg-3">
                <div class="border bg-white" onclick="location.href='/artworks/<?=$artwork->id?>'">
                    <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-contain hx-200">
                    <div class="p-3 border-top">
                        <div class="fx-3"><?= enc($artwork->title) ?></div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">제작자</span>
                            <span class="fx-n1 ml-2"><?= enc($artwork->user_name) ?></span>
                            <span class="badge badge-primary"><?= $artwork->type == 'company' ? "기업" : "일반"  ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">제작일자</span>
                            <span class="fx-n1 ml-2"><?= dt($artwork->created_at) ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">평점</span>
                            <span class="fx-n1 ml-2"><?= $artwork->score ?></span>
                        </div>
                        <div class="mt-2 text-muted fx-n2">
                            <?php foreach($artwork->hash_tags as $tag):?>
                                <span>#<?=$tag?></span>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="d-center mt-4">
        <a href="/artworks?page=<?= $artworks->prevPage  ?>" class="icon bg-yellow text-white mx-1" <?= $artworks->prev ? "" : "disabled" ?>>
            <i class="fa fa-angle-left"></i>
        </a>
        <?php for($i = $artworks->start; $i <= $artworks->end; $i++):?>
            <a href="/artworks?page=<?=$i?>" class="icon <?= $i === $artworks->page ? "bg-red" : "bg-yellow" ?> text-white mx-1"><?=$i?></a>
        <?php endfor;?>
        <a href="/artworks?page=<?= $artworks->nextPage  ?>" class="icon bg-yellow text-white mx-1" <?= $artworks->next ? "" : "disabled" ?>>
            <i class="fa fa-angle-left"></i>
        </a>
    </div>
</div>