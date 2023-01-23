if( typeof MVL==="undefined" ) {
    window.MVL = {}
}

MVL.loading = function( status ){
    if( status == "show" ) {
        $('body').addClass('loading');
    } else {
        $('body').removeClass('loading');
    }
    setTimeout(function(){
        $('body').removeClass('loading');
    },6000);
}


MVL.subscriptionsNew = {
    form: '#subscriptionsNew',
    submit: function( form ){
        MVL.loading('show');

        var button = form.find('button');
        var form = form;
    
        var refresh = $.ajax({
            url: '/account/subscriptions',
            type: 'POST',
            data: form.serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        refresh.done( function( res ){
            console.log( "done: ", res );
            MVL.loading('hide');
        } );
        refresh.fail( function( res ){
            console.log( "fail: ", res );
            MVL.loading('hide');
        } );
    },
    init: function() {
        $( this.form ).on('submit' , function(e){
            e.preventDefault();
            MVL.subscriptionsNew.submit( $(this) );
        } );
    }
}
MVL.subscriptionsNew.init();

MVL.subscriptionsRefresh = {
    btn: '.js-subscriptionRefresh',
    submit: function( btn ){
        MVL.loading('show');

        var button = btn;
    
        var refresh = $.ajax({
            url: '/account/subscriptions/refresh',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        refresh.done( function( res ){
            console.log( "done: ", res );
            MVL.loading('hide');
        } );
        refresh.fail( function( res ){
            console.log( "fail: ", res );
            MVL.loading('hide');
        } );
    },
    init: function() {
        $( this.btn ).on('click' , function(e){
            e.preventDefault();
            MVL.subscriptionsRefresh.submit();
        } );
    }
}
MVL.subscriptionsRefresh.init();

MVL.zipcodes = {
    container: "#form-zipcodes-range",
    class: '.zipcodes-range-item',
    btn: '.js-save',
    save: function (data){

    },
    remove: function (data) {

    },
    handle: function(){
        var container = $(this.container);
        container.find('.js-save').unbind('click');
        container.find('.js-save').bind('click',function(e){
            e.preventDefault();
            var data = $(MVL.zipcodes.container).serializeArray();

            // var data = [];
            // items.map( function(k,v){
            //     data.push({name:v.name,value:v.value});
            // } );
            console.log(data);
        });
    },
    init: function(){
        this.handle();
    }
}
MVL.zipcodes.init();