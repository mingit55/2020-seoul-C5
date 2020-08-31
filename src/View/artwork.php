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
    <div class="row">
        <div class="col-lg-5">
            <img src="/uploads/<?= $artwork->image ?>" alt="" class="fit-contain border">
        </div>
        <div class="col-lg-7">
            <div class="fx-3"><?= enc($artwork->title) ?></div>
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
            <div class="mt-3">
                <p class="fx-n2 text-muted"><?=enc($artwork->content)?></p>
            </div>
            <?php if(user() && user()->id == $artwork->uid):?>
                <div class="mt-2">
                    <button data-target='#update-modal' data-toggle="modal" class="btn-filled">수정하기</button>
                    <a href="/delete/artworks/<?=$artwork->id?>" class="btn-bordered">삭제하기</a>
                </div>
            <?php elseif(admin()):?>
                <div class="mt-2">
                    <button data-target="#delete-modal" data-toggle="modal" class="btn-filled">삭제하기</button>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<?php if(user() && !$artwork->reviewed && $artwork->uid !== user()->id):?>
<div class="container py-5">
    <form class="p-3 border bg-white align-center" action="/insert/scores" method="post">
        <input type="hidden" id="aid" name="aid" value="<?=$artwork->id?>">
        <select name="score" id="score" class="fa text-red form-control" style="width: 200px;">
            <option class="fa" value="5"><?=str_repeat("&#xf005;", 5)?></option>
            <option class="fa" value="4.5"><?=str_repeat("&#xf005;", 4)?>&#xf123;</option>
            <option class="fa" value="4"><?=str_repeat("&#xf005;", 4)?></option>
            <option class="fa" value="3.5"><?=str_repeat("&#xf005;", 3)?>&#xf123;</option>
            <option class="fa" value="3"><?=str_repeat("&#xf005;", 3)?></option>
            <option class="fa" value="2.5"><?=str_repeat("&#xf005;", 2)?>&#xf123;</option>
            <option class="fa" value="2"><?=str_repeat("&#xf005;", 2)?></option>
            <option class="fa" value="1.5"><?=str_repeat("&#xf005;", 1)?>&#xf123;</option>
            <option class="fa" value="1"><?=str_repeat("&#xf005;", 1)?></option>
            <option class="fa" value="0.5"><?=str_repeat("&#xf005;", 0)?>&#xf123;</option>
        </select>
        <button class="btn-filled">확인</button>
    </form>
</div>
<?php endif;?>

<div class="container py-5">
    <div class="row align-items-center border p-3">
        <div class="col-lg-3">
            <img src="/uploads/<?= $artwork->user_image ?>" alt="이미지" class="fit-contain p-2 fit-contain hx-100">
        </div>
        <div class="col-lg-9">
            <div>
                <span class="fx-3"><?= $artwork->user_name ?></span>          
                <span class="badge badge-primary"><?=  $artwork->type == 'company' ? "기업" : "일반" ?></span>
            </div>
            <div class="fx-n1 text-muted"><?= $artwork->user_email ?></div>
        </div>
    </div>
</div>

<form id="update-modal" class="modal fade" action="/update/artworks/<?=$artwork->id?>" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">수정하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" class="form-control" name="title" value="<?= $artwork->title ?>">
                </div>
                <div class="form-group">
                    <label>설명</label>
                    <input type="text" class="form-control" name="content" value="<?= $artwork->content ?>">
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="entry-tags" data-name="hash_tags"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">수정 완료</button>
            </div>
        </div>
    </div>
</form>

<form id="delete-modal" class="modal fade" action="/delete-admin/artworks/<?=$artwork->id?>" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">삭제하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>삭제 사유</label>
                    <input type="text" class="form-control" name="rm_reason">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">삭제 완료</button>
            </div>
        </div>
    </div>
</form>



<script>
    let edit = new HashModule("#entry-tags", []);
    edit.tags = <?= json_encode($artwork->hash_tags) ?>;
    edit.update();
</script>