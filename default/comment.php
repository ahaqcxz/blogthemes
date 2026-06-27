<?php
$comments = Blog::comments((int)($post['id'] ?? 0));
$captcha = comment_captcha();
?>
<section id="comments" class="comments">
    <div class="section-title">
        <p class="kicker">Comments</p>
        <h2>评论</h2>
    </div>
    <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
    <?php if (!$comments): ?><div class="empty-comment">暂无评论，欢迎留下第一条想法。</div><?php endif; ?>
    <div class="comment-list">
        <?php foreach ($comments as $index => $comment): ?>
            <article class="comment-card">
                <div class="comment-head">
                    <strong>#<?= (int)$index + 1 ?> <?= h($comment['nickname']) ?></strong>
                    <time><?= h(display_date($comment['created_at'])) ?></time>
                    <button type="button" onclick="replyToComment(<?= (int)$comment['id'] ?>, <?= h(json_encode($comment['nickname'], JSON_UNESCAPED_UNICODE)) ?>)">回复</button>
                </div>
                <?php if (!empty($comment['qq'])): ?>
                    <?php $contact = utf8_limit($comment['qq'], 20); $contactLabel = preg_match('/^\d+$/', $contact) ? 'QQ：' : '邮箱：'; ?>
                    <p class="comment-contact"><?= h($contactLabel . $contact) ?><?= !empty($comment['ip_key']) ? ' · IP：' . h($comment['ip_key']) : '' ?></p>
                <?php endif; ?>
                <p><?= nl2br(h($comment['content']), false) ?></p>
                <?php if ($comment['reply']): ?><blockquote>站长回复：<?= nl2br(h($comment['reply']), false) ?></blockquote><?php endif; ?>
                <?php if (!empty($comment['children'])): ?>
                    <div class="comment-children">
                        <?php foreach ($comment['children'] as $child): ?>
                            <article class="comment-child">
                                <strong><?= h($child['nickname']) ?></strong>
                                <time><?= h(display_date($child['created_at'])) ?></time>
                                <p><?= nl2br(h($child['content']), false) ?></p>
                                <?php if ($child['reply']): ?><blockquote>站长回复：<?= nl2br(h($child['reply']), false) ?></blockquote><?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
    <form method="post" class="comment-form">
        <input type="hidden" name="_csrf" value="<?= h(csrf_token()) ?>">
        <input type="hidden" name="form" value="comment">
        <input type="hidden" name="post_id" value="<?= (int)($post['id'] ?? 0) ?>">
        <input type="hidden" name="parent_id" id="comment-parent-id" value="0">
        <input class="hp-field" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
        <div class="reply-target" id="reply-target" hidden>正在回复：<span></span><button type="button" onclick="clearReplyTarget()">取消</button></div>
        <label>
            <span>昵称</span>
            <input name="nickname" maxlength="40" placeholder="2-40字" required>
        </label>
        <label>
            <span>QQ/邮箱</span>
            <input name="qq" maxlength="20" placeholder="选填">
        </label>
        <label class="wide">
            <span>内容</span>
            <textarea name="content" maxlength="1000" placeholder="说点什么（5-1000字）" required></textarea>
        </label>
        <label>
            <span>验证码</span>
            <input name="captcha" inputmode="numeric" placeholder="<?= h($captcha['question']) ?>" required>
        </label>
        <button type="submit">发表评论</button>
    </form>
</section>
<script>
function replyToComment(id, nickname) {
    var input = document.getElementById('comment-parent-id');
    var target = document.getElementById('reply-target');
    if (input) input.value = id;
    if (target) {
        target.hidden = false;
        target.querySelector('span').textContent = nickname;
    }
    var textarea = document.querySelector('.comment-form textarea');
    if (textarea) textarea.focus();
}
function clearReplyTarget() {
    var input = document.getElementById('comment-parent-id');
    var target = document.getElementById('reply-target');
    if (input) input.value = 0;
    if (target) target.hidden = true;
}
</script>
