<?php
$comments = Blog::comments((int)($post['id'] ?? 0));
$captcha = comment_captcha();
?>
<section id="comments" class="comments">
    <h2>comments.log</h2>
    <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
    <?php if (!$comments): ?><div class="empty-comment">$ tail comments.log<br>暂无评论，欢迎留下第一条想法。</div><?php endif; ?>
    <div class="comment-list">
        <?php foreach ($comments as $index => $comment): ?>
            <article class="comment-card">
                <div class="comment-head">
                    <strong>#<?= (int)$index + 1 ?> <?= h($comment['nickname']) ?></strong>
                    <time><?= h(display_date($comment['created_at'])) ?></time>
                    <button type="button" onclick="replyToComment(<?= (int)$comment['id'] ?>, <?= h(json_encode($comment['nickname'], JSON_UNESCAPED_UNICODE)) ?>)">reply</button>
                </div>
                <?php if (!empty($comment['qq'])): ?>
                    <?php $contact = utf8_limit($comment['qq'], 20); $contactLabel = preg_match('/^\d+$/', $contact) ? 'QQ: ' : 'mail: '; ?>
                    <p class="comment-contact"><?= h($contactLabel . $contact) ?><?= !empty($comment['ip_key']) ? ' · ip: ' . h($comment['ip_key']) : '' ?></p>
                <?php endif; ?>
                <p><?= nl2br(h($comment['content']), false) ?></p>
                <?php if ($comment['reply']): ?><blockquote>admin: <?= nl2br(h($comment['reply']), false) ?></blockquote><?php endif; ?>
                <?php if (!empty($comment['children'])): ?>
                    <div class="comment-children">
                        <?php foreach ($comment['children'] as $child): ?>
                            <article class="comment-child">
                                <strong><?= h($child['nickname']) ?></strong>
                                <time><?= h(display_date($child['created_at'])) ?></time>
                                <p><?= nl2br(h($child['content']), false) ?></p>
                                <?php if ($child['reply']): ?><blockquote>admin: <?= nl2br(h($child['reply']), false) ?></blockquote><?php endif; ?>
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
        <div class="reply-target" id="reply-target" hidden>reply to: <span></span><button type="button" onclick="clearReplyTarget()">cancel</button></div>
        <label><span>nickname</span><input name="nickname" maxlength="40" placeholder="2-40 chars" required></label>
        <label><span>contact</span><input name="qq" maxlength="20" placeholder="QQ or email"></label>
        <label class="wide"><span>message</span><textarea name="content" maxlength="1000" placeholder="write something..." required></textarea></label>
        <label><span>captcha</span><input name="captcha" inputmode="numeric" placeholder="<?= h($captcha['question']) ?>" required></label>
        <button type="submit">commit comment</button>
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
