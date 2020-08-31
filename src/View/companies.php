<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">한지상품판매관</div>
        <div class="fx-7 text-white">한지업체</div>
    </div>
</div>

<div class="container py-5">
    <hr>
    <div class="title">우수 업체</div>
    <div class="row mt-3 pt-3 border-top">
        <?php foreach($rankers as $company):?>
            <div class="col-lg-3">  
                <div class="bg-white border">
                    <img src="/uploads/<?= $company->image ?>" alt="이미지" class="fit-contain p-3 hx-200">
                    <div class="p-3 border-top">
                        <div>
                            <span class="fx-3"><?=$company->user_name?></span>
                            <span class="badge badge-danger">우수 업체</span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">이메일</span>
                            <span class="ml-2 fx-n1"><?=$company->user_email?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">누적 포인트</span>
                            <span class="ml-2 fx-n1"><?=$company->totalPoint?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div class="container py-5">
    <hr>
    <div class="title">모든 업체</div>
    <div class="row mt-3 pt-3 border-top">
        <?php foreach($companies->data as $company):?>
            <div class="col-lg-3">  
                <div class="bg-white border">
                    <img src="/uploads/<?= $company->image ?>" alt="이미지" class="fit-contain p-3 hx-200">
                    <div class="p-3 border-top">
                        <div>
                            <span class="fx-3"><?=$company->user_name?></span>
                            <span class="badge badge-danger">우수업체</span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">이메일</span>
                            <span class="ml-2 fx-n1"><?=$company->user_email?></span>
                        </div>
                        <div class="mt-2">
                            <span class="fx-n2 text-muted">누적 포인트</span>
                            <span class="ml-2 fx-n1"><?=$company->totalPoint?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="d-center mt-4">
        <a href="/companies?page=<?= $companies->prevPage  ?>" class="icon bg-yellow text-white mx-1" <?= $companies->prev ? "" : "disabled" ?>>
            <i class="fa fa-angle-left"></i>
        </a>
        <?php for($i = $companies->start; $i <= $companies->end; $i++):?>
            <a href="/companies?page=<?=$i?>" class="icon <?= $i === $companies->page ? "bg-red" : "bg-yellow" ?> text-white mx-1"><?=$i?></a>
        <?php endfor;?>
        <a href="/companies?page=<?= $companies->nextPage  ?>" class="icon bg-yellow text-white mx-1" <?= $companies->next ? "" : "disabled" ?>>
            <i class="fa fa-angle-left"></i>
        </a>
    </div>
</div>