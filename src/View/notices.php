
    <div class="visual visual--sub">
        <div class="background background--black">
            <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
        </div>
        <div class="position-center mt-4">
            <div class="fx-2 text-gray">축제공지사항</div>
            <div class="fx-7 text-white">알려드립니다</div>
        </div>
    </div>


    <div class="container py-5">
        <div class="d-between">
            <div>
                <hr>
                <div class="title">알려드립니다.</div>
            </div>
            <?php if(admin()):?>
                <button class="btn-filled" data-toggle='modal' data-target='#write-modal'>공지 작성</button>
            <?php endif;?>
        </div>
        <div class="t-head mt-4">
            <div class="cell-10">글 번호</div>
            <div class="cell-60">제목</div>
            <div class="cell-30">작성일</div>
        </div>
        <?php foreach($notices->data as $notice):?>
            <div class="t-row" onclick="location.href='/notices/<?=$notice->id?>'">
                <div class="cell-10"><?=$notice->id?></div>
                <div class="cell-60"><?=enc($notice->title)?></div>
                <div class="cell-30"><?=dt($notice->created_at)?></div>
            </div>
        <?php endforeach;?>
        <div class="d-center mt-4">
            <a href="/notices?page=<?= $notices->prevPage  ?>" class="icon bg-yellow text-white mx-1" <?= $notices->prev ? "" : "disabled" ?>>
                <i class="fa fa-angle-left"></i>
            </a>
            <?php for($i = $notices->start; $i <= $notices->end; $i++):?>
                <a href="/notices?page=<?=$i?>" class="icon <?= $i === $notices->page ? "bg-red" : "bg-yellow" ?> text-white mx-1"><?=$i?></a>
            <?php endfor;?>
            <a href="/notices?page=<?= $notices->nextPage  ?>" class="icon bg-yellow text-white mx-1" <?= $notices->next ? "" : "disabled" ?>>
                <i class="fa fa-angle-left"></i>
            </a>
        </div>
    </div>


    <form id="write-modal" class="modal fade" method="post" action="/insert/notices" enctype="multipart/form-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fx-4">공지 작성</div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>제목</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>내용</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>첨부 파일</label>
                        <input type="file" name="files[]" multiple class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-filled">작성 완료</button>
                </div>
            </div>
        </div>
</form>