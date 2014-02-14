((function(){
    var Expanded = {
        domready: function(){
            Expanded.elements = document.getElements('.rt-block.expanded');
            Expanded.elements.setStyle('height', 0);
        },

        load: function(){
            if (!Expanded.elements) Expanded.elements = document.getElements('.rt-block.expanded');
            Expanded.elements.each(function(element){
                element.set('style', null);
                element.store('rtexpand:height', element.getSize().y);
                element.setStyle('height', 0);
                //Expanded.animate.delay(1000, Expanded.animate, element);
            }, this);

            window.addEvent('scroll', Expanded.scrollEvent);
        },

        animate: function(element){
            var trigger = !element.getNext() && element.getParent('[id]') && (element.getParent('[id]').getNext() && element.getParent('[id]').getNext().id == 'rt-feature'),
                feature = document.id('rt-feature'),
                margin = 0, morph = {'height': element.retrieve('rtexpand:height', 0)};

            var callback = function(){
                element.set('style', null);
                if (trigger && feature) element.setStyle('marginBottom', margin);
                if (Expanded.elements.contains(element)) Expanded.elements.erase(element);
                if (!Expanded.elements.length) window.removeEvent('scroll', Expanded.scrollEvent);
            };

            if (trigger && feature){
                margin = -1 * (feature.getStyle('margin-top').toInt());
                morph.marginBottom = margin;
            }

            //moofx(element).animate(morph, {duration: 250, callback: callback});
            new Fx.Morph(element, {
                duration: 250,
                onComplete: callback
            }).start(morph);
        },

        scrollEvent: function(){
            var winScroll = window.getScroll().y,
                winScrollSize = window.getScrollSize().y,
                winSize = window.getSize().y;

            for (var i = 0, l = Expanded.elements.length; i < l; i++) {
                if (
                    winScroll + (winSize / 3) >= Expanded.elements[i].getPosition().y ||
                    winSize + winScroll >= winScrollSize
                    ) Expanded.animate(Expanded.elements[i]);
            }
        }
    };

    window.addEvent('load', Expanded.load);
})());
