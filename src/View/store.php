<input type="hidden" id="uid" value="<?=user()->id?>">


<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">한지상품판매관</div>
        <div class="fx-7 text-white">온라인스토어</div>
    </div>
</div>

<div class="container py-5">
    <div class="p-3 border bg-gray d-center">
        <div id="search-area" data-name="search" class="w-100">
            
        </div>
        <button id="btn-search" class="icon text-red ml-4 p-0">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>

<div class="container py-5">
    <div class="d-between mb-3 pb-3 border-bottom">
        <div>
            <hr>
            <div class="title">상품 리스트</div>
        </div>
        <?php if(company()):?>
            <button class="btn-filled" data-target="#add-modal" data-toggle="modal">상품 등록</button>
        <?php endif;?>
    </div>
    <div id="store" class="row">
        
    </div>
</div>

<div class="container py-5">
    <div class="mb-3 pb-3">
        <hr>
        <div class="title">상품 구매</div>
    </div>
    <div class="t-head mt-3">
        <div class="cell-50">상품 정보</div>
        <div class="cell-20">수량</div>
        <div class="cell-20">합계 포인트</div>
        <div class="cell-10">-</div>
    </div>
    <div id="cart">

    </div>
    <div class="mt-3 d-between">
        <div>
            <span class="fx-n1">총 합계 포인트</span>
            <span id="total-point" class="ml-2 fx-3 text-red">0</span>
            <span class="fx-n2 text-muted">p</span>
        </div>
        <div>
            <span class="fx-n1">보유 포인트</span>
            <span id="total-point" class="ml-2 fx-3 text-red"><?= user()->point ?></span>
            <span class="fx-n2 text-muted">p</span>
        </div>
        <form id="buy-form" action="/insert/inventory" method="post">
            <input type="hidden" id="cartList" name="cartList">
            <input type="hidden" id="totalPoint" name="totalPoint">
            <input type="hidden" id="totalCount" name="totalCount">
            <button class="btn-filled">구매 완료</button>
        </form>
    </div>
</div>

<form id="add-modal" class="modal fade" enctype="multipart/form-data" action="/insert/papers" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-5">상품 등록</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="base64">
                    <label>이미지</label>
                    <input type="file" id="image" name="image" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>이름</label>
                    <input type="text" class="form-control" name="paper_name" required>
                </div>
                <div class="form-group">
                    <label>업체명</label>
                    <input type="text" class="form-control" name="company_name" value="<?= user()->user_name ?>" readonly required>
                </div>
                <div class="form-group">
                    <label>가로 사이즈</label>
                    <input type="number" class="form-control" name="width_size" min="100" max="1000" required>
                </div>
                <div class="form-group">
                    <label>세로 사이즈</label>
                    <input type="number" class="form-control" name="height_size" min="100" max="1000" required>
                </div>
                <div class="form-group">
                    <label>포인트</label>
                    <input type="number" class="form-control" name="point" min="10" max="1000" step="10" required>
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="add-tags" data-name="hash_tags"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">추가 완료</button>
            </div>
        </div>
    </div>
</form>

<script src="/js/store.js"></script>
