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
        <hr>
        <div class="title"><?= $notice->id ?></div>

        <div class="fx-4 py-2">
            <?= enc($notice->title) ?>
        </div>
        <div class="mt-2">
            <span class="fx-n1 text-muted">작성일</span>
            <span class="ml-2"><?= dt($notice->created_at) ?></span>
        </div>
        <div class="mt-2">
            <p class="text-muted"><?= enc($notice->content) ?></p>
        </div>
        <?php if(admin()):?>
            <div class="mt-3">
                <button class="btn-filled" data-target="#update-modal" data-toggle="modal">수정하기</button>
                <a href="/delete/notices/<?=$notice->id?>" class="btn-bordered">삭제하기</a>
            </div>
        <?php endif;?>
        <div class="mt-3 row">
            <?php foreach($notice->files as $file):?>
                <?php $info = fileinfo($file);?>
                <?php if(array_search($info->extname, [".jpg", ".png", ".gif"]) !== false):?>
                    <div class="col-lg-6">
                        <img src="<?=$info->filepath?>" alt="이미지" class="fit-cover hx-300">
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>

        <div class="mt-4">
            <hr>
            <div class="title">첨부 파일</div>
            <?php foreach($notice->files as $file):?>
                <?php $info = fileinfo($file);?>
                <div class="py-3">
                    <div class="mb-3">
                        <span class="fx-3"><?= $info->name ?></span>
                        <span class="badge badge-primary ml-2"><?= $info->size ?></span>
                    </div>
                    <a href="/download/<?=$file?>" class="btn-filled">다운로드</a>
                </div>
            <?php endforeach;?>
        </div>
    </div>


    
    <form id="update-modal" class="modal fade" method="post" action="/update/notices/<?=$notice->id?>" enctype="multipart/form-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fx-4">공지 수정</div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>제목</label>
                        <input type="text" class="form-control" name="title" value="<?= $notice->title ?>" required>
                    </div>
                    <div class="form-group">
                        <label>내용</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" required><?= $notice->content ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>첨부 파일</label>
                        <div class="custom-file">
                            <label for="files" class="custom-file-label"><?= count($notice->files) > 0 ? count($notice->files)."개의 파일" : "파일을 선택하세요" ?></label>
                            <input type="file" id="files" name="files[]" multiple class="custom-file-input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-filled">작성 완료</button>
                </div>
            </div>
        </div>
    </form>