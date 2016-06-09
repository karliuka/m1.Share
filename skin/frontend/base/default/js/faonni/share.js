/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_Share
 * @copyright   Copyright (c) 2015 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
if(typeof Faonni == 'undefined') {
    var Faonni = {};
}
/**************************** SHARE **************************/
Faonni.Share = Class.create();
Faonni.Share.prototype = 
{
    initialize: function(selector, config){
		this.selector = $$(selector);
		if (this.selector){
			this.config = config;
			this.prepare();
			this.click();
		}
    },
	
	prepare: function(){
		var viewport = document.viewport.getDimensions();
		this.width = viewport.width;
		this.height = viewport.height;
	},

	click: function(){
		var i = 0;
		this.selector.each(function(element){
			var id = this.config.items[i].id;
			var url = this.config.items[i].url;
			var width = this.config.items[i].width;
			var height = this.config.items[i].height;
			
			Event.observe(element, 'click', function(event){
				var centerWidth = (this.width - width) / 2;
				var centerHeight = (this.height - height) / 2;
				this.popup = window.open(url, "share-popup-" + id, "width=" + width + ",height=" + height + ",left=" + centerWidth + ",top=" + centerHeight + ",location=yes,status=yes");
				var loop = setInterval(function(){   
					if(this.popup.closed){  
						clearInterval(loop);  
						this.update(id, event.element());  
					}
				}.bind(this), 1000); 
			}.bind(this));
			i++;
		}.bind(this));
	},

	update: function(id, element){
		new Ajax.Request(this.config.url, {
			method: 'post',
			parameters:{
				id: id, 
				type: element.readAttribute('data-type'), 
				entity: element.readAttribute('data-id')
			},
			onSuccess: function(transport){ 
				if (transport.responseText.isJSON()){
					var json = transport.responseText.evalJSON();
					if (false === json.error){
						$('share-count-' + json.id).update(json.count);
					}
				}
				return;
			}.bind(this),
			onFailure: function(transport){ 
				return;
			}.bind(this)
		});
	}
}