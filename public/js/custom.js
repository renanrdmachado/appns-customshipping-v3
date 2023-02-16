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
            window.location.href = window.location.href;
            MVL.loading('hide');
        } );
        refresh.fail( function( res ){
            console.log( "fail: ", res );
            window.location.href = window.location.href;
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
            window.location.href = window.location.href;
            MVL.loading('hide');
        } );
        refresh.fail( function( res ){
            console.log( "fail: ", res );
            window.location.href = window.location.href;
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
        MVL.loading('show');
        var data = $(data).serializeArray();
        console.log(data);
        var refresh = $.ajax({
            url: '/shipping',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        refresh.done( function( res ){
            console.log( "done: ", res );
            $('.zipcodes-range-item.new:not(.hidden)').removeClass('new');

            MVL.loading('hide');
        } );
        refresh.fail( function( res ){
            console.log( "fail: ", res );
            MVL.loading('hide');
        } );

    },
    remove: function (data) {
        
        $(data).closest('tr').hide(200);
        setTimeout(function(){
            data.closest('tr').remove();
        },200);
    },
    addLine: function(e){
        var clone = $('.zipcodes-range-item.hidden').first().clone();

        clone.find('input').removeAttr('disabled');
        clone.removeClass('hidden');

        var cloned = $('.js-zipcode-table-new').closest('tr').first().before( clone );
        cloned.show(200);
    },
    handle: function(){
        var container = $(this.container);
        container.find('.js-save').unbind('click');
        container.find('.js-save').bind('click',function(e){
            e.preventDefault();
            MVL.zipcodes.save(MVL.zipcodes.container);
        });
        $('.js-shipping-import-xls').on('submit' , function(e){
            e.preventDefault();
            var formData = new FormData(this);
            MVL.zipcodes.importXLS( formData );
        } );

    },
    init: function(){
        this.handle();
    },
    importXLS: function(file){
        MVL.loading('show');
        var importCsv = $.ajax({
            url: '/shipping/import',
            type: 'POST',
            data: file,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        importCsv.done( function( res ){
            console.log( "done: ", res );
            window.location.href = window.location.href;
            MVL.loading('hide');
        } );
        importCsv.fail( function( res ){
            console.log( "fail: ", res );
            MVL.loading('hide');
        } );

        console.log('APP feito');
    }
}
MVL.zipcodes.init();

MVL.account = {
    cancel: function() {
        if( confirm('Você irá perder todas as suas informações salvas neste APP. Deseja realmente REMOVER sua conta?') ) {
            console.log("Deletando...");

            var deleteAccount = $.ajax({
                url: '/account/delete',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            deleteAccount.done( function( res ){
                console.log( "done: ", res );
                MVL.loading('hide');
            } );
            deleteAccount.fail( function( res ){
                console.log( "fail: ", res );
                MVL.loading('hide');
            } );

            
        } else {
            console.log("Cancelou!");
        }
    },
    init: function() {
        $('.js-cancel-account').on( 'click' , function(e){
            e.preventDefault();
            MVL.account.cancel();
        } );
    }
}

MVL.account.init();