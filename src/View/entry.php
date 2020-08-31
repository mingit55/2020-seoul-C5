<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">한지공예대전</div>
        <div class="fx-7 text-white">출품신청</div>
    </div>
</div>

<div class="workspace my-5">
    <canvas width="1150" height="800"></canvas>
    <div class="tool">
        <div class="tool__item" data-role="select" title="선택"><i class="fa fa-mouse-pointer"></i></div>
        <div class="tool__item" data-role="spin" title="회전"><i class="fa fa-repeat"></i></div>
        <div class="tool__item" data-role="cut" title="자르기"><i class="fa fa-cut"></i></div>
        <div class="tool__item" data-role="glue" title="붙이기"><i class="fa fa-object-ungroup"></i></div>
        <div class="tool__item" data-target="#add-modal" data-toggle="modal" title="추가"><i class="fa fa-folder"></i></div>
        <div id="btn-remove" class="tool__item" title="삭제"><i class="fa fa-trash"></i></div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-5">
            <form id="entry-form" action="/insert/artworks" method="post">
                <input type="hidden" id="image" name="image">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="form-group">
                    <label>설명</label>
                    <input type="text" class="form-control" name="content">
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="entry-tags" data-name="hash_tags"></div>
                </div>
                <div class="form-group">
                    <button class="btn-filled">출품하기</button>
                </div>
            </form>
        </div>
        <div class="col-lg-7">
            <input type="radio" name="tab" hidden="hidden" id="tab-select" checked>
            <input type="radio" name="tab" hidden="hidden" id="tab-spin">
            <input type="radio" name="tab" hidden="hidden" id="tab-cut">
            <input type="radio" name="tab" hidden="hidden" id="tab-glue">
            <div class="helper">
                <div class="helper-search">
                    <input type="text">
                    <button id="btn-search" class="icon">
                        <i class="fa fa-search"></i>
                    </button>
                    <button id="btn-prev" class="icon">
                        <i class="fa fa-angle-left"></i>
                    </button>
                    <button id="btn-next" class="icon">
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <p class="helper-message"></p>
                </div>
                <div class="helper-header">
                    <label for="tab-select" class="tab select">선택</label>
                    <label for="tab-spin" class="tab spin">회전</label>
                    <label for="tab-cut" class="tab cut">자르기</label>
                    <label for="tab-glue" class="tab glue">붙이기</label>
                </div>
                <div class="helper-body">
                    <div class="tab select" data-target="#tab-select">선택 도구는 가장 기본적인 도구로써, 작업 영역 내의 한지를 선택할 수 있게 합니다. 
                        마우스 클릭으로 한지를 활성화하여 이동시킬 수 있으며, 선택된 한지는 삭제 버튼으로 삭제시킬 수 있습니다.</div>
                    <div class="tab spin" data-target="#tab-spin">회전 도구는 작업 영역 내의 한지를 회전할 수 있는 도구입니다. 
                        마우스 더블 클릭으로 회전하고자 하는 한지를 선택하면, 좌우로 마우스를 끌어당겨 회전시킬 수 있습니다. 
                        회전한 뒤에는 우 클릭의 콘텍스트 메뉴로 '확인'을 눌러 한지의 회전 상태를 작업 영역에 반영할 수 있습니다.</div>
                    <div class="tab cut" data-target="#tab-cut">자르기 도구는 작업 영역 내의 한지를 자를 수 있는 도구입니다. 
                        마우스 더블 클릭으로 자르고자 하는 한지를 선택하면 마우스를 움직임으로써 자르고자 하는 궤적을 그릴 수 있습니다. 
                        궤적을 그린 뒤에는 우 클릭의 콘텍스트 메뉴로 '자르기'를 눌러 그려진 궤적에 따라 한지를 자를 수 있습니다.</div>
                    <div class="tab glue" data-target="#tab-glue">붙이기 도구는 작업 영역 내의 한지들을 붙일 수 있는 도구입니다.
                        마우스 더블 클릭으로 붙이고자 하는 한지를 선택하면 처음 선택한 한지와 근접한 한지들을 선택할 수 있습니다. 
                        붙일 한지를 모두 선택한 뒤에는 우 클릭의 콘텍스트 메뉴로 '붙이기'를 눌러 선택한 한지를 붙일 수 있습니다.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">추가</div>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/js/entry/Tool.js"></script>
<script src="/js/entry/Select.js"></script>
<script src="/js/entry/Glue.js"></script>
<script src="/js/entry/Spin.js"></script>
<script src="/js/entry/Cut.js"></script>

<script src="/js/entry/Source.js"></script>
<script src="/js/entry/Part.js"></script>
<script src="/js/entry/Workspace.js"></script>
<script src="/js/entry.js"></script>