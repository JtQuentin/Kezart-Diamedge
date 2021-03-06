Barba.Pjax.start();
Barba.Prefetch.init();

var FadeTransition = Barba.BaseTransition.extend({
    start: function() {
        Promise
            .all([this.newContainerLoading])
            .then(this.fadeIn.bind(this));
    },

    fadeIn: function() {
        init_techno();
        
        var _this = this;

        TweenMax.set($(".transition"), {
            visibility: "visible"
        });
        TweenMax.set($(".transition_panel_top, .transition_panel_bottom"), {
            height: "0.5px"
        });
        TweenMax.to($(".transition_panel_top, .transition_panel_bottom"), .2, {
            width: '100%',
            onComplete: function(){
                TweenMax.to($(".transition_panel_top, .transition_panel_bottom"), .2, {
                    height: '100%',
                    onComplete: function () {
                        new LogoAnimation(document.querySelector(".transition_logo"), {
                            radius: 90,
                            increament: 0.2,
                            angleStart: 1.7,
                            lineWidth: 6
                        });
                        TweenMax.to($(".transition_animation"), .2, {
                            opacity: "1"
                        });
                        _this.done();
                        init();
                    }
                });
            }
        });
    }
});

Barba.Pjax.getTransition = function() {
    return FadeTransition;
};

Barba.Dispatcher.on('transitionCompleted', function () {
    window.scrollTo(0, 0);
    setTimeout(function () {
        TweenMax.to($(".transition_animation"), .1, {
            opacity: '0',
            onComplete: function () {
                TweenMax.to($(".transition"), .1, {
                    opacity: "0",
                    onComplete: function(){
                        TweenMax.set($(".transition_panel_top, .transition_panel_bottom, .transition_animation"), { clearProps: "all" });
                        TweenMax.set($(".transition"), {
                            visibility: "hidden",
                            onComplete: function(){
                                TweenMax.set($(".transition"), { clearProps: "all" });
                            }
                        });
                    }
                });
            }
        });
    }, 200);
});


function init(){
    /**
     * @type {Initiatialize Slider Home}
     */
    var $sliderHome = document.querySelector('.home_slider');
    if ($sliderHome) {
        new Swiper ($sliderHome, {
            loop: true,
            autoplay: 5000,
            keyboardControl: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev'
        });
    }

    /**
     * @type {Initiatialize Slider Filter Machine}
     */
    var $filterCarrousel_machine = document.querySelector('.filter_carrousel--machine');
    if($filterCarrousel_machine) {
        new Swiper ($filterCarrousel_machine, {
            slidesPerView: 'auto',
            nextButton: '.swiper-button-next--machine',
            prevButton: '.swiper-button-prev--machine'
        });
    }

    /**
     * @type {Initiatialize Slider Filter Single Galery}
     */
    var $single_gallery = document.querySelector('.wp_gallery');
    if($single_gallery) {
        new Swiper ($single_gallery, {
            pagination: '.swiper-pagination',
            autoHeight: true,
            slidesPerView: 'auto',
            autoResize: false,
            paginationClickable: true
        });
    }

    /**
     * @type {Initiatialize FancyBox}
     */
    $("[data-fancybox]").fancybox({
        // Options will go here
    });

    /**
     * @type {Initiatialize Slider Filter Application}
     */
    var $filterCarrousel_application = document.querySelector('.filter_carrousel--application');
    if ($filterCarrousel_application) {
        new Swiper ($filterCarrousel_application, {
            cssWidthAndHeight: true,
            slidesPerView: 'auto',
            //visibilityFullFit: true,
            autoResize: false,
            loopedSlides: 4,
            nextButton: '.swiper-button-next--application',
            prevButton: '.swiper-button-prev--application'
        });
    }

    /**
     * @type {Initiatialize Search input}
     */
    $.widget( "custom.catcomplete", $.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
        },
        _renderItem: function( ul, item ) {
            return $( "<li>" )
                .attr( "data-value", item.value )
                .append(
                    item.label.replace(
                        new RegExp("\\b" + this.term, "i"),
                        "<span class='ui-widget-search'>$&</span>"
                    )
                )
                .appendTo( ul );
        },
        _renderMenu: function( ul, items ) {
            var that = this,
                currentCategory = "";
            $.each( items, function( index, item ) {
                var li;
                if ( item.category != currentCategory ) {
                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                li = that._renderItemData( ul, item );
                if ( item.category ) {
                    li.attr( "aria-label", item.category + " : " + item.label );
                }
            });
        }
    });
    $('.headband #s, .filter #s').catcomplete({
        minLength: 3,
        source: function(name, response) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'get_listing_names',
                    name: name
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui){
            var oldValue = document.querySelector("#searchsubmit").getAttribute("href");
            if(ui.item.category == "Product(s)"){
                document.querySelector("#searchsubmit").setAttribute('href', oldValue + 'products=' + ui.item.label);
            }else{
                document.querySelector("#searchsubmit").setAttribute('href', oldValue + 'applications=' + ui.item.label);
            }
        }
    });

    /**
     * @type {Iniatilize Search bar}
     */
    var $formSearch = document.querySelector("#searchform");
    if($formSearch){
        var $linkSearch = document.querySelector("#searchsubmit");
        var oldValue = $linkSearch.getAttribute("href");

        $('.headband #s, .filter #s').keyup(function(){
            if (event.keyCode == 13) {
                Barba.Pjax.goTo($(this).next().attr("href"));
            }
        });
    }

    /**
     * @type {Initiatialize Filter Toolbar}
     */
    $('body').on('click', '.filter_button_grid', function () {
        var idRemoved = $(this).attr('id');
        $(".filter_group_button[data-filter=" + idRemoved + "]").removeClass("filter_group_button--isChecked");

        var $applicationChecked = $(".filter_group--application").find(".filter_group_button--isChecked");
        var $machineChecked = $(".filter_group--machine").find(".filter_group_button--isChecked");
        if($applicationChecked.length == 0){
            $(".filter_all--application").addClass("filter_group_button--all");
        }
        if($machineChecked.length == 0){
            $(".filter_all--machine").addClass("filter_group_button--all");
        }

        filterChecked(false);
    });

    $('body').on('click', '.category_button', function () {
        var getCategories = $(this).attr('categories');
        if(!getCategories == ""){
            var categories = getCategories.split(' ');

            $('.filter_carrousel--application').find('.filter_group_button--isChecked').removeClass('filter_group_button--isChecked');
            $('.filter_carrousel--machine').find('.filter_group_button--isChecked').removeClass('filter_group_button--isChecked');

            categories.forEach(function(value){
                $(".filter_group_button[data-filter=" + value + "]").addClass("filter_group_button--isChecked");
            });

            filterChecked(true);
        }
        else {
            filterAjax(undefined, undefined, $(".headband").attr("id"), true);
        }
    });

    $('.filter_group_button').on("click", function(){
        //Add Class over button clicked
        $(this).toggleClass("filter_group_button--isChecked");

        if($(this).hasClass("filter_all--machine")){
            $('.filter_carrousel--machine').find('.filter_group_button--isChecked').removeClass('filter_group_button--isChecked');
            $(this).addClass("filter_group_button--all");
        }
        else if($(this).hasClass("filter_all--application")){
            $('.filter_carrousel--application').find('.filter_group_button--isChecked').removeClass('filter_group_button--isChecked');
            $(this).addClass("filter_group_button--all");
        }else{
            $(this).parent().siblings().children().removeClass("filter_group_button--all");
        }

        filterChecked(false);
    });

    function filterAjax(_machines, _applications, category, showAll){
        _machines = typeof _machines !== 'undefined' ? _machines : {};
        _applications = typeof _applications !== 'undefined' ? _applications : {};

        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            dataType: "json",
            data: {
                action: 'filter_products',
                machines: _machines,
                applications: _applications,
                category: category,
                showAll: showAll
            },
            success: function(data) {
                $(".grid").empty().html(data);
            }
        });
    }

    function filterChecked(showAll){
        var allApplications = {};
        var allMachines = {};

        var $applicationChecked = $(".filter_group--application").find(".filter_group_button--isChecked");
        var $machineChecked = $(".filter_group--machine").find(".filter_group_button--isChecked");
        var currentCategory = $(".headband").attr("id");

        $applicationChecked.each(function(index){
            allApplications[index] = {
                "value": $.trim($(this).find("span").text()),
                "key": $(this).attr("data-filter")
            };
        });

        $machineChecked.each(function(index){
            allMachines[index] = {
                "value": $.trim($(this).find("span").text()),
                "key": $(this).attr("data-filter")
            };
        });

        filterAjax(allMachines, allApplications, currentCategory, showAll);
    }



    /**
     * @type {Animation home page}
     */

    $('.home_card').on('click',function(){
        $(this).toggleClass('home_card--active');
    });

    /**
     * @type {Animation ScrollBar}
     */
    if (document.querySelector(".filter")) {
        new Sticky(document.querySelector(".filter"), {
            searchField: document.querySelector(".searchbar--toolbar"),
            toolbar: document.querySelector(".toolBar-tools")
        });
    }

    $('[data-toggle="tooltip"]').tooltip();
}
// Init is finish

/**
 *
 * @param container {Target Element}
 * @param options {Options}
 * @constructor
 */

var Sticky = function(container, options){
    this.$filter = container;                // Filter
    this.$searchField = options.searchField;
    this.$toolbar = options.toolbar;

    if(this.$filter){
        this.init();
    }
};

Sticky.prototype.init = function(){
    var self = this;
    this.filterPositionEnd = this.$filter.offsetHeight + this.$filter.offsetTop; // Calcul position end Filter
    this.filterPositionStart = this.$filter.offsetTop; //Position Top Filter

    $('.toolBar-tools_title').on('click', function(){
        $("body").animate({ scrollTop: self.filterPositionStart }, '500', function(){

        });
    });

    document.addEventListener("scroll", function(){
        var scrollPosTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;

        // Moment entre le debut du filtre blanc et le champs de recherche
        if (scrollPosTop > self.filterPositionEnd) {
            $(".toolBar-tools_title").addClass("toolBar-tools_title--active");
            self.$searchField.classList.add("searchbar--toolbar--active");
            self.$toolbar.classList.add("toolBar-tools--fixed");
        }
        else{
            $(".toolBar-tools_title").removeClass("toolBar-tools_title--active");
            self.$searchField.classList.remove("searchbar--toolbar--active");
            self.$toolbar.classList.remove("toolBar-tools--fixed");
        }
    });
};

var LogoAnimation = function(container, options){
    options || (options = {});
    this.$containerCanvas = container;
    this.radius = options.radius;
    this.increament = options.increament;
    this.angleStart = options.angleStart;
    this.lineWidth = options.lineWidth;

    if(this.$containerCanvas){
        this.init();
    }
}

LogoAnimation.prototype.init = function() {
    var context = this.$containerCanvas.getContext("2d");
    var animation;
    var increament = this.increament;
    var degrees = this.angleStart;

    var animCircle = function(){
        degrees = degrees + increament;
        context.beginPath();
        context.clearRect(0, 0, this.$containerCanvas.width, this.$containerCanvas.height);
        context.lineWidth = this.lineWidth;
        context.arc(this.$containerCanvas.width / 2, this.$containerCanvas.height / 2, this.radius, this.angleStart * Math.PI, degrees * Math.PI);
        context.strokeStyle = "#005193";
        context.stroke();

        animation = requestAnimationFrame(animCircle);

        if(degrees >= this.angleStart + 2){
            degrees = 0;
            cancelAnimationFrame(animation);
        }
    }.bind(this);

    animCircle();
};

init();
