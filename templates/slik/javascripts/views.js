views = Class.create();
views.prototype =  {
	initialize: function(iconsBox, detailsBox, loadingBox, options) {
		this.iconsBox = iconsBox;
		this.detailsBox = detailsBox;
		this.loadingBox = loadingBox;
		this.eI = $(iconsBox);
		this.eD = $(detailsBox);
		this.eL = $(loadingBox);
		this.currentBox = null;
		this.dataCache = Array();
		this.iconsDataValid = false;
		this.detailsDataValid = false;
		this.doingSomething = false;
		this.options = {
			sort: 'name',
			order: '',
			view: 'icons',
			imgIcons: null,
			imgIconsActive: null,
			imgIconsButton: null,
			imgDetails: null,
			imgDetailsActive: null,
			imgDetailsButton: null,
			viewsCookie: 'icons'
		}
		this.currentView = this.options.view;
		this.currentSort = this.options.sort;
		this.currentOrder = this.options.order;
		this.set_view_vars(this.currentView);
	},
	
	sortItems: function(sort, order) {
		if (this.doingSomething) return null;
		if (this.dataCache[this.currentView+':'+sort+':'+order]) {
			if (this.currentView == 'icons') {
				this.eI.innerHTML = this.dataCache[this.currentView+':'+sort+':'+order];
				this.detailsDataValid = false;
			} else if (this.currentView == 'details') {
				this.eD.innerHTML = this.dataCache[this.currentView+':'+sort+':'+order];
				this.iconsDataValid = false;
			}
		} else {
			this.load_data('?mode=ajax&view='+this.currentView+'&sort='+sort+'&order='+order, this.currentBox, this.loadingBox, this.currentView+':'+sort+':'+order);
		}
		this.currentSort = sort;
		this.currentOrder = order;
	},
	
	display: function() {
		var showView = (arguments[0]) ? arguments[0] : this.currentView ;
		if (showView == 'icons') {
			this.showIcons();
		} else if (showView == 'details') {
			this.showDetails();
		}
	},
	
	showIcons: function() {
		if (this.doingSomething) return null;
		this.eD.style.display = 'none';
		if	(this.eI.innerHTML == '' || this.iconsDataValid == false) {
			load_data('?mode=ajax&view=icons&sort='+this.currentSort+'&order='+this.currentOrder, this.iconsBox, this.loadingBox);
		} else {
			this.eI.style.display = 'block';
		}
		this.iconsDataValid = true;
		this.currentView = 'icons';
		$(this.options.imgDetailsButtom).src = this.options.imgDetails;
		$(this.options.imgIconsButton).src = this.options.imgIconsActive;
		createCookie(this.options.viewsCookie, 'icons', 365);
	},
	
	showDetails: function() {
		if (this.doingSomething) return null;
		this.eI.style.display = 'none';
		if	(this.eD.innerHTML == '' || this.detailsDataValid == false) {
			load_data('?mode=ajax&view=details&sort='+this.currentSort+'&order='+this.currentOrder, this.detailsBox, this.loadingBox);
		} else {
			this.eD.style.display = 'block';
		}
		this.detailsDataValid = true;
		this.currentView = 'details';
		$(this.options.imgIconsButton).src = this.options.imgIcons;
		$(this.options.imgDetailsButtom).src = this.options.imgDetailsActive;
		createCookie(this.options.viewsCookie, 'details', 365);
	},
	
	set_view_vars: function(current) {
		if (current == 'icons') {
			this.currentBox = this.iconsBox;
		} else if (current == 'details') {
			this.currentBox = this.detailsBox;
		}
	},
	
	load_data: function(url, target, msgbox, cache_label) {
		this.doingSomething = true;
		new Ajax.Updater(target, url,
			{
				method:'get',
				asynchronous:true,
				evalScripts:true,
				onComplete:function()
					{
						new Effect.Fade(msgbox, {queue:{scope:'ajax', position:'end'}});
						new Effect.BlindDown(target, {queue:{scope:'ajax', position:'end'}});
					},
				onLoading:Effect.Appear(msgbox, {queue:{scope:'ajax', position:'end'}})
			}
		);
		if (cache_label && !this.dataCache[cache_label]) this.dataCache[cache_label] = $(target).innerHTML;
		this.doingSomething = false;
	},
};