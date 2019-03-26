module.exports = {
	'<div>{$foo}</div>': '<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">></span></span><span class="token smarty"><span class="token delimiter punctuation">{</span><span class="token variable">$foo</span><span class="token delimiter punctuation">}</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">></span></span>',
	'<div class="{$foo}">': '<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token smarty"><span class="token delimiter punctuation">{</span><span class="token variable">$foo</span><span class="token delimiter punctuation">}</span></span><span class="token punctuation">"</span></span><span class="token punctuation">></span></span>',
	'___SMARTY1___{$foo}': '___SMARTY1___<span class="token smarty"><span class="token delimiter punctuation">{</span><span class="token variable">$foo</span><span class="token delimiter punctuation">}</span></span>'
};