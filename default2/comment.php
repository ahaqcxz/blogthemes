<?php
$comments = Blog::comments((int)($post['id'] ?? 0));
$captcha = comment_captcha();
?>
<div id="comments" class="comments">
    <h5>评论</h5>
    <?php if ($msg = flash()): ?><div class="notice"><?= h($msg) ?></div><?php endif; ?>
    <?php if (!$comments): ?><div class="empty-comment">暂无回帖！赶紧来抢占沙发吧！</div><?php endif; ?>
    <?php foreach ($comments as $index => $comment): ?>
        <div class="comment-card">
            <div class="comment-row">
                <span class="comment-floor">#<?= (int)$index + 1 ?>楼</span>
                <div class="comment-main">
                    <div class="comment-head">
                        <div class="comment-author">
                            <div class="comment-author-line">
                                <strong><?= h($comment['nickname']) ?></strong>
                                <?php if (!empty($comment['qq'])): ?>
                                    <?php $contact = utf8_limit($comment['qq'], 20); $contactLabel = preg_match('/^\d+$/', $contact) ? 'QQ：' : '邮箱：'; ?>
                                    <span class="comment-contact"><?= h($contactLabel . $contact) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($comment['ip_key'])): ?><span class="comment-ip">IP：<?= h($comment['ip_key']) ?></span><?php endif; ?>
                            </div>
                            <time><?= h(display_date($comment['created_at'])) ?></time>
                        </div>
                        <button type="button" class="comment-reply-btn" onclick="replyToComment(<?= (int)$comment['id'] ?>, <?= h(json_encode($comment['nickname'], JSON_UNESCAPED_UNICODE)) ?>)">回复</button>
                    </div>
                    <p><?= nl2br(h($comment['content']), false) ?></p>
                    <?php if (!empty($comment['children'])): ?>
                        <div class="comment-children">
                            <?php foreach ($comment['children'] as $child): ?>
                                <div class="comment-child">
                                    <div class="comment-child-head">
                                        <div class="comment-author">
                                            <div class="comment-author-line">
                                                <strong><?= h($child['nickname']) ?></strong>
                                                <?php if (!empty($child['qq'])): ?>
                                                    <?php $childContact = utf8_limit($child['qq'], 20); $childLabel = preg_match('/^\d+$/', $childContact) ? 'QQ：' : '邮箱：'; ?>
                                                    <span class="comment-contact"><?= h($childLabel . $childContact) ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($child['ip_key'])): ?><span class="comment-ip">IP：<?= h($child['ip_key']) ?></span><?php endif; ?>
                                            </div>
                                            <time><?= h(display_date($child['created_at'])) ?></time>
                                        </div>
                                    </div>
                                    <p><?= nl2br(h($child['content']), false) ?></p>
                                    <?php if ($child['reply']): ?><blockquote>站长回复：<?= nl2br(h($child['reply']), false) ?></blockquote><?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($comment['reply']): ?><blockquote>站长回复：<?= nl2br(h($comment['reply']), false) ?></blockquote><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <form method="post" class="comment-form">
        <input type="hidden" name="_csrf" value="<?= h(csrf_token()) ?>">
        <input type="hidden" name="form" value="comment">
        <input type="hidden" name="post_id" value="<?= (int)($post['id'] ?? 0) ?>">
        <input type="hidden" name="parent_id" id="comment-parent-id" value="0">
        <input class="hp-field" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
        <div class="reply-target" id="reply-target" hidden>正在回复：<span></span><button type="button" onclick="clearReplyTarget()">取消</button></div>
        <input name="nickname" maxlength="40" placeholder="昵称（2-40字）" required>
        <input name="qq" maxlength="20" placeholder="QQ号或邮箱（选填，最多20字符）">
        <textarea name="content" maxlength="1000" placeholder="说点什么（5-1000字）" required></textarea>
        <input name="captcha" inputmode="numeric" placeholder="<?= h($captcha['question']) ?>" required>
        <button type="submit">发表评论</button>
    </form>
</div>
<script>
function replyToComment(id, nickname) {
    var input = document.getElementById('comment-parent-id');
    var target = document.getElementById('reply-target');
    if (input) input.value = id;
    if (target) {
        target.hidden = false;
        target.querySelector('span').textContent = nickname;
    }
    document.querySelector('.comment-form textarea').focus();
}
function clearReplyTarget() {
    var input = document.getElementById('comment-parent-id');
    var target = document.getElementById('reply-target');
    if (input) input.value = 0;
    if (target) target.hidden = true;
}
</script>
