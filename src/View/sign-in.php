
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="이미지" title="이미지">
    </div>
    <div class="position-center mt-4">
        <div class="fx-2 text-gray">회원관리</div>
        <div class="fx-7 text-white">로그인</div>
    </div>
</div>

<div class="container py-5">
    <form method="post">
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
        <div class="form-group mt-3 text-right">
            <button class="btn-filled">로그인</button>
        </div>
    </form>
</div>