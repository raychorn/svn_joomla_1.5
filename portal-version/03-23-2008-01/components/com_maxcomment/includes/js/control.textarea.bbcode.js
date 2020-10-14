/**
 * @author Ryan Johnson <ryan@livepipe.net>
 * @copyright 2007 LivePipe LLC
 * @package Control.TextArea.ToolBar.BBCode
 * @license MIT
 * @url http://livepipe.net/projects/control_textarea/bbcode
 * @version 1.0.0
 */
 
 /**
 * @Modified by Bernard Gilly
 * @Package maXcomment for Joomla
 * @url http://www.visualclinic.fr 
 * @date June 2007
 */

Control.TextArea.ToolBar.BBCode = Class.create();
Object.extend(Control.TextArea.ToolBar.BBCode.prototype,{
	textarea: false,
	toolbar: false,
	options: {
		preview: false
	},
	initialize: function(textarea,options){
		this.textarea = new Control.TextArea(textarea);
		this.toolbar = new Control.TextArea.ToolBar(this.textarea);
		if(options)
			for(o in options)
				this.options[o] = options[o];
		
		//buttons
		this.toolbar.addButton('Bold',function(){
			this.wrapSelection('[b]','[/b]');
			this.title = 'Bold';
		},{
			id: 'bbcode_bold_button'
		});
		
		this.toolbar.addButton('Italics',function(){
			this.wrapSelection('[i]','[/i]');
		},{
			id: 'bbcode_italics_button'
		});
		
		this.toolbar.addButton('Underline',function(){
			this.wrapSelection('[u]','[/u]');
		},{
			id: 'bbcode_underline_button'
		});		
				
		this.toolbar.addButton('Link',function(){
			selection = this.getSelection();
			response = prompt('Enter Link URL','');
			if(response == null)
				return;
			this.replaceSelection('[url=' + (response == '' ? 'http://link_url/' : response).replace(/^(?!(f|ht)tps?:\/\/)/,'http://') + ']' + (selection == '' ? 'Link Text' : selection) + '[/url]');
		},{
			id: 'bbcode_link_button'
		});
		
		this.toolbar.addButton('Image',function(){
			selection = this.getSelection();
			response = prompt('Enter Image URL','');
			if(response == null)
				return;
			this.replaceSelection('[img]' + (response == '' ? 'http://image_url/' : response).replace(/^(?!(f|ht)tps?:\/\/)/,'http://') + '[/img]');
		},{
			id: 'bbcode_image_button'
		});
		
		this.toolbar.addButton('Quote',function(){
			this.wrapSelection('[quote]','[/quote]');
		},{
			id: 'bbcode_quote_button'
		});
		
		this.toolbar.addButton('Code',function(){
			this.wrapSelection('[code]','[/code]');
		},{
			id: 'bbcode_code_button'
		});
		
		this.toolbar.addButton('Help',function(){
			window.open('http://en.wikipedia.org/wiki/BBCode');
		},{
			id: 'bbcode_help_button'
		});
	}
});