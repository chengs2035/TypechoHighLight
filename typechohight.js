hljs.initHighlightingOnLoad();
hljs.initLineNumbersOnLoad({
    singleLine: true
});
//前补0函数
function PrefixInteger(num, length) {
 return (Array(length).join('0') + num).slice(-length);
}

var i = 0;
//增加COPY按钮
$("pre code").each(function() {
	this.id = "pre_code_" + (i++);
	$(this).after('<button class="btn-copy-code" data-clipboard-action="copy" data-clipboard-target="#' + this.id + '">Copy</button>');
	
});
//COPY 按钮跟随滚动条
$("pre").scroll(function() {
	var offsetTop = $(this).scrollTop();
	$(this).find('.btn-copy-code').css('top', offsetTop + 5);
});

var clipboard = new ClipboardJS('.btn-copy-code');

clipboard.on('success',function(e) {
	e.clearSelection();
	$(e.trigger).text('success');
	var time = setInterval(function() {
		$(e.trigger).text('Copy');
		clearInterval(time);
	},
	3000);
});

clipboard.on('error',function(e) {
	console.error('Action:', e.action);
	console.error('Trigger:', e.trigger);
});
