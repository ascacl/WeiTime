<?php if (!defined('THINK_PATH')) exit();?><!-- 移动到基础里的元素 -->
<div id="move-base">
	<div class="form-item cf" sort="<?php echo ($field['content']); ?>">
		<label class="item-label">详细内容</label>
		<div class="controls">
			<label class="textarea">
				<textarea name="content" id="content"><?php echo ($info["content"]); ?></textarea>
				<?php echo hook('adminArticleEdit', array('name'=>'content','value'=>$content));?>
			</label>
		</div>
	</div>
</div>

<!-- 移动到高级里的元素 -->
<div id="move-advance"></div>