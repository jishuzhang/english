<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <style type="text/css">
	#content_left {
		padding-left: 138px;
		padding-top: 5px;
		width: 540px;
	}
	#content_right {
		margin-top: 45px;
	}
	
	.nors {
		position: relative;
	}
	.norsTitle {
		color: #333;
		font-family: Microsoft Yahei;
		font-size: 22px;
		font-weight: normal;
		margin: 35px 0 25px;
	}
	.norsSuggest {
		color: #333;
		display: inline-block;
		font-family: arial;
		font-size: 13px;
		position: relative;
	}
	.norsSuggest li {
		list-style: outside none decimal;
	}
	.norsTitle2 {
		color: #666;
		font-family: arial;
		font-size: 13px;
	}
	.norsSuggest li {
		margin: 13px 0;
	}
	.norsSuggest ol {
		margin-left: 47px;
	}
	</style>

	<div id="content_left">
        <div class="nors">
            <div class="norsSuggest">
                <h3 class="norsTitle">很抱歉，您要访问的页面不存在！</h3>
                <p class="norsTitle2">温馨提示：</p>
                <ol>
                    <li>请检查您访问的网址是否正确</li>
                    <li>如果您不能确认访问的网址，请浏览页面查看更多内容。</li>
                    <li>回到顶部重新发起搜索</li>
                </ol>
            </div>
        </div>
	</div>

</div>
