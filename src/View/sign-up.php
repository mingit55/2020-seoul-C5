
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">회원관리</div>
        <div class="fx-7 text-white">회원가입</div>
    </div>
</div>

<div class="container py-5">
    <form id="sign-up" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>이메일</label>
            <input type="text" id="user_email" class="form-control" name="user_email">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>비밀번호</label>
            <input type="password" id="password" class="form-control" name="password">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>비밀번호 확인</label>
            <input type="password" id="passconf" class="form-control" name="passconf">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>이름</label>
            <input type="text" id="user_name" class="form-control" name="user_name">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>프로필 사진</label>
            <input type="file" id="image" class="form-control" name="image">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>회원 유형</label>
            <select name="type" id="type" class="form-control">
                <option value="normal">일반 회원</option>
                <option value="company">기업 회원</option>
            </select>
        </div>
        <div class="form-group mt-3 text-right">
            <button class="btn-filled">회원가입</button>
        </div>
    </form>
</div>
<script src="/js/sign-up.js"></script>