<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">축제공지사항</div>
        <div class="fx-7 text-white">1:1문의</div>
    </div>
</div>

<div class="container py-5">
    <div class="d-between">
        <div>
            <hr>
            <div class="title">1:1문의</div>
        </div>
    </div>
    <div class="mt-4 t-head">
        <div class="cell-10">상태</div>
        <div class="cell-60">제목</div>
        <div class="cell-20">문의일자</div>
        <div class="cell-10">-</div>
    </div>
    <?php foreach($inquires as $inquire):?>
        <div class="t-row" data-toggle="modal" data-target="#view-modal" data-id="<?= $inquire->id ?>">
            <div class="cell-10"><?= $inquire->answered ? "완료" : "진행 중" ?></div>
            <div class="cell-60"><?= enc($inquire->title) ?></div>
            <div class="cell-20"><?= dt($inquire->created_at) ?></div>
            <div class="cell-10">
                <?php if(!$inquire->answered):?>
                    <button class="btn-filled" data-target="#insert-modal" data-toggle="modal" data-id="<?= $inquire->id ?>">답변하기</button>
                <?php endif;?>
            </div>
        </div>
    <?php endforeach;?>
</div>


<div id="view-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">문의 내역</div>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
<script>
    $("[data-target='#view-modal']").on("click", e => {
        $.getJSON("/api/inquires/" + e.currentTarget.dataset.id, res => {
            $("#view-modal .modal-body").html(`<div class="fx-3">${res.title}</div>
                                                    <div class="mt-2">
                                                        <span class="fx-n2 text-muted">문의자</span>
                                                        <span class="fx-n1 ml-2">${res.user_name}(${res.user_email})</span>
                                                    </div>
                                                    <div class="mt-2">
                                                        <span class="fx-n2 text-muted">문의일자</span>
                                                        <span class="fx-n1 ml-2">${res.created_at}</span>
                                                    </div>
                                                    <textarea class="w-100 border p-3 fx-n1 text-muted" readonly>${res.content}</textarea>

                                                    <div class="mt-3 pt-3 border-top">
                                                        ${
                                                            res.answered_at ? 
                                                            `<div class="mt-2">
                                                                <span class="fx-n2 text-muted">답변일자</span>
                                                                <span class="fx-n1 ml-2">${res.answered_at}</span>
                                                            </div>` : ""
                                                        }
                                                        <textarea class="w-100 border p-3 fx-n1 text-muted" readonly>${res.answer ? res.answer :"문의에 대한 답변이 오지 않았습니다."}</textarea>    
                                                    </div>`);
        });
    });
</script>


<form id="insert-modal" class="modal fade" action="/insert/answers" method="post">
    <input type="hidden" id="iid" name="iid">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">답변하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>내용</label>
                    <input type="text" name="answer" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">작성 완료</button>
            </div>
        </div>
    </div>
</form>

<script>
    $("[data-target='#insert-modal']").on("click", e => {
        e.stopPropagation();
    
        $("#iid").val(e.currentTarget.dataset.id);
        $("#insert-modal").modal("show");
    });
</script>